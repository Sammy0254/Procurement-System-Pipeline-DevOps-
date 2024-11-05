<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$page_title = 'Item Details';
require_once('includes/load.php');
page_require_level(1);

// Check if the item ID is set in the URL
if (!isset($_GET['item_id']) || empty($_GET['item_id'])) {
    $_SESSION['error'] = 'Missing item ID!';
    header('Location: view_items.php');
    exit();
}

$item_id = (int)$_GET['item_id'];
$item = find_by_id('items', $item_id);

if (!$item) {
    $_SESSION['error'] = 'Item not found!';
    header('Location: view_items.php');
    exit();
}

include_once('layouts/header.php');
?>

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Item Details</span>
                </strong>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Item Name</th>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                        </tr>
                        <tr>
                            <th>Receipt No</th>
                            <td><?php echo htmlspecialchars($item['receipt_number']); ?></td>
                        </tr>
                        <tr>
                            <th>Quantity</th>
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td><?php echo htmlspecialchars($item['price']); ?></td>
                        </tr>
                        <tr>
                            <th>Cost</th>
                            <td><?php echo htmlspecialchars($item['cost']); ?></td>
                        </tr>
                        <tr>
                            <th>Supplier</th>
                            <td><?php echo htmlspecialchars($item['supplier']); ?></td>
                        </tr>
                        <tr>
                            <th>Date Added</th>
                            <td><?php echo htmlspecialchars($item['date_added']); ?></td>
                        </tr>
                        <tr>
                            <th>Minimum Stock Level</th>
                            <td><?php echo htmlspecialchars($item['min_stock_level']); ?></td>
                        </tr>
                        <tr>
                            <th>Supplier Contact</th>
                            <td><?php echo htmlspecialchars($item['supplier_contact']); ?></td>
                        </tr>
                    </tbody>
                </table>
                <a href="edit_item.php?item_id=<?php echo $item['id']; ?>" class="btn btn-warning">Edit</a>
                <a href="delete_item.php?item_id=<?php echo $item['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                <a href="view_items.php" class="btn btn-default">Back to Items List</a>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
