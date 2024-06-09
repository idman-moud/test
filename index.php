<!DOCTYPE html>
<html>
<head>
    <title>Forum de Discussion</title>
    <link rel="stylesheet" type="text/css" href="styley.css">
</head>
<body>
    <h1>Forum de Discussion</h1>
    
    <!-- Afficher les messages -->
    <?php
    include 'db.php';
    $query = "SELECT posts.*, citizen.nom as author_nom FROM posts JOIN citizen ON posts.author_id = citizen.id";
    $result = mysqli_query($conn, $query);
    if($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Récupérer le nombre de likes et dislikes
            $post_id = $row['id'];
            $query_likes = "SELECT COUNT(*) AS count FROM likes WHERE post_id = $post_id";
            $query_dislikes = "SELECT COUNT(*) AS count FROM dislikes WHERE post_id = $post_id";
            $result_likes = mysqli_query($conn, $query_likes);
            $result_dislikes = mysqli_query($conn, $query_dislikes);
            $likes = $result_likes ? mysqli_fetch_assoc($result_likes)['count'] : 0;
            $dislikes = $result_dislikes ? mysqli_fetch_assoc($result_dislikes)['count'] : 0;
            
            echo "<div class='post'>";
            echo "<h2>{$row['title']}</h2>";
            echo "<p>{$row['content']}</p>";
            echo "<p>Par: {$row['author_nom']}</p>";
            echo "<p>Date: {$row['created_at']}</p>";
            echo "<div class='actions'>";
            echo "<form action='like_post.php' method='post'>";
            echo "<input type='hidden' name='post_id' value='{$row['id']}'>";
            echo "<button type='submit' name='like'>Like</button> $likes";
            echo "</form>";
            echo "<form action='dislike_post.php' method='post'>";
            echo "<input type='hidden' name='post_id' value='{$row['id']}'>";
            echo "<button type='submit' name='dislike'>Dislike</button> $dislikes";
            echo "</form>";
            echo "</div>";
            
            // Afficher les commentaires
            $query_comments = "SELECT comments.*, citizen.nom as author_nom FROM comments JOIN citizen ON comments.author_id = citizen.id WHERE post_id = $post_id";
            $result_comments = mysqli_query($conn, $query_comments);
            if($result_comments) {
                echo "<div class='comments'>";
                while ($comment = mysqli_fetch_assoc($result_comments)) {
                    echo "<p>{$comment['content']} -  {$comment['author_nom']}</p>";
                }
                echo "</div>";
            }
            
            // Formulaire d'ajout de commentaire
            echo "<form action='add_comment.php' method='post'>";
            echo "<input type='hidden' name='post_id' value='$post_id'>";
            echo "<textarea name='comment_content' placeholder='Ajouter un commentaire' required></textarea>";
            echo "<input type='submit' value='Commenter'>";
            echo "</form>";
            
            echo "</div>";
        }
    } else {
        echo "Erreur de requête: " . mysqli_error($conn);
    }
    ?>
    
    <!-- Formulaire de publication de message -->
    <form action="submit_post.php" method="post">
        <label for="title">Titre:</label><br>
        <input type="text" id="title" name="title" required><br>
        <label for="content">Contenu:</label><br>
        <textarea id="content" name="content" required></textarea><br>
        <input type="submit" value="Poster">
    </form>
</body>
</html>
