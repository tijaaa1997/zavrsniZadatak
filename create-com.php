<!--    1.napraviti formu za komentar
        2.na klik dugmeta posaljemo post request koji u body ima telo komentara i autora
-->

<form method="POST" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
    <input name="com_body" type="text" value="type.."/>
    <input name="com_author" type="text" value="author"/>
    <input type="submit" value="Add" />
</form>


<?php
    include('db.php');

    if (isSet($_POST['com_body']) && isSet($_POST['com_author'])) {

        //3.uzmemo telo post request-a
        $com_body = $_POST['com_body'];
        $com_author = $_POST['com_author'];
        $post_id = $_GET['id'];


        //4.upit ka bazi insert into, da dodamo komentar u bazu
        $sql = "INSERT INTO comments (body, author, post_id) VALUES (:com_body, :com_author, :post_id)";

        $statement = $connection->prepare($sql);

        $statement->bindParam(":com_body", $com_body);

        $statement->bindParam(":com_author", $com_author);

        $statement->bindParam(":post_id", $post_id);

        try {
            $statement->execute();
            header("Refresh:0");
        }
        catch(PDOException $e)
        {
            //5. Sta ako dodje do greske? Ispisi poruku o tome
            echo "Doslo je do greske.Nemoguce postaviti komentar.";
        }
       
    }