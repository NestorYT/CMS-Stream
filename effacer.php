<?php

if($_GET['option'] == 'membre' || $_GET['option'] == 'banni' || $_GET['option'] == 'inactif' || $_GET['option'] == 'staff'){
$namePage = 'Effacement d\'un membre';
}elseif($_GET['option'] == 'qualite'){
$namePage = 'Effacement d\'une qualitée vidéo';
}elseif($_GET['option'] == 'commentaires'){
$namePage = 'Effacement d\'un commentaire';
}elseif($_GET['option'] == 'film'){
$namePage = 'Effacement d\'un film';
}elseif($_GET['option'] == 'genre'){
$namePage = 'Effacement d\'un genre';
}elseif($_GET['option'] == 'mes_films'){
$namePage = 'Effacement de mon film';
}elseif($_GET['option'] == 'news'){
$namePage = 'Effacement de la news';
}


include './system/header.php'; 
require './system/config_inc.php';
require './system/function.php';
?>
<div class="content-inner-section">

<div class="wrap">
			<div class="clear"></div>
<?php

if($_SESSION['rank'] > 3 && $_GET['option'] == 'membre' || $_SESSION['rank'] > 3 && $_GET['option'] == 'banni' || $_SESSION['rank'] > 3 && $_GET['option'] == 'inactif' || $_SESSION['rank'] > 3 && $_GET['option'] == 'staff'){
	if(!isset($_SESSION['pseudo'])){
		header('Location: connexion.html');
	}else{
	
	$q = addslashes($_GET['id']);	
	$req = $bdd->prepare("SELECT * FROM membres WHERE id = :id");
	$req->execute(array(
		'id' => $q));
	$row = $req->fetch();
				if($_GET['option'] == 'membre' || $_GET['option'] == 'banni' || $_GET['option'] == 'inactif' || $_GET['option'] == 'staff'){
					if($q == $row['id']){
					$req = $bdd->prepare("DELETE FROM membres WHERE id = :id");
					$req->bindParam(':id', $q);
				
         			$req->execute();
					
					echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> Le membre à bien été éffacé.</center></div><meta http-equiv="refresh" content="2;'.$_SERVER['HTTP_REFERER'].'" />';
					}else{
					echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Le membre n\'existe pas.</center></div><meta http-equiv="refresh" content="2;'.$_SERVER['HTTP_REFERER'].'" />';	
					} }else{
						
					}
} }elseif($_SESSION['rank'] > 2 && $_GET['option'] == 'commentaires'){
if(!isset($_SESSION['pseudo'])){
		header('Location: connexion.html');
	}else{

	$q = addslashes($_GET['id']);	
	$req = $bdd->prepare("SELECT * FROM commentaires WHERE id = :id");
	$req->execute(array(
		'id' => $q));
	$row = $req->fetch();
				if($_GET['option'] == 'commentaires'){
					if($q == $row['id']){
					$req = $bdd->prepare("DELETE FROM commentaires WHERE id = :id");
					$req->bindParam(':id', $q);
				
         			$req->execute();
					
					echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> Le commentaire à bien été éffacé.</center></div><meta http-equiv="refresh" content="2;'.$_SERVER['HTTP_REFERER'].'" />';
					}else{
					echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Le commentaire n\'existe pas.</center></div><meta http-equiv="refresh" content="2;'.$_SERVER['HTTP_REFERER'].'" />';	
					} }else{
						
					}
}
}elseif($_SESSION['rank'] > 3 && $_GET['option'] == 'news'){
if(!isset($_SESSION['pseudo'])){
		header('Location: connexion.html');
	}else{

	$q = addslashes($_GET['id']);	
	$req = $bdd->prepare("SELECT * FROM news WHERE id = :id");
	$req->execute(array(
		'id' => $q));
	$row = $req->fetch();
				if($_GET['option'] == 'news'){
					if($q == $row['id']){
					$req = $bdd->prepare("DELETE FROM news WHERE id = :id");
					$req->bindParam(':id', $q);
				
         			$req->execute();
					
					echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> La news à bien été éffacé.</center></div><meta http-equiv="refresh" content="2;'.$_SERVER['HTTP_REFERER'].'" />';
					}else{
					echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> La news n\'existe pas.</center></div><meta http-equiv="refresh" content="2;'.$_SERVER['HTTP_REFERER'].'" />';	
					} }else{
						
					}
}
}elseif($_SESSION['rank'] > 2 && $_GET['option'] == 'qualite'){
	if(!isset($_SESSION['pseudo'])){
		header('Location: connexion.html');
	}else{

	$q = addslashes($_GET['id']);	
	$req = $bdd->prepare("SELECT * FROM qualiter WHERE id = :id");
	$req->execute(array(
		'id' => $q));
	$row = $req->fetch();
				if($_GET['option'] == 'qualite'){
					if($q == $row['id']){
					$req = $bdd->prepare("DELETE FROM qualiter WHERE id = :id");
					$req->bindParam(':id', $q);
				
         			$req->execute();
					
					echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> La qualitée vidéo à bien été éffacé.</center></div><meta http-equiv="refresh" content="2;'.$_SERVER['HTTP_REFERER'].'" />';
					}else{
					echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> La qualitée vidéo n\'existe pas.</center></div><meta http-equiv="refresh" content="2;'.$_SERVER['HTTP_REFERER'].'" />';	
					} }else{
						
					}
} }elseif($_SESSION['rank'] > 2 && $_GET['option'] == 'genre'){
	if(!isset($_SESSION['pseudo'])){
		header('Location: connexion.html');
	}else{

	$q = addslashes($_GET['id']);	
	$req = $bdd->prepare("SELECT * FROM genres WHERE id = :id");
	$req->execute(array(
		'id' => $q));
	$row = $req->fetch();
				if($_GET['option'] == 'genre'){
					if($q == $row['id']){
					$req = $bdd->prepare("DELETE FROM genres WHERE id = :id");
					$req->bindParam(':id', $q);
				
         			$req->execute();
					
					echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> Le genre à bien été éffacé.</center></div><meta http-equiv="refresh" content="2;'.$_SERVER['HTTP_REFERER'].'" />';
					}else{
					echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Le genre n\'existe pas.</center></div><meta http-equiv="refresh" content="2;'.$_SERVER['HTTP_REFERER'].'" />';	
					} }else{
						
					}
} }elseif($_GET['option'] == 'mes_films'){

if(!isset($_SESSION['pseudo'])){
	header('Location: connexion.html');
}else{

	$q = addslashes($_GET['id']);
	$req = $bdd->prepare("SELECT * FROM film WHERE id = :id");
	$req->execute(array(
		'id' => $q));
	$row = $req->fetch();

				if($_SESSION['id'] == $row['uploader_id'] && ($row['video_hs'] == 5 || $row['pending'] > 0)){
					if($q == $row['id']){
						$req = $bdd->prepare("DELETE FROM film WHERE id = :id");
						$req->bindParam(':id', $q);
				
         				$req->execute();
					
						echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> Le film à bien été éffacé.</center></div><meta http-equiv="refresh" content="2;'.$_SERVER['HTTP_REFERER'].'" />';

					}else{
						echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Le film n\'existe pas.</center></div><meta http-equiv="refresh" content="2;'.$_SERVER['HTTP_REFERER'].'" />';	
					}}else{
						echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Tu t\'és perdu ?</center></div><meta http-equiv="refresh" content="2;'.$_SERVER['HTTP_REFERER'].'" />';	
					}

}

}elseif(($_GET['option'] == 'film' || $_GET['option'] == 'exclusivite' || $_GET['option'] == 'video_hs' || $_GET['option'] == 'pending') && $_SESSION['rank'] > 2){
if(!isset($_SESSION['pseudo'])){
		header('Location: connexion.html');
}else{

	$q = addslashes($_GET['id']);
	$req = $bdd->prepare("SELECT * FROM film WHERE id = :id");
	$req->execute(array(
		'id' => $q));
	$row = $req->fetch();

					if($q == $row['id']){
						$req = $bdd->prepare("DELETE FROM film WHERE id = :id");
						$req->bindParam(':id', $q);
				
         				$req->execute();
					
						echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> Le film à bien été éffacé.</center></div><meta http-equiv="refresh" content="2;'.$_SERVER['HTTP_REFERER'].'" />';

					}else{
						echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Le film n\'existe pas.</center></div><meta http-equiv="refresh" content="2;'.$_SERVER['HTTP_REFERER'].'" />';	
					}

}
}else{
	header('Location: admin.html');
}
					?>
</div></div>
<?php include './system/footer.php'; ?>