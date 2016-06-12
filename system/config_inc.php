<?php

session_start();
if(isset($_GET['token']) && $_GET['token'] != $_SESSION['token']){
	die("Erreur lors de cette action.");
}
if(!isset($_SESSION['token'])){
	$_SESSION['token'] = md5(time()*rand(1,900));
}

$BDD_hote = '';
$BDD_bd = '';
$BDD_utilisateur = '';
$BDD_mot_passe = '';

try{
	$bdd = new PDO('mysql:host='.$BDD_hote.';dbname='.$BDD_bd, $BDD_utilisateur, $BDD_mot_passe);
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

catch(PDOException $e){
	echo 'Erreur : '.$e->getMessage();
	echo 'N° : '.$e->getCode();
}
ini_set("dislay_errors",0);
error_reporting(1);

$adresseSite = 'http://demo-stream.franceserv.com/';
?>