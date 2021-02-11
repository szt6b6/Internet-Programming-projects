<html>
    <head>
        <title>search</title>
        <link rel="stylesheet" href="css/borrowedList.css">
    </head>
    <body>
        <!-- return home button -->
        <form method="post" id="home" action="index.php">
            <input class="button" type="submit" value="Home"/>
        </form>

<?php
/**see user's borrowed list of books, need to login, look for books according logined user id, can return book to database here */
if(isset($_COOKIE['logined_user_id'])) {
    $userid = $_COOKIE['logined_user_id'];

    require_once './entities/operation_data.php';

    $operator = new Operator();
    $results = $operator->checkSelfBorrowedList($userid);

    if(gettype($results) == 'array') {
        echo "<table>";
        echo "<tr><th>bookname</th>";
        echo "<th>introduction</th>";
        echo "<th>return</th></tr>";
        foreach ($results as $book) {
            echo <<<EOF
            <tr>
                <th>$book->bookname</th>
                <th>$book->introduction</th>
                <form method="post" action="return.php">
                    <input type="hidden" name="userid" value="$userid"/>
                    <input type="hidden" name="bookid" value="$book->bookid"/>
                    <th><input type="submit" value="return book" onclick="return confirm('Are you sure to return this book?');"/></th>
                </form>
            </tr>
EOF;
        }
        echo "</table>";
    } else {
        echo "<p class='error'>you haven't borrowed any books yet.</p>";
    }
    
} else {
    echo "<p class='error'>you are not logined</p>";
}

?>

    </body>
</html>