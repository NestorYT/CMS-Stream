<?php

if($_GET['option'] == 'membre' || $_GET['option'] == 'banni' || $_GET['option'] == 'inactif' || $_GET['option'] == 'staff'){
$namePage = 'Changement du rang d\'un membre';
}elseif($_GET['option'] == 'qualite'){
$namePage = 'Changement d\'une qualitée vidéo';
}elseif($_GET['option'] == 'maintenance' || $_GET['option'] == 'inscription' || $_GET['option'] == 'maintenance' || $_GET['option'] == 'commentaires' || $_GET['option'] == 'news' || $_GET['option'] == 'ddl'){
$namePage = 'Changement d\'option';
}elseif($_GET['option'] == 'genre'){
$namePage = 'Changement d\'un genre';
}elseif($_GET['option'] == 'film' || $_GET['option'] == 'video_hs' || $_GET['option'] == 'exclusivite' || $_GET['option'] == 'pending'){
$namePage = 'Modification d\'un film';
}elseif($_GET['option'] == 'mes_films'){
$namePage = 'Modification d\'un film';
}elseif($_GET['option'] == 'news'){
$namePage = 'Modification d\'une news';
}

include './system/header.php'; 
require './system/config_inc.php';
require './system/function.php';

$req = $bdd->prepare("SELECT * FROM core WHERE id = :id");
					$req->execute(array(
						'id' => 1));
					$row_core = $req->fetch();
?>

<div class="wrap">
			<div class="clear"></div>
<?php
$url = $_SERVER['HTTP_REFERER'];
$q = addslashes($_GET['id']);

if(!isset($_SESSION['pseudo'])){
		header('Location: connexion.html');
}else{

	$req = $bdd->prepare("SELECT * FROM membres WHERE id = :id");
	$req->execute(array(
		'id' => $q));
	$row = $req->fetch();

	$req = $bdd->prepare("SELECT * FROM qualiter WHERE id = :id");
	$req->execute(array(
		'id' => $q));
	$row_qualite = $req->fetch();

	$req = $bdd->prepare("SELECT * FROM genres WHERE id = :id");
	$req->execute(array(
		'id' => $q));
	$row_genre = $req->fetch();

	if(isset($_POST['button'])){
					if($_SERVER['HTTP_REFERER'] == $adresseSite . 'modifier.html?id='.$_GET['id'].'&option='.$_GET['option']){
						if(isset($_POST) && !empty($_POST['rang']) && !empty($_POST['token_custom_site'])){
								if($_POST['token_custom_site'] == $_SESSION['token']){
									if($_POST['f9_img'] == $_SESSION['jeton_f9']){
										unset($_SESSION['jeton_f9']);
										$rang = filter_var(htmlentities($_POST['rang']), FILTER_SANITIZE_STRING);
										if($req = $bdd->prepare("UPDATE membres SET rank = :rang WHERE id = :id")){
												$req->bindParam(':rang', $rang);
												$req->bindParam(':id', $q);
         										$req->execute();


											$result_membre = '<div id="reptopvalid"><center><i class="fa fa-check"></i> Le rang de '.$row['pseudo'].' à bien été modifié.</center></div><meta http-equiv="refresh" content="1;liste.html?option='.$_GET['option'].'" />';
										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Erreur lors de l\'insertion dans la base de données.</center></div>';
										}

										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Merci de ne pas ré-actualiser la page.</center></div>';
										}
										}else{
											echo '';
										}
				}else{
					echo '';
				}
			}else{
				echo '';
			}}else{

			}
	if(isset($_POST['button_qualite'])){
					if($_SERVER['HTTP_REFERER'] == $adresseSite . 'modifier.html?id='.$_GET['id'].'&option='.$_GET['option']){
						if(isset($_POST) && !empty($_POST['qualite']) && !empty($_POST['token_custom_site'])){
								if($_POST['token_custom_site'] == $_SESSION['token']){
									if($_POST['f9_img'] == $_SESSION['jeton_f9']){
										unset($_SESSION['jeton_f9']);
										$qualite = filter_var(htmlentities($_POST['qualite']), FILTER_SANITIZE_STRING);
										$req = $bdd->prepare('SELECT count(*) AS nbre_occurences FROM qualiter WHERE titre = :titre');
												$req->execute(array('titre' => $qualite));
												$donnees = $req->fetch();
												$nbre_occurences = $donnees['nbre_occurences'];
												$req->closeCursor();
										if($nbre_occurences == 0){
										if($req = $bdd->prepare("UPDATE qualiter SET titre = :titre WHERE id = :id")){
											$req->bindParam(':titre', $qualite);
											$req->bindParam(':id', $q);
         									$req->execute();
											

											$result_qualite = '<div id="reptopvalid"><center><i class="fa fa-check"></i> La qualitée vidéo à bien été modifié.</center></div><meta http-equiv="refresh" content="1;liste.html?option='.$_GET['option'].'" />';
										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Erreur lors de l\'insertion dans la base de données.</center></div>';
										}

										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> La qualitée vidéo éxiste déja.</center></div>';
										}
										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Merci de ne pas ré-actualiser la page.</center></div>';
										}
										}else{
											echo '';
										}
				}else{
					echo '';
				}
			}else{
				echo '';
			}}else{

			}

	if(isset($_POST['button_news'])){
					if($_SERVER['HTTP_REFERER'] == $adresseSite . 'modifier.html?id='.$_GET['id'].'&option='.$_GET['option']){
						if(isset($_POST) && !empty($_POST['news']) && !empty($_POST['token_custom_site'])){
								if($_POST['token_custom_site'] == $_SESSION['token']){
									if($_POST['f9_img'] == $_SESSION['jeton_f9']){
										unset($_SESSION['jeton_f9']);
										$news = filter_var(htmlentities($_POST['news']), FILTER_SANITIZE_STRING);
										
										if($req = $bdd->prepare("UPDATE news SET news = :news WHERE id = :id")){
											$req->bindParam(':news', $news);
											$req->bindParam(':id', $q);
         									$req->execute();
											

											$result_news = '<div id="reptopvalid"><center><i class="fa fa-check"></i> La news à bien été modifié.</center></div><meta http-equiv="refresh" content="1;liste.html?option='.$_GET['option'].'" />';
										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Erreur lors de l\'insertion dans la base de données.</center></div>';
										}

										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Merci de ne pas ré-actualiser la page.</center></div>';
										}
										}else{
											echo '';
										}
				}else{
					echo '';
				}
			}else{
				echo '';
			}}else{

			}

	if(isset($_POST['button_genre'])){
					if($_SERVER['HTTP_REFERER'] == $adresseSite . 'modifier.html?id='.$_GET['id'].'&option='.$_GET['option']){
						if(isset($_POST) && !empty($_POST['genre']) && !empty($_POST['token_custom_site'])){
								if($_POST['token_custom_site'] == $_SESSION['token']){
									if($_POST['f9_img'] == $_SESSION['jeton_f9']){
										unset($_SESSION['jeton_f9']);
										$genre = filter_var(htmlentities($_POST['genre']), FILTER_SANITIZE_STRING);
										$req = $bdd->prepare('SELECT count(*) AS nbre_occurences FROM genres WHERE titre = :titre');
												$req->execute(array('titre' => $genre));
												$donnees = $req->fetch();
												$nbre_occurences = $donnees['nbre_occurences'];
												$req->closeCursor();
										if($nbre_occurences == 0){
										if($req = $bdd->prepare("UPDATE genres SET titre = :titre WHERE id = :id")){
											$req->bindParam(':titre', $genre);
											$req->bindParam(':id', $q);
         									$req->execute();


											$result_genre = '<div id="reptopvalid"><center><i class="fa fa-check"></i> Le genre à bien été modifié.</center></div><meta http-equiv="refresh" content="1;liste.html?option='.$_GET['option'].'" />';
										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Erreur lors de l\'insertion dans la base de données.</center></div>';
										}

										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Le genre éxiste déja.</center></div>';
										}
										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Merci de ne pas ré-actualiser la page.</center></div>';
										}
										}else{
											echo '';
										}
				}else{
					echo '';
				}
			}else{
				echo '';
			}}else{

			}

	if($_SESSION['rank'] > 2 && ($_GET['option'] == 'membre' || $_GET['option'] == 'banni' || $_GET['option'] == 'inactif' || $_GET['option'] == 'staff')){

			if(empty($result_membre)){
		?>

		<div class="titre"><i class="fa fa-users" aria-hidden="true"></i> Changement de rang du membre : <?php echo $row['pseudo']; ?><span class="titre-right"><a href="<?php echo $url; ?>">Retour</a></span></div>
								<?php if($row['rank'] == 0){ ?>
								<form action="modifier.html?id=<?php echo $_GET['id']; ?>&option=<?php echo $_GET['option']; ?>" autocomplete="off"  align="center" method="POST">
									<select class="form-control_profil_big" name="rang"/>
									  <option value="0" selected>Banni(e)</option>
									  <option value="1">Membre</option>
									  <option value="2">V.I.P</option>
									  <?php if($_SESSION['rank'] == 4 ) { ?>
									  <option value="3">Modérateur</option>
									  <option value="4">Administrateur</option>
									  <?php }else{} ?>
									</select>
									<input type="hidden" name="token_custom_site" value="<?php echo $_SESSION['token']; ?>">
									<?php
									$_SESSION['jeton_f9'] = md5(time()*rand(1,900));
									?>
									<input type="hidden" value="<?php echo $_SESSION['jeton_f9']; ?>" name="f9_img">
									<button type="submit" name="button" class="btn btn-block btn-lg btn-info waves-effect waves-light">Changer</button>
								</form>
								<?php }elseif($row['rank'] == 1) { ?>
								<form action="modifier.html?id=<?php echo $_GET['id']; ?>&option=<?php echo $_GET['option']; ?>" autocomplete="off"  align="center" method="POST">
									<select class="form-control_profil_big" name="rang"/>
									  <option value="1" selected>Membre</option>
									  <option value="0">Banni(e)</option>
									  <option value="2">V.I.P</option>
									  <?php if($_SESSION['rank'] == 4 ) { ?>
									  <option value="3">Modérateur</option>
									  <option value="4">Administrateur</option>
									  <?php }else{} ?>
									</select>
									<input type="hidden" name="token_custom_site" value="<?php echo $_SESSION['token']; ?>">
									<?php
									$_SESSION['jeton_f9'] = md5(time()*rand(1,900));
									?>
									<input type="hidden" value="<?php echo $_SESSION['jeton_f9']; ?>" name="f9_img">
									<button type="submit" name="button" class="btn btn-block btn-lg btn-info waves-effect waves-light">Changer</button>
								</form>
								<?php }elseif($row['rank'] == 2) { ?>
								<form action="modifier.html?id=<?php echo $_GET['id']; ?>&option=<?php echo $_GET['option']; ?>" autocomplete="off"  align="center" method="POST">
									<select class="form-control_profil_big" name="rang"/>
									  <option value="2" selected>V.I.P</option>
									  <option value="0">Banni(e)</option>
									  <option value="1">Membre</option>
									  <?php if($_SESSION['rank'] == 4 ) { ?>
									  <option value="3">Modérateur</option>
									  <option value="4">Administrateur</option>
									  <?php }else{} ?>
									</select>
									<input type="hidden" name="token_custom_site" value="<?php echo $_SESSION['token']; ?>">
									<?php
									$_SESSION['jeton_f9'] = md5(time()*rand(1,900));
									?>
									<input type="hidden" value="<?php echo $_SESSION['jeton_f9']; ?>" name="f9_img">
									<button type="submit" name="button" class="btn btn-block btn-lg btn-info waves-effect waves-light">Changer</button>
								</form>	  
								<?php }elseif($row['rank'] == 3 && $_SESSION['rank'] == 4) { ?>	
								<form action="modifier.html?id=<?php echo $_GET['id']; ?>&option=<?php echo $_GET['option']; ?>" autocomplete="off"  align="center" method="POST">
									<select class="form-control_profil_big" name="rang"/>
									  <option value="3" selected>Modérateur</option>
									  <option value="0">Banni(e)</option>
									  <option value="1">Membre</option>
									  <option value="2">V.I.P</option>
									  <option value="4">Administrateur</option>
									</select>
									<input type="hidden" name="token_custom_site" value="<?php echo $_SESSION['token']; ?>">
									<?php
									$_SESSION['jeton_f9'] = md5(time()*rand(1,900));
									?>
									<input type="hidden" value="<?php echo $_SESSION['jeton_f9']; ?>" name="f9_img">
									<button type="submit" name="button" class="btn btn-block btn-lg btn-info waves-effect waves-light">Changer</button>
								</form>		  
								<?php }elseif($row['rank'] == 4 && $_SESSION['rank'] == 4 ) { ?>	
								<form action="modifier.html?id=<?php echo $_GET['id']; ?>&option=<?php echo $_GET['option']; ?>" autocomplete="off"  align="center" method="POST">
									<select class="form-control_profil_big" name="rang"/>
									  <option value="4" selected>Administrateur</option>
									  <option value="0">Banni(e)</option>
									  <option value="1">Membre</option>
									  <option value="2">V.I.P</option>
									  <option value="3">Modérateur</option>
									</select>
									<input type="hidden" name="token_custom_site" value="<?php echo $_SESSION['token']; ?>">
									<?php
									$_SESSION['jeton_f9'] = md5(time()*rand(1,900));
									?>
									<input type="hidden" value="<?php echo $_SESSION['jeton_f9']; ?>" name="f9_img">
									<button type="submit" name="button" class="btn btn-block btn-lg btn-info waves-effect waves-light">Changer</button>
								</form>	  
		<?php 
							}else{
									echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Impossible de changer le statut du membre si vous n\'êtes pas administrateur !</center></div>';
								}
		}else{
			echo $result_membre;
		} 
		}elseif($_SESSION['rank'] > 2 && $_GET['option'] == 'news'){
			if(empty($result_news)){

					$chainei_news = addslashes($_GET['id']);
					$req = $bdd->prepare("SELECT * FROM news WHERE id = :id");
					$req->execute(array(
					'id' => $chainei_news));
					$row = $req->fetch();	
		?>

		<div class="titre"><i class="fa fa-film" aria-hidden="true"></i> Changement d'une news<span class="titre-right"><a href="<?php echo $url; ?>">Retour</a></span></div>
								<form action="modifier.html?id=<?php echo $_GET['id']; ?>&option=<?php echo $_GET['option']; ?>" autocomplete="off"  align="center" method="POST">
									<textarea class="form-control_profil_big" type="text" name="news" required/><?php echo $row['news']; ?></textarea>
									<input type="hidden" name="token_custom_site" value="<?php echo $_SESSION['token']; ?>">
									<?php
									$_SESSION['jeton_f9'] = md5(time()*rand(1,900));
									?>
									<input type="hidden" value="<?php echo $_SESSION['jeton_f9']; ?>" name="f9_img">
									<br>
									<button type="submit" name="button_news" class="btn btn-block btn-lg btn-info waves-effect waves-light">Modifié</button>
								</form>

		<?php 
		}else{
			echo $result_news;
		}
		}elseif($_SESSION['rank'] > 2 && $_GET['option'] == 'qualite'){
			if(empty($result_qualite)){
		?>

		<div class="titre"><i class="fa fa-film" aria-hidden="true"></i> Changement d'une qualitée vidéo : <?php echo $row_qualite['titre']; ?><span class="titre-right"><a href="<?php echo $url; ?>">Retour</a></span></div>
								<form action="modifier.html?id=<?php echo $_GET['id']; ?>&option=<?php echo $_GET['option']; ?>" autocomplete="off"  align="center" method="POST">
									<input class="form-control_profil_big" type="text" placeholder="Saisir une qualitée vidéo" name="qualite" required/>
									</select>
									<input type="hidden" name="token_custom_site" value="<?php echo $_SESSION['token']; ?>">
									<?php
									$_SESSION['jeton_f9'] = md5(time()*rand(1,900));
									?>
									<input type="hidden" value="<?php echo $_SESSION['jeton_f9']; ?>" name="f9_img">
									<button type="submit" name="button_qualite" class="btn btn-block btn-lg btn-info waves-effect waves-light">Modifié</button>
								</form>

		<?php 
		}else{
			echo $result_qualite;
		}
		}elseif($_SESSION['rank'] > 2 && $_GET['option'] == 'genre'){
			if(empty($result_genre)){
		?>

		<div class="titre"><i class="fa fa-film" aria-hidden="true"></i> Changement d'un genre : <?php echo $row_genre['titre']; ?><span class="titre-right"><a href="<?php echo $url; ?>">Retour</a></span></div>
								<form action="modifier.html?id=<?php echo $_GET['id']; ?>&option=<?php echo $_GET['option']; ?>" autocomplete="off"  align="center" method="POST">
									<input class="form-control_profil_big" type="text" placeholder="Saisir un genre" name="genre" required/>
									</select>
									<input type="hidden" name="token_custom_site" value="<?php echo $_SESSION['token']; ?>">
									<?php
									$_SESSION['jeton_f9'] = md5(time()*rand(1,900));
									?>
									<input type="hidden" value="<?php echo $_SESSION['jeton_f9']; ?>" name="f9_img">
									<button type="submit" name="button_genre" class="btn btn-block btn-lg btn-info waves-effect waves-light">Modifié</button>
								</form>

		<?php 
		}else{
			echo $result_genre;
		}

	}elseif($_SESSION['rank'] > 3 && ($_GET['option'] == 'maintenance' || $_GET['option'] == 'inscription' || $_GET['option'] == 'maintenance' || $_GET['option'] == 'commentaires' || $_GET['option'] == 'news' || $_GET['option'] == 'ddl')){

							$req = $bdd->prepare("SELECT * FROM core WHERE id = :id");
							$req->execute(array(
								'id' => 1));
							$row_core = $req->fetch();

							if($_GET['option'] == 'maintenance'){
								if($row_core['maintenance'] == '0'){
											$req = $bdd->prepare("UPDATE core SET maintenance = :maintenance WHERE id = :id");
													$req->execute(array(
														'maintenance' => 1,
														'id' => 1));

													echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> La maintenance vient d\'être activée.</center></div><meta http-equiv="refresh" content="2;admin.html" />';
								}elseif($row_core['maintenance'] == '1'){
											$req = $bdd->prepare("UPDATE core SET maintenance = :maintenance WHERE id = :id");
													$req->execute(array(
														'maintenance' => 0,
														'id' => 1));

													echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> La maintenance vient d\'être désactivée.</center></div><meta http-equiv="refresh" content="2;admin.html" />';
								}else{
								echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Tu t\'és perdu ?</center></div>';
							}	
							}elseif($_GET['option'] == 'inscription'){
								if($row_core['inscription'] == '0'){

											$inscription = 1;
											$id = 1;

											$req = $bdd->prepare("UPDATE core SET inscription = :inscription WHERE id = :id");
													$req->bindParam(':inscription', $inscription);
													$req->bindParam(':id', $id);
         											$req->execute();
													

													echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> Les inscriptions sont maintenant fermées.</center></div><meta http-equiv="refresh" content="2;admin.html" />';
								}elseif($row_core['inscription'] == '1'){

											$inscription = 0;
											$id = 1;

											$req = $bdd->prepare("UPDATE core SET inscription = :inscription WHERE id = :id");
													$req->bindParam(':inscription', $inscription);
													$req->bindParam(':id', $id);
         											$req->execute();

													echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> Les inscriptions sont maintenant ouvertes.</center></div><meta http-equiv="refresh" content="2;admin.html" />';
								}else{
								echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Tu t\'és perdu ?</center></div>';
							}				
							}elseif($_GET['option'] == 'commentaires'){
								if($row_core['commentaires'] == '0'){

											$commentaires = 1;
											$id = 1;

											$req = $bdd->prepare("UPDATE core SET commentaires = :commentaires WHERE id = :id");
													$req->bindParam(':commentaires', $commentaires);
													$req->bindParam(':id', $id);
         											$req->execute();

													echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> Les commentaires sont maintenant désactivés.</center></div><meta http-equiv="refresh" content="2;admin.html" />';
								}elseif($row_core['commentaires'] == '1'){

											$commentaires = 0;
											$id = 1;

											$req = $bdd->prepare("UPDATE core SET commentaires = :commentaires WHERE id = :id");
													$req->bindParam(':commentaires', $commentaires);
													$req->bindParam(':id', $id);
         											$req->execute();

													echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> Les commentaires sont maintenant activés.</center></div><meta http-equiv="refresh" content="2;admin.html" />';
								}else{
								echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Tu t\'és perdu ?</center></div>';
							}						
							}elseif($_GET['option'] == 'news'){
								if($row_core['news'] == '0'){

											$news = 1;
											$id = 1;

											$req = $bdd->prepare("UPDATE core SET news = :news WHERE id = :id");
													
													$req->bindParam(':news', $news);
													$req->bindParam(':id', $id);
         											$req->execute();

													echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> Les news sont maintenant désactivées.</center></div><meta http-equiv="refresh" content="2;admin.html" />';
								}elseif($row_core['news'] == '1'){

											$news = 0;
											$id = 1;

											$req = $bdd->prepare("UPDATE core SET news = :news WHERE id = :id");
													
													$req->bindParam(':news', $news);
													$req->bindParam(':id', $id);
         											$req->execute();

													echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> Les news sont maintenant activées.</center></div><meta http-equiv="refresh" content="2;admin.html" />';
								}else{
								echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Tu t\'és perdu ?</center></div>';
							}					
							}elseif($_GET['option'] == 'ddl'){
								if($row_core['ddl'] == '0'){

											$ddl = 1;
											$id = 1;

											$req = $bdd->prepare("UPDATE core SET ddl = :ddl WHERE id = :id");
													
													$req->bindParam(':ddl', $ddl);
													$req->bindParam(':id', $id);
         											$req->execute();

													echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> Les téléchargement sont maintenant désactivées.</center></div><meta http-equiv="refresh" content="2;admin.html" />';
								}elseif($row_core['ddl'] == '1'){

											$ddl = 0;
											$id = 1;

											$req = $bdd->prepare("UPDATE core SET ddl = :ddl WHERE id = :id");
													
													$req->bindParam(':ddl', $ddl);
													$req->bindParam(':id', $id);
         											$req->execute();

													echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> Les téléchargement sont maintenant activées.</center></div><meta http-equiv="refresh" content="2;admin.html" />';
								}else{
								echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Tu t\'és perdu ?</center></div>';
							}					
							}elseif($_GET['option'] != 'news' OR $_GET['option'] != 'commentaires' OR $_GET['option'] != 'maintenance' OR $_GET['option'] != 'news' OR $_GET['option'] != 'ddl'){
								echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Tu t\'és perdu ?</center></div>';
							}

	}elseif($_SESSION['rank'] > 2 && ($_GET['option'] == 'film' || $_GET['option'] == 'video_hs' || $_GET['option'] == 'exclusivite' || $_GET['option'] == 'pending') && isset($_GET['id'])){

					$req = $bdd->prepare("SELECT * FROM film WHERE id = :id");
					$req->execute(array(
						'id' => $q));
					$row = $req->fetch();

		if(isset($_POST['button_film_modifier'])){
			if(preg_match('/jheberg.net/', $_POST['lien_ddl']) || empty($_POST['lien_ddl'])){
						if(isset($_POST) && !empty($_POST['titre']) && !empty($_POST['duree']) && !empty($_POST['date_sortie']) && !empty($_POST['realisateur']) && !empty($_POST['genre_1']) && !empty($_POST['qualite']) && !empty($_POST['url_jaquette']) && !empty($_POST['release']) && !empty($_POST['hebergeur_video']) && !empty($_POST['url_video']) && !empty($_POST['acteur']) && !empty($_POST['synopsis']) && !empty($_POST['token_custom_site'])){

								if($_POST['token_custom_site'] == $_SESSION['token']){
									if($_POST['f1_img'] == $_SESSION['jeton_f1']){
									unset($_SESSION['jeton_f1']);

									if(empty($_POST['genre_2'])){
										$genre_2b = '';	
									}else{
										$genre_2b = $_POST['genre_2'];
									}
									if(empty($_POST['genre_3'])){
										$genre_3b = '';	
									}else{
										$genre_3b = $_POST['genre_3'];
									}

										$titre = filter_var(htmlentities($_POST['titre']), FILTER_SANITIZE_STRING);
										$duree = filter_var(htmlentities($_POST['duree']), FILTER_SANITIZE_STRING);
										$date_sortie = filter_var(htmlentities($_POST['date_sortie']), FILTER_SANITIZE_STRING);
										$realisateur = filter_var(htmlentities($_POST['realisateur']), FILTER_SANITIZE_STRING);
										$genre_1 = filter_var(htmlentities($_POST['genre_1']), FILTER_SANITIZE_STRING);
										$genre_2 = filter_var(htmlentities($genre_2b), FILTER_SANITIZE_STRING);
										$genre_3 = filter_var(htmlentities($genre_3b), FILTER_SANITIZE_STRING);
										$qualite = filter_var(htmlentities($_POST['qualite']), FILTER_SANITIZE_STRING);
										$pending = filter_var(htmlentities($_POST['pending']), FILTER_SANITIZE_NUMBER_INT);
										$exclusivite = filter_var(htmlentities($_POST['exclusivite']), FILTER_SANITIZE_NUMBER_INT);
										$url_jaquette = filter_var(htmlentities($_POST['url_jaquette']), FILTER_SANITIZE_STRING);
										$titre_release = filter_var(htmlentities($_POST['release']), FILTER_SANITIZE_STRING);
										$video_hs = filter_var(htmlentities($_POST['video_hs']), FILTER_SANITIZE_NUMBER_INT);
										$hebergeur_video = filter_var(htmlentities($_POST['hebergeur_video']), FILTER_SANITIZE_STRING);
										$url_video = filter_var(htmlentities($_POST['url_video']), FILTER_SANITIZE_STRING);
										$acteur = filter_var(htmlentities($_POST['acteur']), FILTER_SANITIZE_STRING);
										$synopsis = filter_var(htmlentities($_POST['synopsis']), FILTER_SANITIZE_STRING);
										$lien_ddl = filter_var(htmlentities($_POST['lien_ddl']), FILTER_SANITIZE_STRING);
										
												$req = $bdd->prepare('SELECT count(*) AS nbre_occurences FROM film WHERE titre = :titre AND qualite = :qualiter AND id != :id');
												$req->execute(array(
												'titre' => $titre,
												'qualiter' => $qualite,
												'id' => $q));
												$donnees = $req->fetch();
												$nbre_occurences = $donnees['nbre_occurences'];
												$req->closeCursor();

												$req1 = $bdd->prepare('SELECT count(*) AS nbre_occurences FROM film WHERE titre = :titre AND qualite = :qualiter AND id != :id');
												$req1->execute(array(
												'titre' => $titre,
												'qualiter' => $qualite,
												'id' => $q));
												$donnees1 = $req1->fetch();
												$nbre_occurences1 = $donnees1['nbre_occurences'];
												$req1->closeCursor();

										if($nbre_occurences == 0 || $nbre_occurences1 != 0){	
										if($req = $bdd->prepare('UPDATE film SET url_jaquette = :url_jaquette, titre = :titre, titre_release = :titre_release, duree = :duree, date_sortie = :date_sortie, realisateur = :realisateur, acteurs = :acteurs, genre_1 = :genre_1, genre_2 = :genre_2, genre_3 = :genre_3, qualite = :qualite, synopsy = :synopsy, hebergeur_video = :hebergeur_video, lien_streaming = :lien_streaming, exclusivite = :exclusivite, video_hs = :video_hs, pending = :pending, lien_ddl = :lien_ddl WHERE id = :id')){

												$req->bindParam(':url_jaquette', $url_jaquette);
												$req->bindParam(':titre', $titre);
												$req->bindParam(':titre_release', $titre_release);
												$req->bindParam(':duree', $duree);
												$req->bindParam(':date_sortie', $date_sortie);
												$req->bindParam(':realisateur', $realisateur);
												$req->bindParam(':acteurs', $acteur);
												$req->bindParam(':genre_1', $genre_1);
												$req->bindParam(':genre_2', $genre_2);
												$req->bindParam(':genre_3', $genre_3);
												$req->bindParam(':qualite', $qualite);
												$req->bindParam(':synopsy', $synopsis);
												$req->bindParam(':hebergeur_video', $hebergeur_video);
												$req->bindParam(':lien_streaming', $url_video);
												$req->bindParam(':exclusivite', $exclusivite);
												$req->bindParam(':video_hs', $video_hs);
												$req->bindParam(':pending', $pending);
												$req->bindParam(':lien_ddl', $lien_ddl);
												$req->bindParam(':id', $q);
         										$req->execute();


											$result_modifadmin = '<div id="reptopvalid"><center><i class="fa fa-check"></i> Le film : '.$_POST['titre'].' à bien été modifié.</center></div><meta http-equiv="refresh" content="1;liste.html?option='.$_GET['option'].'" />';
										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Erreur lors de l\'insertion dans la base de données.</center></div>';
										} 
										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Ce film existe déja.</center></div>';
										}
										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Merci de ne pas ré-actualiser la page.</center></div>';
										}
										}else{
											echo '';
										}
				}else{
					echo '';
				}
			}else{
					echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Lien du téléchargement interdit. <br>Uniquement l\'hebergeur jHeberg.</center></div><meta http-equiv="refresh" content="1;ajouter.html?option='.$_GET['option'].'&code='.$code_film.'" />';
				}
			}else{
			}
if(empty($result_modifadmin)){
			$req = $bdd->prepare('SELECT count(*) AS nbre_occurences FROM film WHERE id = :id');
			$req->execute(array(
			'id' => $q));
			$donnees = $req->fetch();
			$nbre_occurences = $donnees['nbre_occurences'];
			$req->closeCursor();

			if($nbre_occurences == 1){	
?>
	<div class="titre">Modifié le film : <?php echo $row['titre']; ?><span class="titre-right"><a href="<?php $_SERVER['HTTP_REFERER']; ?>">Retour</a></span></div>

	<br>
	<form action="modifier.html?id=<?php echo $_GET['id']; ?>&option=<?php echo $_GET['option']; ?>" autocomplete="off"  align="center" method="POST">
	<center><input type="text" name="titre" value="<?php echo $row['titre']; ?>" class="form-control_profil" style="margin-bottom:10px;" required>
	<input type="text" name="duree" value="<?php echo $row['duree']; ?>" class="form-control_profil" style="margin-bottom:10px;" required>
	<input type="text" name="date_sortie" value="<?php echo $row['date_sortie']; ?>" class="form-control_profil" style="margin-bottom:10px;" required>
	<input type="text" name="realisateur" value="<?php echo $row['realisateur']; ?>" class="form-control_profil" style="margin-bottom:10px;" required></center>
	<div class="clear"></div>
	<center>
	<select class="form-control_profil" name="genre_1" style="margin-bottom:10px;"/>
	<option value="<?php echo $row['genre_1']; ?>" selected><?php echo $row['genre_1']; ?></option>
	<?php
	$req = $bdd->prepare("SELECT * FROM genres ORDER BY titre ASC");
										$req->execute();
										while($row_1 = $req->fetch()){

	echo '<option value="'.$row_1['titre'].'">'.$row_1['titre'].'</option>';
	 } ?>
	</select>
	<select class="form-control_profil" name="genre_2" style="margin-bottom:10px;"/>
	<option value="<?php echo $row['genre_2']; ?>" selected><?php echo $row['genre_2']; ?></option>
	<?php
	$req = $bdd->prepare("SELECT * FROM genres ORDER BY titre ASC");
										$req->execute();
										while($row_2 = $req->fetch()){

	echo '<option value="'.$row_2['titre'].'">'.$row_2['titre'].'</option>';
	 } ?>
	</select>
	<select class="form-control_profil" name="genre_3" style="margin-bottom:10px;"/>
	<option value="<?php echo $row['genre_3']; ?>" selected><?php echo $row['genre_3']; ?></option>
	<?php
	$req = $bdd->prepare("SELECT * FROM genres ORDER BY titre ASC");
										$req->execute();
										while($row_3 = $req->fetch()){

	echo '<option value="'.$row_3['titre'].'">'.$row_3['titre'].'</option>';
	 } ?>
	</select>
	<select class="form-control_profil" name="qualite" style="margin-bottom:10px;"/>
	<option value="<?php echo $row['qualite']; ?>" selected><?php echo $row['qualite']; ?></option>
	<?php
	$req = $bdd->prepare("SELECT * FROM qualiter ORDER BY titre ASC");
										$req->execute();
										while($row_4 = $req->fetch()){

	echo '<option value="'.$row_4['titre'].'">'.$row_4['titre'].'</option>';
	 } ?>
	</select>
	</center>
	<div class="clear"></div>
	<center>
	<select class="form-control_profil" name="pending"/>
	<option value="<?php echo $row['pending']; ?>" selected>
	<?php	
	if($row['pending'] == 0){
		echo 'Validé';
	}elseif($row['pending'] == 1){
		echo 'En Attente';
	}elseif($row['pending'] == 2){
		echo 'Non-Validé';
	}elseif($row['pending'] == 3){
		echo 'À Corrigé';
	}
	?>
	</option>
	<option value="0">Validé</option>
	<option value="1">En Attente</option>
	<option value="2">Non-Validé</option>
	<option value="3">À Corrigé</option>
	</select>
	<select class="form-control_profil" name="exclusivite"/>
	<option value="<?php echo $row['exclusivite']; ?>" selected><?php if($row['exclusivite'] == 0){ echo 'Ce n\'est pas une exclusivité'; }else{ echo 'C\'est une exclusivité'; } ?></option>
	<option value="0">Ce n'est pas une exclusivité</option>
	<option value="1">C'est une exclusivité</option>
	</select>
	<input type="text" name="url_jaquette" value="<?php echo $row['url_jaquette']; ?>" class="form-control_profil" required>
	<input type="text" name="release" value="<?php echo $row['titre_release']; ?>" class="form-control_profil" required></center>
	<br>
	<center>
	<input type="text" name="video_hs" value="<?php echo $row['video_hs']; ?>" class="form-control_profil" required>
	<select class="form-control_profil" name="hebergeur_video"/>
	<option value="<?php echo $row['hebergeur_video']; ?>" selected><?php echo $row['hebergeur_video']; ?></option>
	<option value="ViDto">ViDto</option>
	<option value="Streamin">Streamin</option>
	<option value="VideoMega">VideoMega</option>
	<option value="ViD|AG">ViD|AG</option>
	<option value="AllVid">AllVid</option>
	<option value="UpToStream">UpToStream</option>
	<option value="YouWatch">YouWatch</option>
	<option value="UptoBox">UptoBox</option>
	</select>
	<input type="text" name="url_video" value="<?php echo $row['lien_streaming']; ?>" class="form-control_profil" required>
	<?php 
	if($row_core['ddl'] == 0){
	if(empty($row['lien_ddl'])){
			echo '<input type="text" name="lien_ddl" placeholder="Lien jHeberg*" class="form-control_profil" required>';
		}else{
			echo '<input type="text" name="lien_ddl" value="'.$row['lien_ddl'].'" class="form-control_profil" required>';
	}
	}else{} 
	?>
	</center>
	<br>
	<center>
	<textarea value="<?php echo $row['acteurs']; ?>" name="acteur" required><?php echo $row['acteurs']; ?></textarea>
	<textarea value="<?php echo $row['synopsy']; ?>" name="synopsis" required><?php echo $row['synopsy']; ?></textarea>
	</center>
	<input type="hidden" name="token_custom_site" value="<?php echo $_SESSION['token']; ?>">
	<?php
	$_SESSION['jeton_f1'] = md5(time()*rand(1,900));
	?>
	<input type="hidden" value="<?php echo $_SESSION['jeton_f1']; ?>" name="f1_img">
	<br>
	<center><button type="submit" name="button_film_modifier" class="btn btn-block btn-lg btn-info waves-effect waves-light">Modifié le film</button></center>
	</form>
	<br><span style="font-size: 10px;">(*)Optionnel(le)<br>(**)Consulter la F.A.Q pour en savoir plus.</span>
<?php
		}else{
				echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Ce film n\'existe pas !</center></div>';
		} 
			}else{
				echo $result_modifadmin;
			} 
	}elseif($_SESSION['rank'] > 0 && $_GET['option'] == 'mes_films'){

					$req = $bdd->prepare("SELECT * FROM film WHERE id = :id");
					$req->execute(array(
						'id' => $q));
					$row = $req->fetch();
		if($_SESSION['id'] == $row['uploader_id']){





		if(isset($_POST['button_monfilm_modifier'])){
				if(preg_match('/jheberg.net/', $_POST['lien_ddl']) || empty($_POST['lien_ddl'])){
						if(isset($_POST) && !empty($_POST['titre']) && !empty($_POST['duree']) && !empty($_POST['date_sortie']) && !empty($_POST['realisateur']) && !empty($_POST['genre_1']) && !empty($_POST['qualite']) && !empty($_POST['url_jaquette']) && !empty($_POST['release']) && !empty($_POST['hebergeur_video']) && !empty($_POST['url_video']) && !empty($_POST['acteur']) && !empty($_POST['synopsis']) && !empty($_POST['token_custom_site'])){

								if($_POST['token_custom_site'] == $_SESSION['token']){
									if($_POST['f1_img'] == $_SESSION['jeton_f1']){
									unset($_SESSION['jeton_f1']);

									if(empty($_POST['genre_2'])){
										$genre_2b = '';	
									}else{
										$genre_2b = $_POST['genre_2'];
									}
									if(empty($_POST['genre_3'])){
										$genre_3b = '';	
									}else{
										$genre_3b = $_POST['genre_3'];
									}

										$titre = filter_var(htmlentities($_POST['titre']), FILTER_SANITIZE_STRING);
										$duree = filter_var(htmlentities($_POST['duree']), FILTER_SANITIZE_STRING);
										$date_sortie = filter_var(htmlentities($_POST['date_sortie']), FILTER_SANITIZE_STRING);
										$realisateur = filter_var(htmlentities($_POST['realisateur']), FILTER_SANITIZE_STRING);
										$genre_1 = filter_var(htmlentities($_POST['genre_1']), FILTER_SANITIZE_STRING);
										$genre_2 = filter_var(htmlentities($genre_2b), FILTER_SANITIZE_STRING);
										$genre_3 = filter_var(htmlentities($genre_3b), FILTER_SANITIZE_STRING);
										$qualite = filter_var(htmlentities($_POST['qualite']), FILTER_SANITIZE_STRING);
										$pending = 1;
										$url_jaquette = filter_var(htmlentities($_POST['url_jaquette']), FILTER_SANITIZE_STRING);
										$titre_release = filter_var(htmlentities($_POST['release']), FILTER_SANITIZE_STRING);
										$video_hs = 0;
										$hebergeur_video = filter_var(htmlentities($_POST['hebergeur_video']), FILTER_SANITIZE_STRING);
										$url_video = filter_var(htmlentities($_POST['url_video']), FILTER_SANITIZE_STRING);
										$acteur = filter_var(htmlentities($_POST['acteur']), FILTER_SANITIZE_STRING);
										$synopsis = filter_var(htmlentities($_POST['synopsis']), FILTER_SANITIZE_STRING);
										$lien_ddl = filter_var(htmlentities($_POST['lien_ddl']), FILTER_SANITIZE_STRING);
										
												$req = $bdd->prepare('SELECT count(*) AS nbre_occurences FROM film WHERE titre = :titre AND qualite = :qualiter AND id != :id');
												$req->execute(array(
												'titre' => $titre,
												'qualiter' => $qualite,
												'id' => $q));
												$donnees = $req->fetch();
												$nbre_occurences = $donnees['nbre_occurences'];
												$req->closeCursor();

												$req1 = $bdd->prepare('SELECT count(*) AS nbre_occurences FROM film WHERE titre = :titre AND qualite = :qualiter AND id != :id');
												$req1->execute(array(
												'titre' => $titre,
												'qualiter' => $qualite,
												'id' => $q));
												$donnees1 = $req1->fetch();
												$nbre_occurences1 = $donnees1['nbre_occurences'];
												$req1->closeCursor();

										if($nbre_occurences == 0 || $nbre_occurences1 != 0){	
										if($req = $bdd->prepare('UPDATE film SET url_jaquette = :url_jaquette, titre = :titre, titre_release = :titre_release, duree = :duree, date_sortie = :date_sortie, realisateur = :realisateur, acteurs = :acteurs, genre_1 = :genre_1, genre_2 = :genre_2, genre_3 = :genre_3, qualite = :qualite, synopsy = :synopsy, hebergeur_video = :hebergeur_video, lien_streaming = :lien_streaming, video_hs = :video_hs, pending = :pending, lien_ddl = :lien_ddl WHERE id = :id')){

												$req->bindParam(':url_jaquette', $url_jaquette);
												$req->bindParam(':titre', $titre);
												$req->bindParam(':titre_release', $titre_release);
												$req->bindParam(':duree', $duree);
												$req->bindParam(':date_sortie', $date_sortie);
												$req->bindParam(':realisateur', $realisateur);
												$req->bindParam(':acteurs', $acteur);
												$req->bindParam(':genre_1', $genre_1);
												$req->bindParam(':genre_2', $genre_2);
												$req->bindParam(':genre_3', $genre_3);
												$req->bindParam(':qualite', $qualite);
												$req->bindParam(':synopsy', $synopsis);
												$req->bindParam(':hebergeur_video', $hebergeur_video);
												$req->bindParam(':lien_streaming', $url_video);
												$req->bindParam(':video_hs', $video_hs);
												$req->bindParam(':pending', $pending);
												$req->bindParam(':lien_ddl', $lien_ddl);
												$req->bindParam(':id', $q);
         										$req->execute();


											$result_film = '<div id="reptopvalid"><center><i class="fa fa-check"></i> Ton film : '.$_POST['titre'].' à bien été modifié, et replacé en pending.</center></div><meta http-equiv="refresh" content="1;liste.html?id='.$_SESSION['id'].'&option='.$_GET['option'].'" />';
										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Erreur lors de l\'insertion dans la base de données.</center></div>';
										} 
										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Ce film existe déja.</center></div>';
										}
										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Merci de ne pas ré-actualiser la page.</center></div>';
										}
										}else{
											echo '';
										}
				}else{
					echo '';
				}
				}else{
					echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Lien du téléchargement interdit. <br>Uniquement l\'hebergeur jHeberg.</center></div><meta http-equiv="refresh" content="1;ajouter.html?option='.$_GET['option'].'&code='.$code_film.'" />';
				}
			}else{
			}

			if(empty($result_film)){
?>
	<div class="titre">Modifié le film : <?php echo $row['titre']; ?><span class="titre-right"><a href="<?php $_SERVER['HTTP_REFERER']; ?>">Retour</a></span></div>

	<br>
	<form action="modifier.html?id=<?php echo $_GET['id']; ?>&option=<?php echo $_GET['option']; ?>" autocomplete="off"  align="center" method="POST">
	<center><input type="text" name="titre" value="<?php echo $row['titre']; ?>" class="form-control_profil" style="margin-bottom:10px;" required>
	<input type="text" name="duree" value="<?php echo $row['duree']; ?>" class="form-control_profil" style="margin-bottom:10px;" required>
	<input type="text" name="date_sortie" value="<?php echo $row['date_sortie']; ?>" class="form-control_profil" style="margin-bottom:10px;" required>
	<input type="text" name="realisateur" value="<?php echo $row['realisateur']; ?>" class="form-control_profil" style="margin-bottom:10px;" required></center>
	<div class="clear"></div>
	<center>
	<select class="form-control_profil" name="genre_1" style="margin-bottom:10px;"/>
	<option value="<?php echo $row['genre_1']; ?>" selected><?php echo $row['genre_1']; ?></option>
	<?php
	$req = $bdd->prepare("SELECT * FROM genres ORDER BY titre ASC");
										$req->execute();
										while($row_1 = $req->fetch()){

	echo '<option value="'.$row_1['titre'].'">'.$row_1['titre'].'</option>';
	 } ?>
	</select>
	<select class="form-control_profil" name="genre_2" style="margin-bottom:10px;"/>
	<option value="<?php echo $row['genre_2']; ?>" selected><?php echo $row['genre_2']; ?></option>
	<?php
	$req = $bdd->prepare("SELECT * FROM genres ORDER BY titre ASC");
										$req->execute();
										while($row_2 = $req->fetch()){

	echo '<option value="'.$row_2['titre'].'">'.$row_2['titre'].'</option>';
	 } ?>
	</select>
	<select class="form-control_profil" name="genre_3" style="margin-bottom:10px;"/>
	<option value="<?php echo $row['genre_3']; ?>" selected><?php echo $row['genre_3']; ?></option>
	<?php
	$req = $bdd->prepare("SELECT * FROM genres ORDER BY titre ASC");
										$req->execute();
										while($row_3 = $req->fetch()){

	echo '<option value="'.$row_3['titre'].'">'.$row_3['titre'].'</option>';
	 } ?>
	</select>
	<select class="form-control_profil" name="qualite" style="margin-bottom:10px;"/>
	<option value="<?php echo $row['qualite']; ?>" selected><?php echo $row['qualite']; ?></option>
	<?php
	$req = $bdd->prepare("SELECT * FROM qualiter ORDER BY titre ASC");
										$req->execute();
										while($row_4 = $req->fetch()){

	echo '<option value="'.$row_4['titre'].'">'.$row_4['titre'].'</option>';
	 } ?>
	</select>
	</center>
	<div class="clear"></div>
	<center>
	<input type="text" name="url_jaquette" value="<?php echo $row['url_jaquette']; ?>" class="form-control_profil" required>
	<input type="text" name="release" value="<?php echo $row['titre_release']; ?>" class="form-control_profil" required>
	<select class="form-control_profil" name="hebergeur_video"/>
	<option value="<?php echo $row['hebergeur_video']; ?>" selected><?php echo $row['hebergeur_video']; ?></option>
	<option value="ViDto">ViDto</option>
	<option value="Streamin">Streamin</option>
	<option value="VideoMega">VideoMega</option>
	<option value="ViD|AG">ViD|AG</option>
	<option value="AllVid">AllVid</option>
	<option value="UpToStream">UpToStream</option>
	<option value="YouWatch">YouWatch</option>
	<option value="UptoBox">UptoBox</option>
	</select>
	<input type="text" name="url_video" value="<?php echo $row['lien_streaming']; ?>" class="form-control_profil" required>
	<?php 
	if($row_core['ddl'] == 0){
	if(empty($row['lien_ddl'])){
			echo '<input type="text" name="lien_ddl" placeholder="Lien jHeberg*" class="form-control_profil" required>';
		}else{
			echo '<input type="text" name="lien_ddl" value="'.$row['lien_ddl'].'" class="form-control_profil" required>';
	}
	}else{} 
	?>
	</center>
	<br>
	<center>
	<textarea value="<?php echo $row['acteurs']; ?>" name="acteur" required><?php echo $row['acteurs']; ?></textarea>
	<textarea value="<?php echo $row['synopsy']; ?>" name="synopsis" required><?php echo $row['synopsy']; ?></textarea>
	</center>
	<input type="hidden" name="token_custom_site" value="<?php echo $_SESSION['token']; ?>">
	<?php
	$_SESSION['jeton_f1'] = md5(time()*rand(1,900));
	?>
	<input type="hidden" value="<?php echo $_SESSION['jeton_f1']; ?>" name="f1_img">
	<br>
	<center><button type="submit" name="button_monfilm_modifier" class="btn btn-block btn-lg btn-info waves-effect waves-light">Modifié le film</button></center>
	</form>
	<br><span style="font-size: 10px;">(*)Optionnel(le)<br>(**)Consulter la F.A.Q pour en savoir plus.</span>
<?php

			}else{
				echo $result_film;
			}
	}else{
		echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Tu t\'és perdu ?</center></div>';
	}
	}else{
		echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Tu t\'és perdu ?</center></div>';
	}
}
?>
</div>
<?php include './system/footer.php'; ?>
