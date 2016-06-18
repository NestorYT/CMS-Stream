<?php require './system/config_inc.php';
require './system/function.php';

$chaineid = addslashes($_GET['option']);
$chaineidp = addslashes($_GET['pending']);
$chaineidmp = addslashes($_GET['mon_pending']);

$req = $bdd->prepare("SELECT * FROM film WHERE id = :id");
$req->execute(array(
'id' => $chaineid));
$row_core_name = $req->fetch();

$req_verif_1 = $bdd->prepare('SELECT count(*) AS nbre_occurences FROM film WHERE id = :id');
$req_verif_1->execute(array(
'id' => $chaineid));
$donnees_1 = $req_verif_1->fetch();
$nbre_occurences_1 = $donnees_1['nbre_occurences'];
$req_verif_1->closeCursor();

$req_verif_2 = $bdd->prepare('SELECT count(*) AS nbre_occurences FROM film WHERE id = :id');
$req_verif_2->execute(array(
'id' => $chaineidp));
$donnees_2 = $req_verif_2->fetch();
$nbre_occurences_2 = $donnees_2['nbre_occurences'];
$req_verif_2->closeCursor();

$req_verif_3 = $bdd->prepare('SELECT count(*) AS nbre_occurences FROM film WHERE id = :id');
$req_verif_3->execute(array(
'id' => $chaineidmp));
$donnees_3 = $req_verif_3->fetch();
$nbre_occurences_3 = $donnees_3['nbre_occurences'];
$req_verif_3->closeCursor();

if($_GET['option']){
$namePage = 'Film : '.$row_core_name['titre'];
}elseif($_GET['pending']){
$namePage = 'Film : en pending';
}elseif($_GET['mon_pending']){
$namePage = 'Film : en pending';
}

	$req = $bdd->prepare("SELECT * FROM core WHERE id = :id");
					$req->execute(array(
						'id' => 1));
					$row_core = $req->fetch();

	if($row_core['maintenance'] == 1 && $_SESSION['rank'] < 3){

		include './system/maintenance.php';

	}else{ 
			
include 'system/header.php'; ?>

<div class="wrap">
<div class="clear"></div>

<?php
if($nbre_occurences_1 == 1 || $nbre_occurences_2 == 1 || $nbre_occurences_3 == 1){
if(!isset($_SESSION['pseudo'])){
if(!empty($_GET['option'])){			
$req = $bdd->prepare("SELECT * FROM film WHERE id = :id");
					$req->execute(array(
						'id' => $chaineid));
					$row = $req->fetch();	

					$req = $bdd->prepare("SELECT * FROM membres WHERE id = :id");
					$req->execute(array(
						'id' => $row['uploader_id']));
					$row_2 = $req->fetch();	

if(isset($_POST['button_video_hs'])){
	if($_POST['token_custom_site'] == $_SESSION['token']){
		if($_POST['f9_img'] == $_SESSION['jeton_f9']){
		unset($_SESSION['jeton_f9']);
			if($row['video_hs'] != 5){	
				$i = $row['video_hs']+1;
				if($req = $bdd->prepare("UPDATE film SET video_hs = :video_hs WHERE id = :id")){
					$req->execute(array(
					'video_hs' => $i,
					'id' => $chaineid));

					echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> Merci pour le signalement.</center></div><meta http-equiv="refresh" content="1;'.$_SERVER['HTTP_REFERER'].'" />';
				}else{
					echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Erreur lors de l\'insertion dans la base de données.</center></div>';
				}
			}else{
				echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Ce film à déja été retirer de la liste, cause : Vidéo HS !</center></div>';	
			}
		}else{
			echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Merci de ne pas ré-actualiser la page.</center></div>';
		}
	}else{
		echo '';
	}
}else{}		

					if($row['video_hs'] != 5){
						if($row['pending'] == 0){
?>

<div id="viewProjet" class="pageProjets">

				<div class="left">
					<a class="zoombox zgallery1" href="<?php echo $row['url_jaquette']; ?>">
						<div class="grandeThumb" style="background-image: url('<?php echo $row['url_jaquette']; ?>');"></div>
					</a><div class="clear"></div>	
					<form action="infos.html?option=<?php echo $_GET['option']; ?>" autocomplete="off"  align="center" method="POST">
					<input type="hidden" name="token_custom_site" value="<?php echo $_SESSION['token']; ?>">
					<?php
					$_SESSION['jeton_f9'] = md5(time()*rand(1,900));
					?>
					<input type="hidden" value="<?php echo $_SESSION['jeton_f9']; ?>" name="f9_img">
					<button name="button_video_hs" class="bouton-hs" type="submit"><i class="fa fa-chain-broken one" aria-hidden="true"></i> Vidéo HS ? - (<?php echo $row['video_hs']; ?>)</button>
					</form>
					<div class="clear"></div>	
					<div class="facebook" alt="Facebook share" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=http://www.modzcatz.fr/infos.html?option=<?php echo $_GET['option']; ?>', 'facebook_share', 'height=320, width=640, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');"><i class="fa fa-facebook" aria-hidden="true"></i> Partager</div>	
					<div class="clear"></div>	
					<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><p class="bouton-retour"><i class="fa fa-chevron-left" aria-hidden="true"></i> Retour au site</p></a><div class="clear"></div>				
				</div>
				<div class="right"><span class="titre-info"><i class="fa fa-info" aria-hidden="true"></i> Informations</span></div>
				<div class="right-sub">
					<p class="categories">Ajouté le <span class="coulor_net"><b><?php echo $row['date_add']; ?></b></span> par <?php if(empty($row_2['pseudo'])){ echo '<span class="rank">Inconnu</span>'; }else{ echo '<span class="rank'.$row_2['rank'].'">'.$row_2['pseudo'].'</span>'; } ?></p><div class="clear"></div>
					<h3><?php echo $row['titre']; ?><label><?php echo $row['titre_release']; ?></label></h3>
					<div class="info-left_bear">
					<p class="info-left"><b><i class="fa fa-clock-o" aria-hidden="true"></i> Durée :</b> <?php echo $row['duree']; ?></p><div class="clear"></div>
					<p class="info-left"><b><i class="fa fa-calendar" aria-hidden="true"></i> Date de sortie :</b> <?php echo $row['date_sortie']; ?></p><div class="clear"></div>
					<p class="info-left"><b><i class="fa fa-user" aria-hidden="true"></i> Réalisé par :</b> <?php echo $row['realisateur']; ?></p><div class="clear"></div>
					<p class="info-left"><b><i class="fa fa-comment-o" aria-hidden="true"></i> Genre(s) :</b> <?php echo '<a href="recherche.html?genre='.$row['genre_1'].'" class="link_profile_upload">'.$row['genre_1'].'</a>';
					if(!empty($row['genre_2']) && !empty($row['genre_3'])){
						echo ', <a href="recherche.html?genre='.$row['genre_2'].'" class="link_profile_upload">'.$row['genre_2'].'</a>, ';
						echo '<a href="recherche.html?genre='.$row['genre_3'].'" class="link_profile_upload">'.$row['genre_3'].'</a>';
					}elseif(!empty($row['genre_2'])){
						echo ', <a href="recherche.html?genre='.$row['genre_2'].'" class="link_profile_upload">'.$row['genre_2'].'</a>';
					}elseif(!empty($row['genre_3'])){
						echo ', <a href="recherche.html?genre='.$row['genre_3'].'" class="link_profile_upload">'.$row['genre_3'].'</a>';
					}
					$str_q = str_replace(' ', '+', $row['qualite']);
					?>
					</p><div class="clear"></div>
					<p class="info-left_end"><b><i class="fa fa-television" aria-hidden="true"></i> Qualité :</b> <a href="recherche.html?qualite=<?php echo $str_q; ?>" class="link_profile_upload"><?php echo $row['qualite']; ?></a></p></div>
					<div class="info-left_bear">
					<p class="info-right"><b><i class="fa fa-users" aria-hidden="true"></i> Acteurs :</b> <?php echo $row['acteurs']; ?></p></div>
					<div class="clear"></div>
					<div class="description">
						<hr>
						<p style="margin-top: 15px;line-height: normal;"><?php echo $row['synopsy']; ?></p>					</div>
				</div>
				<div class="right2"><span class="titre-info"><i class="fa fa-television" aria-hidden="true"></i> Lecteur Streaming</span></div>
					<div class="right-sub2">
						<p><center><?php
						if($row['hebergeur_video'] == 'ViDto'){
							echo '<iframe width="640" height="360" src="http://vidto.me/embed-'.$row['lien_streaming'].'-640x360.html" frameborder="0" allowfullscreen></iframe>';
						}elseif($row['hebergeur_video'] == 'Streamin'){
							echo '<iframe width="640" height="360" src="http://streamin.to/embed-'.$row['lien_streaming'].'-640x360.html" frameborder="0" allowfullscreen></iframe>';
						}elseif($row['hebergeur_video'] == 'VideoMega'){
							echo '<iframe width="640" height="360" scrolling="no" frameborder="0" allowtransparency="true" src="http://videomega.tv/view.php?ref='.$row['lien_streaming'].'&width=640&height=360" allowfullscreen=""></iframe>';
						}elseif($row['hebergeur_video'] == 'ViD|AG'){
							echo '<iframe width="640" height="360" src="http://vid.ag/embed-'.$row['lien_streaming'].'.html" frameborder="0" allowfullscreen></iframe>';
						}elseif($row['hebergeur_video'] == 'AllVid'){
							echo '<iframe width="640" height="360" src="http://allvid.ch/embed-'.$row['lien_streaming'].'.html" frameborder="0" allowfullscreen></iframe>';
						}elseif($row['hebergeur_video'] == 'UpToStream'){
							echo '<iframe width="640" height="360" src="https://uptostream.com/iframe/'.$row['lien_streaming'].'" frameborder="0" allowfullscreen></iframe>';
						}elseif($row['hebergeur_video'] == 'YouWatch'){
							echo '<iframe width="640" height="360" src="http://youwatch.org/embed-'.$row['lien_streaming'].'.html" frameborder="0" allowfullscreen></iframe>';
						}
						?></center></p>					
				</div>
				<?php if($row_core['ddl'] == 0){ ?>
				<div class="right2"><span class="titre-info"><i class="fa fa-download" aria-hidden="true"></i> Téléchargement</span></div>
					<div class="right-sub2">
							
					<div class="ddl" align="center">
					Connectez-vous pour télécharger le film.
					</div>				
				</div>
				<?php }else{} ?>
				<div class="right2"><span class="titre-info"><i class="fa fa-comments" aria-hidden="true"></i> Commentaire(s)</span></div>
					<div class="right-sub2">

					<?php
					echo '<center>Connectez-vous pour écrire un commentaire</center>';
					$retour = $bdd->query("SELECT COUNT(*) AS nbArt FROM commentaires WHERE film_id = '$chaineid'");
					$donnees = $retour->fetch();

					$nbArt = $donnees['nbArt'];
					$perPage = 5;
					$nbPage = ceil($nbArt/$perPage);
									
					if(isset($_GET['p']) && $_GET['p'] > 0 && $_GET['p'] <= $nbPage){
					$cPage = $_GET['p'];
					}else{
					$cPage = 1;
					}

					$req = $bdd->prepare("SELECT * FROM commentaires WHERE film_id = '$chaineid' ORDER BY id DESC LIMIT ".(($cPage-1)*$perPage).",$perPage");
					$req->execute();
					if($nbArt > 0){
					while($row_4 = $req->fetch()){		

					$req1 = $bdd->prepare("SELECT * FROM membres WHERE id = :id");
					$req1->execute(array(
						'id' => $row_4['pseudo_id']));
					$row_3 = $req1->fetch();

					?>	

					<hr>
					<div class="commentaires">
					<div class="left_infos_film">
							<?php if(empty($row_3['url_avatar'])){
								echo '<img src="images/avatar.jpg">';
							}else{
								echo '<img src="'.$row_3['url_avatar'].'">';
							}
							?>
					</div>
					<div class="right_infos_film">
							<?php echo nl2br($row_4['commentaire']); ?>
					</div>
					<div class="coms">Commenté par <?php if(empty($row_3['pseudo'])){ echo '<span class="rank">Inconnu</span>'; }else{ echo '<span class="rank'.$row_3['rank'].'">'.$row_3['pseudo'].'</span>'; } echo ' le '.$row_4['date_add']; ?></div>
					</div>

					<div class="clear"></div>
					<?php 
					} 
					echo '<center>';
						for($i=1;$i<=$nbPage;$i++){
							if($i == $cPage){
								echo '<div class="pagination_current">'.$i.'</div>';
							}else{
								echo '<a href="infos.html?option='.$chaineid.'&p='.$i.'" class="pagination">'.$i.'</a>';
							}
						}
					echo '</center>';
					}else{
						echo '<hr><center>Aucun(s) commentaire(s)</center>';
					}
					?>

					</div>
					
					</div>

				<div class="clear"></div>

<?php 
}else{
	echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Le film est actuellement en pending !</center></div><meta http-equiv="refresh" content="1;index.html" />';
}
}else{
	echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> La vidéo de ce film est HS !</center></div><meta http-equiv="refresh" content="1;index.html" />';
}
}else{
	echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Tu t\'és perdu ?</center></div><meta http-equiv="refresh" content="1;index.html" />';
}
}else{

if(!empty($_GET['option'])){

			if(isset($_POST['button_commentaire'])){
						if(isset($_POST) && !empty($_POST['commentaire']) && !empty($_POST['token_custom_site'])){
								if($_POST['token_custom_site'] == $_SESSION['token']){
									if($_POST['f8_img'] == $_SESSION['jeton_f8']){
										unset($_SESSION['jeton_f8']);

										$commentaire = filter_var(htmlentities($_POST['commentaire']), FILTER_SANITIZE_STRING);
										$id_pseudo = filter_var(htmlentities($_SESSION['id']), FILTER_SANITIZE_STRING);
										$id_film = filter_var(htmlentities($chaineid), FILTER_SANITIZE_STRING);

										$date = date("j F Y");
										$date = str_replace('September', 'Septembre', $date);
										$date = str_replace('October', 'Octobre', $date);
										$date = str_replace('November', 'Novembre', $date);
										$date = str_replace('December', 'Décembre', $date);
										$date = str_replace('January', 'Janvier', $date);
										$date = str_replace('February', 'Février', $date);
										$date = str_replace('March', 'Mars', $date);
										$date = str_replace('April', 'Avril', $date);
										$date = str_replace('May', 'Mai', $date);
										$date = str_replace('June', 'Juin', $date);
										$date = str_replace('July', 'Juillet', $date);
										$date = str_replace('August', 'Août', $date);

										if($i = $bdd->prepare('INSERT INTO commentaires VALUES (:id, :film_id, :pseudo_id, :commentaire, :date_add)')){
													$i->bindParam(':id', $id);
													$i->bindParam(':film_id', $id_film);
													$i->bindParam(':pseudo_id', $id_pseudo);
													$i->bindParam(':commentaire', $commentaire);
													$i->bindParam(':date_add', $date);
													$i->execute();

											echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> Votre commentaire à été envoyé avec succès.</center></div><meta http-equiv="refresh" content="1;'.$_SERVER['HTTP_REFERER'].'" />';
										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Erreur lors de l\'insertion dans la base de données.</center></div>';
										}

									}else{
										echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Merci de ne pas ré-actualiser la page.</center></div>'; ;
									}
								}else{
									echo '';
								}

				}else{
					echo '';
				}
			}else{

			}	

					$req = $bdd->prepare("SELECT * FROM film WHERE id = :id");
					$req->execute(array(
						'id' => $chaineid));
					$row = $req->fetch();	

					$req = $bdd->prepare("SELECT * FROM membres WHERE id = :id");
					$req->execute(array(
						'id' => $row['uploader_id']));
					$row_2 = $req->fetch();	

if(isset($_POST['button_video_hs'])){
	if($_POST['token_custom_site'] == $_SESSION['token']){
		if($_POST['f9_img'] == $_SESSION['jeton_f9']){
		unset($_SESSION['jeton_f9']);
			if($row['video_hs'] != 5){	
				$i = $row['video_hs']+1;
				if($req = $bdd->prepare("UPDATE film SET video_hs = :video_hs WHERE id = :id")){
					$req->execute(array(
					'video_hs' => $i,
					'id' => $chaineid));

					echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> Merci pour le signalement.</center></div><meta http-equiv="refresh" content="1;'.$_SERVER['HTTP_REFERER'].'" />';
				}else{
					echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Erreur lors de l\'insertion dans la base de données.</center></div>';
				}
			}else{
				echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Ce film à déja été retirer de la liste, cause : Vidéo HS !</center></div>';	
			}
		}else{
			echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Merci de ne pas ré-actualiser la page.</center></div>';
		}
	}else{
		echo '';
	}
}else{}		

					if($row['video_hs'] != 5){
						if($row['pending'] == 0){
?>

<div id="viewProjet" class="pageProjets">

				<div class="left">
					<a class="zoombox zgallery1" href="<?php echo $row['url_jaquette']; ?>">
						<div class="grandeThumb" style="background-image: url('<?php echo $row['url_jaquette']; ?>');"></div>
					</a>
					<!-- <div class="clear"></div>
					<a href=""><p class="bouton-retour-vote-down"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></p></a>
					<a href=""><p class="bouton-retour-vote-up"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></p></a>
					-->
					<div class="clear"></div>
					<form action="infos.html?option=<?php echo $_GET['option']; ?>" autocomplete="off"  align="center" method="POST">
					<input type="hidden" name="token_custom_site" value="<?php echo $_SESSION['token']; ?>">
					<?php
					$_SESSION['jeton_f9'] = md5(time()*rand(1,900));
					?>
					<input type="hidden" value="<?php echo $_SESSION['jeton_f9']; ?>" name="f9_img">
					<button name="button_video_hs" class="bouton-hs" type="submit"><i class="fa fa-chain-broken one" aria-hidden="true"></i> Vidéo HS ? - (<?php echo $row['video_hs']; ?>)</button>
					</form>

					<div class="clear"></div>	
					<div class="facebook" alt="Facebook share" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=http://www.modzcatz.fr/infos.html?option=<?php echo $_GET['option']; ?>', 'facebook_share', 'height=320, width=640, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');"><i class="fa fa-facebook" aria-hidden="true"></i> Partager</div>	
					<div class="clear"></div>	
					<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><p class="bouton-retour"><i class="fa fa-chevron-left" aria-hidden="true"></i> Retour au site</p></a><div class="clear"></div>				
				</div>
				<div class="right"><span class="titre-info"><i class="fa fa-info" aria-hidden="true"></i> Informations</span></div>
				<div class="right-sub">
					<p class="categories">Ajouté le <span class="coulor_net"><b><?php echo $row['date_add']; ?></b></span> par <?php if(empty($row_2['pseudo'])){ echo '<span class="rank">Inconnu</span>'; }else{ echo '<span class="rank'.$row_2['rank'].'">'.$row_2['pseudo'].'</span>'; } ?></p><div class="clear"></div>
					<h3><?php echo $row['titre']; ?><label><?php if($_SESSION['rank'] >= 3){ ?><a href="modifier.html?id=<?php echo htmlspecialchars(htmlentities($row['id'])); ?>&option=film" style="color: #2c3e50;"><i class="fa fa-cogs" aria-hidden="true"></i></a><?php }else{} ?> <?php echo $row['titre_release']; ?></label></h3>
					<div class="info-left_bear">
					<p class="info-left"><b><i class="fa fa-clock-o" aria-hidden="true"></i> Durée :</b> <?php echo $row['duree']; ?></p><div class="clear"></div>
					<p class="info-left"><b><i class="fa fa-calendar" aria-hidden="true"></i> Date de sortie :</b> <?php echo $row['date_sortie']; ?></p><div class="clear"></div>
					<p class="info-left"><b><i class="fa fa-user" aria-hidden="true"></i> Réalisé par :</b> <?php echo $row['realisateur']; ?></p><div class="clear"></div>
					<p class="info-left"><b><i class="fa fa-comment-o" aria-hidden="true"></i> Genre(s) :</b> <?php echo '<a href="recherche.html?genre='.$row['genre_1'].'" class="link_profile_upload">'.$row['genre_1'].'</a>';
					if(!empty($row['genre_2']) && !empty($row['genre_3'])){
						echo ', <a href="recherche.html?genre='.$row['genre_2'].'" class="link_profile_upload">'.$row['genre_2'].'</a>, ';
						echo '<a href="recherche.html?genre='.$row['genre_3'].'" class="link_profile_upload">'.$row['genre_3'].'</a>';
					}elseif(!empty($row['genre_2'])){
						echo ', <a href="recherche.html?genre='.$row['genre_2'].'" class="link_profile_upload">'.$row['genre_2'].'</a>';
					}elseif(!empty($row['genre_3'])){
						echo ', <a href="recherche.html?genre='.$row['genre_3'].'" class="link_profile_upload">'.$row['genre_3'].'</a>';
					}
					$str_q = str_replace(' ', '+', $row['qualite']);
					?>
					</p><div class="clear"></div>
					<p class="info-left_end"><b><i class="fa fa-television" aria-hidden="true"></i> Qualité :</b> <a href="recherche.html?qualite=<?php echo $str_q; ?>" class="link_profile_upload"><?php echo $row['qualite']; ?></a></p>
					</div>
					<div class="info-left_bear">
					<p class="info-right"><b><i class="fa fa-users" aria-hidden="true"></i> Acteurs :</b> <?php echo $row['acteurs']; ?></p>
					</div>
					<div class="clear"></div>
					<div class="description">
						<hr>
						<p style="margin-top: 15px;line-height: normal;"><?php echo $row['synopsy']; ?></p>					</div>
				</div>
				<div class="right2"><span class="titre-info"><i class="fa fa-television" aria-hidden="true"></i> Lecteur Streaming</span></div>
					<div class="right-sub2">
						<p><center><?php
						if($row['hebergeur_video'] == 'ViDto'){
							echo '<iframe width="640" height="360" src="http://vidto.me/embed-'.$row['lien_streaming'].'-640x360.html" frameborder="0" allowfullscreen></iframe>';
						}elseif($row['hebergeur_video'] == 'Streamin'){
							echo '<iframe width="640" height="360" src="http://streamin.to/embed-'.$row['lien_streaming'].'-640x360.html" frameborder="0" allowfullscreen></iframe>';
						}elseif($row['hebergeur_video'] == 'VideoMega'){
							echo '<iframe width="640" height="360" scrolling="no" frameborder="0" allowtransparency="true" src="http://videomega.tv/view.php?ref='.$row['lien_streaming'].'&width=640&height=360" allowfullscreen=""></iframe>';
						}elseif($row['hebergeur_video'] == 'ViD|AG'){
							echo '<iframe width="640" height="360" src="http://vid.ag/embed-'.$row['lien_streaming'].'.html" frameborder="0" allowfullscreen></iframe>';
						}elseif($row['hebergeur_video'] == 'AllVid'){
							echo '<iframe width="640" height="360" src="http://allvid.ch/embed-'.$row['lien_streaming'].'.html" frameborder="0" allowfullscreen></iframe>';
						}elseif($row['hebergeur_video'] == 'UpToStream'){
							echo '<iframe width="640" height="360" src="https://uptostream.com/iframe/'.$row['lien_streaming'].'" frameborder="0" allowfullscreen></iframe>';
						}elseif($row['hebergeur_video'] == 'YouWatch'){
							echo '<iframe width="640" height="360" src="http://youwatch.org/embed-'.$row['lien_streaming'].'.html" frameborder="0" allowfullscreen></iframe>';
						}
						?></center></p>					
					</div>
					<?php if($row_core['ddl'] == 0){ ?>
					<div class="right2"><span class="titre-info"><i class="fa fa-download" aria-hidden="true"></i> Téléchargement</span></div>
					<div class="right-sub2">
							
					<div class="ddl" align="center">
							<?php
								if(!empty($row['lien_ddl'])){

									$JhebergIDs = $row['lien_ddl'];
									$JhebergIDs = preg_replace('#http://www.jheberg.net/mirrors/([a-z0-9\.\_\,\/\-\?\&\=\-\#]+)/#i','$1',$JhebergIDs); 
									$JhebergIDs = preg_replace('#http://jheberg.net/mirrors/([a-z0-9\.\_\,\/\-\?\&\=\-\#]+)/#i','$1',$JhebergIDs); 
									 
							        $ch = curl_init('http://www.jheberg.net/api/verify/file/?id='.$JhebergIDs);
							                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							        $json = curl_exec($ch);
							        $array = json_decode($json, true);

							        if($array['fileName'] ? 1:0){
							        echo '<a href="'.$row['lien_ddl'].'"><div class="ddl_film">Télécharger le film ('.$array['fileHits'].')</div></a>';

							        echo '<div class="filesize">Taille : '.format_octets($array['fileSize']).'</div><div class="clear"></div><hr><div class="clear"></div>';

									foreach ($array['hosts'] as $verif_jheberg) {
										
										$nameheberg = array('Uploaded', 'Uptobox', '1fichier', '2shared', 'Filecloud', 'Filerio', 'Mediafire', 'Mega', 'Rapidgator', 'Turbobit', 'Free', 'Hugefiles', 'Uplea', 'Oboom', 'Nitroflare', 'Jeodrive', 'Rockfile', 'Openload', 'Youwatch', 'Tusfiles', 'Rutube');
										$corrigeheberg = array('uploaded', 'utb', '1fichier', '2shared', 'filecloud', 'filerio', 'mediafire', 'mega', 'rg', 'turbobit', 'free', 'hugefiles_dl', 'uplea-download', 'oboom-download', 'nitroflare-download', 'jeodrive-download', 'rockfile-download', 'openload-download', 'youwatch-download', 'tusfiles-download', 'rutube-download');
										$imagename = str_replace($nameheberg, $corrigeheberg, $verif_jheberg['hostName']);

										if($verif_jheberg['hostOnline'] == true){
											$verif_jheberg_message = '<div class="status success-status"><p>Hébergeur disponible</p></div>';
										}elseif($verif_jheberg['hostOnline'] == false){
											$verif_jheberg_message = '<div class="status failed-status"><p>Hébergeur indisponible</p></div>';
										}
										echo '<div class="hoster"><div class="hoster-thumbnail"><img src="http://cdn.jheberg.net/images/hosts/download/'.$imagename.'.png">'.$verif_jheberg_message.'</div></div>';

									}
								}else{
									echo 'Aucun lien de Téléchargement';
								}
								}else{
									echo 'Aucun lien de Téléchargement';
								}

							?>	
					</div>				
				</div>
				<?php }else{} ?>
				
					<div class="right2"><span class="titre-info"><i class="fa fa-comments" aria-hidden="true"></i> Commentaire(s)</span></div>
					<div class="right-sub2">

					<?php

					$retour = $bdd->query("SELECT COUNT(*) AS nbArt FROM commentaires WHERE film_id = '$chaineid'");
					$donnees = $retour->fetch();

					$nbArt = $donnees['nbArt'];
					$perPage = 5;
					$nbPage = ceil($nbArt/$perPage);
									
					if(isset($_GET['p']) && $_GET['p'] > 0 && $_GET['p'] <= $nbPage){
					$cPage = $_GET['p'];
					}else{
					$cPage = 1;
					}

					$req1 = $bdd->prepare("SELECT * FROM membres WHERE id = :id");
					$req1->execute(array(
						'id' => $_SESSION['id']));
					$row_5 = $req1->fetch();
					?>
					<?php 
					$req = $bdd->prepare("SELECT * FROM core WHERE id = :id");
					$req->execute(array(
						'id' => 1));
					$row_core = $req->fetch();

					if($row_core['commentaires'] == 1 && $_SESSION['rank'] < 3){

					echo '<center>Les commentaires sont temporairement désactivé !</center>';

					}else{

					if($_SESSION['rank'] == 0){
						echo '<center>Impossible - Vous étes BANNI !</center>';
						}else{ ?>
					<form action="infos.html?option=<?php echo $chaineid; ?>" autocomplete="off"  method="POST">
					<div class="commentaires">
					<div class="left_infos_film">
							<?php if(empty($row_5['url_avatar'])){
								echo '<img src="images/avatar.jpg">';
							}else{
								echo '<img src="'.$row_5['url_avatar'].'">';
							}
							?>
					</div>
					<div class="right_infos_film">
							<textarea placeholder="Écrire un commentaire" name="commentaire" required></textarea>
					</div>
					<input type="hidden" name="token_custom_site" value="<?php echo $_SESSION['token']; ?>">
					<?php
					$_SESSION['jeton_f8'] = md5(time()*rand(1,900));
					?>
					<input type="hidden" value="<?php echo $_SESSION['jeton_f8']; ?>" name="f8_img">
					<button type="submit" name="button_commentaire" class="btn btn-block btn-lg btn-info waves-effect waves-light_com">Laisser un commentaire</button>
					</div>
					</form>
					<?php } } ?>
					<?php
					$req = $bdd->prepare("SELECT * FROM commentaires WHERE film_id = '$chaineid' ORDER BY id DESC LIMIT ".(($cPage-1)*$perPage).",$perPage");
					$req->execute();
					if($nbArt > 0){
					while($row_4 = $req->fetch()){		

					$req1 = $bdd->prepare("SELECT * FROM membres WHERE id = :id");
					$req1->execute(array(
						'id' => $row_4['pseudo_id']));
					$row_3 = $req1->fetch();

					?>	

					<hr>
					<div class="commentaires">
					<div class="left_infos_film">
							<?php if(empty($row_3['url_avatar'])){
								echo '<img src="images/avatar.jpg">';
							}else{
								echo '<img src="'.$row_3['url_avatar'].'">';
							}
							?>
					</div>
					<div class="right_infos_film">
							<?php echo nl2br($row_4['commentaire']); ?>
					</div>
					<div class="coms">Commenté par <?php if(empty($row_3['pseudo'])){ echo '<span class="rank">Inconnu</span>'; }else{ echo '<span class="rank'.$row_3['rank'].'">'.$row_3['pseudo'].'</span>'; } echo ' le '.$row_4['date_add']; ?></div>
					</div>
					<div class="clear"></div>
					<?php 
					} 
					echo '<center>';
						for($i=1;$i<=$nbPage;$i++){
							if($i == $cPage){
								echo '<div class="pagination_current">'.$i.'</div>';
							}else{
								echo '<a href="infos.html?option='.$chaineid.'&p='.$i.'" class="pagination">'.$i.'</a>';
							}
						}
					echo '</center>';
					}else{
						echo '<hr><center>Aucun(s) commentaire(s)</center>';
					}
					?>
					</div>

				<div class="clear"></div>

			</div>

			<div class="clear"></div>
			
				

<?php 
}else{
	echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Le film est actuellement en pending !</center></div><meta http-equiv="refresh" content="1;index.html" />';
}
}else{
	echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> La vidéo de ce film est HS !</center></div><meta http-equiv="refresh" content="1;index.html" />';
}

}elseif(!empty($_GET['pending']) && $_SESSION['rank'] > 2){
$req = $bdd->prepare("SELECT * FROM film WHERE id = :id");
					$req->execute(array(
						'id' => $chaineidp));
					$row = $req->fetch();	

					$req = $bdd->prepare("SELECT * FROM membres WHERE id = :id");
					$req->execute(array(
						'id' => $row['uploader_id']));
					$row_2 = $req->fetch();	
?>


<div id="viewProjet" class="pageProjets">
				<?php if($row['video_hs'] == 5){
				echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> La vidéo est HS !</center></div><br>';
				}else{}
				if($row['pending'] == 1){
				echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> La vidéo est en attente.</center></div><br>';
				}elseif($row['pending'] == 2){
				echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> La vidéo est non-validé !</center></div><br>';
				}elseif($row['pending'] == 3){
				echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> La vidéo est à corrigée !</center></div><br>';
				}elseif($row['pending'] == 0){
				echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> La vidéo est validé.</center></div><br>';
				}
				?>
				<div class="left">
					<a class="zoombox zgallery1" href="<?php echo $row['url_jaquette']; ?>">
						<div class="grandeThumb" style="background-image: url('<?php echo $row['url_jaquette']; ?>');"></div>
					</a><div class="clear"></div>	
					<p class="bouton-hs over"><i class="fa fa-chain-broken two" aria-hidden="true"></i> Vidéo HS ? - (<?php echo $row['video_hs']; ?>)</p>
					<div class="clear"></div>	
					<div class="facebook_no"><i class="fa fa-facebook" aria-hidden="true"></i> Partager</div>	
					<div class="clear"></div>	
					<p class="bouton-retour over"><i class="fa fa-chevron-left" aria-hidden="true"></i> Retour au site</p><div class="clear"></div>				
				</div>
				<div class="right"><span class="titre-info"><i class="fa fa-info" aria-hidden="true"></i> Informations</span></div>
				<div class="right-sub">
					<p class="categories">Ajouté le <span class="coulor_net"><b><?php echo $row['date_add']; ?></b></span> par <?php if(empty($row_2['pseudo'])){ echo '<span class="rank">Inconnu</span>'; }else{ echo '<span class="rank'.$row_2['rank'].'">'.$row_2['pseudo'].'</span>'; } ?></p><div class="clear"></div>
					<h3><?php echo $row['titre']; ?><label><?php echo $row['titre_release']; ?></label></h3>
					<div class="info-left_bear">
					<p class="info-left"><b><i class="fa fa-clock-o" aria-hidden="true"></i> Durée :</b> <?php echo $row['duree']; ?></p><div class="clear"></div>
					<p class="info-left"><b><i class="fa fa-calendar" aria-hidden="true"></i> Date de sortie :</b> <?php echo $row['date_sortie']; ?></p><div class="clear"></div>
					<p class="info-left"><b><i class="fa fa-user" aria-hidden="true"></i> Réalisé par :</b> <?php echo $row['realisateur']; ?></p><div class="clear"></div>
					<p class="info-left"><b><i class="fa fa-comment-o" aria-hidden="true"></i> Genre(s) :</b> <?php echo '<a href="recherche.html?genre='.$row['genre_1'].'" class="link_profile_upload">'.$row['genre_1'].'</a>';
					if(!empty($row['genre_2']) && !empty($row['genre_3'])){
						echo ', <a href="recherche.html?genre='.$row['genre_2'].'" class="link_profile_upload">'.$row['genre_2'].'</a>, ';
						echo '<a href="recherche.html?genre='.$row['genre_3'].'" class="link_profile_upload">'.$row['genre_3'].'</a>';
					}elseif(!empty($row['genre_2'])){
						echo ', <a href="recherche.html?genre='.$row['genre_2'].'" class="link_profile_upload">'.$row['genre_2'].'</a>';
					}elseif(!empty($row['genre_3'])){
						echo ', <a href="recherche.html?genre='.$row['genre_3'].'" class="link_profile_upload">'.$row['genre_3'].'</a>';
					}
					$str_q = str_replace(' ', '+', $row['qualite']);
					?>
					</p><div class="clear"></div>
					<p class="info-left_end"><b><i class="fa fa-television" aria-hidden="true"></i> Qualité :</b> <a href="recherche.html?qualite=<?php echo $str_q; ?>" class="link_profile_upload"><?php echo $row['qualite']; ?></a></p></div>
					<div class="info-left_bear">
					<p class="info-right"><b><i class="fa fa-users" aria-hidden="true"></i> Acteurs :</b> <?php echo $row['acteurs']; ?></p></div>
					<div class="clear"></div>
					<div class="description">
						<hr>
						<p style="margin-top: 15px;line-height: normal;"><?php echo $row['synopsy']; ?></p>					</div>
				</div>
				<div class="right2"><span class="titre-info"><i class="fa fa-television" aria-hidden="true"></i> Lecteur Streaming</span></div>
					<div class="right-sub2">
						<p><center><?php
						if($row['hebergeur_video'] == 'ViDto'){
							echo '<iframe width="640" height="360" src="http://vidto.me/embed-'.$row['lien_streaming'].'-640x360.html" frameborder="0" allowfullscreen></iframe>';
						}elseif($row['hebergeur_video'] == 'Streamin'){
							echo '<iframe width="640" height="360" src="http://streamin.to/embed-'.$row['lien_streaming'].'-640x360.html" frameborder="0" allowfullscreen></iframe>';
						}elseif($row['hebergeur_video'] == 'VideoMega'){
							echo '<iframe width="640" height="360" scrolling="no" frameborder="0" allowtransparency="true" src="http://videomega.tv/view.php?ref='.$row['lien_streaming'].'&width=640&height=360" allowfullscreen=""></iframe>';
						}elseif($row['hebergeur_video'] == 'ViD|AG'){
							echo '<iframe width="640" height="360" src="http://vid.ag/embed-'.$row['lien_streaming'].'.html" frameborder="0" allowfullscreen></iframe>';
						}elseif($row['hebergeur_video'] == 'AllVid'){
							echo '<iframe width="640" height="360" src="http://allvid.ch/embed-'.$row['lien_streaming'].'.html" frameborder="0" allowfullscreen></iframe>';
						}elseif($row['hebergeur_video'] == 'UpToStream'){
							echo '<iframe width="640" height="360" src="https://uptostream.com/iframe/'.$row['lien_streaming'].'" frameborder="0" allowfullscreen></iframe>';
						}elseif($row['hebergeur_video'] == 'YouWatch'){
							echo '<iframe width="640" height="360" src="http://youwatch.org/embed-'.$row['lien_streaming'].'.html" frameborder="0" allowfullscreen></iframe>';
						}
						?></center></p>					
				</div>
				<?php if($row_core['ddl'] == 0){ ?>
				<div class="right2"><span class="titre-info"><i class="fa fa-download" aria-hidden="true"></i> Téléchargement</span></div>
					<div class="right-sub2">
							
					<div class="ddl" align="center">
							<?php
								if(!empty($row['lien_ddl'])){

									$JhebergIDs = $row['lien_ddl'];
									$JhebergIDs = preg_replace('#http://www.jheberg.net/mirrors/([a-z0-9\.\_\,\/\-\?\&\=\-\#]+)/#i','$1',$JhebergIDs); 
									$JhebergIDs = preg_replace('#http://jheberg.net/mirrors/([a-z0-9\.\_\,\/\-\?\&\=\-\#]+)/#i','$1',$JhebergIDs); 
									 
							        $ch = curl_init('http://www.jheberg.net/api/verify/file/?id='.$JhebergIDs);
							                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							        $json = curl_exec($ch);
							        $array = json_decode($json, true);

							        if($array['fileName'] ? 1:0){
							        echo '<a href="'.$row['lien_ddl'].'"><div class="ddl_film">Télécharger le film ('.$array['fileHits'].')</div></a>';

							        echo '<div class="filesize">Taille : '.format_octets($array['fileSize']).'</div><div class="clear"></div><hr><div class="clear"></div>';

									foreach ($array['hosts'] as $verif_jheberg) {
										
										$nameheberg = array('Uploaded', 'Uptobox', '1fichier', '2shared', 'Filecloud', 'Filerio', 'Mediafire', 'Mega', 'Rapidgator', 'Turbobit', 'Free', 'Hugefiles', 'Uplea', 'Oboom', 'Nitroflare', 'Jeodrive', 'Rockfile', 'Openload', 'Youwatch', 'Tusfiles', 'Rutube');
										$corrigeheberg = array('uploaded', 'utb', '1fichier', '2shared', 'filecloud', 'filerio', 'mediafire', 'mega', 'rg', 'turbobit', 'free', 'hugefiles_dl', 'uplea-download', 'oboom-download', 'nitroflare-download', 'jeodrive-download', 'rockfile-download', 'openload-download', 'youwatch-download', 'tusfiles-download', 'rutube-download');
										$imagename = str_replace($nameheberg, $corrigeheberg, $verif_jheberg['hostName']);

										if($verif_jheberg['hostOnline'] == true){
											$verif_jheberg_message = '<div class="status success-status"><p>Hébergeur disponible</p></div>';
										}elseif($verif_jheberg['hostOnline'] == false){
											$verif_jheberg_message = '<div class="status failed-status"><p>Hébergeur indisponible</p></div>';
										}
										echo '<div class="hoster"><div class="hoster-thumbnail"><img src="http://cdn.jheberg.net/images/hosts/download/'.$imagename.'.png">'.$verif_jheberg_message.'</div></div>';

									}
								}else{
									echo 'Aucun lien de Téléchargement';
								}
								}else{
									echo 'Aucun lien de Téléchargement';
								}

							?>	
					</div>				
				</div>
				<?php }else{} ?>
				<div class="clear"></div>

			</div>

			<div class="clear"></div>
			
				</div>
<?php
}elseif(!empty($_GET['mon_pending'])){

					$req = $bdd->prepare("SELECT * FROM film WHERE id = :id");
					$req->execute(array(
						'id' => $chaineidmp));
					$row = $req->fetch();	

					$req = $bdd->prepare("SELECT * FROM membres WHERE id = :id");
					$req->execute(array(
						'id' => $row['uploader_id']));
					$row_2 = $req->fetch();	
if($row['uploader_id'] == $_SESSION['id']){
?>


<div id="viewProjet" class="pageProjets">
				<?php if($row['video_hs'] == 5){
				echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Ma vidéo est HS !</center></div><br>';
				}else{}
				if($row['pending'] == 1){
				echo '<div id="reptopalert"><center><i class="fa fa-exclamation-triangle"></i> Ma vidéo est en attente.</center></div><br>';
				}elseif($row['pending'] == 2){
				echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Ma vidéo est non-validé !</center></div><br>';
				}elseif($row['pending'] == 3){
				echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Ma vidéo est à corrigée !</center></div><br>';
				}elseif($row['pending'] == 0){
				echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> Ma vidéo est validé.</center></div><br>';
				}
				?>
				<div class="left">
					<a class="zoombox zgallery1" href="<?php echo $row['url_jaquette']; ?>">
						<div class="grandeThumb" style="background-image: url('<?php echo $row['url_jaquette']; ?>');"></div>
					</a><div class="clear"></div>	
					<p class="bouton-hs over"><i class="fa fa-chain-broken two" aria-hidden="true"></i> Vidéo HS ? - (<?php echo $row['video_hs']; ?>)</p><div class="facebook_no"><i class="fa fa-facebook" aria-hidden="true"></i> Partager</div>	
					<div class="clear"></div>	<div class="clear"></div>	
					<p class="bouton-retour over"><i class="fa fa-chevron-left" aria-hidden="true"></i> Retour au site</p><div class="clear"></div>				
				</div>
				<div class="right"><span class="titre-info"><i class="fa fa-info" aria-hidden="true"></i> Informations</span></div>
				<div class="right-sub">
					<p class="categories">Ajouté le <span class="coulor_net"><b><?php echo $row['date_add']; ?></b></span> par <?php echo '<span class="rank'.$row_2['rank'].'">'.$row_2['pseudo'].'</span>'; ?></p><div class="clear"></div>
					<h3><?php echo $row['titre']; ?><label><?php echo $row['titre_release']; ?></label></h3>
					<div class="info-left_bear">
					<p class="info-left"><b><i class="fa fa-clock-o" aria-hidden="true"></i> Durée :</b> <?php echo $row['duree']; ?></p><div class="clear"></div>
					<p class="info-left"><b><i class="fa fa-calendar" aria-hidden="true"></i> Date de sortie :</b> <?php echo $row['date_sortie']; ?></p><div class="clear"></div>
					<p class="info-left"><b><i class="fa fa-user" aria-hidden="true"></i> Réalisé par :</b> <?php echo $row['realisateur']; ?></p><div class="clear"></div>
					<p class="info-left"><b><i class="fa fa-comment-o" aria-hidden="true"></i> Genre(s) :</b> <?php echo '<a href="recherche.html?genre='.$row['genre_1'].'" class="link_profile_upload">'.$row['genre_1'].'</a>';
					if(!empty($row['genre_2']) && !empty($row['genre_3'])){
						echo ', <a href="recherche.html?genre='.$row['genre_2'].'" class="link_profile_upload">'.$row['genre_2'].'</a>, ';
						echo '<a href="recherche.html?genre='.$row['genre_3'].'" class="link_profile_upload">'.$row['genre_3'].'</a>';
					}elseif(!empty($row['genre_2'])){
						echo ', <a href="recherche.html?genre='.$row['genre_2'].'" class="link_profile_upload">'.$row['genre_2'].'</a>';
					}elseif(!empty($row['genre_3'])){
						echo ', <a href="recherche.html?genre='.$row['genre_3'].'" class="link_profile_upload">'.$row['genre_3'].'</a>';
					}
					$str_q = str_replace(' ', '+', $row['qualite']);
					?>
					</p><div class="clear"></div>
					<p class="info-left_end"><b><i class="fa fa-television" aria-hidden="true"></i> Qualité :</b> <a href="recherche.html?qualite=<?php echo $str_q; ?>" class="link_profile_upload"><?php echo $row['qualite']; ?></a></p></div>
					<div class="info-left_bear">
					<p class="info-right"><b><i class="fa fa-users" aria-hidden="true"></i> Acteurs :</b> <?php echo $row['acteurs']; ?></p></div>
					<div class="clear"></div>
					<div class="description">
						<hr>
						<p style="margin-top: 15px;line-height: normal;"><?php echo $row['synopsy']; ?></p>					</div>
				</div>
				<div class="right2"><span class="titre-info"><i class="fa fa-television" aria-hidden="true"></i> Lecteur Streaming</span></div>
					<div class="right-sub2">
						<p><center><?php
						if($row['hebergeur_video'] == 'ViDto'){
							echo '<iframe width="640" height="360" src="http://vidto.me/embed-'.$row['lien_streaming'].'-640x360.html" frameborder="0" allowfullscreen></iframe>';
						}elseif($row['hebergeur_video'] == 'Streamin'){
							echo '<iframe width="640" height="360" src="http://streamin.to/embed-'.$row['lien_streaming'].'-640x360.html" frameborder="0" allowfullscreen></iframe>';
						}elseif($row['hebergeur_video'] == 'VideoMega'){
							echo '<iframe width="640" height="360" scrolling="no" frameborder="0" allowtransparency="true" src="http://videomega.tv/view.php?ref='.$row['lien_streaming'].'&width=640&height=360" allowfullscreen=""></iframe>';
						}elseif($row['hebergeur_video'] == 'ViD|AG'){
							echo '<iframe width="640" height="360" src="http://vid.ag/embed-'.$row['lien_streaming'].'.html" frameborder="0" allowfullscreen></iframe>';
						}elseif($row['hebergeur_video'] == 'AllVid'){
							echo '<iframe width="640" height="360" src="http://allvid.ch/embed-'.$row['lien_streaming'].'.html" frameborder="0" allowfullscreen></iframe>';
						}elseif($row['hebergeur_video'] == 'UpToStream'){
							echo '<iframe width="640" height="360" src="https://uptostream.com/iframe/'.$row['lien_streaming'].'" frameborder="0" allowfullscreen></iframe>';
						}elseif($row['hebergeur_video'] == 'YouWatch'){
							echo '<iframe width="640" height="360" src="http://youwatch.org/embed-'.$row['lien_streaming'].'.html" frameborder="0" allowfullscreen></iframe>';
						}
						?></center></p>					
				</div>
				<?php if($row_core['ddl'] == 0){ ?>
				<div class="right2"><span class="titre-info"><i class="fa fa-download" aria-hidden="true"></i> Téléchargement</span></div>
					<div class="right-sub2">
							
					<div class="ddl" align="center">
							<?php
								if(!empty($row['lien_ddl'])){

									$JhebergIDs = $row['lien_ddl'];
									$JhebergIDs = preg_replace('#http://www.jheberg.net/mirrors/([a-z0-9\.\_\,\/\-\?\&\=\-\#]+)/#i','$1',$JhebergIDs); 
									$JhebergIDs = preg_replace('#http://jheberg.net/mirrors/([a-z0-9\.\_\,\/\-\?\&\=\-\#]+)/#i','$1',$JhebergIDs); 
									 
							        $ch = curl_init('http://www.jheberg.net/api/verify/file/?id='.$JhebergIDs);
							                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							        $json = curl_exec($ch);
							        $array = json_decode($json, true);

							        if($array['fileName'] ? 1:0){
							        echo '<a href="'.$row['lien_ddl'].'"><div class="ddl_film">Télécharger le film ('.$array['fileHits'].')</div></a>';

							        echo '<div class="filesize">Taille : '.format_octets($array['fileSize']).'</div><div class="clear"></div><hr><div class="clear"></div>';

									foreach ($array['hosts'] as $verif_jheberg) {
										
										$nameheberg = array('Uploaded', 'Uptobox', '1fichier', '2shared', 'Filecloud', 'Filerio', 'Mediafire', 'Mega', 'Rapidgator', 'Turbobit', 'Free', 'Hugefiles', 'Uplea', 'Oboom', 'Nitroflare', 'Jeodrive', 'Rockfile', 'Openload', 'Youwatch', 'Tusfiles', 'Rutube');
										$corrigeheberg = array('uploaded', 'utb', '1fichier', '2shared', 'filecloud', 'filerio', 'mediafire', 'mega', 'rg', 'turbobit', 'free', 'hugefiles_dl', 'uplea-download', 'oboom-download', 'nitroflare-download', 'jeodrive-download', 'rockfile-download', 'openload-download', 'youwatch-download', 'tusfiles-download', 'rutube-download');
										$imagename = str_replace($nameheberg, $corrigeheberg, $verif_jheberg['hostName']);

										if($verif_jheberg['hostOnline'] == true){
											$verif_jheberg_message = '<div class="status success-status"><p>Hébergeur disponible</p></div>';
										}elseif($verif_jheberg['hostOnline'] == false){
											$verif_jheberg_message = '<div class="status failed-status"><p>Hébergeur indisponible</p></div>';
										}
										echo '<div class="hoster"><div class="hoster-thumbnail"><img src="http://cdn.jheberg.net/images/hosts/download/'.$imagename.'.png">'.$verif_jheberg_message.'</div></div>';

									}
								}else{
									echo 'Aucun lien de Téléchargement';
								}
								}else{
									echo 'Aucun lien de Téléchargement';
								}

							?>	
					</div>				
				</div>
				<?php }else{} ?>
				<div class="clear"></div>

			</div>

			<div class="clear"></div>
			
				</div>
<?php
}else{
	echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Ce n\'est pas ton film !</center></div><meta http-equiv="refresh" content="1;liste.html?id='.$_SESSION['id'].'&option=mes_films" />';
}
}else{
	echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Tu t\'és perdu ?</center></div><meta http-equiv="refresh" content="1;index.html" />';
}}
}else{
	echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Tu t\'és perdu ?</center></div><meta http-equiv="refresh" content="1;index.html" />';
}
?>
</div>
<?php
include 'system/footer.php'; 
 } ?>
