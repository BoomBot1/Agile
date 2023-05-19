<!doctype html>
<!-- !!Я очень долго придумал как бы мне так в бд что-то запихать. Потом понял что я не понял как разместить бд на гитхабе (вообще не пользовался такой штукой ни разу) и могу только подставить сюда пару подготовленных mysql запросов на основе POD.
Допустим, есть какой-то серв с адресом localhost.

?php

/*Допустим, есть какой-то пользователь admen, который может вносить изменения в бд db1.*/

$connect = new POD("mysql:host=localhost;dbname=db1;charset=utf8", "admen", "mysql");

/*Допустим я хочу что-то записать. Таблица называется mem и содержит id, ник, логин и пароль пользователя (они собираются методом POST ниже - в нормально коде)*/

$sql = "INSERT users (id, nickname, login, password) VALUE (:id, :nick, :log, :pass)";

$data_arr = [
	'id'=>$_POST["user_id"],
	'nick'=>$_POST["user_nick"],
	'log'=>$_POST["user_log"],
	'pass'=>$_POST["user_pass"]
];

$query = $connect->prepare($sql);
$query->execute($data_arr);

/*Если вам будет нужно, я могу сделать тут проверку на уникальность id и пароля. Но, в нормальных условиях, как будто бы лучше присваивать id через auto_increment. Как будто бы нужно ещё пару sql запросов, но мне, честно, в голоову не лезет в данный момент.*/




-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<!-- Создаст файл, в котором будут те данные, котоыре вы указали :) -->
<main class="container-fluid">
	<div class="container-text-center">
		<form action="index.php" method="post">

			<input type="text" id="uid" name="user_id" placeholder="Введите свой id"><br>
			<br>
			<input type="text" id="nickname" name="user_nick" placeholder="Введите свой никнейм"><br>
			<br>
			<input type="text" id="login" name="user_log" placeholder="Введите свой логин"><br>
			<br>
			<input type="password" id="pass" name="user_pass" placeholder="Введите свой пароль"><br>
			<br>
			<button type="submit">Создать</button>

		</form>
	</div>
</main>
<?php

	$uid = $_POST["user_id"];
	$unick = "Ваш ник: " . $_POST["user_nick"];
	$ulogin = "Ваш логин: " . $_POST["user_log"];
	$upass = "Ваш пароль: " . $_POST["user_pass"];

	if(!$uid==""){
		if (!file_exists($uid.".txt")){
			$cre = fopen($uid . '.txt', 'w');
			$write = $unick . "\n" . $ulogin . "\n" . $upass;
			fwrite($cre, $write);

			fclose($cre);
		}
		else{
			echo '<p>Пользователь с таким id уже записан.</p>';
		}
	}
?>
</body>
</html>