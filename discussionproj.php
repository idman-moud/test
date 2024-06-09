
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="discu.css">
    <title>Forum de Discussion</title>
    <style>
    body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header{
    background-image:linear-gradient(rgba(0,0,0,0.6),rgba(0,0,0,0.6))  ,   url(imgi.jpg);
    background-repeat: no-repeat;
    height: 100px;
    width: 1488px;
    background-position: center;
    filter: brightness(230%) contrast(120%);
}
         h1{
            color: white;
         }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        textarea {
            width: 40%;
            padding: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .news-item {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
        }

        .news-item h2 {
            margin-top: 0;
        }

        .news-item p {
            margin: 10px 0;
        } 
        footer {
    position: fixed;
    left: 0;
    bottom: 0%;
    width: 100%;
    height: 7%;
    background-color: #333; /* Couleur de fond du footer */
    color: white; /* Couleur du texte du footer */
    text-align: center;
  }
    </style>
</head>
<body bgcolor="#82defa">
    <header>
    <img src="logo3.jpg" width="95px" height="98px" align="left">
       
       <h1><center>OUR SOCIETY</center></h1>

  
       
        <nav>
            <ul>
                <li><a href="projet.html">Accueil</a></li>
                <li><a href="insciplearn.html">Inscription</a></li>
                <li  class="active"><a href="discussionproj.php">Discussion</a></li>
                <li><a href="evet.php">Evenement</a></li>
                <li><a href="actualiterproj.php">Actualiter</a></li>
            </ul>
        </nav>
    </header>
    <h2><center>Forum de Discussion</center></h2>
      
    <?php

// Configuration
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'nous';

// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Post a message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message']) && isset($_POST['citizen_id'])) {
   
    $message = $_POST['message'];
    $citizen_id = $_POST['citizen_id']; // Assurez-vous que cette valeur est bien passée par le formulaire

    // Votre requête SQL doit maintenant inclure le citizen_id
    $sql = "INSERT INTO posts (citizen_id, message) VALUES ( ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("is", $citizen_id,$message);
        if ($stmt->execute()) {
            // Redirect to the discussion page after successful post
            header("Location: discussionproj.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Display all messages
$sql = "SELECT p.id,p.message, p.created_at, c.nom AS citizen_name
        FROM posts p
        JOIN citizens c ON p.citizen_id = c.id
        ORDER BY p.created_at DESC";
$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div>";
            echo "<h3>". htmlspecialchars($row["message"]) . "</h3>";
            echo "<h5>.Posted by " . htmlspecialchars($row["citizen_name"]) . " on " . $row["created_at"] . "</h5>";
            echo "</div>";
        }
    } else {
        echo "No messages yet!";
    }
}

$conn->close();
?>

<form method="POST" enctype="multipart/form-data">
    
    <br><br>
     <label for="message">Message:</label>
     <textarea id="message" name="message"></textarea><br><br>
     <label for="citizen_id">Citizen ID:</label>
 <input type="text" id="citizen_id" name="citizen_id"><br><br>
 <input type="submit" value="Post Message">
     </form>

    <footer>
    

        
    <h4>Contact: 77156076/ 77454872 <br>
 Emails : mairamduomaham@gmail.com/idmanidrissmoud@gmail.com</h4>
 
     
 
 
</footer>

                </body>
                </html>