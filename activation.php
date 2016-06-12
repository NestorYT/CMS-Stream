<?php require './system/config_inc.php';

  $req = $bdd->prepare("SELECT * FROM core WHERE id = :id");
          $req->execute(array(
            'id' => 1));
          $row_core = $req->fetch();

  if($row_core['maintenance'] == 1 && $_SESSION['rank'] < 3){

    include './system/maintenance.php';

  }else{ 

$namePage = 'Activation';
include 'system/header.php'; 
include 'system/config_inc.php';
?>

<div class="wrap" align="center">
      <div class="clear"></div>
<?php
if(isset($_SESSION['pseudo'])){

$message_erreur1 = "Pour effectuer cette action, vous devez être déconnecté.";
echo '<div id="reptoperror"><center>'. $message_erreur1 .'</center></div>';

}else{	
					
$login = $_GET['log'];
$cle = $_GET['cle'];

$stmt = $bdd->prepare("SELECT cle,actif FROM membres WHERE pseudo like :login ");
if($stmt->execute(array(':login' => $login)) && $row = $stmt->fetch())
  {
    $clebdd = $row['cle'];	// Récupération de la clé
    $actif = $row['actif']; // $actif contiendra alors 0 ou 1
  }
if($actif == '1'){
	
echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Votre compte est déjà actif !</center></div><meta http-equiv="refresh" content="3;connexion.html" />';

  }else{
	  
if($cle == $clebdd){
 
          $stmt = $bdd->prepare("UPDATE membres SET actif = 1 WHERE pseudo like :login ");
          $stmt->bindParam(':login', $login);
          $stmt->execute();
		  
		  echo '<div id="reptopvalid"><center><i class="fa fa-check"></i> Votre compte a bien été activé !</center></div><meta http-equiv="refresh" content="3;connexion.html" />';
       }
     else 
       {
          echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Erreur ! Votre compte ne peut être activé...</center></div>';
       }
  }  
}
?>
</div>
<?php include 'system/footer.php'; 
 } ?>