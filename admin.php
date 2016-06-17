<?php
$namePage = 'Administration';

include './system/header.php'; 
require './system/config_inc.php';
require './system/function.php';
?>

<div class="wrap">
			<div class="clear"></div>
<?php
if($_SESSION['rank'] > 2){
	if(!isset($_SESSION['pseudo'])){
		header('Location: connexion.html');
	}else{

					$req = $bdd->prepare("SELECT * FROM core WHERE id = :id");
					$req->execute(array(
						'id' => 1));
					$row_core = $req->fetch();

					$result_option_1 = 'maintenance';
					$result_option_2 = 'inscription';
					$result_option_3 = 'commentaires';
					$result_option_4 = 'news';
					$result_option_5 = 'ddl';

						if($row_core['maintenance'] == 0){
						$result_maintenance = 'Activer la maintenance';
						}elseif($row_core['maintenance'] == 1){
						$result_maintenance = 'Désactiver la maintenance';
						}
						if($row_core['inscription'] == 0){
						$result_inscription = 'Désactiver les inscriptions';

						}elseif($row_core['inscription'] == 1){
						$result_inscription = 'Activer les inscriptions';
						}
						if($row_core['commentaires'] == 0){
						$result_commentaires = 'Désactiver les commentaires';
						}elseif($row_core['commentaires'] == 1){
						$result_commentaires = 'Activer les commentaires';
						}
						if($row_core['news'] == 0){
						$result_news = 'Désactiver les news';
						}elseif($row_core['news'] == 1){
						$result_news = 'Activer les news';
						}
						if($row_core['ddl'] == 0){
						$result_ddl = 'Désactiver les téléchargements';
						}elseif($row_core['ddl'] == 1){
						$result_ddl = 'Activer les téléchargements';
						}
						
						$retour = $bdd->query('SELECT COUNT(*) AS nbre_entrees FROM membres WHERE actif = 0');
						$donnees = $retour->fetch();
						$retour = $bdd->query('SELECT COUNT(*) AS nbre_entrees FROM membres WHERE rank = 0');
						$donnees_1 = $retour->fetch();
						$retour = $bdd->query('SELECT COUNT(*) AS nbre_entrees FROM film WHERE video_hs = 5');
						$donnees_2 = $retour->fetch();
						$retour = $bdd->query('SELECT COUNT(*) AS nbre_entrees FROM film WHERE pending > 0');
						$donnees_3 = $retour->fetch();

			?>

					<div class="titre"><i class="fa fa-users" aria-hidden="true"></i> Gestion des membres<span class="titre-right"><a href="/">Retour à l'accueil</a></span></div>
					<div class="link_admin">Liste des membres<span class="link_admin-right"><a href="liste.html?option=membre"><i class="fa fa-cog" aria-hidden="true"></i></a></span></div>
					<div class="link_admin">Liste des comptes inactivées <?php if($donnees['nbre_entrees'] == 0){ echo ''; }elseif($donnees['nbre_entrees'] > 0){ echo '<font color="#D14836">('.$donnees['nbre_entrees'].')</font>';} ?><span class="link_admin-right"><a href="liste.html?option=inactif"><i class="fa fa-cog" aria-hidden="true"></i></a></span></div>
					<div class="link_admin">Liste des membres bannis <?php if($donnees_1['nbre_entrees'] == 0){ echo ''; }elseif($donnees_1['nbre_entrees'] > 0){ echo '<font color="#D14836">('.$donnees_1['nbre_entrees'].')</font>';} ?><span class="link_admin-right"><a href="liste.html?option=banni"><i class="fa fa-cog" aria-hidden="true"></i></a></span></div>
					<div class="link_admin">Liste du personnels<span class="link_admin-right"><a href="liste.html?option=staff"><i class="fa fa-cog" aria-hidden="true"></i></a></span></div>

					<div class="titre"><i class="fa fa-film" aria-hidden="true"></i> Gestion des films</div>
					<div class="link_admin">Ajouter un film<span class="link_admin-right"><a href="ajouter.html?option=film"><i class="fa fa-cog" aria-hidden="true"></i></a></span></div>
					<div class="link_admin">Liste des films<span class="link_admin-right"><a href="liste.html?option=film"><i class="fa fa-cog" aria-hidden="true"></i></a></span></div>
					<div class="link_admin">Liste des exclusivitées<span class="link_admin-right"><a href="liste.html?option=exclusivite"><i class="fa fa-cog" aria-hidden="true"></i></a></span></div>
					<div class="link_admin">Liste des HS <?php if($donnees_2['nbre_entrees'] == 0){ echo ''; }elseif($donnees_2['nbre_entrees'] > 0){ echo '<font color="#D14836">('.$donnees_2['nbre_entrees'].')</font>';} ?><span class="link_admin-right"><a href="liste.html?option=video_hs"><i class="fa fa-cog" aria-hidden="true"></i></a></span></div>
					<div class="link_admin">Liste du pending <?php if($donnees_3['nbre_entrees'] == 0){ echo ''; }elseif($donnees_3['nbre_entrees'] > 0){ echo '<font color="#D14836">('.$donnees_3['nbre_entrees'].')</font>';} ?><span class="link_admin-right"><a href="liste.html?option=pending"><i class="fa fa-cog" aria-hidden="true"></i></a></span></div>

					<div class="titre"><i class="fa fa-film" aria-hidden="true"></i> Gestion des qualitées</div>
					<div class="link_admin">Ajouter une qualitée<span class="link_admin-right"><a href="ajouter.html?option=qualite"><i class="fa fa-cog" aria-hidden="true"></i></a></span></div>					
					<div class="link_admin">Liste des qualitées<span class="link_admin-right"><a href="liste.html?option=qualite"><i class="fa fa-cog" aria-hidden="true"></i></a></span></div>
					
					<div class="titre"><i class="fa fa-film" aria-hidden="true"></i> Gestion des genres</div>
					<div class="link_admin">Ajouter un genre<span class="link_admin-right"><a href="ajouter.html?option=genre"><i class="fa fa-cog" aria-hidden="true"></i></a></span></div>
					<div class="link_admin">Liste des genres<span class="link_admin-right"><a href="liste.html?option=genre"><i class="fa fa-cog" aria-hidden="true"></i></a></span></div>

					<div class="titre"><i class="fa fa-comments-o" aria-hidden="true"></i> Gestion des commentaires</div>
					<div class="link_admin">Liste des commentaires<span class="link_admin-right"><a href="liste.html?option=commentaires"><i class="fa fa-cog" aria-hidden="true"></i></a></span></div>

					<div class="titre"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Gestion des news</div>
					<div class="link_admin">Ajouter une news<span class="link_admin-right"><a href="ajouter.html?option=news"><i class="fa fa-cog" aria-hidden="true"></i></a></span></div>
					<div class="link_admin">Liste des news<span class="link_admin-right"><a href="liste.html?option=news"><i class="fa fa-cog" aria-hidden="true"></i></a></span></div>

					<?php if($_SESSION['rank'] > 3){ ?>
					<div class="titre"><i class="fa fa-cog" aria-hidden="true"></i> Gestion du site</div>

					<div class="link_admin"><?php echo $result_maintenance; ?><span class="link_admin-right"><a href="modifier.html?option=<?php echo $result_option_1; ?>"><i class="fa fa-wrench" aria-hidden="true"></i></a></span></div>
					<div class="link_admin"><?php echo $result_inscription; ?><span class="link_admin-right"><a href="modifier.html?option=<?php echo $result_option_2; ?>"><i class="fa fa-wrench" aria-hidden="true"></i></a></span></div>
					<div class="link_admin"><?php echo $result_commentaires; ?><span class="link_admin-right"><a href="modifier.html?option=<?php echo $result_option_3; ?>"><i class="fa fa-wrench" aria-hidden="true"></i></a></span></div>
					<div class="link_admin"><?php echo $result_news; ?><span class="link_admin-right"><a href="modifier.html?option=<?php echo $result_option_4; ?>"><i class="fa fa-wrench" aria-hidden="true"></i></a></span></div>
					<div class="link_admin"><?php echo $result_ddl; ?><span class="link_admin-right"><a href="modifier.html?option=<?php echo $result_option_5; ?>"><i class="fa fa-wrench" aria-hidden="true"></i></a></span></div>	
						<?php
					}else{}
} }else{
	header('Location: index.html');
}
					?>
</div>
<?php include './system/footer.php'; ?>
