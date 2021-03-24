<html>
    <head>
        <link href="styles/blog.css" rel="stylesheet">
    </head>
<body>

    <?php 

        include('db.php');
        include('header.php');
        //posts.php
        //1.napraviti nazive da budu linkovi 
        //2. kada se stisne na link treba da se posalje GET request sa odgovarajucim id    localhost:8080/single-post.php?id=2


        //single-post.php
        //1.dobaviti id iz url-a
        $id = $_GET['id'];


        //2.napraviti sql upit
        //3.izvrsiti sql upit i uzeti rezultat

        $sql = "select posts.id, posts.title, posts.body, posts.author, posts.created_at, comments.id as com_id, comments.body as com_body, comments.author as com_author 
        FROM posts inner join comments on posts.id = post_id  WHERE posts.id=:id";

        $statement = $connection->prepare($sql);

        $statement->bindParam(':id', $id);

        // izvrsavamo upit
        $statement->execute();

        // zelimo da se rezultat vrati kao asocijativni niz.
        // ukoliko izostavimo ovu liniju, vratice nam se obican, numerisan niz
        $statement->setFetchMode(PDO::FETCH_ASSOC);

        // punimo promenjivu sa rezultatom upita
        $posts = $statement->fetchAll();

        if(sizeof($posts) == 0) {
            echo "Doslo je do greske. Ne postoji post sa trazenim id.";
        } else {

    
            $post = $posts[0];

            //4. prikazati dobavljeni post ili poruku o gresci
    
            ?>
    
            <main role="main" class="container">
                <div class="row">
                    <div class="col-sm-8 blog-main">
                        <div class="blog-post">
                        <h2 class="blog-post-title"><a href="single-post.php?id=<?php echo($post['id'])?>"><?php echo($post['title'])?></a></h2>
                        <p class="blog-post-meta"><?php echo($post['created_at'])?> by <a href="#"><?php echo($post['author']) ?></a></p></p>
                        <p><?php echo($post['body'])?></p>
                    </div>
                </div>
            </main>
            
            <ul>
        <?php
            }

            
            foreach($posts as $post_and_comment) {
                ?>
                <li><?php echo($post_and_comment['com_body']) ?> by <?php echo($post_and_comment['com_author']) ?></li>
                <hr/>
                <?php
            }

        ?>
        </ul>


    <?php
        include('sidebar.php');
        include('footer.php');

    ?>

</body>
</html>