<?php
$csrf_error = "";
if (empty($_SESSION['_token'])) {
    $_SESSION['_token'] = bin2hex(random_bytes(32));
    $_SESSION["token_expire"] = time() + 600; // 10 minutes = 600 secs
}

$token = $_SESSION['_token'];
$token_expire = $_SESSION["token_expire"];
?>