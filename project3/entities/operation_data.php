<?php
require_once 'db_connector.php';
include 'book.php';
include 'user.php';

class Operator
{
    var $connection;

    public function __construct()
    {
        //get database connection object
        $this->connection = (new Db_connector("localhost", "root", "123456", "book_management_system"))->getConnection();
    }

    /**function used to add books to database, only admin can use */
    public function addBook($book)
    {
        $sql = "INSERT INTO books (bookname, introduction, remindedNumberOfBooks, numberOfBooks) values 
                ('$book->bookname', '$book->introduction', '$book->remindedNumberOfBooks', '$book->numberOfBooks')";
        return $this->connection->query($sql);
    }

    /**function used to delete books from database, only admin can use */
    public function deleteBook($deleteid)
    {
        $sql = "delete from books where bookid = '$deleteid'";
        return $this->connection->query($sql);
    }

    /**function used to update books from database, only admin can use */
    public function updateBook($book)
    {
        $sql = "update books set bookname = '$book->bookname', introduction = '$book->introduction', 
                remindedNumberOfBooks = '$book->remindedNumberOfBooks', numberOfBooks = '$book->numberOfBooks' where bookid = '$book->bookid'";
        return $this->connection->query($sql);
    }

    /**function used to look for books by bookname(use string match pattern)*/
    public function lookForBooks($searched_book)
    {
        //store the results
        $books;
        $sql = "SELECT * from books where bookname like '%" . $searched_book . "%'";
        $results = $this->connection->query($sql);
        if ($results->num_rows > 0) {
            // 输出数据
            while ($row = $results->fetch_assoc()) {
                $books[] = new Book($row['bookname'], $row['introduction'], $row['remindedNumberOfBooks'], $row['numberOfBooks'], $row['bookid']);
            }
        }
        else {
            return "no result in database";
        }
        return $books;
    }

    /**function used to check the borrowed list of user's*/
    public function checkSelfBorrowedList($userid)
    {
        //store the results
        $books;
        $sql = "select * from books where bookid in (select distinct(bookid) from borrow_relations where userid = $userid);";
        $results = $this->connection->query($sql);
        if ($results->num_rows > 0) {
            // 输出数据
            while ($row = $results->fetch_assoc()) {
                $books[] = new Book($row['bookname'], $row['introduction'], $row['remindedNumberOfBooks'], $row['numberOfBooks'], $row['bookid']);
            }
        }
        else {
            return "no result in database";
        }
        return $books;
    }

    /**function used to borrow a book from database */
    public function borrowBookFromDatabase($userid, $bookid)
    {
        $sql_insert = "insert into borrow_relations (userid, bookid) values('$userid','$bookid');";
        $sql_reduce = "update books set remindedNumberOfBooks = remindedNumberOfBooks - 1 where bookid = '$bookid';";
        $this->connection->query("start transaction");
        if ($this->connection->query($sql_insert) && $this->connection->query($sql_reduce)) {
            $this->connection->query("commit");
            return true;
        }
        else {
            $this->connection->query("rollback");
            return false;
        }
    }

    /**function used to return a book to database */
    public function returnBookToDatabase($userid, $bookid)
    {
        $sql_delete = "delete from borrow_relations where userid = '$userid' and bookid = '$bookid'";
        $sql_increase = "update books set remindedNumberOfBooks = remindedNumberOfBooks + 1 where bookid = '$bookid'";
        $this->connection->query("start transaction");
        if ($this->connection->query($sql_delete) && $this->connection->query($sql_increase)) {
            $this->connection->query("commit");
            return true;
        }
        else {
            $this->connection->query("rollback");
            return false;
        }
    }

    /**function used to login*/
    public function login($username, $password)
    {
        $sql = "SELECT * FROM users where username='$username' and password='$password'";
        $result = $this->connection->query($sql);
        if ($result->num_rows != 1) {
            return 0;
        }
        else {
            $row = $result->fetch_assoc();
            $user = new User($row['userid'], $row['username'], $row['password'], $row['isadmin']);
            setcookie('logined_user_id', $user->userid);
            setcookie('is_admin', $user->isadmin);
        }
        return 1;
    }

    public function register($username, $password)
    {
        $sql = "insert into users (username, password) values('$username', '$password')";
        if ($this->connection->query($sql)) {
            return 1;
        }
        else {
            return 0;
        }
    }

    public function __destruct()
    {
        $this->connection->close();
    }
}

?>