<html>
    <head>
        <title>login</title>
        <link rel="stylesheet" href="css/login.css">
    </head>
    <body>
        <!-- return home button -->
        <form method="post" id="home" action="index.php">
            <input class="button" type="submit" value="Home"/>
        </form>
        <div class="box">
            <form method="post" action="login.php">
                <input class="username" type="text" name="username" placeholder="username" required/>
                <input class="password" type="password" name="password" placeholder="password" required/>
                <input class="btn" type="submit" value="login" />
                <button id="btn2" type="button" onclick="location.href='register.php'">register</button>
            </form>
        </div>
    
    </body>
</html>


<?php
/**used for user login action, use cookie to store login stage information*/

require_once './entities/operation_data.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    $operator = new Operator();
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    if ($operator->login($username, $password) == 1) {
        echo "<script> alert('login successfully'); </script>";
        header('Location: ./index.php');
    }
    else {
        echo 'invalid username or password.';
    }
}

?>