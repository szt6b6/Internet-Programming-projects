<html>
    <head>
        <title>search</title>
        <link rel="stylesheet" href="css/return.css">
    </head>
    <body>
        <!-- return home button -->
        <form method="post" id="home" action="index.php">
            <input class="button" type="submit" value="Home"/>
        </form>

<?php
/**return book to database */
if (isset($_COOKIE['logined_user_id'])) {
    $userid = filter_var($_POST['userid'], FILTER_SANITIZE_NUMBER_INT);
    $bookid = filter_var($_POST['bookid'], FILTER_SANITIZE_NUMBER_INT);

    require_once './entities/operation_data.php';

    $operator = new Operator();

    if ($operator->returnBookToDatabase($userid, $bookid)) {
        echo "<p class='success'>return book sucessfully</p>";
    }
    else {
        echo "<p class='error'>return book failed</p>";
    }


}
else {
    echo "<p class='error'>you are not logined<p>";
}

?>
    </body>
</html>