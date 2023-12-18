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

// Process form submission for updating invoice
if (isset($_POST['submit'])) {
    // Retrieve updated information from the form
    $client_name = $_POST['client_name'];
    $invoice_number = $_POST['invoice_number'];
    $invoice_date = $_POST['invoice_date'];
    $due_date = $_POST['due_date'];
    $amount = $_POST['amount'];

    // Update the invoice in the database
    $sql = "UPDATE `invoices` SET 
            `client_name`='$client_name', 
            `invoice_number`='$invoice_number', 
            `invoice_date`='$invoice_date', 
            `due_date`='$due_date', 
            `amount`='$amount' 
            WHERE `id`='$invoice_id'";
    
    $result = $conn->query($sql);

    if ($result === TRUE) {
        echo "Invoice updated successfully.";
    } else {
        echo "Error updating invoice: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Invoice</title>
    <!-- Include your styles or link to a stylesheet if needed -->
</head>

<body>
    <h2>Update Invoice</h2>
    <form action="" method="POST">
        <label for="client_name">Client Name:</label>
        <input type="text" name="client_name" value="<?php echo $invoice['client_name']; ?>" required>
        <br>
        <!-- Include other form fields for updating -->
        <br>
        <input type="submit" name="submit" value="Update Invoice">
    </form>

    <!-- Add a link back to the main page or a list of invoices -->
    <a href="create.php">Back to Invoices</a>
</body>

</html>
