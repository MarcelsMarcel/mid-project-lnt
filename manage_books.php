<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$action = $conn->prepare("SELECT * FROM books WHERE user_id = ?");
$action->bind_param("i", $user_id);
$action->execute();
$result = $action->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Books</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
    <a style="align-self: center;" href="add_book.php">Add New Book</a>
    <h3>Your Books</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Author</th>
            <th>Publisher</th>
            <th>Number of Pages</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['author']; ?></td>
            <td><?php echo $row['publisher']; ?></td>
            <td><?php echo $row['number_of_page']; ?></td>
            <td>
                <a href="update_book.php?id=<?php echo $row['id']; ?>">Edit</a>
                <a href="delete_book.php?id=<?php echo $row['id']; ?>">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a style="align-self: center;" href="logout.php">Logout</a>
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

<?php
$action->close();
$conn->close();
?>