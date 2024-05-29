<?php
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    deleteTransaction($conn, $id);
    echo "Transaction deleted successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Transaction</title>
</head>
<body>
    <h1>Delete Transaction</h1>
    <form action="delete_transaction.php" method="post">
        <label>Transaction ID: <input type="number" name="id" required></label><br>
        <button type="submit">Delete Transaction</button>
    </form>
    <br>
    <a href="index.php">Back to Main</a>
</body>
</html>
