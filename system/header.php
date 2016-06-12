<!DOCTYPE html>
<html lang="fr" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<?php require './system/config_inc.php'; ?>
	<meta charset="utf-8">
	<meta name="Keywords" content="Le premier site de streaming intelligent, illimité, gratuit et sans pub ! Recommandations personnalisées. Vos films préférés.Film en streaming , film streaming , vk-streaming, vkstreaming , full stream , full-streaming , full streaming ,film streaming , film stream , stream-full, film streaming hd, streaming hd , streaming 720p , google, youtube film complet, youtube streaming , mail.ru , film streaming , streaming sans limite , streaming illimité, stream no limite , Film en Streaming HD 2015, Film en Streaming 2015 , Film en Streaming Netflix, Netflix streaming, Netflix, meilleur site de streaming, top site de streaming, movies,mangas,series,full,free hd films,Streaming films complet en ligne,films en streaming complet sans limite">

	<?php if($_SERVER['REQUEST_URI'] == '/infos.html?option='.$_GET['option']){ ?>
	<meta property="og:url" content="http://demo-stream.franceserv.com/infos.html?option=<?php echo $_GET['option']; ?>">
	<meta property="og:type" content="article">
	<meta property="og:title" content="<?php echo $row_core_name['titre']; ?>">
	<meta property="og:description" content="<?php echo $row_core_name['synopsy']; ?>">
	<meta property="og:image" content="<?php echo $row_core_name['url_jaquette']; ?>">
	<meta property="og:image:width" content="120">
	<meta property="og:image:height" content="160">
	<?php }else{ ?>
	<meta property="og:url" content="http://demo-stream.franceserv.com/">
	<meta property="og:type" content="article">
	<meta property="og:title" content="CMS Stream">
	<meta property="og:description" content="Le premier site de streaming intelligent, illimité, gratuit et sans pub ! Recommandations personnalisées.">
	<meta property="og:image" content="http://image.prntscr.com/image/5e21948d2b6b46d1a4231df5d67b8ca0.png">
	<?php } ?>

	<title>CMS Stream | <?php echo $namePage; ?></title>
	<link rel="stylesheet" href="./css/1.css">
	<link rel="Shortcut Icon" href="./favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="./css/font-awesome-min.css">
	<script src="./js/jquery/jquery.min.js"></script>
	<script src="./js/search.js"></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	</head>
<script>
$(function() {
$("body").append($("<div></div>").attr("id", "progress"));
$("#progress").width((50 + Math.random() * 30) + "%");
});
$(window).load(function() {
$("#progress").width("101%").delay(300).fadeOut(400);
});
</script>
<body>
<div class="header">
<div class="logo">
	<?php
	$req = $bdd->prepare("SELECT * FROM core WHERE id = :id");
					$req->execute(array(
						'id' => 1));
					$row_core = $req->fetch();


	if($row_core['maintenance'] == 1){
		$result_maintenance = 'hideen_admin_maintenance';
	}else{ 
		$result_maintenance = 'hideen_admin';
	}
	
						$retour = $bdd->query('SELECT COUNT(*) AS nbre_entrees FROM film WHERE video_hs = 5');
						$donnees_2 = $retour->fetch();
						$retour = $bdd->query('SELECT COUNT(*) AS nbre_entrees FROM film WHERE pending = 1');
						$donnees_3 = $retour->fetch();

						$result_notif = $donnees_2['nbre_entrees'] + $donnees_3['nbre_entrees'];

						if($_SESSION['rank'] > 2 ){ 
						if($result_notif > 0 ){ 	
						$admin = '<span class="'.$result_maintenance.'"><a href="admin.html"><i class="fa fa-cogs" aria-hidden="true"></i><span class="header_notif">'.$result_notif.'</span></a></span>';	
						}else{
						$admin = '<span class="'.$result_maintenance.'"><a href="admin.html"><i class="fa fa-cogs" aria-hidden="true"></i></a></span>';	
						}
						}else{
						$admin = '';	
						}

	?><a href="/"><h1 class="">CMS Stream</h1></a><br>
<?php echo $admin; ?> Le site n°1 du streaming français gratuit.</div>
<div class="contenair_header_top">
<form method="get" id="search" action="recherche.html" align="left">

		<?php

					if(!isset($_SESSION['pseudo'])){
						echo  '<div class="login"><a href="index.html" class="link_header_start"><i class="fa fa-home" aria-hidden="true"></i> Accueil</a><a href="faq.html" class="link_header"><i class="fa fa-question-circle" aria-hidden="true"></i> F.A.Q</a><a href="connexion.html" class="link_header"><i class="fa fa-sign-in" aria-hidden="true"></i> Connexion</a><a href="inscription.html" class="link_header_end"><i class="fa fa-pencil" aria-hidden="true"></i> Inscription</a></div>';	
					}else{

						$retour = $bdd->query('SELECT COUNT(*) AS nbre_entrees FROM film WHERE video_hs = 5 AND uploader_id = '.$_SESSION['id'].'');
						$donnees_4 = $retour->fetch();
						$retour = $bdd->query('SELECT COUNT(*) AS nbre_entrees FROM film WHERE pending = 3 AND uploader_id = '.$_SESSION['id'].'');
						$donnees_5 = $retour->fetch();
						
						$result_notif_1 = $donnees_4['nbre_entrees'] + $donnees_5['nbre_entrees'];
						
						if($_SESSION['rank'] < 3 ){ 
						$ajouter = '<a href="ajouter.html?option=auto" class="link_header"><i class="fa fa-film" aria-hidden="true"></i> Ajouter</a>';	
						}else{
						$ajouter = '';	
						}

						if($result_notif_1 > 0 ){ 	
						$profile = '<a href="mon_profile.html" class="link_header"><i class="fa fa-credit-card" aria-hidden="true"></i> Mon profile <span class="header_notif">'.$result_notif_1.'</span></a>';	
						}else{
						$profile = '<a href="mon_profile.html" class="link_header"><i class="fa fa-credit-card" aria-hidden="true"></i> Mon profile</a>';	
						}
						
						echo  '<div class="login"><a href="index.html" class="link_header_start"><i class="fa fa-home" aria-hidden="true"></i> Accueil</a><a href="ajouter.html?option=auto" class="link_header"><i class="fa fa-film" aria-hidden="true"></i> Ajouter</a><a href="faq.html" class="link_header"><i class="fa fa-question-circle" aria-hidden="true"></i> F.A.Q</a>'.$profile.'<a href="deconnexion.html" class="link_header_end"><i class="fa fa-sign-out" aria-hidden="true"></i> Déconnexion</a></div>';					
				}
		?>
              <input type="text" class="search" value="Recherche ..." onblur="if(this.value == '') { this.value = 'Recherche ...'; }" onfocus="if(this.value == 'Recherche ...') { this.value = ''; }" name="option" id="recherche">
              <button type="submit">Submit</button>
              <div id="resultat" style="display: none;"></div>
</form>
</div>
</div>