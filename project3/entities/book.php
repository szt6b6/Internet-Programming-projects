<?php

class Book
{
    var $bookid;
    var $bookname;
    var $introduction;
    var $remindedNumberOfBooks;
    var $numberOfBooks;

    //default id set to 0
    public function __construct($bookname, $introduction, $remindedNumberOfBooks, $numberOfBooks, $bookid=0)
    {
        $this->bookid = $bookid;
        $this->bookname = $bookname;
        $this->introduction = $introduction;
        $this->remindedNumberOfBooks = $remindedNumberOfBooks;
        $this->numberOfBooks = $numberOfBooks;
    }

    //normal user view
    public function __toString()
    {
        return <<<EOF
        <tr>
            <th><input type="text" name="bookname" value="$this->bookname" readonly /></th>
            <th><input type="text" name="introduction" value="$this->introduction" readonly/></th>
            <th><input type="number" name="remindedNumberOfBooks" value="$this->remindedNumberOfBooks" readonly/></th>

            <form method="post" action="borrow.php">
                <input type="hidden" name="bookid" value="$this->bookid"/>
                <input type="hidden" name="remindedNumberOfBooks" value="$this->remindedNumberOfBooks"/>
                <th><input type="submit" value="borrow" onclick="return confirm('Are you sure to borrow this book?');"/></th>
            </form>
        </tr>
EOF;
    }

        //admin view
        public function adminView()
        {
            return <<<EOF
                <tr>
                    <form method="post" action="admin.php?update=$this->bookid">
                        <th><input type="text" name="bookname" value="$this->bookname" required /></th>
                        <th><input type="text" name="introduction" value="$this->introduction" required/></th>
                        <th><input id="leftNumber" type="number" name="remindedNumberOfBooks" value="$this->remindedNumberOfBooks" required/></th>
                        <th><input id="totalNumber" type="number" name="numberOfBooks" value="$this->numberOfBooks" readonly/></th>
                        <th><input type="submit" value="update" onclick="return confirm('Are you sure to update this book?');"/></th>
                    </form>
                    <form method="post" action="admin.php?delete=$this->bookid">
                        <th><input type="submit" value="delete" onclick="return confirm('Are you sure to delete this book?');"/></th>
                    </form>
                    <form method="post" action="borrow.php">
                        <input type="hidden" name="bookid" value="$this->bookid"/>
                        <input type="hidden" name="remindedNumberOfBooks" value="$this->remindedNumberOfBooks"/>
                        <th><input type="submit" value="borrow" onclick="return confirm('Are you sure to borrow this book?');"/></th>
                    </form>
                </tr>
EOF;
        }
}

?>