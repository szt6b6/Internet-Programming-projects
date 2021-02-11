<html>
    <head>
        <title>search</title>
        <link rel="stylesheet" href="css/search.css">
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/search.js" defer></script>
    </head>
    <body>
        <!-- return home button -->
        <form method="post" id="home" action="index.php">
            <input class="button" type="submit" value="Home"/>
        </form>
        <div>

<?php
/**used to get result from databae from user search */
require_once "./entities/operation_data.php";

//php 过滤器过滤用户输入
$searched_book = filter_var($_POST['search'], FILTER_SANITIZE_STRING);

$operator = new Operator();
$results = $operator->lookForBooks($searched_book);
if (gettype($results) == 'array') {
    echo "<table>";
    echo "<th>bookname</th>";
    echo "<th>introduction</th>";
    echo "<th>leftNumberOfBooks</th>";
    if (isset($_COOKIE['is_admin']) && $_COOKIE['is_admin'] == 1) {
        echo "<th>totalNumberOfBooks</th>";
    }
    foreach ($results as $book) {
        //admin additional function delete and update
        if (isset($_COOKIE['is_admin']) && $_COOKIE['is_admin'] == 1) {
            echo $book->adminView();
        } else {
            echo $book;
        }
    }
    echo "</table>";
} else {
    echo $results;
}

?>
        </div>
    </body>
</html>


