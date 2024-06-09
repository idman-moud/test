<?php
// Configuration et connexion à la base de données

// Vérifiez si l'ID du message est passé
if (isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];

    // Récupérez les informations du message original
    $sql = "SELECT title FROM posts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();

    // Affichez le titre du message original
    echo "<h1>Vous répondez à : " . htmlspecialchars($post['title']) . "</h1>";

    // Affichez le formulaire de réponse
    echo '<form action="post_reply.php" method="post">
        <input type="hidden" name="post_id" value="' . $post_id . '">
        <label for="citizen_id">Votre ID de citoyen :</label>
        <input type="number" id="citizen_id" name="citizen_id" required>
        <br>
        <label for="reply_message">Votre réponse :</label>
        <textarea id="reply_message" name="reply_message" required></textarea>
        <br>
        <input type="submit" value="Envoyer la réponse">
    </form>';
}

// Fermez la connexion à la base de données
$conn->close();
?>
