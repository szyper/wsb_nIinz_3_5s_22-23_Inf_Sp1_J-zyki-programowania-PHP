<?php
session_start();
?>
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

  if (isset($_SESSION["success"])){
	  echo $_SESSION["success"];
    unset($_SESSION["success"]);
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
          <form action="./scripts/add_user.php" method="post">
            <input type="text" name="firstName" placeholder="Podaj imię" autofocus><br><br>
            <input type="text" name="lastName" placeholder="Podaj nazwisko"><br><br>
            <input type="date" name="birthday"> Data urodzenia<br><br>
            <select name="city_id">
        ADDUSERFORM;
          $sql = "SELECT * FROM `cities`";
          $result = $conn->query($sql);
          while ($city = $result->fetch_assoc()){
            echo "<option value=\"$city[id]\">$city[city]</option>";
          }
	      echo <<<ADDUSERFORM
            </select><br><br>
<!--            <input type="number" name="city_id" placeholder="Podaj id miasta"><br><br>-->
            <input type="checkbox" name="terms"> Regulamin<br><br>
            <input type="submit" value="Dodaj użytkownika">
          </form>
ADDUSERFORM;
      }else{
        echo "<a href=\"./3_db_table_delete_add.php?addUser=1\">Dodaj użytkownika</a>";
      }
    ?>

</body>
</html>