<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $action = $conn->prepare("DELETE FROM books WHERE id = ?");
    $action->bind_param("i", $id);

    if ($action->execute()) {
        echo "Book deleted successfully!";
        header("Location: manage_books.php");
        exit();
    } else {
        echo "Error: " . $action->error;
    }

    $action->close();
} else {
    echo "No book ID provided.";
}

$conn->close();
?>