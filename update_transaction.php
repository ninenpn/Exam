<?php
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $type = $_POST['type'];
    $item_name = $_POST['item_name'];
    $amount = $_POST['amount'];
    $transaction_date = $_POST['transaction_date'];

    updateTransaction($conn, $id, $type, $item_name, $amount, $transaction_date);
    echo "Transaction updated successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Transaction</title>
</head>
<body>
    <h1>Update Transaction</h1>
    <form action="update_transaction.php" method="post">
        <label>Transaction ID: <input type="number" name="id" required></label><br>
        <label>Type:
            <select name="type">
                <option value="income">Income</option>
                <option value="expense">Expense</option>
            </select>
        </label><br>
        <label>Item Name: <input type="text" name="item_name" required></label><br>
        <label>Amount: <input type="number" step="0.01" name="amount" required></label><br>
        <label>Transaction Date: <input type="date" name="transaction_date" required></label><br>
        <button type="submit">Update Transaction</button>
    </form>
    <br>
    <a href="index.php">Back to Main</a>
</body>
</html>
