<?php
// Connexion à la base de données avec PDO
$serveur='localhost';
$utilisateur='root';
$mot_de_passe='';
$base='nous';
$dsn = "mysql:host=$serveur;dbname=$base;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
try {
    $pdo = new PDO($dsn, $utilisateur, $mot_de_passe, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

// Récupérer le mois et l'année actuels
$month = isset($_GET['month']) ? $_GET['month'] : date('n');
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');

// Traitement de l'ajout d'événement
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    
    // Insérer l'événement dans la base de données
    $stmt = $pdo->prepare("INSERT INTO calendar_event_master (event_name, event_start_date) VALUES (:event_name, :event_date)");
    $stmt->bindParam(':event_name', $event_name);
    $stmt->bindParam(':event_date', $event_date);
    $stmt->execute();
    
    // Rediriger vers la même page pour rafraîchir le calendrier
    header("Location: ".$_SERVER['PHP_SELF']."?month=$month&year=$year");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier</title>
   <link rel="stylesheet" href="evetstyl.css">
</head>
<body bgcolor="#82defa">
<header>
<img src="logo3.jpg" width="100px" height="100px" align="left">
      <h1><center>OUR SOCIETY</center></h1>
      <ul>
        <li>
            <a href="projet.html">Accueil</a>
        </li> <li>
            <a href="insciplearn.html">Inscription</a>
        </li> <li>
            <a href="discussionproj.php">Discussion</a>
        </li>
        <li class="active">
            <a href="evet.php">Evenement</a>
        </li> <li >
            <a href="actualiterproj.php">Actualiter</a>
        </li>
      </ul>
    </header> 
    <br><br><br>
    <h2>Calendrier</h2>
    <div>
        <a href="?month=<?php echo ($month > 1) ? ($month - 1) : 12; ?>&year=<?php echo ($month > 1) ? $year : ($year - 1); ?>">Précédent</a>
        <?php echo date('F Y', mktime(0, 0, 0, $month, 1, $year)); ?>
        <a href="?month=<?php echo ($month < 12) ? ($month + 1) : 1; ?>&year=<?php echo ($month < 12) ? $year : ($year + 1); ?>">Suivant</a>
    </div>
    <h2>Ajouter un événement</h2>
    <form method="post" action="">
        <label for="event_name">Nom de l'événement :</label>
        <input type="text" id="event_name" name="event_name" required>
        <label for="event_date">Date de l'événement :</label>
        <input type="date" id="event_date" name="event_date" required>
        <input type="submit" value="Ajouter">
    </form>

    <?php
   // Fonction pour afficher le calendrier
function displayCalendar($month, $year, $pdo) {
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    $daysInMonth = date('t', $firstDayOfMonth);
    $offset = date('w', $firstDayOfMonth);
    
    echo '<table>';
    echo '<tr><th>Lun</th><th>Mar</th><th>Mer</th><th>Jeu</th><th>Ven</th><th>Sam</th><th>Dim</th></tr>';
    
    $day = 1;
    $rows = ceil(($offset + $daysInMonth) / 7);
    
    for ($i = 0; $i < $rows; $i++) {
        echo '<tr>';
        for ($j = 0; $j < 7; $j++) {
            if (($day <= $daysInMonth && $i == 0 && $j >= $offset) || ($i > 0 && $day <= $daysInMonth)) {
                echo '<td>';
                // Vérifier s'il y a un événement pour ce jour
                $start_date = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
                $stmt = $pdo->prepare("SELECT * FROM calendar_event_master WHERE event_start_date = :start_date");
                $stmt->bindParam(':start_date', $start_date);
                $stmt->execute();
                $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($events)) {
                    // Afficher les détails de l'événement
                    echo '<ul class="event-list">';
                    foreach ($events as $event) {
                        echo '<li>'.$event['event_name'].'</li>';
                    }
                    echo '</ul>';
                }
                // Afficher le numéro du jour
                echo '<span class="day-number">'. $day .'</span>';
                echo '</td>';
                $day++;
            } else {
                echo '<td></td>';
            }
        }
        echo '</tr>';
    }
    echo '</table>';
}

    displayCalendar($month, $year, $pdo);
    ?>
       <footer>
    

        
    <h4>Contact: 77156076/ 77454872 <br>
 Emails : mairamduomaham@gmail.com/idmanidrissmoud@gmail.com</h4>
 
     
 
 
</footer>
</body>
</html>