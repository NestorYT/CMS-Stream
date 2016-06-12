<?php require './system/config_inc.php';

	$req = $bdd->prepare("SELECT * FROM core WHERE id = :id");
					$req->execute(array(
						'id' => 1));
					$row_core = $req->fetch();

	if($row_core['maintenance'] == 1 && $_SESSION['rank'] < 3){

		include './system/maintenance.php';

	}else{ 
			
$namePage = 'Mot de passe oublié';

include 'system/header.php'; 
require 'system/function.php';

?>

<div class="wrap" align="center">
      <div class="clear"></div>
<?php

					if(isset($_SESSION['pseudo'])){
						$message_erreur1 = "Pour effectuer cette action, vous devez être déconnecté.";
						echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> '. $message_erreur1 .'</center></div>';
					}else{

						if($_SERVER['HTTP_REFERER'] == $adresseSite + 'recup_mdp.html'){
							if(isset($_POST) && isset($_POST['email'])){
								if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
									$req = $bdd->prepare("SELECT * FROM membres WHERE email = :email");
									$req->execute(array('email' => $_POST['email']));
									$row = $req->fetch();
									if($row['renvoi_mdp'] == 0){
										$req = $bdd->prepare('SELECT count(*) AS nbre_occurences FROM membres WHERE email = :email');
										$req->execute(array('email' => $_POST['email']));

										$donnees = $req->fetch();
										$nbre_occurences = $donnees['nbre_occurences'];
										$req->closeCursor();

										if($nbre_occurences == 0)
										{
											$message_erreur = '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> L\'adresse email est incorrect.</center></div>';
										}else{
											$password_email  = random(15);
											$password =filter_var(htmlentities(sha1($password_email), FILTER_SANITIZE_STRING));
											$email = filter_var(htmlentities($_POST['email'], FILTER_SANITIZE_STRING));
											$renvoi_mdp = 1;
											if($req = $bdd->prepare("UPDATE membres SET password = :password, renvoi_mdp = :renvoi_mdp WHERE email = :email")){
												$req->bindParam(':password', $password);
												$req->bindParam(':renvoi_mdp', $renvoi_mdp);
												$req->bindParam(':email', $email);
         										$req->execute();
												

												$destinataire = $email;
												$Hello = "Bonjour/bonsoir cher membre";
												$changement_ligne = "\n";
												$changement = 'Vous avez recement demander le renvoi d\'un mot de passe.';
												$mdp = 'Le voici : ' . $password_email;
												$changer_now = 'Merci de le changer immédiatement.';
												$message_ok = ''.$Hello.''.$changement_ligne.''.$changement.''.$changement_ligne.''.$mdp.''.$changement_ligne.''.$changement_ligne.''.$changer_now.'';

												$sujet = 'Envoi du mot de passe temporaire.';
												$message = stripslashes($message_ok);
												$headers = "From: <".$_SESSION['email'].">\n";
												$headers .= "Reply-To: ".$_SESSION['email']."\n";
												$headers .= "Content-Type: text/plain; charset=\"iso-8859-1\"";
												if(mail($destinataire,$sujet,$message,$headers)){
													$message_success = '<div id="reptopvalid"><center><i class="fa fa-envelope" aria-hidden="true"></i> Votre mot de passe temporaire a été envoyé.</center></div><meta http-equiv="refresh" content="2;connexion.html" />';
												}else{
													$message_erreur = '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Erreur lors de l\'envoi du mail.</center></div>';
												}
											}else{
												$message_erreur = '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Erreur critique, veuillez informé l\'administrateur.</center></div>';
											}
										}
									}else{
										$message_erreur = '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Vous avez déjà un mot de passe temporaire, veuillez contacter l\'administrateur.</center></div>';
									}
								}else{
									$message_erreur = '';
								}
							}
						}

						if(isset($message_erreur)){
							echo $message_erreur;
						}else{
							echo $message_success;
						}

						?>
					<div class="titre"><i class="fa fa-paper-plane" aria-hidden="true"></i> Mot de passe oublié<span class="titre-right"><a href="/">Retour à l'accueil</a></span></div>
					<br>	
							
						<form action="recup_mdp.html" autocomplete="off"  method="POST">
							<input class="form-control" placeholder="Adresse email" type="email" name="email" style="margin-bottom:20px;" required/>
							<input type="hidden" name="token_login" value="<?php echo $_SESSION['token']; ?>">
							<br>
							<button type="submit" class="btnmdpo btn btn-block btn-lg btn-info waves-effect waves-light">Récupérer mon mot de passe</button>
						</form>
						<?php
					}
					?>

	</div>
<?php include 'system/footer.php'; 
 } ?>