<?php
/**used for logout action */

if (isset($_COOKIE['logined_user_id']) || isset($_COOKIE['isadmin'])) {
    setcookie('logined_user_id', '', time() - 3600);
    setcookie('is_admin', '', time() - 3600);
}
header('Location: ./index.php');
exit();
?>