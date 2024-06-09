<?php
// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupère le message
    $message = $_POST["message"];
    
    // Vérifie si un fichier a été téléchargé
    if ($_FILES["file"]["name"]) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);

        // Déplace le fichier téléchargé vers le répertoire de téléchargement
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            echo "Le fichier ". basename( $_FILES["file"]["name"]). " a été téléchargé.";
        } else {
            echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
        }
    }

    // Enregistre le message dans la base de données, y compris le lien vers le fichier téléchargé
    // Assurez-vous d'ajuster cette partie pour correspondre à votre schéma de base de données

    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "grgio";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérification de la connexion
    if ($conn->connect_error) {
        die("Erreur de connexion à la base de données : " . $conn->connect_error);
    }

    // Requête SQL pour insérer le message dans la base de données
    $sql = "INSERT INTO discussions (id, user_id, message, file_path, timestamp) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $user_id = 1; // Remplacez 1 par l'identifiant de l'utilisateur actuel, si disponible
    $file_path = isset($target_file) ? $target_file : null;
    $stmt->bind_param("iss", $user_id, $message, $file_path);
    $stmt->execute();

    // Ferme la connexion à la base de données
    $stmt->close();
    $conn->close();
}
?>