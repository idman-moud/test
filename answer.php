<?php
// Vérifier si le formulaire de réponse a été soumis
if(isset($_POST['submit'])) {
    // Récupérer l'identifiant du poste depuis le formulaire
    $post_id = $_POST['post_id'];
    
    // Assurez-vous de valider et échapper les données du formulaire avant de les utiliser dans la requête SQL

    // Connexion à la base de données
    require_once 'db.php';

    // Requête pour insérer la réponse dans la base de données
    $sql = "INSERT INTO responses (post_id, response_text) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$post_id, $_POST['response_text']]);
    
    // Redirection vers la page de discussion ou une autre page appropriée
    header("Location: discussionproj.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Répondre au Poste</title>
</head>
<body>
    <h2>Répondre au Poste</h2>
    <form method="post">
        <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($_POST['post_id']); ?>">
        <textarea name="response_text" placeholder="Votre réponse"></textarea>
        <br>
        <input type="submit" name="submit" value="Répondre">
    </form>
</body>
</html>
