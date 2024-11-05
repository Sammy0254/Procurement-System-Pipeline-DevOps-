<?php
$page_title = 'Stock Alerts';
require_once('includes/load.php');
page_require_level(1); // Ensure appropriate user level

// Establish the database connection
$host = 'localhost';
$username = 'root'; // Replace with your actual MySQL username
$password = ''; // Replace with your actual MySQL password
$database = 'inventory_system'; // Replace with your actual database name

// Create a new MySQLi connection
$con = new mysqli($host, $username, $password, $database);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Define the stock threshold
define('STOCK_THRESHOLD', 10); // Example threshold value

// Function to get low stock items
function get_low_stock_items($con) {
    $sql = "SELECT * FROM items WHERE quantity <= " . STOCK_THRESHOLD;
    $result = $con->query($sql);
    return $result;
}

// Get low stock items
$low_stock_items = get_low_stock_items($con);

// Include the header layout
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
                    <span>Stock Alerts</span>
                </strong>
                <a href="view_items.php" class="btn btn-info pull-right btn-sm" style="margin-right: 10px;">View All Items</a>
            </div>
            <div class="panel-body">
                <?php if ($low_stock_items && $low_stock_items->num_rows > 0): ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Item Name</th>
                                <th>Receipt No</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Cost</th>
                                <th>Supplier</th>
                                <th>Date Added</th>
                                <th>Min Stock Level</th>
                                <th>Supplier Contact</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i = 1;
                            while ($item = $low_stock_items->fetch_assoc()): 
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td><?php echo htmlspecialchars($item['receipt_number']); ?></td>
                                <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                <td><?php echo htmlspecialchars($item['price']); ?></td>
                                <td><?php echo htmlspecialchars($item['cost']); ?></td>
                                <td><?php echo htmlspecialchars($item['supplier']); ?></td>
                                <td><?php echo htmlspecialchars($item['date_added']); ?></td>
                                <td><?php echo htmlspecialchars($item['min_stock_level']); ?></td>
                                <td><?php echo htmlspecialchars($item['supplier_contact']); ?></td>
                            </tr>
                            <?php 
                            $i++;
                            endwhile; 
                            ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No low stock items found or failed to retrieve data.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
// Close the database connection
$con->close();

// Include the footer layout
include_once('layouts/footer.php');
?>
