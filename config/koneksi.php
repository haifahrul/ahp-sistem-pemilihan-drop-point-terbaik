<?php
//koneksi.php
$dbhost="localhost";
$dbname="aal-ahp";
$dbuser="guest";
$dbpassword="guest";


function opendb()
{
	global $dbhost, $dbuser, $dbpassword, $dbname, $dbconnection;
	$dbconnection=mysqli_connect($dbhost, $dbuser, $dbpassword) or die ("tidak dapat membuka database");
	$dbselect=mysqli_select_db($dbconnection, $dbname);

	return $dbconnection;
}

function closedb()
{
	global $dbconnection;
	mysqli_close($dbconnection);
}

function querydb($query)
{
	$result=mysqli_query(opendb(), $query) or die ("tidak dapat melakukan Query=$query");
	return $result;
}
?>