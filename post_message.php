<?php

// Configuration
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'nous';

// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Post a message
if (isset($_POST['title']) && isset($_POST['message']) && isset($_POST['citizen_id'])) {
    $citizen_id = $_POST['citizen_id'];
    $title = $_POST['title'];
    $message = $_POST['message'];

    $sql = "INSERT INTO posts (citizen_id, title, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("iss", $citizen_id, $title, $message);
        if ($stmt->execute()) {
            // Redirect to the discussion page after successful post
            header("Location: discussionproj.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Display all messages
$sql = "SELECT p.id, p.title, p.message, p.created_at, c.nom AS citizen_name
        FROM posts p
        JOIN citizens c ON p.citizen_id = c.id
        ORDER BY p.created_at DESC";
$result = $conn->query($sql);

// Display a form for users to enter their message
echo '<form action="post_message.php" method="post">
    <label for="citizen_id">Citizen ID:</label>
    <input type="number" id="citizen_id" name="citizen_id" required>
    <br>
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" required>
    <br>
    <label for="message">Message:</label>
    <textarea id="message" name="message" required></textarea>
    <br>
    <input type="submit" value="Post Message">
</form>';

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<h2>" . htmlspecialchars($row["title"]) . "</h2>";
        echo "<p>Posted by " . htmlspecialchars($row["citizen_name"]) . " on " . $row["created_at"] . "</p>";
        echo "<p>" . htmlspecialchars($row["message"]) . "</p>";
        echo "<hr>";
    }
} else {
    echo "No messages yet!";
}

$conn->close();
?>