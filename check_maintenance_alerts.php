<?php
$page_title = 'Check Maintenance Alerts';
require_once('includes/load.php');
page_require_level(1);

// Define the maintenance threshold (days)
define('MAINTENANCE_THRESHOLD', 30); // Example threshold value

// Function to get overdue maintenance items
function get_overdue_maintenance_items($con) {
    $date_threshold = date('Y-m-d', strtotime('-' . MAINTENANCE_THRESHOLD . ' days'));
    $sql = "SELECT * FROM maintenance_records WHERE actual_date <= '$date_threshold' AND notes IS NULL"; // Adjust the condition as needed
    $result = $con->query($sql);

    if ($result === false) {
        die("Error in query: " . $con->error);
    }

    return $result;
}

// Establish the database connection
$host = 'localhost'; // Usually 'localhost'
$username = 'root'; // Replace with your actual MySQL username
$password = ''; // Replace with your actual MySQL password
$database = 'inventory_system'; // Replace with your actual database name

$con = new mysqli($host, $username, $password, $database);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Get overdue maintenance items
$overdue_items = get_overdue_maintenance_items($con);

include_once('layouts/header.php');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-alert"></span>
                    <span>Maintenance Alerts</span>
                </strong>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Schedule ID</th>
                            <th>Actual Date</th>
                            <th>Notes</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if ($overdue_items->num_rows > 0) {
                            $i = 1;
                            while ($item = $overdue_items->fetch_assoc()): 
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo htmlspecialchars($item['schedule_id']); ?></td>
                            <td><?php echo htmlspecialchars($item['actual_date']); ?></td>
                            <td><?php echo htmlspecialchars($item['notes']); ?></td>
                            <td><?php echo htmlspecialchars($item['created_at']); ?></td>
                        </tr>
                        <?php 
                            $i++;
                            endwhile; 
                        } else {
                            echo "<tr><td colspan='5'>No overdue maintenance items found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
