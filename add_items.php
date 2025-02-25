<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$page_title = 'Add New Item';
require_once('includes/load.php');
require_once('includes/database.php');
page_require_level(1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_name = $_POST['item_name'];
    $receipt_number = $_POST['receipt_number'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $supplier = $_POST['supplier'];
    $date_added = $_POST['date_added'];
    $min_stock_level = $_POST['min_stock_level'];
    $supplier_contact = $_POST['supplier_contact'];
    $cost = $price * $quantity;

    // Handle file uploads
    $image_path = '';
    $document_path = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_path = 'uploads/images/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
    }

    if (isset($_FILES['document']) && $_FILES['document']['error'] == 0) {
        $document_path = 'uploads/documents/' . basename($_FILES['document']['name']);
        move_uploaded_file($_FILES['document']['tmp_name'], $document_path);
    }

    // Prepare and execute the SQL statement using mysqli directly
    $sql = "INSERT INTO items (name, receipt_number, quantity, price, cost, supplier, date_added, min_stock_level, supplier_contact) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $db->prepare($sql)) {
        $stmt->bind_param('ssiidssii', $item_name, $receipt_number, $quantity, $price, $cost, $supplier, $date_added, $min_stock_level, $supplier_contact);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Item added successfully!";
        } else {
            $_SESSION['error'] = "Failed to add item! " . $stmt->error;
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = "Failed to prepare SQL statement! " . $db->error;
    }

    // Clear POST data
    $_POST = array();

    // Redirect to view_items.php
    header('Location: view_items.php');
    exit();
}
?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">

            <div class="panel-body">
                <form action="add_items.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="item_name">Item Name:</label>
                        <input type="text" class="form-control" name="item_name" required>
                    </div>
                    <div class="form-group">
                        <label for="receipt_number">Receipt Number:</label>
                        <input type="text" class="form-control" name="receipt_number" required>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <input type="number" class="form-control" name="quantity" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" class="form-control" name="price" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="cost">Cost:</label>
                        <input type="text" class="form-control" name="cost" readonly>
                    </div>
                    <div class="form-group">
                        <label for="supplier">Supplier/Vendor:</label>
                        <input type="text" class="form-control" name="supplier" required>
                    </div>
                    <div class="form-group">
                        <label for="date_added">Date Added:</label>
                        <input type="datetime-local" class="form-control" name="date_added" value="<?php echo date('Y-m-d\TH:i'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="min_stock_level">Minimum Stock Level:</label>
                        <input type="number" class="form-control" name="min_stock_level">
                    </div>
                    <div class="form-group">
                        <label for="supplier_contact">Supplier Contact:</label>
                        <input type="text" class="form-control" name="supplier_contact">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="view_items.php" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.querySelector('input[name="quantity"]');
    const priceInput = document.querySelector('input[name="price"]');
    const costInput = document.querySelector('input[name="cost"]');

    function updateCost() {
        const quantity = parseFloat(quantityInput.value) || 0;
        const price = parseFloat(priceInput.value) || 0;
        costInput.value = (quantity * price).toFixed(2);
    }

    quantityInput.addEventListener('input', updateCost);
    priceInput.addEventListener('input', updateCost);
});
</script>
