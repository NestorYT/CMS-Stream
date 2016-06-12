<?php 
			
$namePage = 'Connexion';

include 'system/header.php'; 
require 'system/config_inc.php';
require 'system/function.php';
?>
<div class="content-inner-section">

<div class="wrap" align="center">
			<div class="clear"></div>
<?php
					if(isset($_SESSION['pseudo'])){
						$message_erreur1 = "Pour effectuer cette action, vous devez être déconnecté.";
						echo '<div id="reptoperror"><center>'. $message_erreur1 .'</center></div>';
					}else{

						$req = $bdd->prepare("SELECT * FROM membres");
						$req->execute();
						$row = $req->fetch();

						if($_SERVER['HTTP_REFERER'] == $adresseSite . 'connexion.html'){
							if(isset($_POST) && isset($_POST['pseudo']) AND isset($_POST['password']) && isset($_POST['token_login'])){
								sleep(1);
								$pseudo = filter_var(htmlentities($_POST['pseudo'], FILTER_SANITIZE_STRING));
								$y = $bdd->prepare('SELECT COUNT(*) FROM membres WHERE pseudo = ?');
								$y->execute(array($pseudo));
								$x = $y->fetch();
								if ($x[0] == 0){
									$message_erreur = '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></i> L\'utilisateur est inconnu.</center></div>';
								}else{
									if($_POST['token_login'] == $_SESSION['token']){
										$e = $bdd->prepare('SELECT * FROM membres WHERE pseudo = ?');
										$e->execute(array($pseudo));
										$rep = $e->fetch();
										$password = filter_var(htmlentities(sha1($_POST['password']), FILTER_SANITIZE_STRING));
										if($password == $rep['password']){
										if($rep['actif'] == 1){
											if($rep['rank'] <= 4){
												$req->execute(array(
													'pseudo' => $_POST['pseudo']));

												$_SESSION['id'] = @$rep['id'];
												$_SESSION['pseudo'] = @$rep['pseudo'];
												$_SESSION['rank'] = @$rep['rank'];
												$_SESSION['email'] = @$rep['email'];

												header('Location:index.html');
											}else{
												$message_erreur = '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Vous n\'avez pas les droits pour vous connecter.</center></div>';
											}
											}else{
												$message_erreur = '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Vous n\'avez pas activé votre compte.<br><a href="renvoi_activation.html" class="link_login">Renvoyez moi l\'em@il d\'activation</a></center></div>';
											}											
											
										}else{
											$message_erreur = '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Le mot de passe saisit est incorrect.</center></div>';
										}
									}else{
										$message_erreur = '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Pas de CSRF ici.</center></div>';
									}
								}
							}
						}else{
							$message_erreur = '';
						}
						if(isset($message_erreur)){
							echo $message_erreur;
						}
						?>
					<div class="titre"><i class="fa fa-lock" aria-hidden="true"></i> Connexion<span class="titre-right"><a href="/">Retour à l'accueil</a></span></div>
					<br>			
					<form action="connexion.html" autocomplete="off"  method="POST">
							<input class="form-control" placeholder="Pseudo" type="text" name="pseudo" style="margin-bottom:10px;" required/>
							<input class="form-control" placeholder="Mot de passe" type="password" name="password"  style="margin-bottom:10px;" required/>
							<input type="hidden" name="token_login" value="<?php echo $_SESSION['token']; ?>">
							<p class="register_label">
							<a href="recup_mdp.html">Mot de passe oublié ?</a> || <a href="inscription.html">Pas encore de compte ?</a></p>
							
							<button type="submit" class="btn btn-block btn-lg btn-info waves-effect waves-light">Se connecter</button></a>
						</form>
						<?php
					}
					?>
</div></div>
<?php include 'system/footer.php'; ?>