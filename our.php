<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "nous";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

$nom = $_POST["nom"];
$adresse = $_POST["adresse"];
$email = $_POST["email"];
$password = $_POST["password"];
$id_carte_nationale = $_POST["id_carte_nationale"];

$sql = "INSERT INTO citizens (nom, adresse, Email, password, id) VALUES ('$nom', '$adresse', '$email', '$password','$id_carte_nationale')";

if (mysqli_query($conn, $sql)) {
    echo "Bravo cher citoyen, bienvenue dans notre société !";
    header("Location: discussionproj.php"); // Rediriger vers la page de discussion
    exit();
} else {
    echo "Erreur : " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>
