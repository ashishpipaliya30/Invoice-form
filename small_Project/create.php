<?php
include "conn.php";

if (isset($_POST['submit'])) {
    $client_name = $_POST['client_name'];
    $invoice_number = $_POST['invoice_number'];
    $invoice_date = $_POST['invoice_date'];
    $due_date = $_POST['due_date'];
    $amount = $_POST['amount'];

    $sql = "INSERT INTO `invoices`(`client_name`, `invoice_number`, `invoice_date`, `due_date`, `amount`) VALUES ('$client_name','$invoice_number','$invoice_date','$due_date','$amount')";
    $result = $conn->query($sql);

    if ($result == TRUE) {
        echo "";
    } else {
        echo "Error:". $sql . "<br>". $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Form</title>
    <!-- Your existing styles here -->
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
            height: 100vh;
        }

        .container {
            width: 70%;
            max-width: 600px;
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

        form {
            margin-top: 20px;
        }

        fieldset {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        legend {
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            cursor: pointer;
            font-size: 1.2rem;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Invoice Form</h2>
        <form action="create.php" method="POST">
            <fieldset>
                <legend>Invoice information:</legend>
                Client Name:<br>
                <input type="text" name="client_name" required>
                <br>
                Invoice Number:<br>
                <input type="text" name="invoice_number" required>
                <br>
                Invoice Date:<br>
                <input type="date" name="invoice_date" required>
                <br>
                Due Date:<br>
                <input type="date" name="due_date" required>
                <br>
                Amount:<br>
                <input type="text" name="amount" required>
                <br><br>
                <input type="submit" name="submit" value="Create Invoice">
            </fieldset>
        </form>
    </div>
</body>

</html>
