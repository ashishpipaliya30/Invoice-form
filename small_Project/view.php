<?php
include "conn.php";

if (isset($_GET['id'])) {
    $invoice_id = $_GET['id'];

    // Check if the form is submitted for updating the invoice
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['edit'])) {
            // Update the invoice in the database
            $client_name = $_POST['client_name'];
            $invoice_number = $_POST['invoice_number'];
            $invoice_date = $_POST['invoice_date'];
            $due_date = $_POST['due_date'];
            $amount = $_POST['amount'];

            $updateSql = "UPDATE `invoices` SET 
                          `client_name` = '$client_name',
                          `invoice_number` = '$invoice_number',
                          `invoice_date` = '$invoice_date',
                          `due_date` = '$due_date',
                          `amount` = '$amount'
                          WHERE `id` = '$invoice_id'";

            if ($conn->query($updateSql) === TRUE) {
                echo "Invoice updated successfully.";
            } else {
                echo "Error updating invoice: " . $conn->error;
            }
        } elseif (isset($_POST['delete'])) {
            // Delete the invoice from the database
            $deleteSql = "DELETE FROM `invoices` WHERE `id` = '$invoice_id'";

            if ($conn->query($deleteSql) === TRUE) {
                echo "Invoice deleted successfully.";
                // Redirect to view_invoices.php after deletion
                header("Location: view_invoices.php");
                exit;
            } else {
                echo "Error deleting invoice: " . $conn->error;
            }
        }
    }

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
    // If 'id' parameter is not present, retrieve all invoices
    $sql = "SELECT * FROM `invoices`";
    $result = $conn->query($sql);

    if (!$result) {
        echo "Error retrieving invoices: " . $conn->error;
        exit;
    }

    // Check if the query returned any rows
    if ($result->num_rows > 0) {
        // Fetch all rows from the result set
        $invoices = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        echo "No invoices found.";
        exit;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Invoice</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .container {
            width: 70%;
            max-width: 800px;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        h2 {
            background-color: #007BFF;
            color: #fff;
            padding: 20px;
            text-align: center;
            margin: 0;
            font-size: 2rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #007BFF;
            color: #fff;
        }

        .action-buttons a {
            display: inline-block;
            margin-right: 10px;
            text-decoration: none;
            padding: 5px 10px;
            color: #fff;
            border-radius: 5px;
        }

        .edit-button {
            background-color: #28a745;
        }

        .delete-button {
            background-color: #dc3545;
        }

        a {
            text-decoration: none;
            color: #007BFF;
        }

        p {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>View Invoices</h2>

        <?php if (isset($_GET['id'])) : ?>
            <form method="post" action="">
                <!-- Display existing invoice data in input fields -->
                <p><strong>ID:</strong> <?php echo $invoice['id']; ?></p>
                <label for="client_name">Client Name:</label>
                <input type="text" name="client_name" value="<?php echo $invoice['client_name']; ?>" required>
                <!-- Repeat similar input fields for other invoice details -->

                <p class="action-buttons">
                    <button type="submit" name="edit">Update Invoice</button>
                    <button type="submit" name="delete">Delete Invoice</button>
                    <a href="view_invoices.php">Back to Invoices</a>
                </p>
            </form>

            <?php
            // Add this section for debugging
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                var_dump($_POST);
            }
            ?>

        <?php else : ?>
            <?php if (!empty($invoices)) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Client Name</th>
                            <th>Invoice Number</th>
                            <th>Invoice Date</th>
                            <th>Due Date</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($invoices as $invoice) : ?>
                            <tr>
                                <td><?php echo $invoice['id']; ?></td>
                                <td><?php echo $invoice['client_name']; ?></td>
                                <td><?php echo $invoice['invoice_number']; ?></td>
                                <td><?php echo $invoice['invoice_date']; ?></td>
                                <td><?php echo $invoice['due_date']; ?></td>
                                <td><?php echo $invoice['amount']; ?></td>
                                <td class="action-buttons">
                                    <a class="edit-button" href="create.php?id=<?php echo $invoice['id']; ?>">Edit</a>
                                    <a class="delete-button" href="create.php?id=<?php echo $invoice['id']; ?>">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>No invoices found.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
