<!doctype html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="./css/table.css">
  <title>Użytkownicy</title>
</head>
<body>
	<h4>Użytkownicy</h4>
  <table>
    <tr>
      <th>Imię</th>
      <th>Nazwisko</th>
      <th>Data urodzenia</th>
      <th>Miasto</th>
      <th>Województwo</th>
      <th>Kraj</th>
    </tr>

	<?php
		require_once "./scripts/connect.php";
	$sql = "SELECT `users`.`firstName` AS `imie` , `users`.`lastName`, `users`.`birthday`, `cities`.`city`, `states`.`state`, `countries`.`country` FROM `users` INNER JOIN `cities` ON `users`.`city_id`=`cities`.`id` INNER JOIN `states` ON `cities`.`state_id`=`states`.`id` INNER JOIN `countries` ON `states`.`country_id`=`countries`.`id`;";
    $result = $conn->query($sql);
    while($user = $result->fetch_assoc()){
      echo <<< TABLEUSERS
        <tr>
          <td>$user[imie]</td>
          <td>$user[lastName]</td>
          <td>$user[birthday]</td>
          <td>$user[city]</td>
          <td>$user[state]</td>
          <td>$user[country]</td>
          <td><a href="./scripts/delete_user.php">Usuń</a></td>
        </tr>
TABLEUSERS;
    }
    echo "</table>";
	?>

</body>
</html>