<?php
	session_start();
	//print_r($_POST);
	$error = 0;
	foreach ($_POST as $key => $value){
		//echo "$key: $value<br>";
		if (empty($value)){
			echo "$key<br>";
			echo "<script>history.back();</script>";
			exit();
		}
	}

	if (!isset($_POST["terms"])){
		$_SESSION["error"] = "Zatwierdź regulamin!";
		$error = 1;
	}

	if ($error != 0){
		echo "<script>history.back();</script>";
		exit();
	}

	require_once "./connect.php";
	$sql = "UPDATE `users` SET `city_id` = '$_POST[city_id]', `firstName` = '$_POST[firstName]', `lastName` = '$_POST[lastName]', `birthday` = '$_POST[birthday]' WHERE `users`.`id` = $_SESSION[updateUserId];";
	$conn->query($sql);
	if ($conn->affected_rows == 0){
		$_SESSION["error"] = "Nie dodano rekordu!";
	}else{
		$_SESSION["success"] = "Prawidłowo dodano rekord";
	}

	header('location: ../4_db_table_delete_add_update.php');
