<?php require './system/config_inc.php';

	$req = $bdd->prepare("SELECT * FROM core WHERE id = :id");
					$req->execute(array(
						'id' => 1));
					$row_core = $req->fetch();

	if($row_core['maintenance'] == 1 && $_SESSION['rank'] < 3){

		include './system/maintenance.php';

	}else{ 
			
$namePage = 'Inscription';

include 'system/header.php'; 
require 'system/function.php';
require 'system/recaptchalib.php';

$siteKey = '6LcOLBITAAAAAJg8On0Emc-6GUZfSn7gb2RQQ5IE'; // votre clé publique
$secret = '6LcOLBITAAAAAP67EVlRBS-4Z15gGTKkLvijuAZ5'; // votre clé privée
?>

<div class="wrap" align="center">
			<div class="clear"></div>
<?php


					
					$req = $bdd->prepare("SELECT * FROM membres WHERE email = :email");
					$req->execute(array(
						'email' => $_POST['email']));
					$row = $req->fetch();
					
					$req = $bdd->prepare("SELECT * FROM membres WHERE pseudo = :pseudo");
					$req->execute(array(
						'pseudo' => $_POST['pseudo']));
					$row_1 = $req->fetch();
					
					$req = $bdd->prepare("SELECT * FROM core WHERE id = :id");
					$req->execute(array(
						'id' => 1));
					$row_core = $req->fetch();

					if($row_core['inscription'] == 0) {

					$reCaptcha = new ReCaptcha($secret);
					if(isset($_SESSION['pseudo'])){
						$message_erreur1 = "Pour effectuer cette action, vous devez &ecirc;tre d&eacute;connect&eacute;.";
						echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> '. $message_erreur1 .'</center></div>';
					}else{

						if($_SERVER['HTTP_REFERER'] == $adresseSite . 'inscription.html'){

							
							if(isset($_POST) && isset($_POST['pseudo']) && isset($_POST['password']) && isset($_POST['password_verif']) && isset($_POST['email']) && isset($_POST['token_login']) && isset($_POST["g-recaptcha-response"])){

								$domainList = array('yopmail', 'mailcatch', 'zoemail', 'zippymail', 'yuurok', 'yogamaven', 'xoxy', 'wuzupmail', 'wronghead', 'winemaven', 'willselfdestruct', 'whyspam', 'trashymail', 'trashmailer', 'trashmail', 'jetable', 'gustr', 'armyspy', 'cuvox', 'dayrep', 'einrot', 'fleckens', 'jourrapide', 'rhyta', 'superrito', 'teleworm', 'gmx');

								if(preg_match('/@(' . join('|', $domainList) . ')(\.[a-zA-Z]{2,4})+$/', $_POST['email'])){
									$message_erreur = '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> @mail Blacklisté, merci de saisir un mail non jettable !</center></div><meta http-equiv="refresh" content="2;inscription.html" />';
								}else{
								if($_POST['email'] != $row['email']){
								if($_POST['pseudo'] != $row_1['pseudo']){
								if($_POST['token_login'] == $_SESSION['token']){
									$pseudo =  filter_var(htmlentities($_POST['pseudo']), FILTER_SANITIZE_STRING);
									$password =  filter_var(htmlentities($_POST['password']), FILTER_SANITIZE_STRING);
									$password_verif =  filter_var(htmlentities($_POST['password_verif']), FILTER_SANITIZE_STRING);

									if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
										$resp = $reCaptcha->verifyResponse($_SERVER["REMOTE_ADDR"], $_POST["g-recaptcha-response"]);
										if ($resp != null && $resp->success)
										{
											$email =  htmlentities($_POST['email']);
											if($password == $password_verif){
												$req = $bdd->prepare('SELECT count(*) AS nbre_occurences FROM membres WHERE pseudo = :pseudo');
												$req->execute(array('pseudo' => $pseudo));

												$donnees = $req->fetch();
												$nbre_occurences = $donnees['nbre_occurences'];
												$req->closeCursor();

												if($nbre_occurences == 0)
												{
													if($_POST['f5_img'] == $_SESSION['jeton_f5']){
														unset($_SESSION['jeton_f5']);

														$password =  filter_var(htmlentities(sha1($password)), FILTER_SANITIZE_STRING);
														$str_ip = str_replace(', 127.0.0.1', '', get_ip());
														$ip = $str_ip;
														$date = date("Y-m-j H:m:s");
														$rank = 1;
														$cle = md5(microtime(TRUE)*100000);
														
														
														if($i = $bdd->prepare('
															INSERT INTO membres (id, pseudo, password, email, ip, date, rank, cle)
															VALUES (:id, :pseudo, :password, :email, :ip, :date, :rank, :cle)')
															){

														$i->bindParam(':id', $id);
														$i->bindParam(':pseudo', $pseudo);
														$i->bindParam(':password', $password);
														$i->bindParam(':email', $email);
														$i->bindParam(':ip', $ip);
														$i->bindParam(':date', $date);
														$i->bindParam(':rank', $rank);
														$i->bindParam(':cle', $cle);
														$i->execute();

														$destinataire = $email;
														$sujet = "Activer votre compte" ;
														$entete = "From: inscription@modzcatz.fr" ;
														
														$message = 'Bienvenue sur MoDzCatZ.fr,
 
Pour activer votre compte, veuillez cliquer sur le lien ci dessous
ou copier/coller dans votre navigateur internet.
 
http://modzcatz.fr/activation.html?log='.urlencode($_POST['pseudo']).'&cle='.urlencode($cle).'
 
 
---------------
Ceci est un mail automatique, Merci de ne pas y répondre.';
														
														mail($destinataire, $sujet, $message, $entete) ;
														
														$message_success = '<div id="reptopvalid"><center><i class="fa fa-check"></i> Votre inscription est maintenant termin&eacute;e, activer votre compte via le mail que vous avez reçu.</center></div><meta http-equiv="refresh" content="2;index.html" />';
														
														
													}else{
														$message_erreur = '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Impossible de cr&eacute;er votre compte pour le moment, veuillez r&eacute;-essayer plus tard.</center></div><meta http-equiv="refresh" content="1;inscription.html" />';
													}
												}else{
													$message_erreur = '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Merci de ne pas r&eacute;e-actualiser la page.</center></div><meta http-equiv="refresh" content="1;inscription.html" />';
												}
											}else{
												$message_erreur = '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Le pseudo saisis est d&eacute;j&agrave; utilis&eacute;.</center></div><meta http-equiv="refresh" content="1;inscription.html" />';
											}
										}else{
											$message_erreur = '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Le captcha est incorrect.</center></div><meta http-equiv="refresh" content="1;inscription.html" />';
										}
									}else{
										$message_erreur = '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Les mot de passe ne correspondent pas.</center></div><meta http-equiv="refresh" content="1;inscription.html" />';
									}

								}else{
									$message_erreur = '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> L\'adresse email saisit est incorrect.</center></div><meta http-equiv="refresh" content="1;inscription.html" />';
								}
								
							}else{
								$message_erreur = '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Pas de CSRF ici.</center></div><meta http-equiv="refresh" content="1;inscription.html" />';
							}

						}else{
							$message_erreur = '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Pseudo déja utilisé.</center></div><meta http-equiv="refresh" content="1;inscription.html" />';
						}
						}else{
							$message_erreur = '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> @mail déja utilisé.</center></div><meta http-equiv="refresh" content="1;inscription.html" />';
						}
					}
						}else{
							$message_erreur = '';
						}
						
					}else{
						$message_erreur = '';
					}


					if(isset($message_erreur)){
						echo $message_erreur;
					}else{
						echo $message_success;
					}

					
					?>

<div class="titre"><i class="fa fa-user-plus" aria-hidden="true"></i> Inscription<span class="titre-right"><a href="/">Retour à l'accueil</a></span></div>
<br>		
					<form action="inscription.html" autocomplete="off" method="POST">

						<center><input class="form-control" placeholder="Pseudo" type="text" name="pseudo" style="margin-bottom:10px;" required/>
						<input class="form-control" placeholder="Email" type="email" name="email" style="margin-bottom:10px;" required/></center>

								<center><input class="form-control" placeholder="Mot de passe" name="password" type="password" style="margin-bottom:10px;" required/>

								<input class="form-control" placeholder="Confirmer le mot de passe" name="password_verif" type="password" style="margin-bottom:10px;" required/></center>

						<input type="hidden" name="token_login" value="<?php echo $_SESSION['token']; ?>">
						<?php
						$_SESSION['jeton_f5'] = md5(time()*rand(1,900));
						?>
						<input type="hidden" value="<?php echo $_SESSION['jeton_f5']; ?>" name="f5_img">
						<p>
						<br>
							<div class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>"></div><br>

							<span  style="margin-bottom: 5px;" class="terme_cdu">En vous inscrivant, vous acceptez les <a href="termes">termes</a> et <a href="cdu">conditions d'utilisations</a>.</span></p>
							<br>
							<button type="submit" class="btn btn-block btn-lg btn-info waves-effect waves-light">S'inscrire</button>
						</form>
					<?php
				}
			}else{
				echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Les inscriptions sont actuellement fermée.</center></div>';
			}
				?>
		
	</div>
<?php include 'system/footer.php'; 
 } ?>