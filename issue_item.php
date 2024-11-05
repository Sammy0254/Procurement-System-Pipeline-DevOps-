<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$page_title = 'Issue Item';
require_once('includes/load.php');
require_once('includes/sql.php');
require_once('includes/database.php');
page_require_level(1);

// Fetch all items for selection
$items = find_all('items');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_id = (int)$_POST['item_id'];
    $quantity_issued = (int)$_POST['quantity'];
    $issued_to = $_POST['issued_to'];
    $date_issued = date('Y-m-d H:i:s'); // Set to current date and time

    // Find the item to ensure it exists and fetch its current quantity
    $item = find_by_id('items', $item_id);
    if (!$item) {
        $_SESSION['error'] = 'Item not found!';
        header('Location: issue_item.php');
        exit();
    }

    // Ensure there's enough quantity to issue
    if ($quantity_issued > $item['quantity']) {
        $_SESSION['error'] = 'Not enough quantity to issue!';
        header('Location: issue_item.php');
        exit();
    }

    // Update the item's quantity
    $new_quantity = $item['quantity'] - $quantity_issued;
    $update_sql = "UPDATE items SET quantity = {$new_quantity} WHERE id = {$item_id}";

    // Record the issuance in an 'issuances' table
    $insert_sql = "INSERT INTO issuances (item_id, quantity, issued_to, date_issued) 
                   VALUES ({$item_id}, {$quantity_issued}, '{$db->escape($issued_to)}', '{$date_issued}')";

    if ($db->query($update_sql) && $db->query($insert_sql)) {
        $_SESSION['message'] = "Item issued successfully!";
    } else {
        $_SESSION['error'] = "Failed to issue item! " . $db->error;
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
                    <span>Issue Item</span>
                </strong>
            </div>
            <div class="panel-body">
                <form action="issue_item.php" method="post">
                    <div class="form-group">
                        <label for="item_id">Item:</label>
                        <select class="form-control" name="item_id" required>
                            <?php foreach ($items as $item): ?>
                                <option value="<?php echo $item['id']; ?>"><?php echo htmlspecialchars($item['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity to Issue:</label>
                        <input type="number" class="form-control" name="quantity" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="issued_to">Issued To:</label>
                        <input type="text" class="form-control" name="issued_to" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Issue</button>
                        <a href="view_items.php" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
