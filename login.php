<?php
include 'db_connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password']; // No hashing

    $action = $conn->prepare("SELECT id, password FROM userdata WHERE username = ?"); // Change userdata to users
    $action->bind_param("s", $username);
    $action->execute();
    $action->store_result();

    if ($action->num_rows > 0) {
        $action->bind_result($user_id, $stored_password); // Fetch user_id
        $action->fetch();

        // Compare plain text passwords
        if ($password === $stored_password) {
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user_id; // Store user_id in session
            header("Location: manage_books.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that username.";
    }

    $action->close();
    $conn->close();
}
?>