<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../config.php');
require_once('./inc/sess_auth.php');
header('Content-Type: application/json');

if(!isset($_settings) || $_settings->userdata('type') != 1){
  http_response_code(403);
  echo json_encode(['error'=>'Forbidden']);
  exit;
}

function param($key,$def=''){ return isset($_GET[$key]) ? trim($_GET[$key]) : $def; }

$action = param('action');

// Build date filters
$date_from = param('date_from');
$date_to = param('date_to');
$cargo_type = param('cargo_type');
$destination = param('destination');

$filters = [];
if($date_from !== '') $filters[] = "cl.date_created >= '".$conn->real_escape_string($date_from)." 00:00:00'";
if($date_to !== '') $filters[] = "cl.date_created <= '".$conn->real_escape_string($date_to)." 23:59:59'";
if($cargo_type !== '' && ctype_digit($cargo_type)) $filters[] = "ci.cargo_type_id = ".((int)$cargo_type);
if($destination !== '') $filters[] = "cm_to.meta_value LIKE '%".$conn->real_escape_string($destination)."%'";

$where = count($filters) ? ('WHERE '.implode(' AND ',$filters)) : '';

function json_out($data){ echo json_encode($data); exit; }

switch($action){
  case 'volume_by_type':
    $sql = "SELECT ctl.name AS cargo_type, SUM(ci.weight) AS total_weight, COUNT(DISTINCT cl.id) AS shipments
            FROM cargo_list cl
            LEFT JOIN cargo_items ci ON ci.cargo_id = cl.id
            LEFT JOIN cargo_type_list ctl ON ctl.id = ci.cargo_type_id
            LEFT JOIN cargo_meta cm_to ON cm_to.cargo_id = cl.id AND cm_to.meta_field = 'to_location'
            $where
            GROUP BY ci.cargo_type_id
            ORDER BY total_weight DESC";
    $res = $conn->query($sql);
    $labels=$weights=$counts=[];
    while($row=$res && $r=$res->fetch_assoc()){
      $labels[] = $r['cargo_type'] ?: 'Unknown';
      $weights[] = (float)$r['total_weight'];
      $counts[] = (int)$r['shipments'];
    }
    json_out(['labels'=>$labels,'weights'=>$weights,'counts'=>$counts]);
    break;
  case 'volume_by_destination':
    $sql = "SELECT cm_to.meta_value AS destination, SUM(ci.weight) AS total_weight
            FROM cargo_list cl
            LEFT JOIN cargo_items ci ON ci.cargo_id = cl.id
            LEFT JOIN cargo_meta cm_to ON cm_to.cargo_id = cl.id AND cm_to.meta_field = 'to_location'
            $where
            GROUP BY cm_to.meta_value
            ORDER BY total_weight DESC
            LIMIT 12";
    $res = $conn->query($sql);
    $labels=$weights=[];
    while($row=$res && $r=$res->fetch_assoc()){
      $labels[] = $r['destination'] ?: 'Unknown';
      $weights[] = (float)$r['total_weight'];
    }
    json_out(['labels'=>$labels,'weights'=>$weights]);
    break;
  case 'efficiency':
    // Approximate metrics from tracking_list timestamps
    $periodSql = "DATE(cl.date_created) as d";
    $sql = "SELECT $periodSql,
                   AVG(TIMESTAMPDIFF(HOUR, cl.date_created, COALESCE(cl.date_updated, NOW()))) AS avg_processing_hours,
                   AVG(CASE WHEN cl.status IN (2,3,4) THEN TIMESTAMPDIFF(HOUR, cl.date_created, cl.date_updated) - 24 ELSE NULL END) AS avg_delay_hours
            FROM cargo_list cl
            LEFT JOIN cargo_items ci ON ci.cargo_id = cl.id
            LEFT JOIN cargo_meta cm_to ON cm_to.cargo_id = cl.id AND cm_to.meta_field = 'to_location'
            $where
            GROUP BY DATE(cl.date_created)
            ORDER BY d ASC
            LIMIT 60";
    $res = $conn->query($sql);
    $labels=$avg_delay=[];$avg_proc=[];
    while($row=$res && $r=$res->fetch_assoc()){
      $labels[] = $r['d'];
      $avg_proc[] = round((float)$r['avg_processing_hours'],2);
      $avg_delay[] = round(max(0,(float)$r['avg_delay_hours']),2);
    }
    json_out(['labels'=>$labels,'avg_processing_hours'=>$avg_proc,'avg_delay_hours'=>$avg_delay]);
    break;
  case 'utilization':
    // If storage tables exist, compute percentage per warehouse
    $labels=[];$util=[];
    $check = $conn->query("SHOW TABLES LIKE 'storage_units'");
    if($check && $check->num_rows){
      $sql = "SELECT w.name as warehouse,
                     SUM(su.occupied_weight) as used_w,
                     SUM(su.capacity_weight) as cap_w
              FROM storage_units su
              INNER JOIN warehouses w ON w.id = su.warehouse_id
              GROUP BY su.warehouse_id";
      $res = $conn->query($sql);
      while($row=$res && $r=$res->fetch_assoc()){
        $labels[] = $r['warehouse'];
        $cap = (float)$r['cap_w'];
        $u = (float)$r['used_w'];
        $util[] = $cap > 0 ? round(($u/$cap)*100,2) : 0;
      }
    }
    json_out(['labels'=>$labels,'utilization'=>$util]);
    break;
  case 'revenue':
    // Revenue by shipping_type bucket
    $labels=['City','State','Country'];
    $arr=[0,0,0];
    $sql = "SELECT cl.shipping_type, SUM(cl.total_amount) as rev
            FROM cargo_list cl
            LEFT JOIN cargo_items ci ON ci.cargo_id = cl.id
            LEFT JOIN cargo_meta cm_to ON cm_to.cargo_id = cl.id AND cm_to.meta_field = 'to_location'
            $where
            GROUP BY cl.shipping_type";
    $res = $conn->query($sql);
    while($row=$res && $r=$res->fetch_assoc()){
      $idx = max(1,min(3,(int)$r['shipping_type'])) - 1;
      $arr[$idx] = (float)$r['rev'];
    }
    json_out(['labels'=>$labels,'revenue'=>$arr]);
    break;
  case 'export_csv':
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="analytics_export.csv"');
    $out = fopen('php://output','w');
    fputcsv($out,['Report','Label','Value']);
    // Volume by type
    $sql = "SELECT ctl.name AS cargo_type, SUM(ci.weight) AS total_weight
            FROM cargo_list cl
            LEFT JOIN cargo_items ci ON ci.cargo_id = cl.id
            LEFT JOIN cargo_type_list ctl ON ctl.id = ci.cargo_type_id
            LEFT JOIN cargo_meta cm_to ON cm_to.cargo_id = cl.id AND cm_to.meta_field = 'to_location'
            $where GROUP BY ci.cargo_type_id ORDER BY total_weight DESC";
    $res = $conn->query($sql);
    while($row=$res && $r=$res->fetch_assoc()){ fputcsv($out,['Volume by Type',$r['cargo_type'],$r['total_weight']]); }
    // Revenue
    $sql = "SELECT cl.shipping_type, SUM(cl.total_amount) as rev FROM cargo_list cl $where GROUP BY cl.shipping_type";
    $res = $conn->query($sql);
    while($row=$res && $r=$res->fetch_assoc()){ fputcsv($out,['Revenue by Category',$r['shipping_type'],$r['rev']]); }
    fclose($out);
    exit;
  case 'export_pdf':
    // Simple fallback: redirect to CSV for now or implement DOMPDF later
    header('Location: '._base_url_.'admin/analytics_api.php?action=export_csv&'.http_build_query($_GET));
    exit;
  default:
    echo json_encode(['error'=>'Unknown action']);
}


