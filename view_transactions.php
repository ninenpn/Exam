<?php
include 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Transactions</title>
    <style>
        .income { color: green; }
        .expense { color: red; }
    </style>
</head>
<body>
    <h1>View Transactions</h1>
    <form action="view_transactions.php" method="get">
        <label>View:
            <select name="view_type" id="view_type" onchange="toggleDateInputs()">
                <option value="all">All Transactions</option>
                <option value="specific">Specific Month/Year</option>
            </select>
        </label>
        <div id="date_inputs" style="display:none;">
            <label>Month: <input type="number" name="month" min="1" max="12"></label>
            <label>Year: <input type="number" name="year" min="2000" max="2100"></label>
        </div>
        <button type="submit" name="view">View Transactions</button>
    </form>

    <script>
        function toggleDateInputs() {
            var viewType = document.getElementById("view_type").value;
            var dateInputs = document.getElementById("date_inputs");
            if (viewType === "specific") {
                dateInputs.style.display = "block";
            } else {
                dateInputs.style.display = "none";
            }
        }
    </script>

    <?php
    if (isset($_GET['view'])) {
        $view_type = $_GET['view_type'];

        if ($view_type == "all") {
            $transactions = getAllTransactions($conn);
        } elseif ($view_type == "specific") {
            $month = $_GET['month'];
            $year = $_GET['year'];
            echo "<p>Filtering transactions for month: $month, year: $year</p>";
            $transactions = getTransactionsByMonth($conn, $month, $year);
        }

        if (!empty($transactions)) {
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>Type</th><th>Item Name</th><th>Amount</th><th>Transaction Date</th><th>Created At</th><th>Updated At</th></tr>";
            foreach ($transactions as $transaction) {
                $transaction = array_change_key_case($transaction, CASE_LOWER);
                $typeClass = $transaction['type'] == 'income' ? 'income' : 'expense';
                echo "<tr class='{$typeClass}'>
                        <td>{$transaction['id']}</td>
                        <td>{$transaction['type']}</td>
                        <td>{$transaction['item_name']}</td>
                        <td>{$transaction['amount']}</td>
                        <td>{$transaction['transaction_date']}</td>
                        <td>{$transaction['created_at']}</td>
                        <td>{$transaction['updated_at']}</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "No transactions found.";
        }
    }
    ?>
    <br>
    <a href="index.php">Back to Main</a>
</body>
</html>
