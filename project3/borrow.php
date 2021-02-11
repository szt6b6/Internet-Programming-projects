<html>
    <head>
        <title>borrow</title>
        <link rel="stylesheet" href="css/borrow.css">
    </head>
    <body>
        <!-- return home button -->
        <form method="post" id="home" action="index.php">
            <input class="button" type="submit" value="Home"/>
        </form>

<?php
/**use to handle the post request from user from search.php, handle borrow action, need login*/
if (!isset($_COOKIE['logined_user_id'])) {
    header('Location: ./login.php');
    exit();
}
else {
    $userid = $_COOKIE['logined_user_id'];
    $bookid = filter_var($_POST['bookid'], FILTER_SANITIZE_NUMBER_INT);
    $remindedNumberOfBooks = filter_var($_POST['remindedNumberOfBooks'], FILTER_SANITIZE_NUMBER_INT);
    //judge the left number of books in database
    if ($remindedNumberOfBooks <= 0) {
        echo "<p class='error'>no this book available<p>";
        exit();
    }
    require_once './entities/operation_data.php';

    $operation = new Operator();
    if ($operation->borrowBookFromDatabase($userid, $bookid))
        echo "<p class='success'>borrow successfully</p>";
    else
        echo "<p class='error'>borrow failed</p>";
}
?>

    </body>
</html>