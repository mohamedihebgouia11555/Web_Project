<?php
//connexion à la BD
$host = 'localhost';
$dbname = 'expert_school';
$username = 'root';
$password = '';

try{
	$pdo = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
	die("Erreur de connexion à la base de données: ". $e->getMessage());
}
?>