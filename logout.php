<?php
session_start();
//unset($_SESSION['sesNamaPengguna']);
//unset($_SESSION['sesTipePengguna']);
session_destroy();
header("location:login.php");
?>
