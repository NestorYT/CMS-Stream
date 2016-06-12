<?php
require './system/config_inc.php';

if($_GET['option'] == 'film'){
$namePage = 'Ajouter un film';
}elseif($_GET['option'] == 'qualite'){
$namePage = 'Ajouter une qualité vidéo';
}elseif($_GET['option'] == 'genre'){
$namePage = 'Ajouter un genre';
}elseif($_GET['option'] == 'news'){
$namePage = 'Ajouter une news';
}elseif($_GET['option'] == 'auto'){
$namePage = 'Rechercher un film via Allociné';
}elseif($_GET['option'] == 'film_auto'){
$namePage = 'Ajouter un film via Allociné';
}
$code_film = addslashes($_GET['code']);

$req = $bdd->prepare("SELECT * FROM core WHERE id = :id");
					$req->execute(array(
						'id' => 1));
					$row_core = $req->fetch();

	if($row_core['maintenance'] == 1 && $_SESSION['rank'] < 3){

		include './system/maintenance.php';

	}else{

include './system/header.php'; 
require './system/function.php';

?>

<div class="wrap">
			<div class="clear"></div>
<?php
if(!isset($_SESSION['pseudo'])){
		header('Location: connexion.html');
	}else{

if(($_SESSION['rank'] > 2 && $_GET['option'] == 'qualite') || ($_SESSION['rank'] > 2 && $_GET['option'] == 'genre') || ($_SESSION['rank'] > 2 && $_GET['option'] == 'news')){
		
	if('http://'.$_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] == $adresseSite . 'ajouter.html?option='.$_GET['option']){		
		if(!isset($_GET['option']) OR $_GET['option'] == 'qualite' OR $_GET['option'] == 'genre' OR $_GET['option'] == 'news'){
        					
					if($_GET['option'] == 'qualite'){
					$result_get = 'Ajouter une qualité vidéo';
					$result_icon = '<i class="fa fa-film" aria-hidden="true"></i>';
					}elseif($_GET['option'] == 'genre'){
					$result_get = 'Ajouter un genre';
					$result_icon = '<i class="fa fa-film" aria-hidden="true"></i>';
					}elseif($_GET['option'] == 'news'){
					$result_get = 'Ajouter une news';
					$result_icon = '<i class="fa fa-newspaper-o" aria-hidden="true"></i>';
					}
					
	
				if(isset($_POST['button'])){
					if($_SERVER['HTTP_REFERER'] == $adresseSite . 'ajouter.html?option=qualite'){
						if(isset($_POST) && isset($_POST['qualite']) && isset($_POST['token_custom_site'])){
								if($_POST['token_custom_site'] == $_SESSION['token']){
									if($_POST['f1_img'] == $_SESSION['jeton_f1']){
										unset($_SESSION['jeton_f1']);
										$qualite = filter_var(htmlentities($_POST['qualite']), FILTER_SANITIZE_STRING);
												$req = $bdd->prepare('SELECT count(*) AS nbre_occurences FROM qualiter WHERE titre = :titre');
												$req->execute(array('titre' => $qualite));
												$donnees = $req->fetch();
												$nbre_occurences = $donnees['nbre_occurences'];
												$req->closeCursor();
										if($nbre_occurences == 0){		
										if($i = $bdd->prepare('INSERT INTO qualiter (id, titre)
												VALUES (:id, :titre)')){

														$i->bindParam(':id', $id);
														$i->bindParam(':titre', $qualite);
														$i->execute();

											echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> La qualité vidéo : '.$_POST['qualite'].' à bien été ajoutée.</center></div><meta http-equiv="refresh" content="1;ajouter.html?option='.$_GET['option'].'" />';
										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Erreur lors de l\'insertion dans la base de données.</center></div><meta http-equiv="refresh" content="1;ajouter.html?option='.$_GET['option'].'" />';
										}
										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Cette qualitée vidéo existe déja.</center></div><meta http-equiv="refresh" content="1;ajouter.html?option='.$_GET['option'].'" />';
										}
										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Merci de ne pas ré-actualiser la page.</center></div><meta http-equiv="refresh" content="1;ajouter.html?option='.$_GET['option'].'" />';
										}
										}else{
											echo '';
										}
				}else{
					echo '';
				}
			}elseif($_SERVER['HTTP_REFERER'] == $adresseSite . 'ajouter.html?option=genre'){
						if(isset($_POST) && isset($_POST['genre']) && isset($_POST['token_custom_site'])){
								if($_POST['token_custom_site'] == $_SESSION['token']){
									if($_POST['f1_img'] == $_SESSION['jeton_f1']){
										unset($_SESSION['jeton_f1']);
										$genre = filter_var(htmlentities($_POST['genre']), FILTER_SANITIZE_STRING);
												$req = $bdd->prepare('SELECT count(*) AS nbre_occurences FROM genres WHERE titre = :genre');
												$req->execute(array('genre' => $genre));
												$donnees = $req->fetch();
												$nbre_occurences = $donnees['nbre_occurences'];
												$req->closeCursor();
										if($nbre_occurences == 0){		
										if($i = $bdd->prepare('INSERT INTO genres (id, titre)
												VALUES (:id, :titre)')){

														$i->bindParam(':id', $id);
														$i->bindParam(':titre', $genre);
														$i->execute();

											echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> Le genre : '.$_POST['genre'].' à bien été ajoutée.</center></div><meta http-equiv="refresh" content="1;ajouter.html?option='.$_GET['option'].'" />';
										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Erreur lors de l\'insertion dans la base de données.</center></div><meta http-equiv="refresh" content="1;ajouter.html?option='.$_GET['option'].'" />';
										}
										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Ce genre existe déja.</center></div><meta http-equiv="refresh" content="1;ajouter.html?option='.$_GET['option'].'" />';
										}
										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Merci de ne pas ré-actualiser la page.</center></div><meta http-equiv="refresh" content="1;ajouter.html?option='.$_GET['option'].'" />';
										}
										}else{
											echo '';
										}
				}else{
					echo '';
				}
			}elseif($_SERVER['HTTP_REFERER'] == $adresseSite . 'ajouter.html?option=news'){
						if(isset($_POST) && isset($_POST['news']) && isset($_POST['token_custom_site'])){
								if($_POST['token_custom_site'] == $_SESSION['token']){
									if($_POST['f1_img'] == $_SESSION['jeton_f1']){
										unset($_SESSION['jeton_f1']);

										$pseudo_id = filter_var(htmlentities($_SESSION['id']), FILTER_SANITIZE_STRING);
										$news = filter_var(htmlentities($_POST['news']), FILTER_SANITIZE_STRING);
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

										if($i = $bdd->prepare('INSERT INTO news (id, pseudo_id, news, date_add)
												VALUES (:id, :pseudo_id, :news, :date_add)')){

														$i->bindParam(':id', $id);
														$i->bindParam(':pseudo_id', $pseudo_id);
														$i->bindParam(':news', $news);
														$i->bindParam(':date_add', $date);
														$i->execute();

											echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> La news à bien été ajoutée.</center></div><meta http-equiv="refresh" content="1;ajouter.html?option='.$_GET['option'].'" />';
										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Erreur lors de l\'insertion dans la base de données.</center></div><meta http-equiv="refresh" content="1;ajouter.html?option='.$_GET['option'].'" />';
										}
										
										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Merci de ne pas ré-actualiser la page.</center></div><meta http-equiv="refresh" content="1;ajouter.html?option='.$_GET['option'].'" />';
										}
										}else{
											echo '';
										}
				}else{
					echo '';
				}
			}else{
				echo '';
			}
			
			
			}else{

			}				
?>
<div class="titre"><?php echo $result_icon; ?> <?php echo $result_get; ?><span class="titre-right"><a href="/admin.html">Retour à l'administration</a></span></div>
						<?php if($_GET['option'] == 'qualite'){ ?>
						<form action="ajouter.html?option=<?php echo $_GET['option']; ?>" autocomplete="off"  align="center" method="POST">
							<input class="form-control_profil_big" type="text" placeholder="Saisir une qualité vidéo" name="qualite" required/>
							<input type="hidden" name="token_custom_site" value="<?php echo $_SESSION['token']; ?>">
							<?php
							$_SESSION['jeton_f1'] = md5(time()*rand(1,900));
							?>
							<input type="hidden" value="<?php echo $_SESSION['jeton_f1']; ?>" name="f1_img">
							<button type="submit" name="button" class="btn btn-block btn-lg btn-info waves-effect waves-light">Ajouter</button>
						</form>
						<?php }elseif($_GET['option'] == 'genre'){ ?>
						<form action="ajouter.html?option=<?php echo $_GET['option']; ?>" autocomplete="off"  align="center" method="POST">
							<input class="form-control_profil_big" type="text" placeholder="Saisir un genre vidéo" name="genre" required/>
							<input type="hidden" name="token_custom_site" value="<?php echo $_SESSION['token']; ?>">
							<?php
							$_SESSION['jeton_f1'] = md5(time()*rand(1,900));
							?>
							<input type="hidden" value="<?php echo $_SESSION['jeton_f1']; ?>" name="f1_img">
							<button type="submit" name="button" class="btn btn-block btn-lg btn-info waves-effect waves-light">Ajouter</button>
						</form>
							<?php 
							}elseif($_GET['option'] == 'news'){ ?>
						<form action="ajouter.html?option=<?php echo $_GET['option']; ?>" autocomplete="off"  align="center" method="POST">
							<textarea class="form-control_profil_big" type="text" placeholder="Saisir une news" name="news" required/></textarea>
							<input type="hidden" name="token_custom_site" value="<?php echo $_SESSION['token']; ?>">
							<?php
							$_SESSION['jeton_f1'] = md5(time()*rand(1,900));
							?>
							<input type="hidden" value="<?php echo $_SESSION['jeton_f1']; ?>" name="f1_img"><br>
							<button type="submit" name="button" class="btn btn-block btn-lg btn-info waves-effect waves-light">Ajouter</button>
						</form>
<?php 
}  
}else{
	echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Tu t\'és perdu ?</center></div>';
}
}else{
	echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Tu t\'és perdu ?</center></div>';
} 


}elseif($_SESSION['rank'] > 0 && $_GET['option'] == 'film_auto' && !empty($code_film)){

    require_once "./api/api-allocine-helper.php";
    
    // Créer un objet AlloHelper.
    $allohelper = new AlloHelper;
    $movie = $allohelper->movie($code_film);

	if($_GET['option'] == 'film_auto'){
	$result_get = 'Ajouter un film';
	$result_icon = '<i class="fa fa-film" aria-hidden="true"></i>';
	}

	if(isset($_POST['button_film'])){

					if($_SERVER['HTTP_REFERER'] == $adresseSite . 'ajouter.html?option=film_auto&code='.$code_film){
						if(isset($_POST) && isset($_POST['titre']) && isset($_POST['duree']) && isset($_POST['date_sortie']) && isset($_POST['realisateur']) && isset($_POST['genre_1']) && isset($_POST['qualite']) && isset($_POST['url_jaquette']) && isset($_POST['release']) && isset($_POST['hebergeur_video']) && isset($_POST['url_video']) && isset($_POST['acteur']) && isset($_POST['synopsis']) && isset($_POST['token_custom_site'])){

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
									if($_SESSION['rank'] > 2){
										$exclusiviteb = $_POST['exclusivite'];	
									}else{
										$exclusiviteb = '0';
									}
									if($_SESSION['rank'] > 2){
										$pending = '0';	
									}else{
										$pending = '1';
									}

										$titre = filter_var(htmlentities($_POST['titre']), FILTER_SANITIZE_STRING);
										$duree = filter_var(htmlentities($_POST['duree']), FILTER_SANITIZE_STRING);
										$date_sortie = filter_var(htmlentities($_POST['date_sortie']), FILTER_SANITIZE_STRING);
										$realisateur = filter_var(htmlentities($_POST['realisateur']), FILTER_SANITIZE_STRING);
										$genre_1 = filter_var(htmlentities($_POST['genre_1']), FILTER_SANITIZE_STRING);
										$genre_2 = filter_var(htmlentities($genre_2b), FILTER_SANITIZE_STRING);
										$genre_3 = filter_var(htmlentities($genre_3b), FILTER_SANITIZE_STRING);
										$qualite = filter_var(htmlentities($_POST['qualite']), FILTER_SANITIZE_STRING);
										$exclusivite = filter_var(htmlentities($exclusiviteb), FILTER_SANITIZE_STRING);
										$url_jaquette = filter_var(htmlentities($_POST['url_jaquette']), FILTER_SANITIZE_STRING);
										$titre_release = filter_var(htmlentities($_POST['release']), FILTER_SANITIZE_STRING);
										$hebergeur_video = filter_var(htmlentities($_POST['hebergeur_video']), FILTER_SANITIZE_STRING);
										$url_video = filter_var(htmlentities($_POST['url_video']), FILTER_SANITIZE_STRING);
										$acteur = filter_var(htmlentities($_POST['acteur']), FILTER_SANITIZE_STRING);
										$synopsis = filter_var(htmlentities($_POST['synopsis']), FILTER_SANITIZE_STRING);
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
										$id_uploader = $_SESSION['id'];
										$video_hs = '0';

												$req = $bdd->prepare('SELECT count(*) AS nbre_occurences FROM film WHERE titre = :titre AND qualite = :qualiter');
												$req->execute(array(
												'titre' => $titre,
												'qualiter' => $qualite
												));
												$donnees = $req->fetch();
												$nbre_occurences = $donnees['nbre_occurences'];
												$req->closeCursor();

										if($nbre_occurences == 0){	
										if($i = $bdd->prepare('INSERT INTO film (id, date_add, uploader_id, url_jaquette, titre, titre_release, duree, date_sortie, realisateur, acteurs, genre_1, genre_2, genre_3, qualite, synopsy, hebergeur_video, lien_streaming, exclusivite, video_hs, pending) VALUES (:id, :date_add, :uploader_id, :url_jaquette, :titre, :titre_release, :duree, :date_sortie, :realisateur, :acteurs, :genre_1, :genre_2, :genre_3, :qualite, :synopsy, :hebergeur_video, :lien_streaming, :exclusivite, :video_hs, :pending)')){

													$i->bindParam(':id', $id);
													$i->bindParam(':date_add', $date);
													$i->bindParam(':uploader_id', $id_uploader);
													$i->bindParam(':url_jaquette', $url_jaquette);
													$i->bindParam(':titre', $titre);
													$i->bindParam(':titre_release', $titre_release);
													$i->bindParam(':duree', $duree);
													$i->bindParam(':date_sortie', $date_sortie);
													$i->bindParam(':realisateur', $realisateur);
													$i->bindParam(':acteurs', $acteur);
													$i->bindParam(':genre_1', $genre_1);
													$i->bindParam(':genre_2', $genre_2);
													$i->bindParam(':genre_3', $genre_3);
													$i->bindParam(':qualite', $qualite);
													$i->bindParam(':synopsy', $synopsis);
													$i->bindParam(':hebergeur_video', $hebergeur_video);
													$i->bindParam(':lien_streaming', $url_video);
													$i->bindParam(':exclusivite', $exclusivite);
													$i->bindParam(':video_hs', $video_hs);
													$i->bindParam(':pending', $pending);
													$i->execute();

											echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> Le film : '.$_POST['titre'].' à bien été ajoutée.</center></div><meta http-equiv="refresh" content="1;ajouter.html?option=auto" />';
										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Erreur lors de l\'insertion dans la base de données.</center></div><meta http-equiv="refresh" content="1;ajouter.html?option='.$_GET['option'].'&code='.$code_film.'" />';
										} 
										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Ce film existe déja.</center></div><meta http-equiv="refresh" content="1;ajouter.html?option='.$_GET['option'].'&code='.$code_film.'" />';
										}
										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Merci de ne pas ré-actualiser la page.</center></div><meta http-equiv="refresh" content="1;ajouter.html?option='.$_GET['option'].'&code='.$code_film.'" />';
										}
										}else{
											echo '';
										}
				}else{
					echo '';
				}}else{
					echo '';
					}
			}else{
			}

if(isset($movie->genre)){
if(count($movie->genre) == 0){
$i0 = '<option value="" selected>Choissisez un 1er genre</option>';
$i1 = '<option value="" selected>Choissisez un 2eme genre*</option>';
$i2 = '<option value="" selected>Choissisez un 3eme genre*</option>';
}elseif(count($movie->genre) == 1){
$i = $movie->genre;
$i0 = '<option value="'.utf8_encode($i[0]->{'$'}).'" selected>'.utf8_encode($i[0]->{'$'}).'</option>';
$i1 = '<option value="" selected>Choissisez un 2eme genre*</option>';
$i2 = '<option value="" selected>Choissisez un 3eme genre*</option>';
}elseif(count($movie->genre) == 2){
$i = $movie->genre;
$i0 = '<option value="'.utf8_encode($i[0]->{'$'}).'" selected>'.utf8_encode($i[0]->{'$'}).'</option>';
$i1 = '<option value="'.utf8_encode($i[1]->{'$'}).'" selected>'.utf8_encode($i[1]->{'$'}).'</option>';
$i2 = '<option value="" selected>Choissisez un 3eme genre*</option>';
}elseif(count($movie->genre) >= 3){
$i = $movie->genre;
$i0 = '<option value="'.utf8_encode($i[0]->{'$'}).'" selected>'.utf8_encode($i[0]->{'$'}).'</option>';
$i1 = '<option value="'.utf8_encode($i[1]->{'$'}).'" selected>'.utf8_encode($i[1]->{'$'}).'</option>';
$i2 = '<option value="'.utf8_encode($i[2]->{'$'}).'" selected>'.utf8_encode($i[2]->{'$'}).'</option>';
}
}else{
$i0 = '<option value="" selected>Choissisez un 1er genre</option>';
$i1 = '<option value="" selected>Choissisez un 2eme genre*</option>';
$i2 = '<option value="" selected>Choissisez un 3eme genre*</option>';
}

if(isset($movie->castingShort)){
	$r = $movie->castingShort;
	if(isset($r->{'actors'}) && isset($r->{'directors'})){		
		$r_actors = '<textarea value="'.strip_tags(utf8_encode($r->{'actors'})) .'" name="acteur" required style="margin-right: 5px;">'.strip_tags(utf8_encode($r->{'actors'})) .'</textarea>';
		$r_directors = '<input type="text" name="realisateur" value="'.utf8_encode($r->{'directors'}) .'" class="form-control_profil" style="margin-bottom:10px;" required>';
	}elseif(isset($r->{'actors'})){
		$r_actors = '<textarea value="'.utf8_encode($r->{'actors'}) .'" name="acteur" required style="margin-right: 5px;">'.utf8_encode($r->{'actors'}) .'</textarea>';
		$r_directors = '<input type="text" name="realisateur" placeholder="R&eacute;alisateur" class="form-control_profil" style="margin-bottom:10px;" required>';
	}elseif(isset($r->{'directors'})){
		$r_actors = '<textarea placeholder="Acteurs" name="acteur" required style="margin-right: 5px;"></textarea>';
		$r_directors = '<input type="text" name="realisateur" value="'.utf8_encode($r->{'directors'}) .'" class="form-control_profil" style="margin-bottom:10px;" required>';
	}else{
		$r_actors = '<textarea placeholder="Acteurs" name="acteur" required style="margin-right: 5px;"></textarea>';
		$r_directors = '<input type="text" name="realisateur" placeholder="R&eacute;alisateur" class="form-control_profil" style="margin-bottom:10px;" required>';
	}
}else{

}

if(isset($movie->synopsis)){

$brute_synopsis = utf8_encode(strip_tags($movie->synopsis));
$accentued = array("&nbsp;");
$nonaccentued = array("");	
$movie_synopsis = str_replace($accentued, $nonaccentued, $brute_synopsis);	
$textarea_synopsis = '<textarea value="'.$movie_synopsis.'" name="synopsis" required>'.$movie_synopsis.'</textarea>';
}else{
$textarea_synopsis = '<textarea placeholder="Synopsis" name="synopsis" required></textarea>';
}

if(isset($movie->runtime)){

$interval = DateInterval::createFromDateString($movie->runtime . ' seconds');
$d1 = new DateTime();
$d2 = clone $d1;
$d2->add($interval);
$duree = $d1->diff($d2); // $d2 - $d1

if($duree->format('%i') == 1 || $duree->format('%i') == 2 || $duree->format('%i') == 3 || $duree->format('%i') == 4 || $duree->format('%i') == 5 || $duree->format('%i') == 6 || $duree->format('%i') == 7 || $duree->format('%i') == 8 || $duree->format('%i') == 9){
$newDuree = '<input type="text" name="duree" value="'.$duree->format('%H:0%i').'" class="bis_form-control_profil" style="margin-bottom:10px;" required>';	
}else{
$newDuree = '<input type="text" name="duree" value="'.$duree->format('%H:%i').'" class="bis_form-control_profil" style="margin-bottom:10px;" required>';	
}

}else{
$newDuree = '<input type="text" name="duree" placeholder="Durée du film" class="bis_form-control_profil" style="margin-bottom:10px;" required>';
}

if(isset($movie->release)){

if(count($movie->release) == 0){

$newDate = '<input type="text" name="date_sortie" placeholder="Date de sortie" class="bis_form-control_profil" style="margin-bottom:10px;" required>';

}elseif(count($movie->release) > 0){

$a = $movie->release;
$mounth = date("m", strtotime($a->{'releaseDate'}));
$day = date("d", strtotime($a->{'releaseDate'}));
$years = date("Y", strtotime($a->{'releaseDate'}));

$mois_num = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
$mois_letter = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');

$newDate = str_replace($mois_num, $mois_letter, $mounth);
$newDateSortie = '<input type="text" name="date_sortie" value="'.$day.' '.$newDate.' '.$years.'" class="bis_form-control_profil" style="margin-bottom:10px;" required>';
}

}elseif(isset($movie->dvdReleaseDate)){

if(count($movie->dvdReleaseDate) == 0){

$newDate = '<input type="text" name="date_sortie" placeholder="Date de sortie" class="bis_form-control_profil" style="margin-bottom:10px;" required>';

}elseif(count($movie->dvdReleaseDate) > 0){

$mounth = date("m", strtotime($movie->dvdReleaseDate));
$day = date("d", strtotime($movie->dvdReleaseDate));
$years = date("Y", strtotime($movie->dvdReleaseDate));

$mois_num = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
$mois_letter = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');

$newDate = str_replace($mois_num, $mois_letter, $mounth);
$newDateSortie = '<input type="text" name="date_sortie" value="'.$day.' '.$newDate.' '.$years.'" class="bis_form-control_profil" style="margin-bottom:10px;" required>';
}

}else{

$newDateSortie = '<input type="text" name="date_sortie" placeholder="Date de sortie" class="bis_form-control_profil" style="margin-bottom:10px;" required>';

}

if(isset($movie->title)){
$newTitle = '<center><input type="text" name="titre" value="'.utf8_encode($movie->title).'" class="bis_form-control_profil" style="margin-bottom:10px;" required>';
}else{
$newTitle = '<center><input type="text" name="titre" placeholder="Nom du film" class="bis_form-control_profil" style="margin-bottom:10px;" required>';	
}
?>

<div class="titre"><?php echo $result_icon; ?> <?php echo $result_get; ?><span class="titre-right"><a href="/index.html">Retour à l'accueil</a></span></div>

<br>
<form action="ajouter.html?option=<?php echo $_GET['option']; ?>&code=<?php echo $code_film; ?>" autocomplete="off"  align="center" method="POST">
<?php 
echo $newTitle;
echo $newDuree; 
echo $newDateSortie; 
echo $r_directors; 
?>
</center>
<div class="clear"></div>
<center>
<select class="form-control_profil" name="genre_1" style="margin-bottom:10px;" required/>
<?php echo $i0; ?>
<?php
$req = $bdd->prepare("SELECT * FROM genres ORDER BY titre ASC");
									$req->execute();
									while($row_1 = $req->fetch()){

echo '<option value="'.$row_1['titre'].'">'.$row_1['titre'].'</option>';
 } ?>
</select>
<select class="form-control_profil" name="genre_2" style="margin-bottom:10px;"/>
<?php echo $i1; ?>
<?php
$req = $bdd->prepare("SELECT * FROM genres ORDER BY titre ASC");
									$req->execute();
									while($row_2 = $req->fetch()){

echo '<option value="'.$row_2['titre'].'">'.$row_2['titre'].'</option>';
 } ?>
</select>
<select class="form-control_profil" name="genre_3" style="margin-bottom:10px;"/>
<?php echo $i2; ?>
<?php
$req = $bdd->prepare("SELECT * FROM genres ORDER BY titre ASC");
									$req->execute();
									while($row_3 = $req->fetch()){

echo '<option value="'.$row_3['titre'].'">'.$row_3['titre'].'</option>';
 } ?>
</select>
<select class="form-control_profil" name="qualite" style="margin-bottom:10px;" required/>
<option value="" selected>Choissisez une qualité</option>
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
<input type="text" name="url_jaquette" value="<?php echo utf8_encode($movie->poster); ?>" class="form-control_profil" required>
<input type="text" name="release" placeholder="Nom de la release" class="form-control_profil" required>
<select class="form-control_profil" name="hebergeur_video"/>
<option value="ViDto" selected>ViDto</option>
<option value="Streamin">Streamin</option>
<option value="VideoMega">VideoMega</option>
<option value="ViD|AG">ViD|AG</option>
<option value="AllVid">AllVid</option>
</select>
<input type="text" name="url_video" placeholder="Numero de la vidéo**" class="form-control_profil" required>
</center>
<?php if($_SESSION['rank'] > 2){ ?>
<br>
<center>
<select class="form-control_profil" name="exclusivite"/>
<option value="0" selected>Ce n'est pas une exclusivité</option>
<option value="1">C'est une exclusivité</option>
</select>
</center>
<?php }else {
	echo '<input type="hidden" name="exclusivite" value="" class="form-control_profil">';
	} ?>	
<br>
<center>
<?php 
echo $r_actors; 
echo $textarea_synopsis; 
?>
</center>
<input type="hidden" name="token_custom_site" value="<?php echo $_SESSION['token']; ?>">
<?php
$_SESSION['jeton_f1'] = md5(time()*rand(1,900));
?>
<input type="hidden" value="<?php echo $_SESSION['jeton_f1']; ?>" name="f1_img">
<br>
<center><button type="submit" name="button_film" class="btn btn-block btn-lg btn-info waves-effect waves-light">Ajouter le film</button></center>
</form>
<br><span style="font-size: 10px;">(*)Optionnel(le)<br>(**)Consulter la F.A.Q pour en savoir plus.</span>

<?php
}elseif($_SESSION['rank'] > 0 && $_GET['option'] == 'auto'){

require_once "./api/api-allocine-helper.php";

	if(isset($_POST['button_film'])){

// Créer un objet AlloHelper.
    $allohelper = new AlloHelper;

    // Définir les paramètres
    $accentued = array("à","á","â","ã","ä","ç","è","é","ê","ë","ì",
		"í","î","","ï","ñ","ò","ó","ô","õ","ö","ù","ú","û","ü","ý","ÿ",
		"À","Á","Â","Ã","Ä","Ç","È","É","Ê","Ë","Ì","Í","Î","Ï","Ñ","Ò",
		"Ó","Ô","Õ","Ö","Ù","Ú","Û","Ü","Ý");
	$nonaccentued = array("a","a","a","a","a","c","e","e","e","e","i","i",
		"i","i","n","o","o","o","o","o","u","u","u","u","y","y","A","A","A",
		"A","A","C","E","E","E","E","I","I","I","I","N","O","O","O","O","O",
		"U","U","U","U","Y");

	$title_corriger = str_replace($accentued, $nonaccentued, $_POST['titre']);
	$title_corriger = str_replace(".", " ", $title_corriger);
    $motsCles = $title_corriger;
    $page = 1;
    $donnees = $allohelper->search( $motsCles, $page );
    $chainemotsCles = addslashes($motsCles);
	$chainemotsCles = filter_var(htmlentities($chainemotsCles), FILTER_SANITIZE_STRING);
    // Il est important d'utiliser le bloc try-catch pour gérer les erreurs.
    try
    {
        // Envoi de la requête avec les paramètres, et enregistrement des résultats dans $donnees.
        $donnees = $allohelper->search( $motsCles, $page );

        if(isset( $donnees->movie )){
        // Pas de résultat ?
        if ( count( $donnees->movie ) < 1 )
        {
            // Afficher un message d'erreur.
            echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Pas de résultat pour "' . $chainemotsCles . '"</center></div>';
        }
        
        else
        {
            // Pour chaque résultat de film.
            foreach ( $donnees['movie'] as $film )
            {
                // Afficher le code.
            ?>
            <div class="form_auto">
            <div class="jaquette_auto"><img class="jaquette_auto" src="<?php echo $film['poster']; ?>"></div>
            <div class="titre_auto"><?php echo utf8_encode($film['title']); ?></div>
            <a href="ajouter.html?option=film_auto&code=<?php echo $film['code']; ?>"><p class="bouton-retour_profil_auto_2">Ajouter</p></a>
			</div>
            <?php
                
            }
            echo '<div class="clear"></div>';
            echo '<center><a href="ajouter.html?option=film"><p class="bouton-retour_profil_auto">Ajouter un film manellement</p></a></center>';

        }
    }else{
     	echo '<div class="clear"></div>';
            echo '<div id="reptoperror" style="margin-bottom: 10px;"><center><i class="fa fa-exclamation-triangle"></i> Pas de résultat pour "' . $chainemotsCles . '"</center></div><center><a href="ajouter.html?option=film"><p class="bouton-retour_profil_auto">Ajouter un film manellement</p></a></center>';
 	}

    }
    
    // En cas d'erreur.
    catch ( ErrorException $e )
    {
        // Affichage des informations sur la requête
        echo "<pre>", print_r($allohelper->getRequestInfos(), 1), "</pre>";
        
        // Afficher un message d'erreur.
        echo "Erreur " . $e->getCode() . ": " . $e->getMessage();
    }

	}else{}	

?>
<div class="titre"><i class="fa fa-search" aria-hidden="true"></i> Rechercher un film via Allociné<span class="titre-right"><a href="/index.html">Retour à l'accueil</a></span></div>

<br>
<form action="ajouter.html?option=<?php echo $_GET['option']; ?>" autocomplete="off"  align="center" method="POST">
<center><input type="text" name="titre" placeholder="Nom du film" class="form-control_profil_auto" style="margin-bottom:10px;" required>
<br>
<center><button type="submit" name="button_film" class="btn btn-block btn-lg btn-info waves-effect waves-light">Chercher sur Allociné</button></center>
</form>

<?php
}elseif($_SESSION['rank'] > 0 && $_GET['option'] == 'film'){

if($_GET['option'] == 'film'){
$result_get = 'Ajouter un film';
$result_icon = '<i class="fa fa-film" aria-hidden="true"></i>';
}
if(isset($_POST['button_film'])){

					if($_SERVER['HTTP_REFERER'] == $adresseSite . 'ajouter.html?option=film'){
						if(isset($_POST) && isset($_POST['titre']) && isset($_POST['duree']) && isset($_POST['date_sortie']) && isset($_POST['realisateur']) && isset($_POST['genre_1']) && isset($_POST['qualite']) && isset($_POST['url_jaquette']) && isset($_POST['release']) && isset($_POST['hebergeur_video']) && isset($_POST['url_video']) && isset($_POST['acteur']) && isset($_POST['synopsis']) && isset($_POST['token_custom_site'])){

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
									if($_SESSION['rank'] > 2){
										$exclusiviteb = $_POST['exclusivite'];	
									}else{
										$exclusiviteb = '0';
									}
									if($_SESSION['rank'] > 2){
										$pending = '0';	
									}else{
										$pending = '1';
									}

										$titre = filter_var(htmlentities($_POST['titre']), FILTER_SANITIZE_STRING);
										$duree = filter_var(htmlentities($_POST['duree']), FILTER_SANITIZE_STRING);
										$date_sortie = filter_var(htmlentities($_POST['date_sortie']), FILTER_SANITIZE_STRING);
										$realisateur = filter_var(htmlentities($_POST['realisateur']), FILTER_SANITIZE_STRING);
										$genre_1 = filter_var(htmlentities($_POST['genre_1']), FILTER_SANITIZE_STRING);
										$genre_2 = filter_var(htmlentities($genre_2b), FILTER_SANITIZE_STRING);
										$genre_3 = filter_var(htmlentities($genre_3b), FILTER_SANITIZE_STRING);
										$qualite = filter_var(htmlentities($_POST['qualite']), FILTER_SANITIZE_STRING);
										$exclusivite = filter_var(htmlentities($exclusiviteb), FILTER_SANITIZE_STRING);
										$url_jaquette = filter_var(htmlentities($_POST['url_jaquette']), FILTER_SANITIZE_STRING);
										$titre_release = filter_var(htmlentities($_POST['release']), FILTER_SANITIZE_STRING);
										$hebergeur_video = filter_var(htmlentities($_POST['hebergeur_video']), FILTER_SANITIZE_STRING);
										$url_video = filter_var(htmlentities($_POST['url_video']), FILTER_SANITIZE_STRING);
										$acteur = filter_var(htmlentities($_POST['acteur']), FILTER_SANITIZE_STRING);
										$synopsis = filter_var(htmlentities($_POST['synopsis']), FILTER_SANITIZE_STRING);
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
										$id_uploader = $_SESSION['id'];
										$video_hs = '0';

												$req = $bdd->prepare('SELECT count(*) AS nbre_occurences FROM film WHERE titre = :titre AND qualite = :qualiter');
												$req->execute(array(
												'titre' => $titre,
												'qualiter' => $qualite
												));
												$donnees = $req->fetch();
												$nbre_occurences = $donnees['nbre_occurences'];
												$req->closeCursor();

										if($nbre_occurences == 0){	
										if($i = $bdd->prepare('INSERT INTO film (id, date_add, uploader_id, url_jaquette, titre, titre_release, duree, date_sortie, realisateur, acteurs, genre_1, genre_2, genre_3, qualite, synopsy, hebergeur_video, lien_streaming, exclusivite, video_hs, pending) VALUES (:id, :date_add, :uploader_id, :url_jaquette, :titre, :titre_release, :duree, :date_sortie, :realisateur, :acteurs, :genre_1, :genre_2, :genre_3, :qualite, :synopsy, :hebergeur_video, :lien_streaming, :exclusivite, :video_hs, :pending)')){

													$i->bindParam(':id', $id);
													$i->bindParam(':date_add', $date);
													$i->bindParam(':uploader_id', $id_uploader);
													$i->bindParam(':url_jaquette', $url_jaquette);
													$i->bindParam(':titre', $titre);
													$i->bindParam(':titre_release', $titre_release);
													$i->bindParam(':duree', $duree);
													$i->bindParam(':date_sortie', $date_sortie);
													$i->bindParam(':realisateur', $realisateur);
													$i->bindParam(':acteurs', $acteur);
													$i->bindParam(':genre_1', $genre_1);
													$i->bindParam(':genre_2', $genre_2);
													$i->bindParam(':genre_3', $genre_3);
													$i->bindParam(':qualite', $qualite);
													$i->bindParam(':synopsy', $synopsis);
													$i->bindParam(':hebergeur_video', $hebergeur_video);
													$i->bindParam(':lien_streaming', $url_video);
													$i->bindParam(':exclusivite', $exclusivite);
													$i->bindParam(':video_hs', $video_hs);
													$i->bindParam(':pending', $pending);
													$i->execute();

											echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> Le film : '.$_POST['titre'].' à bien été ajoutée.</center></div><meta http-equiv="refresh" content="1;ajouter.html?option='.$_GET['option'].'" />';
										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Erreur lors de l\'insertion dans la base de données.</center></div><meta http-equiv="refresh" content="1;ajouter.html?option='.$_GET['option'].'" />';
										} 
										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Ce film existe déja.</center></div><meta http-equiv="refresh" content="1;ajouter.html?option='.$_GET['option'].'" />';
										}
										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Merci de ne pas ré-actualiser la page.</center></div><meta http-equiv="refresh" content="1;ajouter.html?option='.$_GET['option'].'" />';
										}
										}else{
											echo '';
										}
				}else{
					echo '';
				}}else{
					echo '';
					}
			}else{
			}	

?>

<div class="titre"><?php echo $result_icon; ?> <?php echo $result_get; ?><span class="titre-right"><a href="/index.html">Retour à l'accueil</a></span></div>

<br>
<form action="ajouter.html?option=<?php echo $_GET['option']; ?>" autocomplete="off"  align="center" method="POST">
<center><input type="text" name="titre" placeholder="Nom du film" class="form-control_profil" style="margin-bottom:10px;" required>
<input type="text" name="duree" placeholder="Durée du film" class="form-control_profil" style="margin-bottom:10px;" required>
<input type="text" name="date_sortie" placeholder="Date de sortie" class="form-control_profil" style="margin-bottom:10px;" required>
<input type="text" name="realisateur" placeholder="Réalisateur(s)" class="form-control_profil" style="margin-bottom:10px;" required></center>
<div class="clear"></div>
<center>
<select class="form-control_profil" name="genre_1" style="margin-bottom:10px;" required/>
<option value="" selected>Choissisez un 1er genre</option>
<?php
$req = $bdd->prepare("SELECT * FROM genres ORDER BY titre ASC");
									$req->execute();
									while($row_1 = $req->fetch()){

echo '<option value="'.$row_1['titre'].'">'.$row_1['titre'].'</option>';
 } ?>
</select>
<select class="form-control_profil" name="genre_2" style="margin-bottom:10px;"/>
<option value="" selected>Choissisez un 2eme genre*</option>
<?php
$req = $bdd->prepare("SELECT * FROM genres ORDER BY titre ASC");
									$req->execute();
									while($row_2 = $req->fetch()){

echo '<option value="'.$row_2['titre'].'">'.$row_2['titre'].'</option>';
 } ?>
</select>
<select class="form-control_profil" name="genre_3" style="margin-bottom:10px;"/>
<option value="" selected>Choissisez un 3eme genre*</option>
<?php
$req = $bdd->prepare("SELECT * FROM genres ORDER BY titre ASC");
									$req->execute();
									while($row_3 = $req->fetch()){

echo '<option value="'.$row_3['titre'].'">'.$row_3['titre'].'</option>';
 } ?>
</select>
<select class="form-control_profil" name="qualite" style="margin-bottom:10px;" required/>
<option value="" selected>Choissisez une qualité</option>
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
<input type="text" name="url_jaquette" placeholder="URL de la Jaquette" class="form-control_profil" required>
<input type="text" name="release" placeholder="Nom de la release" class="form-control_profil" required>
<select class="form-control_profil" name="hebergeur_video"/>
<option value="ViDto" selected>ViDto</option>
<option value="Streamin">Streamin</option>
<option value="VideoMega">VideoMega</option>
<option value="ViD|AG">ViD|AG</option>
<option value="AllVid">AllVid</option>
</select>
<input type="text" name="url_video" placeholder="Numero de la vidéo**" class="form-control_profil" required>
</center>
<?php if($_SESSION['rank'] > 2){ ?>
<br>
<center>
<select class="form-control_profil" name="exclusivite"/>
<option value="0" selected>Ce n'est pas une exclusivité</option>
<option value="1">C'est une exclusivité</option>
</select>
</center>
<?php }else {
	echo '<input type="hidden" name="exclusivite" value="" class="form-control_profil">';
	} ?>	
<br>
<center>
<textarea placeholder="Acteur(s)" name="acteur" required></textarea>
<textarea placeholder="Synopsis" name="synopsis" required></textarea>
</center>
<input type="hidden" name="token_custom_site" value="<?php echo $_SESSION['token']; ?>">
<?php
$_SESSION['jeton_f1'] = md5(time()*rand(1,900));
?>
<input type="hidden" value="<?php echo $_SESSION['jeton_f1']; ?>" name="f1_img">
<br>
<center><button type="submit" name="button_film" class="btn btn-block btn-lg btn-info waves-effect waves-light">Ajouter le film</button></center>
</form>
<br><span style="font-size: 10px;">(*)Optionnel(le)<br>(**)Consulter la F.A.Q pour en savoir plus.</span>

<?php

}else{
	echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Tu t\'és perdu ?</center></div><meta http-equiv="refresh" content="1;index.html" />';
} }
					?>
</div>
<?php include './system/footer.php'; 
}
?>