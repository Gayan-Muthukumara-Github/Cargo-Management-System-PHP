<?php require_once('../config.php'); ?>
<?php require_once('./inc/sess_auth.php'); ?>
<?php require_once('../classes/ComplianceValidator.php'); ?>

<style>
.compliance-dashboard {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.compliance-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.compliance-card .card-header {
    background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-primary-dark) 100%);
    color: white;
    padding: 1rem 1.5rem;
    font-weight: 600;
}

.compliance-card .card-body {
    padding: 1.5rem;
}

.violation-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.violation-badge.critical { background: #fee2e2; color: #991b1b; }
.violation-badge.high { background: #fef3c7; color: #92400e; }
.violation-badge.medium { background: #dbeafe; color: #1e40af; }
.violation-badge.low { background: #d1fae5; color: #065f46; }

.compliance-status {
    display: inline-block;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.875rem;
}

.compliance-status.compliant { background: #d1fae5; color: #065f46; }
.compliance-status.non_compliant { background: #fee2e2; color: #991b1b; }
.compliance-status.requires_approval { background: #fef3c7; color: #92400e; }
.compliance-status.pending { background: #e5e7eb; color: #374151; }

.filter-section {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.alert-banner {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border: 1px solid #f59e0b;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1.5rem;
    color: #92400e;
}

.alert-banner.critical {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    border-color: #ef4444;
    color: #991b1b;
}
</style>

<?php
$validator = new ComplianceValidator();
$dashboard_data = $validator->getComplianceDashboard();

// Check if compliance tables exist
$tables_exist = true;
$tables = ['compliance_violations', 'hazardous_approvals', 'compliance_rules'];
foreach ($tables as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if (!$result || $result->num_rows == 0) {
        $tables_exist = false;
        break;
    }
}
?>

<div class="card mb-3">
    <div class="card-header">
        <h3 class="card-title mb-0">
            <i class="fas fa-shield-alt mr-2"></i>Compliance & Validation Dashboard
        </h3>
        <?php if (!$tables_exist): ?>
        <div class="float-right">
            <a href="?page=setup_compliance" class="btn btn-warning btn-sm">
                <i class="fas fa-database mr-1"></i>Setup Compliance Tables
            </a>
        </div>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <?php if (!$tables_exist): ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle mr-2"></i>
            <strong>Setup Required:</strong> Compliance tables need to be created. Click the "Setup Compliance Tables" button above to initialize the compliance system.
        </div>
        <?php endif; ?>
        
        <!-- Alert Banner for Critical Issues -->
        <?php if (isset($dashboard_data['violations_by_severity']['critical']) && $dashboard_data['violations_by_severity']['critical'] > 0): ?>
        <div class="alert-banner critical">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            <strong>Critical Alert:</strong> <?php echo $dashboard_data['violations_by_severity']['critical']; ?> cargo items have critical compliance violations requiring immediate attention.
        </div>
        <?php endif; ?>
        
        <?php if (isset($dashboard_data['violations_by_severity']['high']) && $dashboard_data['violations_by_severity']['high'] > 0): ?>
        <div class="alert-banner">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <strong>High Priority:</strong> <?php echo $dashboard_data['violations_by_severity']['high']; ?> cargo items have high-priority compliance issues.
        </div>
        <?php endif; ?>
        
        <!-- Compliance Overview Cards -->
        <div class="compliance-dashboard">
            <div class="compliance-card">
                <div class="card-header">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Open Violations
                </div>
                <div class="card-body">
                    <?php foreach (['critical', 'high', 'medium', 'low'] as $severity): ?>
                        <?php $count = $dashboard_data['violations_by_severity'][$severity] ?? 0; ?>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="violation-badge <?php echo $severity; ?>"><?php echo ucfirst($severity); ?></span>
                            <span class="font-weight-bold"><?php echo $count; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="compliance-card">
                <div class="card-header">
                    <i class="fas fa-clipboard-check mr-2"></i>Pending Approvals
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="display-4 font-weight-bold text-warning"><?php echo $dashboard_data['pending_approvals']; ?></div>
                        <p class="mb-0">Hazardous Materials</p>
                        <small class="text-muted">Awaiting approval</small>
                    </div>
                </div>
            </div>
            
            <div class="compliance-card">
                <div class="card-header">
                    <i class="fas fa-chart-pie mr-2"></i>Compliance Status
                </div>
                <div class="card-body">
                    <?php foreach (['compliant', 'non_compliant', 'requires_approval', 'pending'] as $status): ?>
                        <?php $count = $dashboard_data['compliance_status'][$status] ?? 0; ?>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="compliance-status <?php echo $status; ?>"><?php echo ucfirst(str_replace('_', ' ', $status)); ?></span>
                            <span class="font-weight-bold"><?php echo $count; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters and Violations List -->
<div class="filter-section">
    <h5 class="mb-3">Compliance Violations</h5>
    <div class="row mb-3">
        <div class="col-md-3">
            <select id="filter_severity" class="form-control">
                <option value="">All Severities</option>
                <option value="critical">Critical</option>
                <option value="high">High</option>
                <option value="medium">Medium</option>
                <option value="low">Low</option>
            </select>
        </div>
        <div class="col-md-3">
            <select id="filter_status" class="form-control">
                <option value="">All Statuses</option>
                <option value="open">Open</option>
                <option value="acknowledged">Acknowledged</option>
                <option value="resolved">Resolved</option>
                <option value="ignored">Ignored</option>
            </select>
        </div>
        <div class="col-md-3">
            <div class="input-group">
                <input type="text" id="filter_cargo_ref" class="form-control" placeholder="Cargo Reference">
                <div class="input-group-append">
                    <button class="btn btn-secondary" type="button" id="btn_validate_ref">
                        <i class="fas fa-check-circle mr-1"></i> Validate
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <button id="btn_refresh" class="btn btn-primary btn-block">
                <i class="fas fa-sync-alt mr-1"></i>Refresh
            </button>
        </div>
    </div>
    
    <div class="table-responsive">
        <table id="violations_table" class="table table-striped">
            <thead>
                <tr>
                    <th>Cargo Ref</th>
                    <th>Violation Type</th>
                    <th>Message</th>
                    <th>Severity</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data loaded via AJAX -->
            </tbody>
        </table>
    </div>
</div>

<!-- Pending Approvals Section -->
<div class="filter-section">
    <h5 class="mb-3">Pending Hazardous Material Approvals</h5>
    <div class="table-responsive">
        <table id="approvals_table" class="table table-striped">
            <thead>
                <tr>
                    <th>Cargo Ref</th>
                    <th>Approval Type</th>
                    <th>Document</th>
                    <th>Submitted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data loaded via AJAX -->
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function() {
    // Load violations table
    function loadViolations() {
        const params = {
            severity: $('#filter_severity').val(),
            status: $('#filter_status').val(),
            cargo_ref: $('#filter_cargo_ref').val()
        };
        
        $.ajax({
            url: _base_url_ + 'admin/compliance_api.php',
            method: 'GET',
            data: {action: 'get_violations', ...params},
            dataType: 'json',
            success: function(response) {
                const tbody = $('#violations_table tbody');
                tbody.empty();
                
                if (response.data && response.data.length > 0) {
                    response.data.forEach(function(violation) {
                        const row = `
                            <tr>
                                <td>${violation.cargo_ref || 'N/A'}</td>
                                <td>${violation.violation_type}</td>
                                <td>${violation.violation_message}</td>
                                <td><span class="violation-badge ${violation.severity}">${violation.severity}</span></td>
                                <td><span class="compliance-status ${violation.status}">${violation.status}</span></td>
                                <td>${violation.date_created}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="viewViolation(${violation.id})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-success" onclick="resolveViolation(${violation.id})">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                        tbody.append(row);
                    });
                } else {
                    tbody.append('<tr><td colspan="7" class="text-center">No violations found</td></tr>');
                }
            },
            error: function(xhr) {
                console.error('get_violations error', xhr.status, xhr.responseText);
                const tbody = $('#violations_table tbody');
                tbody.empty();
                tbody.append('<tr><td colspan="7" class="text-center text-danger">Failed to load violations</td></tr>');
            }
        });
    }
    
    // Load approvals table
    function loadApprovals() {
        $.ajax({
            url: _base_url_ + 'admin/compliance_api.php',
            method: 'GET',
            data: {action: 'get_pending_approvals'},
            dataType: 'json',
            success: function(response) {
                const tbody = $('#approvals_table tbody');
                tbody.empty();
                
                if (response.data && response.data.length > 0) {
                    response.data.forEach(function(approval) {
                        const row = `
                            <tr>
                                <td>${approval.cargo_ref || 'N/A'}</td>
                                <td>${approval.approval_type}</td>
                                <td>
                                    ${approval.document_path ? 
                                        `<a href="${_base_url_}${approval.document_path}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-download"></i> View
                                        </a>` : 
                                        'No document'
                                    }
                                </td>
                                <td>${approval.date_created}</td>
                                <td>
                                    <button class="btn btn-sm btn-success" onclick="approveHazardous(${approval.id})">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="rejectHazardous(${approval.id})">
                                        <i class="fas fa-times"></i> Reject
                                    </button>
                                </td>
                            </tr>
                        `;
                        tbody.append(row);
                    });
                } else {
                    tbody.append('<tr><td colspan="5" class="text-center">No pending approvals</td></tr>');
                }
            },
            error: function(xhr) {
                console.error('get_pending_approvals error', xhr.status, xhr.responseText);
                const tbody = $('#approvals_table tbody');
                tbody.empty();
                tbody.append('<tr><td colspan="5" class="text-center text-danger">Failed to load approvals</td></tr>');
            }
        });
    }
    
    // Event handlers
    $('#btn_refresh, #filter_severity, #filter_status, #filter_cargo_ref').on('change click', function() {
        loadViolations();
        loadApprovals();
    });

    $('#btn_validate_ref').on('click', function() {
        const ref = $('#filter_cargo_ref').val().trim();
        if (!ref) {
            alert_toast('Enter a Cargo Reference first', 'warning');
            return;
        }
        $.ajax({
            url: _base_url_ + 'admin/compliance_api.php',
            method: 'POST',
            data: {action: 'validate_cargo_by_ref', cargo_ref: ref},
            dataType: 'json',
            success: function(resp) {
                if (resp.status === 'success') {
                    alert_toast('Validation completed', 'success');
                    loadViolations();
                    loadApprovals();
                } else {
                    alert_toast(resp.message || 'Validation failed', 'error');
                }
            },
            error: function(xhr){
                console.error('validate_cargo_by_ref error', xhr.status, xhr.responseText);
                alert_toast('Validation request failed', 'error');
            }
        });
    });
    
    // Load initial data
    loadViolations();
    loadApprovals();
    
    // Auto-refresh every 30 seconds
    setInterval(function() {
        loadViolations();
        loadApprovals();
    }, 30000);
});

function viewViolation(violationId) {
    // Open modal to view violation details
    uni_modal('Violation Details', 'compliance/view_violation.php?id=' + violationId);
}

function resolveViolation(violationId) {
    if (confirm('Mark this violation as resolved?')) {
        $.ajax({
            url: _base_url_ + 'admin/compliance_api.php',
            method: 'POST',
            data: {action: 'resolve_violation', id: violationId},
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert_toast('Violation resolved successfully', 'success');
                    $('#btn_refresh').click();
                } else {
                    alert_toast('Error: ' + response.message, 'error');
                }
            }
        });
    }
}

function approveHazardous(approvalId) {
    if (confirm('Approve this hazardous material request?')) {
        $.ajax({
            url: _base_url_ + 'admin/compliance_api.php',
            method: 'POST',
            data: {action: 'approve_hazardous', id: approvalId},
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert_toast('Approval granted successfully', 'success');
                    loadApprovals();
                } else {
                    alert_toast('Error: ' + response.message, 'error');
                }
            }
        });
    }
}

function rejectHazardous(approvalId) {
    const reason = prompt('Reason for rejection:');
    if (reason) {
        $.ajax({
            url: _base_url_ + 'admin/compliance_api.php',
            method: 'POST',
            data: {action: 'reject_hazardous', id: approvalId, reason: reason},
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert_toast('Approval rejected', 'success');
                    loadApprovals();
                } else {
                    alert_toast('Error: ' + response.message, 'error');
                }
            }
        });
    }
}
</script>
