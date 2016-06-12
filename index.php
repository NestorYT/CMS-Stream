<?php require './system/config_inc.php';
$namePage = 'Accueil';

	$req = $bdd->prepare("SELECT * FROM core WHERE id = :id");
					$req->execute(array(
						'id' => 1));
					$row_core = $req->fetch();

	if($row_core['maintenance'] == 1 && $_SESSION['rank'] < 3){

		include './system/maintenance.php';

	}else{ 
			
?>
<?php include 'system/header.php'; ?>

<div class="wrap" align="center">

			<div class="clear"></div>

<div class="titre"><i class="fa fa-search" aria-hidden="true"></i> Rechercher par genres / qualités</div>
<?php
									$req = $bdd->prepare("SELECT DISTINCT qualite FROM film WHERE video_hs != '5' AND pending = '0' ORDER BY qualite ASC");
									$req->execute();
									while($row = $req->fetch()){

$str_q = str_replace(' ', '+', $row['qualite']);

?>
<a href="recherche.html?qualite=<?php echo $str_q; ?>"><div class="choix-qualiter"><?php echo $row['qualite']; ?></div></a>

<?php } 
									$req = $bdd->prepare("SELECT DISTINCT genre_1 FROM film WHERE video_hs != '5' AND pending = '0' ORDER BY genre_1 ASC");
									$req->execute();
									while($row = $req->fetch()){
										
$str_q = str_replace(' ', '+', $row['genre_1']);

?>
<a href="recherche.html?genre=<?php echo $str_q; ?>"><div class="choix-qualiter"><?php echo $row['genre_1']; ?></div></a>
<?php } ?>
<div class="titre"><i class="fa fa-info" aria-hidden="true"></i> LES EXCLUSIVITES
<span class="titre-right"><a href="recherche.html?film=exclusivite">AFFICHER TOUT</a></span>
</div>
<?php
									$req = $bdd->prepare("SELECT * FROM film WHERE exclusivite = '1' AND video_hs != '5' AND pending = '0' ORDER BY id DESC LIMIT 6");
									$req->execute();
									$etat = $req->rowCount();
									if($etat > 0){
									while($row = $req->fetch()){

?>
<div class="jaquette"><a href="infos.html?option=<?php echo $row['id']; ?>">
<img src="<?php echo $row['url_jaquette']; ?>" width="150" height="222" class="jaquette"><span><?php echo $row['qualite']; ?></span></a>
</div>
<?php }
}else{
	echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Aucune(s) éxclusivitée(s) !</center></div>';
} ?>

<div class="titre"><i class="fa fa-info" aria-hidden="true"></i> FILMS ALÉATOIRE
<span class="titre-right"><a href="recherche.html?film=tous">AFFICHER TOUT</a></span>
</div>

<?php
									$req = $bdd->prepare("SELECT * FROM film WHERE video_hs != '5' AND pending = '0' ORDER BY RAND() LIMIT 12");
									$req->execute();
									$etat = $req->rowCount();
									if($etat > 0){
									while($row = $req->fetch()){

?>
<div class="jaquette"><a href="infos.html?option=<?php echo $row['id']; ?>">
<img src="<?php echo $row['url_jaquette']; ?>" width="150" height="222" class="jaquette"><span><?php echo $row['qualite']; ?></span></a>
</div>
<?php }
}else{
	echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Aucun(s) film(s) !</center></div>';
} ?>
<div class="clear"></div>
<div class="block_down_1">
<div class="titre_news"><i class="fa fa-info" aria-hidden="true"></i> NEWS DU SITE
</div>
<div class="news">
<?php
									$retour = $bdd->query("SELECT COUNT(*) AS nbArt FROM news");
									$donnees = $retour->fetch();

									$nbArt = $donnees['nbArt'];
									$perPage = 1;
									$nbPage = ceil($nbArt/$perPage);
									
									if(isset($_GET['p']) && $_GET['p'] > 0 && $_GET['p'] <= $nbPage){
									$cPage = $_GET['p'];
									}else{
									$cPage = 1;
									}

									$req = $bdd->prepare("SELECT * FROM news ORDER BY id DESC LIMIT ".(($cPage-1)*$perPage).",$perPage");
									$req->execute();

	if($nbArt > 0){
		while($row = $req->fetch()){
					$req = $bdd->prepare("SELECT * FROM membres WHERE id = :id");
					$req->execute(array(
						'id' => $row['pseudo_id']));
					$row_news = $req->fetch();
?>
<div class="left_news"><?php if(empty($row_news['url_avatar'])){ echo '<img src="images/avatar.jpg">'; }else{ echo '<img src="'.$row_news['url_avatar'].'">'; } ?></div>
<div class="right_left"><?php echo nl2br($row['news']); ?></div>
<div class="coms"><?php if(empty($row_news['pseudo'])){ echo '<span class="rank">Inconnu</span>'; }else{ echo '<span class="rank'.$row_news['rank'].'">'.$row_news['pseudo'].'</span>'; } echo ' le '.$row['date_add']; ?></div>
					</div>
<?php }}else{
	echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Aucune(s) news(s) !</center></div>';
	} ?>
<div class="clear"></div>
<div class="pagination_reborn">
<?php

		if($cPage != 1 && $cPage < $nbPage){
			echo '<a href="index.html?&p=',$cPage-1,'"><div class="pagination_preview_mini">Precedent</div></a>';
		}elseif($cPage != 1){
			echo '<a href="index.html?&p=',$cPage-1,'"><div class="pagination_next_solo_mini">Precedent</div></a>';
		}

		if($cPage < $nbPage && $cPage == 1){
			echo '<a href="index.html?&p=',$cPage+1,'"><div class="pagination_next_solo_mini">Suivant</div></a>';
		}elseif($cPage < $nbPage && $cPage != 1){
			echo '<a href="index.html?&p=',$cPage+1,'"><div class="pagination_next_mini">Suivant</div></a>';
		}
		
?>
</div>
</div>
<!-- <div class="block_down">
<div class="titre_news"><i class="fa fa-info" aria-hidden="true"></i> shoutbox
</div>
</div>
</div> -->
<div class="clear"></div>
</div>
<div class="clear"></div>
<?php include 'system/footer.php'; 
 } ?>