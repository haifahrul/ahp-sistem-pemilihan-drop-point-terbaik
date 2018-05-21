<?php
session_start();
unset($_SESSION['sesNamaPengguna']);
unset($_SESSION['sesTipePengguna']);
header("location:login.php");
?>
