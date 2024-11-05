<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$page_title = 'Return Item';
require_once('includes/load.php');
require_once('includes/sql.php');
require_once('includes/database.php');
page_require_level(1);

global $db;

// Fetch all items for selection
$items = find_all('items');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_id = (int)$_POST['item_id'];
    $quantity = (int)$_POST['quantity'];
    $returned_by = $_POST['returned_by'];
    $return_date = date('Y-m-d H:i:s'); // Set to current date and time

    // Find the item to ensure it exists and fetch its current quantity
    $item = find_by_id('items', $item_id);
    if (!$item) {
        $_SESSION['error'] = 'Item not found!';
        header('Location: return_item.php');
        exit();
    }

    // Insert return record into database
    $insert_sql = "INSERT INTO returns (item_id, quantity, returned_by, return_date) 
                   VALUES ({$item_id}, {$quantity}, '{$db->escape($returned_by)}', '{$return_date}')";

    if ($db->query($insert_sql)) {
        $_SESSION['message'] = "Return processed successfully!";
    } else {
        $_SESSION['error'] = "Failed to process return! " . $db->error;
    }

    // Clear POST data
    $_POST = array();

    // Redirect to view_items.php
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
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Return Item</span>
                </strong>
            </div>
            <div class="panel-body">
                <form action="return_item.php" method="post">
                    <div class="form-group">
                        <label for="item_id">Item:</label>
                        <select class="form-control" name="item_id" required>
                            <?php foreach ($items as $item): ?>
                                <option value="<?php echo $item['id']; ?>"><?php echo htmlspecialchars($item['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity to Return:</label>
                        <input type="number" class="form-control" name="quantity" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="returned_by">Returned By:</label>
                        <input type="text" class="form-control" name="returned_by" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Return</button>
                        <a href="view_items.php" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
