<html>
    <head>
        <title>simple book management system</title>
        <script src="js/index.js" defer></script>
        <script src="js/jquery-3.3.1.min.js"></script>
        <link rel="stylesheet" href="css/index.css">
    </head>

    <body>
        <div id="login_logout_bar">
            <form method="post" id="home" action="index.php">
                <input class="button" type="submit" value="Home"/>
            </form>
           
            <div id="login_status">login status: <?php if(isset($_COOKIE['logined_user_id'])) echo $_COOKIE['logined_user_id']; else echo 'unlogin';?></div>
            <!-- login button -->
            <form method="post" id="login" action="login.php">
                <input class="button" type="submit" value="login"/>
            </form>

            <!-- logout button -->
            <form method="post" id="logout" action="logout.php">
                <input class="button" type="submit" value="logout" onclick="return confirm('Are you sure to logout?');"/>
            </form>

            <!-- see borrow list button -->
            <?php if(isset($_COOKIE['logined_user_id'])) echo <<<EOF
                <form method="post" id="borrowList" action="borrowedList.php">
                    <input class="button" type="submit" value="my borrowed"/>
                </form>
                EOF;
            ?>
        </div>

        <form id="search_field" method="post" action="search.php">
            <input class="search" type="text" placeholder="input bookname to search" name="search"/>
            <input class="button" type="submit" value="search"/>
        </form>

        <!-- if isadmin = 1. then is admin, he can manage books-->
        <?php if(isset($_COOKIE['is_admin']) && $_COOKIE['is_admin'] == 1) echo <<<EOF
                <form method="post" action="admin.php?click_add_book">
                    <input class="button" type="submit" value="add_book"/>
                </form>
        EOF;
        ?>
    </body>

</html>
