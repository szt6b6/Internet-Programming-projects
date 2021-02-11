<html>
    <head>
        <title>search</title>
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/admin.js"></script>
        <link rel="stylesheet" href="css/admin.css">
    </head>
    <body>
        <!-- return home button -->
        <form method="post" id="home" action="index.php">
            <input class="button" type="submit" value="Home"/>
        </form>
<?php
/**admin page, can manage books, add, delete, update */

require_once './entities/operation_data.php';

if (isset($_COOKIE['is_admin']) && $_COOKIE['is_admin'] == 1) {
    if (isset($_GET['delete'])) {
        $deleteid = filter_var($_GET['delete'], FILTER_SANITIZE_STRING);
        $operator = new Operator();
        if ($operator->deleteBook($deleteid))
            echo "<p class='success'>delete book successfully</p>";
        else
            echo "<p class='error'>delete failed<p>";
    }
    else if (isset($_GET['update'])) {
        $updateid = filter_var($_GET['update'], FILTER_SANITIZE_STRING);
        $bookname = filter_var($_POST['bookname'], FILTER_SANITIZE_STRING);
        $introduction = filter_var($_POST['introduction'], FILTER_SANITIZE_STRING);
        $remindedNumberOfBooks = filter_var($_POST['remindedNumberOfBooks'], FILTER_SANITIZE_NUMBER_INT);
        $numberOfBooks = filter_var($_POST['numberOfBooks'], FILTER_SANITIZE_NUMBER_INT);
        if ($numberOfBooks >= $remindedNumberOfBooks && $numberOfBooks > 0 && $remindedNumberOfBooks >= 0) {
            $book = new Book($bookname, $introduction, $remindedNumberOfBooks, $numberOfBooks, $updateid);
            $operator = new Operator();
            if ($operator->updateBook($book))
                echo "<p class='success'>update successfully</p>";
            else
                echo "<p class='error'>update failed<p>";
        }
        else {
            echo "<p class='error'>update failed, wrong book number</p>";
        }
    }
    else if (isset($_GET['click_add_book'])) {
        echo <<<EOF
        <table>
            <tr>
                <th>bookname</th>
                <th>introduction</th>
                <th>leftNumberOfBooks</th>
                <th>totalNumberOfBooks</th>
            </tr>
            <tr>
                <form method="post" action="admin.php?add_book_to_database">
                    <th><input type="text" name="bookname" required /></th>
                    <th><input type="text" name="introduction" required/></th>
                    <th><input id="leftNumber" type="number" name="remindedNumberOfBooks" required/></th>
                    <th><input id="totalNumber" type="number" name="numberOfBooks" readonly/></th>
                    <th><input type="submit" value="add" onclick="return confirm('Are you sure to add this book?');"/></th>
                </form>
            </tr>
        </table>
        EOF;
    }
    else if (isset($_GET['add_book_to_database'])) {
        $bookname = filter_var($_POST['bookname'], FILTER_SANITIZE_STRING);
        $introduction = filter_var($_POST['introduction'], FILTER_SANITIZE_STRING);
        $remindedNumberOfBooks = filter_var($_POST['remindedNumberOfBooks'], FILTER_SANITIZE_NUMBER_INT);
        $numberOfBooks = filter_var($_POST['numberOfBooks'], FILTER_SANITIZE_NUMBER_INT);
        if ($numberOfBooks >= $remindedNumberOfBooks && $numberOfBooks > 0 && $remindedNumberOfBooks >= 0) {
            $book = new Book($bookname, $introduction, $remindedNumberOfBooks, $numberOfBooks);
            $operator = new Operator();
            if ($operator->addBook($book))
                echo "<p class='success'>add book successfully</p>";
            else
                echo "<p class='error'>add failed</p>";
        }
        else {
            echo "<p class='error'>wrong book number</p>";
        }
    }
}
else {
    echo "<p class='error'>access denied</p>";
}

?>

    </body>
</html>