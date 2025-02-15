<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password']; // No hashing

    if (strlen($password) < 8) {
        echo "Password must be at least 8 characters long.";
        echo '<a href="register.html">Register</a>';
        exit; // Stop further execution
    }

    // Check if the username already exists
    $checkUser  = $conn->prepare("SELECT * FROM userdata WHERE username = ?");
    $checkUser ->bind_param("s", $username);
    $checkUser ->execute();
    $checkUser ->store_result();

    if ($checkUser ->num_rows > 0) {
        echo "Account already exists. Please choose a different username.\n";
        echo '<a href="register.html">Register</a>';
    } else {
        // Prepare and bind
        $action = $conn->prepare("INSERT INTO userdata (username, password) VALUES (?, ?)");
        $action->bind_param("ss", $username, $password); // Store plain text password

        if ($action->execute()) {
            echo "Registration successful!";
            echo '<a href="index.html">Click here to login</a>';
        } else {
            echo "Error: " . $action->error;
        }

        $action->close();
    }

    $checkUser ->close();
    $conn->close();
}
?>