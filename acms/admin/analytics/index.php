<?php require_once('../config.php'); ?>
<?php require_once('../admin/inc/sess_auth.php'); ?>
<style>
  .analytics-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(360px,1fr));gap:1.25rem}
  .filter-row{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:.75rem}
  .chart-card{background:#fff;border-radius:16px;box-shadow:var(--admin-shadow);overflow:hidden}
  .chart-card .card-header{background:linear-gradient(135deg,var(--admin-primary) 0%,var(--admin-primary-dark) 100%);color:#fff;padding:1rem 1.25rem}
  .chart-card .card-body{padding:1rem 1.25rem}
</style>

<div class="card mb-3">
  <div class="card-header">
    <div class="d-flex align-items-center justify-content-between w-100">
      <h3 class="card-title mb-0"><i class="fas fa-chart-line mr-2"></i>Analytics & Reporting</h3>
      <div>
        <button id="btn-export-csv" class="btn btn-sm btn-light"><i class="fas fa-file-csv mr-1"></i>Export CSV</button>
        <button id="btn-export-pdf" class="btn btn-sm btn-light"><i class="fas fa-file-pdf mr-1"></i>Export PDF</button>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="filter-row mb-3">
      <input type="text" id="date_from" class="form-control" placeholder="Date from (YYYY-MM-DD)">
      <input type="text" id="date_to" class="form-control" placeholder="Date to (YYYY-MM-DD)">
      <select id="filter_cargo_type" class="form-control">
        <option value="">All Cargo Types</option>
        <?php 
          $tres = $conn->query("SELECT id,name FROM cargo_type_list WHERE delete_flag='0' AND status=1 ORDER BY name");
          while($row=$tres->fetch_assoc()):
        ?>
        <option value="<?php echo $row['id'] ?>"><?php echo htmlspecialchars($row['name']) ?></option>
        <?php endwhile; ?>
      </select>
      <input type="text" id="filter_destination" class="form-control" placeholder="Destination contains...">
    </div>

    <div class="analytics-grid">
      <div class="chart-card">
        <div class="card-header"><strong>Cargo Volume by Type</strong></div>
        <div class="card-body"><canvas id="chart_volume_type" height="140"></canvas></div>
      </div>
      <div class="chart-card">
        <div class="card-header"><strong>Cargo Volume by Destination</strong></div>
        <div class="card-body"><canvas id="chart_volume_destination" height="140"></canvas></div>
      </div>
      <div class="chart-card">
        <div class="card-header"><strong>Delays & Processing Efficiency</strong></div>
        <div class="card-body"><canvas id="chart_efficiency" height="140"></canvas></div>
      </div>
      <div class="chart-card">
        <div class="card-header"><strong>Storage Utilization</strong></div>
        <div class="card-body"><canvas id="chart_utilization" height="140"></canvas></div>
      </div>
      <div class="chart-card">
        <div class="card-header"><strong>Revenue by Category</strong></div>
        <div class="card-body"><canvas id="chart_revenue" height="140"></canvas></div>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url ?>plugins/chart.js/Chart.min.js"></script>
<script>
  const qs=(s)=>document.querySelector(s);
  const qsv=(s)=>qs(s)&&qs(s).value||'';
  function buildParams(){
    return {
      date_from:qsv('#date_from'),
      date_to:qsv('#date_to'),
      cargo_type:qsv('#filter_cargo_type'),
      destination:qsv('#filter_destination')
    };
  }
  function fetchJSON(url,params){
    return $.ajax({
      url:url,
      method:'GET',
      data:params,
      dataType:'json'
    });
  }

  let charts={};
  function upsertChart(key,type,labels,datasets,options){
    const ctx=document.getElementById(key).getContext('2d');
    if(charts[key]){ charts[key].data.labels=labels; charts[key].data.datasets=datasets; charts[key].update(); return; }
    charts[key]=new Chart(ctx,{type:type,data:{labels:labels,datasets:datasets},options:options||{responsive:true,maintainAspectRatio:false}});
  }

  function reloadAll(){
    const p=buildParams();
    fetchJSON(_base_url_+'admin/analytics_api.php',{action:'volume_by_type',...p}).then(res=>{
      upsertChart('chart_volume_type','bar',res.labels,[{label:'Weight (kg)',data:res.weights,backgroundColor:'#60a5fa'},{label:'# Shipments',data:res.counts,backgroundColor:'#34d399'}]);
    });
    fetchJSON(_base_url_+'admin/analytics_api.php',{action:'volume_by_destination',...p}).then(res=>{
      upsertChart('chart_volume_destination','bar',res.labels,[{label:'Weight (kg)',data:res.weights,backgroundColor:'#fbbf24'}]);
    });
    fetchJSON(_base_url_+'admin/analytics_api.php',{action:'efficiency',...p}).then(res=>{
      upsertChart('chart_efficiency','line',res.labels,[{label:'Avg Delay (hrs)',data:res.avg_delay_hours,borderColor:'#ef4444',backgroundColor:'rgba(239,68,68,.2)',fill:true},{label:'Avg Processing (hrs)',data:res.avg_processing_hours,borderColor:'#10b981',backgroundColor:'rgba(16,185,129,.2)',fill:true}],{scales:{y:{beginAtZero:true}}});
    });
    fetchJSON(_base_url_+'admin/analytics_api.php',{action:'utilization',...p}).then(res=>{
      upsertChart('chart_utilization','doughnut',res.labels,[{label:'Utilization %',data:res.utilization,backgroundColor:['#60a5fa','#a78bfa','#34d399','#f59e0b','#ef4444','#06b6d4']}]);
    });
    fetchJSON(_base_url_+'admin/analytics_api.php',{action:'revenue',...p}).then(res=>{
      upsertChart('chart_revenue','bar',res.labels,[{label:'Revenue',data:res.revenue,backgroundColor:'#a78bfa'}]);
    });
  }

  $('#date_from,#date_to,#filter_cargo_type,#filter_destination').on('change keyup',function(){ reloadAll(); });
  $('#btn-export-csv').on('click',function(){
    const p=buildParams();
    const query=$.param({...p,action:'export_csv'});
    window.open(_base_url_+'admin/analytics_api.php?'+query,'_blank');
  });
  $('#btn-export-pdf').on('click',function(){
    const p=buildParams();
    const query=$.param({...p,action:'export_pdf'});
    window.open(_base_url_+'admin/analytics_api.php?'+query,'_blank');
  });

  $(function(){ reloadAll(); });
</script>


