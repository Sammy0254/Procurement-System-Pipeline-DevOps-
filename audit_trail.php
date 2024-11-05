<?php
require_once('includes/load.php');

function get_audit_trail() {
    global $con; // Assuming $con is your database connection
    $sql = "SELECT * FROM audit_trail ORDER BY action_date DESC";
    return $con->query($sql);
}

$audit_trail = get_audit_trail();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Audit Trail</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <?php include('layouts/header.php'); ?>
    
    <main>
        <h1>Audit Trail</h1>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Action</th>
                    <th>Details</th>
                    <th>Date</th>
                    <th>User ID</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($audit_trail->num_rows > 0): ?>
                    <?php while ($row = $audit_trail->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['action']); ?></td>
                            <td><?php echo htmlspecialchars($row['details']); ?></td>
                            <td><?php echo htmlspecialchars($row['action_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
    
    <?php include('layouts/footer.php'); ?>
</body>
</html>
