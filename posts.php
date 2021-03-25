
<html>
<head>
<link href="styles/blog.css" rel="stylesheet">
</head>
<body>
<?php


    include('header.php');
    include('sidebar.php');
    include ('db.php');

    //hocemo da dobavimo postove iz baze
    $sql = "SELECT * FROM posts ORDER BY created_at desc";

    $statement = $connection->prepare($sql);

    // izvrsavamo upit
    $statement->execute();

    // zelimo da se rezultat vrati kao asocijativni niz.
    // ukoliko izostavimo ovu liniju, vratice nam se obican, numerisan niz
    $statement->setFetchMode(PDO::FETCH_ASSOC);

    // punimo promenjivu sa rezultatom upita
    $posts = $statement->fetchAll();

?>
<main role="main" class="container">

<div class="row">

    <div class="col-sm-8 blog-main">

    <?php

        foreach($posts as $post) {
            ?>
            
            <div class="blog-post">
            <h2 class="blog-post-title"><a href="single-post.php?id=<?php echo($post['id'])?>"><?php echo($post['title'])?></a></h2>
            <p class="blog-post-meta"><?php echo($post['created_at'])?> by <a href="#"><?php echo($post['author']) ?></a></p></p>

            <p><?php echo($post['body'])?></p>
        </div><!-- /.blog-post -->

 

        <?php
        }
    ?>
       


        <nav class="blog-pagination">
            <a class="btn btn-outline-primary" href="#">Older</a>
            <a class="btn btn-outline-secondary disabled" href="#">Newer</a>
        </nav>

    </div><!-- /.blog-main -->
</div>
</main>
<?php

    include('footer.php');
?>
</body>
</html>



