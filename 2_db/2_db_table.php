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
  <?php
    if (isset($_GET["userDeleteId"])){
      if ($_GET["userDeleteId"] == 0){
        echo "<h4>Nie usunięto użytkownika!</h4>";
      }else{
        echo "<h4>Usunięto użytkownika o id = $_GET[userDeleteId]</h4>";
      }
    }
  ?>
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
	  $sql = "SELECT `users`.`id`, `users`.`firstName` AS `imie` , `users`.`lastName`, `users`.`birthday`, `cities`.`city`, `states`.`state`, `countries`.`country` FROM `users` INNER JOIN `cities` ON `users`.`city_id`=`cities`.`id` INNER JOIN `states` ON `cities`.`state_id`=`states`.`id` INNER JOIN `countries` ON `states`.`country_id`=`countries`.`id`;";
    $result = $conn->query($sql);
//    echo $result->num_rows;
    if ($result->num_rows == 0){
      echo "<tr><td colspan='6'>Brak rekordów do wyświetlenia</td></tr>";
    }else{
	    while($user = $result->fetch_assoc()){
		    echo <<< TABLEUSERS
        <tr>
          <td>$user[imie]</td>
          <td>$user[lastName]</td>
          <td>$user[birthday]</td>
          <td>$user[city]</td>
          <td>$user[state]</td>
          <td>$user[country]</td>
          <td><a href="./scripts/delete_user.php?deleteUserId=$user[id]">Usuń</a></td>
        </tr>
TABLEUSERS;
	    }
    }
    echo "</table>";
	?>
    <hr>
    <?php
      if (isset($_GET["addUser"])){
        echo <<<ADDUSERFORM
          <h3>Dodaj użytkownika</h3>
ADDUSERFORM;
      }else{
        echo "<a href=\"./2_db_table.php?addUser=1\">Dodaj użytkownika</a>";
      }
    ?>

</body>
</html>