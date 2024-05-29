<?php
include 'db.php';

function getTransactionsByMonth($conn, $month, $year) {
    $sql = "SELECT id, type, item_name, amount, transaction_date, created_at, updated_at 
            FROM transactions 
            WHERE MONTH(transaction_date) = ? AND YEAR(transaction_date) = ? 
            ORDER BY transaction_date";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $month, $year);
    $stmt->execute();
    $result = $stmt->get_result();
    $transactions = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $transactions;
}

function getAllTransactions($conn) {
    $sql = "SELECT id, type, item_name, amount, transaction_date, created_at, updated_at 
            FROM transactions 
            ORDER BY transaction_date";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

function addTransaction($conn, $type, $item_name, $amount, $transaction_date) {
    $sql = "INSERT INTO transactions (type, item_name, amount, transaction_date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssds", $type, $item_name, $amount, $transaction_date);
    $stmt->execute();
    $stmt->close();
}

function updateTransaction($conn, $id, $type, $item_name, $amount, $transaction_date) {
    $sql = "UPDATE transactions SET type = ?, item_name = ?, amount = ?, transaction_date = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdsi", $type, $item_name, $amount, $transaction_date, $id);
    $stmt->execute();
    $stmt->close();
}

function deleteTransaction($conn, $id) {
    $sql = "DELETE FROM transactions WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

function getMonthlyReport($conn, $month, $year) {
    $sql = "SELECT type, SUM(amount) as total 
            FROM transactions 
            WHERE MONTH(transaction_date) = ? AND YEAR(transaction_date) = ? 
            GROUP BY type";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $month, $year);
    $stmt->execute();
    $result = $stmt->get_result();
    $report = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    $summary = [
        'income' => 0,
        'expense' => 0,
        'balance' => 0
    ];

    foreach ($report as $row) {
        if ($row['type'] == 'income') {
            $summary['income'] = $row['total'];
        } elseif ($row['type'] == 'expense') {
            $summary['expense'] = $row['total'];
        }
    }
    $summary['balance'] = $summary['income'] - $summary['expense'];
    return $summary;
}

function getFullReport($conn) {
    $sql = "SELECT type, SUM(amount) as total 
            FROM transactions 
            GROUP BY type";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $report = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    $summary = [
        'income' => 0,
        'expense' => 0,
        'balance' => 0
    ];

    foreach ($report as $row) {
        if ($row['type'] == 'income') {
            $summary['income'] = $row['total'];
        } elseif ($row['type'] == 'expense') {
            $summary['expense'] = $row['total'];
        }
    }
    $summary['balance'] = $summary['income'] - $summary['expense'];
    return $summary;
}
?>
