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

	if ($_POST["email"] != $_POST["email2"])
		$errors[] = "Adresy poczty elektronicznej są różne!";

if ($_POST["pass"] != $_POST["pass2"])
	$errors[] = "Hasła są różne!";

	if (!empty($errors)){
		$_SESSION["error_message"] = implode("<br>", $errors);
		//echo $_SESSION["error_message"];
		echo "<script>history.back();</script>";
		exit();
	}

try {
	require_once "./connect.php";
	$stmt = $conn->prepare("INSERT INTO `users` (`city_id`, `email`, `firstName`, `lastName`, `birthday`, `password`) VALUES (?, ?, ?, ?, ?, ?);");
	$pass = password_hash($_POST["pass"], PASSWORD_ARGON2ID);
	$stmt->bind_param('isssss', $_POST["city_id"], $_POST["email"], $_POST["firstName"], $_POST["lastName"], $_POST["birthday"], $pass);
	$stmt->execute();
	if ($stmt->affected_rows){
		$_SESSION["success"] = "Prawidłowo dodano użytkownika $_POST[firstName] $_POST[lastName]";
		header("location: ../pages/view");
	}
	else
		echo "error";

}catch(mysqli_sql_exception $e)
{
		$_SESSION["error_message"] = $e->getMessage();
		echo "<script>history.back();</script>";
		exit();
}


