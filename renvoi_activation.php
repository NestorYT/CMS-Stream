<?php require './core/config_inc.php';

	$req = $bdd->prepare("SELECT * FROM core WHERE id = :id");
					$req->execute(array(
						'id' => 1));
					$row_core = $req->fetch();

	if($row_core['maintenance'] == 1 && $_SESSION['rank'] < 3){

		include './system/maintenance.php';

	}else{ 
			
$namePage = 'Renvoi de mail d\'activation';
include 'system/header.php'; 
include 'system/config_inc.php'; 
?>

<div class="wrap" align="center">
      <div class="clear"></div>
<?php
if(isset($_SESSION['pseudo'])){

$message_erreur1 = "Pour effectuer cette action, vous devez être déconnecté.";
echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> '. $message_erreur1 .'</center></div><meta http-equiv="refresh" content="2;index.html" />';

}else{
						if($_SERVER['HTTP_REFERER'] == $adresseSite . 'renvoi_activation.html'){
							if(isset($_POST) && isset($_POST['mail'])){	
										$email = $_POST['mail'];
										$e = $bdd->prepare('SELECT * FROM membres WHERE email = ?');
										$e->execute(array($email));
										$rep = $e->fetch();
							if($email == $rep['email']){
							if($email == $rep['email'] AND $rep['actif'] == 0){							
										$destinataire = $email;
										$sujet = "Activer votre compte" ;
										$entete = "From: inscription@modzcatz.fr" ;
														
										$message = 'Bienvenue sur MoDzCatZ.fr,
 
Pour activer votre compte, veuillez cliquer sur le lien ci dessous
ou copier/coller dans votre navigateur internet.
 
http://modzcatz.fr/activation.html?log='.urlencode($rep['pseudo']).'&cle='.urlencode($rep['cle']).'
 
 
---------------
Ceci est un mail automatique, Merci de ne pas y répondre.';
														
mail($destinataire, $sujet, $message, $entete) ;
$message_success = '<div id="reptopvalid"><center><i class="fa fa-envelope" aria-hidden="true"></i> Em@il d\'activation renvoyé - Merci de vérifier vos mails.</center></div><meta http-equiv="refresh" content="2;index.html" />';
						}else{
						$message_erreur = '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> L\'utilisateur est déja activé.</center></div>';	
						}
						}else{
						$message_erreur = '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> L\'em@il est inconnu.</center></div>';	
						}
						
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

					<div class="titre"><i class="fa fa-paper-plane" aria-hidden="true"></i> Renvoie du mail de confirmation<span class="titre-right"><a href="/">Retour à l'accueil</a></span></div>
					<br>			
					<form action="renvoi_activation.html" autocomplete="off"  method="POST">
							<input class="form-control" placeholder="Em@il" type="text" name="mail" style="margin-bottom:20px;" required/>
							<br>
							<button type="submit" class="btn btn-block btn-lg btn-info waves-effect waves-light">Renvoyer</button></a>
						</form>
<?php					
}
?>
</div>
<?php include 'system/footer.php'; 
 } ?>