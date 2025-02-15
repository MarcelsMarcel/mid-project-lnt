<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $number_of_page = $_POST['number_of_page'];
    $user_id = $_SESSION['user_id'];

    $action = $conn->prepare("INSERT INTO books (name, author, publisher, number_of_page, user_id) VALUES (?, ?, ?, ?, ?)");
    $action->bind_param("ssssi", $name, $author, $publisher, $number_of_page, $user_id);

    if ($action->execute()) {
        echo "Book added successfully!";
    } else {
        echo "Error: " . $action->error;
    }

    $action->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="container">
    <h2>Add New Book</h2>
    <form action="add_book.php" method="POST">
        <label style="align-self: center;" for="name">Book Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>
        
        <label style="align-self: center;" for="author">Author:</label><br>
        <input type="text" id="author" name="author" required><br><br>
        
        <label style="align-self: center;" for="publisher">Publisher:</label><br>
        <input type="text" id="publisher" name="publisher" required><br><br>
        
        <label style="align-self: center;" for="number_of_page">Number of Pages:</label><br>
        <input type="number" id="number_of_page" name="number_of_page" required><br><br>
        
        <input style="padding-bottom: 10px;" type="submit" value="Add Book">
    </form>
    <a href="manage_books.php">Back to Manage Books</a>
    </div>

    <footer>
        <div class="footer-container">
            <p>LnT Mid Project - Back End</p>
            <div class="social-links">
                <a href="https://www.instagram.com/marcel_setyadji/" target="_blank">
                    <img src="https://img.icons8.com/ios11/512/228BE6/instagram-circle.png" alt="Instagram">
                </a>
                <a href="https://www.instagram.com/vinadrrr/" target="_blank">
                    <img src="https://img.icons8.com/ios11/512/228BE6/instagram-circle.png" alt="X (Twitter)">
                </a>
                <a href="https://www.instagram.com/ray_kurniii/" target="_blank">
                    <img src="https://img.icons8.com/ios11/512/228BE6/instagram-circle.png" alt="Facebook">
                </a>
            </div>
        </div>
    </footer>  

</body>
</html>