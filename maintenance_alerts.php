<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$page_title = 'Maintenance Alerts';
require_once('includes/load.php');
require_once('includes/sql.php');
require_once('includes/database.php');
page_require_level(1);

global $db;

// Fetch upcoming and overdue maintenance tasks
$sql = "SELECT ms.id, i.name as item_name, ms.scheduled_date, ms.details
        FROM maintenance_schedules ms
        JOIN items i ON ms.item_id = i.id
        WHERE ms.scheduled_date < CURDATE() OR ms.scheduled_date = CURDATE()";

$result = $db->query($sql);

if ($result && $result->num_rows > 0) {
    $alerts = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $alerts = []; // Default to an empty array if no results
}

include_once('layouts/header.php');
?>

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-warning-sign"></span>
                    <span>Maintenance Alerts</span>
                </strong>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Item Name</th>
                            <th>Scheduled Date</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($alerts) > 0): ?>
                            <?php foreach ($alerts as $alert): ?>
                                <tr>
                                    <td><?= htmlspecialchars($alert['id']) ?></td>
                                    <td><?= htmlspecialchars($alert['item_name']) ?></td>
                                    <td><?= htmlspecialchars($alert['scheduled_date']) ?></td>
                                    <td><?= htmlspecialchars($alert['details']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">No maintenance alerts found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
