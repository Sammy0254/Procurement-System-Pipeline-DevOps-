<?php
$page_title = 'Delete Item';
require_once('includes/load.php');
page_require_level(1);

require_once('includes/config.php');

$msg = []; // Initialize the message variable as an array

if (isset($_GET['item_id'])) {
    $item_id = $_GET['item_id'];

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Delete related records from 'issuances'
        $delete_issuances_sql = "DELETE FROM issuances WHERE item_id=?";
        $delete_stmt = $conn->prepare($delete_issuances_sql);
        $delete_stmt->bind_param("i", $item_id);
        $delete_stmt->execute();
        $delete_stmt->close();

        // Delete the item
        $sql = "DELETE FROM items WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $item_id);
        if ($stmt->execute()) {
            $msg[] = "Item deleted successfully.";
        } else {
            throw new Exception("Error deleting item: " . $conn->error);
        }
        $stmt->close();

        // Commit transaction
        $conn->commit();
    } catch (Exception $e) {
        // Rollback transaction in case of error
        $conn->rollback();
        $msg[] = $e->getMessage();
    }
    // Redirect with message
    $_SESSION['message'] = $msg; // Store message in session to display on redirected page
    header('Location: view_items.php');
    exit();
} else {
    $msg[] = "Invalid item ID.";
    $_SESSION['message'] = $msg; // Store message in session to display on redirected page
    header('Location: view_items.php');
    exit();
}
?>
