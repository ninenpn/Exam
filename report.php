<?php
include 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report</title>
</head>
<body>
    <h1>Report</h1>
    <form action="report.php" method="get">
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
        <button type="submit" name="view">View Report</button>
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
            $report = getFullReport($conn);
            echo "<h2>Full Report</h2>";
        } elseif ($view_type == "specific") {
            $month = $_GET['month'];
            $year = $_GET['year'];
            echo "<h2>Report for {$month}/{$year}</h2>";
            $report = getMonthlyReport($conn, $month, $year);
        }

        if (!empty($report)) {
            echo "<p>Total Income: {$report['income']}</p>";
            echo "<p>Total Expense: {$report['expense']}</p>";
            echo "<p>Balance: {$report['balance']}</p>";
        } else {
            echo "No transactions found.";
        }
    }
    ?>
    <br>
    <a href="index.php">Back to Main</a>
</body>
</html>
