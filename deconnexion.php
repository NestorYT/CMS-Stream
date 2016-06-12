<?php require './system/config_inc.php';

	$req = $bdd->prepare("SELECT * FROM core WHERE id = :id");
					$req->execute(array(
						'id' => 1));
					$row_core = $req->fetch();

	if($row_core['maintenance'] == 1 && $_SESSION['rank'] < 3){

		include './system/maintenance.php';

	}else{ 
			
require "system/config_inc.php";
if(isset($_SESSION['pseudo'])){
	$req = $bdd->prepare("SELECT * FROM membres WHERE pseudo=:pseudo");
	$req->execute(array(
		'pseudo' => $_SESSION['pseudo']));
	$rouk = $req->fetch();

	unset($_SESSION['id'], $_SESSION['pseudo'], $_SESSION['token']);
	session_unset();
	session_destroy();
	header ('Location: index.html');
}else{
	header('Location:index.html');
} } ?>