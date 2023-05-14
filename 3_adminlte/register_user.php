<?php
	session_start();
	//print_r($_POST);
	$errors = [];
	foreach ($_POST as $key => $value){
		//echo "$key: $value<br>";
		if (empty($value)){
			$errors[] = "Pole <b>$key</b> jest wymagane";
		}
	}

	//print_r($errors);

	if (!isset($_POST["terms"]))
		$errors[] = "Pole <b>terms</b> jest wymagane";

	//sprawdzenie czy hasła i email są identyczne

	if (!empty($errors)){
		$_SESSION["error_message"] = implode("<br>", $errors);
		//echo $_SESSION["error_message"];
		echo "<script>history.back();</script>";
	}
