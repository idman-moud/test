<html>
<head>
</head>
<title> exemple d’application sur php </title>
<section>
<h2>Liste des citoyens</h2>	
<table border=1>
<tr><td><b>Nom</td><td><b>Adresse</td><td><b>Email</td><td>Password</td></tr>
<?php
// Effectuer la connexion à la Base de Données
$serverName = "localhost";       // serveur local
$userName = "root";   // administrateur de la base
$password = "";           // mot de passe de l'administrateur
$dbName = "projet";   // nom de la base
$connexion = mysqli_connect($serverName, $userName, $password, $dbName);
if ($connexion) {
 // Effectuer la requête
 $query = "SELECT nom, adresse, Email,password FROM citizen
  ";
 $result = mysqli_query($connexion, $query);

 // Afficher les lignes du tableau en fonction de la réponse à la requête
 if ($result) {
  if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
    echo "<tr><td>".$row["nom"]."</td><td>".$row["adresse"]."</td><td>".$row["Email"]."</td><td>".$row["password"]."</td></tr>\n";
   }
  }
 }

 // Fermer la connexion
 mysqli_close($connexion);
}
?>
</table>
</section></html>
