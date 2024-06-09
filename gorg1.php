<?php
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

// Vérification des données postées
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Requête SQL pour vérifier les informations d'identification
    $sql = "SELECT id FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // L'utilisateur est authentifié, rediriger vers une page de discussion
        header("Location: gorg1.php");
        exit();
    } else {
        // Informer l'utilisateur que les informations d'identification sont incorrectes
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }
}

$conn->close();
?>