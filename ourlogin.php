<html>
<head>
</head>
<title> ajouter des citoyens </title>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "nous";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

$email = $_POST["email"];
$password = $_POST["password"];

$sql = "SELECT * FROM citizens WHERE Email='$email' AND password='$password'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    echo "Welcome back!";
    header("Location: discussionproj.php"); // Rediriger vers la page de discussion
    exit();
} else {
    echo "Veuillez revoir votre mot de passe ou votre e-mail.";
}

mysqli_close($conn);
?>

</html>