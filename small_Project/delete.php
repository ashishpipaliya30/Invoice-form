<?php
include "conn.php";

if (isset($_GET['id'])) {
    $invoice_id = $_GET['id'];
    
    // Retrieve invoice details from the database
    $sql = "SELECT * FROM `invoices` WHERE `id` = '$invoice_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $invoice = $result->fetch_assoc();
    } else {
        echo "Invoice not found.";
        exit;
    }
} else {
    echo "Invalid invoice ID.";
    exit;
}

// Process form submission for deleting invoice
if (isset($_POST['delete'])) {
    // Delete the invoice from the database
    $sql = "DELETE FROM `invoices` WHERE `id`='$invoice_id'";
    $result = $conn->query($sql);

    if ($result === TRUE) {
        echo "Invoice deleted successfully.";
        // Redirect to the main page or a list of invoices after deletion
        header("Location: invoices.php");
        exit;
    } else {
        echo "Error deleting invoice: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Invoice</title>
    <!-- Include your styles or link to a stylesheet if needed -->
</head>

<body>
    <h2>Delete Invoice</h2>
    <p>Are you sure you want to delete the following invoice?</p>
    <p><strong>ID:</strong> <?php echo $invoice['id']; ?></p>
    <p><strong>Client Name:</strong> <?php echo $invoice['client_name']; ?></p>
    <!-- Include other invoice details for confirmation -->

    <form action="" method="POST">
        <input type="submit" name="delete" value="Delete Invoice">
    </form>

    <!-- Add a link back to the main page or a list of invoices -->
    <a href="create.php">Back to Invoices</a>
</body>

</html>
