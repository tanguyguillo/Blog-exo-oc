<?php

// We connect to the database.
try {
    $database = new PDO('mysql:host=localhost;dbname=blog-exo-oc;charset=utf8', 'blog-exo-oc', 'blog-exo-oc');
} catch(Exception $e) {
    die('Erreur : '.$e->getMessage());
}

// We retrieve the 5 last blog posts.
$statement = $database->query(
    "SELECT id, titre, contenu, DATE_FORMAT(date_creation, '%d/%m/%Y à %Hh%imin%ss') AS date_creation_fr FROM billets ORDER BY date_creation DESC LIMIT 0, 5"
);
$posts = [];
while (($row = $statement->fetch())) {
    $post = [
        'title' => $row['titre'],
        'french_creation_date' => $row['date_creation_fr'],
        'content' => $row['contenu'],
    ];

    $posts[] = $post;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Le blog de l'AVBN</title>
    <link href="style.css" rel="stylesheet" />
</head>

<body>
<h1>Le super blog de l'AVBN !</h1>
<p>Derniers billets du blog :</p>

<?php
foreach ($posts as $post) {
    ?>
    <div class="news">
        <h3>
            <?php echo htmlspecialchars($post['title']); ?>
            <em>le <?php echo $post['french_creation_date']; ?></em>
        </h3>
        <p>
            <?php
            // We display the post content.
            echo nl2br(htmlspecialchars($post['content']));
            ?>
            <br />
            <em><a href="#">Commentaires</a></em>
        </p>
    </div>
    <?php
} // The end of the posts loop.
?>
</body>
</html>