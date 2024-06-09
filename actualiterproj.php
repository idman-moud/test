<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-UA-comptible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="stylesheet" href="styleact.css">

    <title>site</title>
</head> 
<body bgcolor="#82defa">
    
    <header>
    <img src="logo3.jpg" width="95px" height="98px" align="left">
       
            <h1><center>OUR SOCIETY</center></h1>

      <ul>
        <li>
            <a href="projet.html">Accueil</a>
        </li> <li>
            <a href="insciplearn.html">Inscription</a>
        </li> <li>
            <a href="discussionproj.php">Discussion</a>
        </li>
        <li>
            <a href="evet.php">Evenement</a>
        </li> <li class="active">
            <a href="actualiterproj.php">Actualiter</a>
        </li>
      </ul>
    </header> 
  
    <div class="container">
        <h1>Actualités</h1>
    
        <!-- Formulaire de publication d'actualité -->
        <form method="post" enctype="multipart/form-data">
            <label for="title">Titre :</label><br>
            <input type="text" id="title" name="title"><br>
            <label for="content">Contenu :</label><br>
            <textarea id="content" name="content"></textarea><br>
            <input type="submit" value="Publier">
        </form>
    
        <!-- Affichage des actualités -->
        <?php
        // Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nous";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Traitement du formulaire de publication d'actualité
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $title = $_POST['title'];
    $content = $_POST['content'];
    $published_date = date("Y-m-d H:i:s");

    // Insertion de l'actualité dans la base de données
    $sql = "INSERT INTO news (title, content, published_date) VALUES ('$title', '$content', '$published_date')";
    if ($conn->query($sql) === TRUE) {
        echo "Actualité publiée avec succès.";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!-- Affichage des actualités -->
<?php
$sql = "SELECT * FROM news ORDER BY published_date DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<h2>" . $row["title"] . "</h2>";
        echo "<h4>" . $row["content"] . "</h4>";
        echo "<p>Date de publication: " . $row["published_date"] . "</p>";
        echo "</div>";
    }
} else {
    echo "Aucune actualité trouvée.";
}

$conn->close();

        ?>
    </div>
    
</form>
    <footer>
    

        
        <h4>Contact: 77156076/ 77454872 <br>
     Emails : mairamduomaham@gmail.com/idmanidrissmoud@gmail.com</h4>
     
         
     
     
 </footer>

</body>
</html>