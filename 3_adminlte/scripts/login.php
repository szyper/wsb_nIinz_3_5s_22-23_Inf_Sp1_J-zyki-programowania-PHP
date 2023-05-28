<?php
session_start();
//print_r($_POST);
$errors = [];
foreach ($_POST as $key => $value){
	if (empty($value)){
		$errors[] = "Pole <b>$key</b> jest wymagane";
	}
}

if (!empty($errors)){
	$_SESSION["error_message"] = implode("<br>", $errors);
	echo "<script>history.back();</script>";
	exit();
}

try {
	require_once "./connect.php";
	$stmt = $conn->prepare("SELECT * FROM `users` WHERE email=?;");
	$stmt->bind_param('s', $_POST["login"]);
	$stmt->execute();
	$result = $stmt->get_result();
	$user = $result->fetch_assoc();

	if ($result->num_rows != 0){
//		echo "email istnieje!";
		if (password_verify($_POST["pass"], $user["password"])){
			$_SESSION["logged"]["firstName"] = $user["firstName"];
			$_SESSION["logged"]["lastName"] = $user["lastName"];
			header("location: ../pages/view?logged=1");
			exit();
		}else{
			$_SESSION["error_message"] = "Błędny login lub hasło!";
			echo "<script>history.back();</script>";
			exit();
		}
		//header("location: ../pages/view");
	}
	else{
		$_SESSION["error_message"] = "Błędny login lub hasło!";
		echo "<script>history.back();</script>";
		exit();
	}

}catch(mysqli_sql_exception $e)
{
	$_SESSION["error_message"] = $e->getMessage();
	echo "<script>history.back();</script>";
	exit();
}