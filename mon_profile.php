<?php require './system/config_inc.php';

	$req = $bdd->prepare("SELECT * FROM core WHERE id = :id");
					$req->execute(array(
						'id' => 1));
					$row_core = $req->fetch();

	if($row_core['maintenance'] == 1 && $_SESSION['rank'] < 3){

		include './system/maintenance.php';

	}else{ 
			
$namePage = 'Mon profile';

include 'system/header.php'; 
require 'system/config_inc.php';
require 'system/function.php';
?>

<div class="wrap_profil">
			<div class="clear"></div>
<?php
if($_SESSION['rank'] > 0){
	if(!isset($_SESSION['pseudo'])){
		header('Location: connexion.html');
	}else{
					$req = $bdd->prepare("SELECT * FROM membres WHERE id = :id AND pseudo = :pseudo");
					$req->execute(array(
						'id' => $_SESSION['id'],
						'pseudo' => $_SESSION['pseudo']));
					$row = $req->fetch();
				

					if(isset($_POST['button_mdp'])){
					if($_SERVER['HTTP_REFERER'] == $adresseSite . 'mon_profile.html'){
						if(isset($_POST) && isset($_POST['mdp']) && isset($_POST['new_mdp']) && isset($_POST['token_custom_site'])){
						$mdp = filter_var(htmlentities(sha1($_POST['mdp']), FILTER_SANITIZE_STRING));
						if($mdp == $row['password']){ // Ancien mdp = mdp bdd
								if($_POST['token_custom_site'] == $_SESSION['token']){
									if($_POST['f6_img'] == $_SESSION['jeton_f6']){
										unset($_SESSION['jeton_f6']);
										$password = filter_var(htmlentities(sha1($_POST['new_mdp']), FILTER_SANITIZE_STRING));
										$renvoi_mdp = 0;
										if($req = $bdd->prepare("UPDATE membres SET password = :password , renvoi_mdp = :renvoi_mdp WHERE id = :id")){

											$req->bindParam(':password', $password);
											$req->bindParam(':renvoi_mdp', $renvoi_mdp);
											$req->bindParam(':id', $_SESSION['id']);
         									$req->execute();


											echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> Votre mot de passe à été mises à jour avec succès.</center></div><meta http-equiv="refresh" content="2;mon_profile.html" />';
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
							echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> L\'ancien mot de passe est incorrect.</center></div>';
						}

				}else{
					echo '';
				}
			}else{
				echo '';
			}}else{

			}
			if(isset($_POST['button_mail'])){
					if($_SERVER['HTTP_REFERER'] == $adresseSite . 'mon_profile.html'){
						if(isset($_POST) && isset($_POST['mail']) && isset($_POST['token_custom_site'])){
								if($_POST['token_custom_site'] == $_SESSION['token']){
									if($_POST['f7_img'] == $_SESSION['jeton_f7']){
										unset($_SESSION['jeton_f7']);
										$mail = filter_var(htmlentities($_POST['mail']), FILTER_SANITIZE_STRING);
												$req = $bdd->prepare('SELECT count(*) AS nbre_occurences FROM membres WHERE email = :email');
												$req->execute(array('email' => $mail));
												$donnees = $req->fetch();
												$nbre_occurences = $donnees['nbre_occurences'];
												$req->closeCursor();
										if(filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){
										if($nbre_occurences == 0){
										if($req = $bdd->prepare("UPDATE membres SET email = :mail WHERE id = :id")){
											
											$req->bindParam(':mail', $mail);
											$req->bindParam(':id', $_SESSION['id']);
         									$req->execute();


											echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> Ton @mail à été mises à jour avec succès.</center></div><meta http-equiv="refresh" content="1;mon_profile.html" />';
										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Erreur lors de l\'insertion dans la base de données.</center></div>';
										}
										}else{
										echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> @mail déja utilisé</center></div>';
										}
										}else{
										echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> L\'adresse email saisit est incorrect.</center></div>';
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
			if(isset($_POST['button_url_avatar'])){
					if($_SERVER['HTTP_REFERER'] == $adresseSite . 'mon_profile.html'){
						if(isset($_POST) && isset($_POST['url_avatar']) && isset($_POST['token_custom_site'])){
								if($_POST['token_custom_site'] == $_SESSION['token']){
									if($_POST['f8_img'] == $_SESSION['jeton_f8']){
										unset($_SESSION['jeton_f8']);
										$url_avatar = filter_var(htmlentities($_POST['url_avatar']), FILTER_SANITIZE_STRING);
										if($req = $bdd->prepare("UPDATE membres SET url_avatar = :url_avatar WHERE id = :id")){
											
											$req->bindParam(':url_avatar', $url_avatar);
											$req->bindParam(':id', $_SESSION['id']);
         									$req->execute();


											echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> Ton avatar à été mises à jour avec succès.</center></div><meta http-equiv="refresh" content="1;mon_profile.html" />';
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
				echo '';
			}}else{

			}
			if(isset($_POST['button_theme'])){
					if($_SERVER['HTTP_REFERER'] == $adresseSite . 'mon_profile.html'){
						if(isset($_POST) && isset($_POST['theme']) && isset($_POST['token_custom_site'])){
							if(!empty($_POST['theme'])){
								if($_POST['token_custom_site'] == $_SESSION['token']){
									if($_POST['f9_img'] == $_SESSION['jeton_f9']){
										unset($_SESSION['jeton_f9']);
										$theme = filter_var(htmlentities($_POST['theme']), FILTER_SANITIZE_NUMBER_INT);
										if($req = $bdd->prepare("UPDATE membres SET theme = :theme WHERE id = :id")){
											
											$req->bindParam(':theme', $theme);
											$req->bindParam(':id', $_SESSION['id']);
         									$req->execute();
											

											echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> Ton thème à été mises à jour avec succès.</center></div><meta http-equiv="refresh" content="1;mon_profile.html" />';
										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Erreur lors de l\'insertion dans la base de données.</center></div>';
										}

										}else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Merci de ne pas ré-actualiser la page.</center></div>'; ;
										}
										}else{
											echo '';
										} }else{
											echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Merci de ne choisir un thème.</center></div>'; ;
										}
				}else{
					echo '';
				}
			}else{
				echo '';
			}}else{

			}
			?>

			<div id="viewProjet" class="pageProjets">
				
				<div class="left_profil">

						
							<?php if(empty($row['url_avatar'])){
								echo '<div class="grandeThumb_profil" style="background-image: url(\'images/avatar.jpg\');">';
							}else{
								echo '<div class="grandeThumb_profil" style="background-image: url(\''.$row['url_avatar'].'\');">';
							}
							?>
							
				</div>
					<div class="clear"></div>	
					<a href="/"><p class="bouton-retour_profil"><i class="fa fa-chevron-left" aria-hidden="true"></i> Retour au site</p></a><div class="clear"></div>				
				</div>
				<div class="right_profil"><span class="titre-info"><i class="fa fa-info" aria-hidden="true"></i> Informations de mon profile</span></div>
				<div class="right-sub_profil">
					<h4><span class="rank<?php echo $row['rank']; ?>"><?php echo $row['pseudo']; ?></span></h4>
					<div class="info-left_bear">
					<p class="info-left"><b><i class="fa fa-calendar" aria-hidden="true"></i> Inscrit le :</b> <?php echo $row['date']; ?></p>

					<p class="info-left"><b><i class="fa fa-user" aria-hidden="true"></i> Statut :</b> 
					<?php 
					if($row['rank'] == 1){
						echo '<span class="rank'.$row['rank'].'">Membre</span>';
					}elseif($row['rank'] == 2){
						echo '<span class="rank'.$row['rank'].'">Premium</span>';
					}elseif($row['rank'] == 0){
						echo '<span class="rank'.$row['rank'].'">Banni</span>';
					}elseif($row['rank'] == 4){
						echo '<span class="rank'.$row['rank'].'">Administrateur</span>';
					}elseif($row['rank'] == 3){
						echo '<span class="rank'.$row['rank'].'">Modérateur</span>';
					}   
					?>
					</p>
					</div>
					<div class="info-left_bear">
					<p class="info-right_profil_2"><b><i class="fa fa-envelope" aria-hidden="true"></i> Mon @mail :</b> <?php echo $row['email']; ?></p>
					</div>
				</div>
				<div class="right2"><span class="titre-info"><i class="fa fa-tachometer" aria-hidden="true"></i> Mes Uploads & commentaires</span></div>
				<div class="right-sub3">
				<?php $retour = $bdd->query('SELECT COUNT(*) AS nbre_entrees FROM film WHERE uploader_id = '.$_SESSION['id'].'');
						$donnees_1 = $retour->fetch(); 

						$retour = $bdd->query('SELECT COUNT(*) AS nbre_entrees FROM film WHERE video_hs = 5 AND uploader_id = '.$_SESSION['id'].'');
						$donnees_4 = $retour->fetch();
						$retour = $bdd->query('SELECT COUNT(*) AS nbre_entrees FROM film WHERE pending > 0 AND uploader_id = '.$_SESSION['id'].'');
						$donnees_5 = $retour->fetch();
						$result_notif_2 = $donnees_4['nbre_entrees'] + $donnees_5['nbre_entrees'];

						$retour = $bdd->query('SELECT COUNT(*) AS nbre_entrees FROM commentaires WHERE pseudo_id = '.$_SESSION['id'].'');
						$donnees_com = $retour->fetch();

						if($donnees_com['nbre_entrees'] > 0 ){ 	
						$com_nb = $donnees_com['nbre_entrees'];	
						}else{
						$com_nb = '0';
						}

						if($result_notif_2 > 0 ){ 	
						$profile_1 = '<font color="#D14836">('.$result_notif_2.')</font>';	
						}else{
						$profile_1 = '';
						}
						?>	
					<div class="info-left_bear">			
					<p class="info-left_1"><b><i class="fa fa-film" aria-hidden="true"></i> Mes Uploads :</b> <?php echo $donnees_1['nbre_entrees']; ?></p>
					<p class="info-left_1"><b><i class="fa fa-comments-o" aria-hidden="true"></i> Mes commentaires :</b> <?php echo $com_nb; ?></p>
					</div>
					<div class="info-left_bear">
					<p class="info-right_profil_1"><a href="liste.html?id=<?php echo $row['id']; ?>&option=mes_films" class="link_profile_upload">Liste de mes uploads <?php echo $profile_1; ?></a></p>
					</div>
					<div class="clear"></div>						
				</div>
				<div class="right2"><span class="titre-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modification(s)</span></div>
					<div class="right-sub2">				
						<form action="mon_profile.html" autocomplete="off"  method="POST">
						<label><b><i class="fa fa-lock" aria-hidden="true"></i> Changer de mot de passe</label></b><br>
							<input class="form-control_profil" placeholder="Ancien mot de passe" type="password" name="mdp" required/>
							<input class="form-control_profil" placeholder="Nouveau mot de passe" type="password" name="new_mdp" required/>
							<input type="hidden" name="token_custom_site" value="<?php echo $_SESSION['token']; ?>">
							<?php
							$_SESSION['jeton_f6'] = md5(time()*rand(1,900));
							?>
							<input type="hidden" value="<?php echo $_SESSION['jeton_f6']; ?>" name="f6_img">
							<button type="submit" name="button_mdp" class="btn btn-block btn-lg btn-info waves-effect waves-light_profil">Changer</button>
						</form>
						<br>
						<form action="mon_profile.html" autocomplete="off"  method="POST">
						<label><b><i class="fa fa-envelope" aria-hidden="true"></i> Changer d'@mail</label></b><br>
							<input class="form-control_profil_big" placeholder="Addresse @mail" type="mail" name="mail" required/>
							<input type="hidden" name="token_custom_site" value="<?php echo $_SESSION['token']; ?>">
							<?php
							$_SESSION['jeton_f7'] = md5(time()*rand(1,900));
							?>
							<input type="hidden" value="<?php echo $_SESSION['jeton_f7']; ?>" name="f7_img">
							<button type="submit" name="button_mail" class="btn btn-block btn-lg btn-info waves-effect waves-light_profil">Changer</button>
						</form>		
						<br>
						<form action="mon_profile.html" autocomplete="off"  method="POST">
						<label><b><i class="fa fa-picture-o" aria-hidden="true"></i> Changer d'avatar</label></b><br>
							<input class="form-control_profil_big" placeholder="URL de ton nouvel Avatar" type="text" name="url_avatar"/>
							<input type="hidden" name="token_custom_site" value="<?php echo $_SESSION['token']; ?>">
							<?php
							$_SESSION['jeton_f8'] = md5(time()*rand(1,900));
							?>
							<input type="hidden" value="<?php echo $_SESSION['jeton_f8']; ?>" name="f8_img">
							<button type="submit" name="button_url_avatar" class="btn btn-block btn-lg btn-info waves-effect waves-light_profil">Changer</button>
						</form>
										
				</div>
				<div class="clear"></div>

			</div>

			<div class="clear"></div>

						<?php
} }else{
	header('Location: connexion.html');
}
					?>
</div>
<?php include 'system/footer.php'; 
 } ?>