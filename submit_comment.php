<?php

$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'nous';

// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment']) && isset($_POST['post_id'])) {
    $comment = $_POST['comment'];
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user_id']; // Assurez-vous que l'utilisateur est connecté et que son ID est stocké dans $_SESSION

    $query = "INSERT INTO commentaires (post_id, user_id, texte, date_creation) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iis", $post_id, $user_id, $comment);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: page_du_poste.php?id=" . $post_id); // Redirigez vers la page du poste
    } else {
        echo "Erreur lors de l'ajout du commentaire.";
    }
}
?>
