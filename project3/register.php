<html>
    <head>
        <title>register</title>
        <link rel="stylesheet" href="css/register.css">
    </head>
    <body>
        <!-- return home button -->
        <form method="post" id="home" action="index.php">
            <input class="button" type="submit" value="Home"/>
        </form>

        <div class="box">
            <form method="post" action="register.php">
                <input class="username" type="text" name="username" placeholder="Username" required/>
                <input class="password" type="password" name="password" placeholder="Password" required/>
                <input class="btn" type="submit" value="register" onclick="return confirm('Are you sure to register?');"/>
            </form>
        </div>

    </body>
</html>

<?php
/**used for register actions, only normal user */
require_once './entities/operation_data.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    $operator = new Operator();
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    if ($operator->register($username, $password) == 1) {
        echo "<script> alert('register successfully'); </script>";
        header('Location: ./login.php');
    }
    else {
        echo '<p class="error>register error.</p>';
    }
}
?>