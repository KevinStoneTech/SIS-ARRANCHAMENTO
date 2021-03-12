<?php
session_start();
if(!isset($_SESSION["user_id2"])){
    header("Location: signin.php");
    exit;
}
?>