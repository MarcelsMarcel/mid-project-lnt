<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $number_of_page = $_POST['number_of_page'];

    $action = $conn->prepare("UPDATE books SET name = ?, author = ?, publisher = ?, number_of_page = ? WHERE id = ?");
    $action->bind_param("ssssi", $name, $author, $publisher, $number_of_page, $id);

    if ($action->execute()) {
        echo "Book updated successfully!";
        header("Location: manage_books.php");
        exit();
    } else {
        echo "Error: " . $action->error;
    }

    $action->close();
} else {
    $id = $_GET['id'];
    $action = $conn->prepare("SELECT * FROM books WHERE id = ?");
    $action->bind_param("i", $id);
    $action->execute();
    $result = $action->get_result();
    $book = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Edit Book</h2>
        <form action="update_book.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $book['id']; ?>">
            
            <label for="name">Book Name:</label>
            <input type="text" id="name" name="name" class="input-field" value="<?php echo $book['name']; ?>" required>
            
            <label for="author">Author:</label>
            <input type="text" id="author" name="author" class="input-field" value="<?php echo $book['author']; ?>" required>
            
            <label for="publisher">Publisher:</label>
            <input type="text" id="publisher" name="publisher" class="input-field" value="<?php echo $book['publisher']; ?>" required>
            
            <label for="number_of_page">Number of Pages:</label>
            <input type="number" id="number_of_page" name="number_of_page" class="input-field" value="<?php echo $book['number_of_page']; ?>" required>
            
            <input type="submit" value="Update Book" class="btn">
        </form>
        <a href="manage_books.php" class="back-link">Back to Manage Books</a>
    </div>
    
    <footer>
        <div class="footer-container">
            <p>© 2025 YourWebsite. All Rights Reserved.</p>
            <div class="social-links">
                <a href="https://www.instagram.com" target="_blank">
                    <img src="https://img.icons8.com/ios11/512/228BE6/instagram-circle.png" alt="Instagram">
                </a>
                <a href="https://twitter.com" target="_blank">
                    <img src="https://images.seeklogo.com/logo-png/49/2/twitter-x-logo-png_seeklogo-492392.png" alt="X (Twitter)">
                </a>
                <a href="https://www.facebook.com" target="_blank">
                    <img src="https://img.icons8.com/ios_filled/512/228BE6/facebook.png" alt="Facebook">
                </a>
            </div>
        </div>
    </footer>
</body>
</html>
