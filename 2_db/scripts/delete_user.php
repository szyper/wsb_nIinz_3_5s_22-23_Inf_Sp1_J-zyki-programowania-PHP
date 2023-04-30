<?php
//	print_r($_GET);
//	var_dump($_GET);
//echo $_GET["deleteUserId"];

if (!empty($_GET["deleteUserId"])) {
	require_once "./connect.php";
//	$sql = "DELETE FROM users WHERE `users`.`firstName` = 'Anna'";
	// $sql = "DELETE FROM users WHERE `users`.`id` = 8";
	$sql = "DELETE FROM users WHERE `users`.`id` = $_GET[deleteUserId]";
	$conn->query($sql);
}
//echo $conn->affected_rows; //1 - ok, 0 - error

if ($conn->affected_rows == 0){
	$userId = 0;
}else{
	$userId = $_GET["deleteUserId"];
}

//header("location: ../2_db_table.php?userDeleteId=$userId");
header("location: ../4_db_table_delete_add_update.php?userDeleteId=$userId");
