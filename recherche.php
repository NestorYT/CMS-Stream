<?php require './system/config_inc.php';

if($_GET['option']){
$namePage = 'Recherche : '.$_GET['option'];
}elseif($_GET['genre']){
$namePage = 'Recherche : '.$_GET['genre'];
}elseif($_GET['qualite']){
$namePage = 'Recherche : '.$_GET['qualite'];
}elseif($_GET['film'] == 'exclusivite'){
$namePage = 'Recherche : Éxclusivité';
}elseif($_GET['film'] == 'tous'){
$namePage = 'Recherche : Tous les films';
}

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
<?php 
if(!empty($_GET['option'])){

									$chainesearch = addslashes($_GET['option']);
									$chainesearch = filter_var(htmlentities($chainesearch), FILTER_SANITIZE_STRING);

									if(strlen($chainesearch) >= 3){
									$s=explode(" ",$chainesearch);
									$sql="SELECT COUNT(*) AS nbArt FROM film";
									$i=0;
									foreach($s as $mot){
									if($i==0){
										$sql.=" WHERE (video_hs != '5' AND pending = '0') AND ";
									}else{
										$sql.=" AND ";
									}
										$sql.="((titre LIKE '%$mot%') OR (realisateur LIKE '%$mot%') OR (acteurs LIKE '%$mot%') OR (genre_1 LIKE '%$mot%') OR (genre_2 LIKE '%$mot%') OR (genre_3 LIKE '%$mot%') OR (qualite LIKE '%$mot%'))";
										$i++;
									}}
									$sql = $bdd->query($sql);
									$donnees = $sql->fetch();

									$nbArt = $donnees['nbArt'];
									$perPage = 18;
									$nbPage = ceil($nbArt/$perPage);
									
									if(isset($_GET['p']) && $_GET['p'] > 0 && $_GET['p'] <= $nbPage){
									$cPage = $_GET['p'];
									}else{
									$cPage = 1;
									}

									if(strlen($chainesearch) >= 3){
									$s=explode(" ",$chainesearch);
									$sql="SELECT * FROM film";
									$i=0;
									foreach($s as $mot){
									if(strlen($mot) >= 3){
									if($i==0){
										$sql.=" WHERE (video_hs != '5' AND pending = '0') AND ";
									}else{
										$sql.=" AND ";
									}
										$sql.="((titre LIKE '%$mot%') OR (realisateur LIKE '%$mot%') OR (acteurs LIKE '%$mot%') OR (genre_1 LIKE '%$mot%') OR (genre_2 LIKE '%$mot%') OR (genre_3 LIKE '%$mot%') OR (qualite LIKE '%$mot%'))";
										$i++;
									}
									}
									$sql2=" LIMIT ".(($cPage-1)*$perPage).",$perPage";
									$sql = $bdd->prepare($sql.$sql2);
									$sql->execute();
?>
<div class="titre"><i class="fa fa-search" aria-hidden="true"></i> Recherche : <?php echo $chainesearch; ?> - 
<?php echo $nbArt; ?> résultat(s)<span class="titre-right"><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">retour</a></span></div>
<?php
									if($nbArt > 0){
									while($row = $sql->fetch()){

?>
<div class="jaquette"><a href="infos.html?option=<?php echo $row['id']; ?>">
<img src="<?php echo $row['url_jaquette']; ?>" width="150" height="222" class="jaquette"><span><?php echo $row['qualite']; ?></span></a>
</div>
<?php 
}
echo '<div class="clear"></div>';

		if($cPage != 1 && $cPage < $nbPage){
			$str_q = str_replace(' ', '+', $chainesearch);
			echo '<a href="recherche.html?option='.$str_q.'&p=',$cPage-1,'"><div class="pagination_preview">Precedent</div></a>';
		}elseif($cPage != 1){
			$str_q = str_replace(' ', '+', $chainesearch);
			echo '<a href="recherche.html?option='.$str_q.'&p=',$cPage-1,'"><div class="pagination_next_solo">Precedent</div></a>';
		}

		if($cPage < $nbPage && $cPage == 1){
			$str_q = str_replace(' ', '+', $chainesearch);
			echo '<a href="recherche.html?option='.$str_q.'&p=',$cPage+1,'"><div class="pagination_next_solo">Suivant</div></a>';
		}elseif($cPage < $nbPage && $cPage != 1){
			$str_q = str_replace(' ', '+', $chainesearch);
			echo '<a href="recherche.html?option='.$str_q.'&p=',$cPage+1,'"><div class="pagination_next">Suivant</div></a>';
		}
		
}else{
	echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Aucun(s) résultat(s) !</center></div>';
}
}else{
	echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Merci de rentrer 3 caractères minimum !</center></div>';
}
}elseif(!empty($_GET['genre'])){
									$chainegenre = addslashes($_GET['genre']);
									$chainegenre = filter_var(htmlentities($chainegenre), FILTER_SANITIZE_STRING);

									$retour = $bdd->query("SELECT COUNT(*) AS nbArt FROM film WHERE (genre_1 LIKE '%$chainegenre%') OR (genre_2 LIKE '%$chainegenre%') OR (genre_3 LIKE '%$chainegenre%') AND video_hs != 5 AND pending = 0");
									$donnees = $retour->fetch();
									$nbArt = $donnees['nbArt'];
									$perPage = 18;
									$nbPage = ceil($nbArt/$perPage);
									
									if(isset($_GET['p']) && $_GET['p'] > 0 && $_GET['p'] <= $nbPage){
									$cPage = $_GET['p'];
									}else{
									$cPage = 1;
									}

									$req = $bdd->prepare("SELECT * FROM film WHERE (genre_1 LIKE '%$chainegenre%') OR (genre_2 LIKE '%$chainegenre%') OR (genre_3 LIKE '%$chainegenre%') AND video_hs != 5 AND pending = 0 ORDER BY id DESC LIMIT ".(($cPage-1)*$perPage).",$perPage");
									$req->execute();

?>
<div class="titre"><i class="fa fa-search" aria-hidden="true"></i> Recherche : <?php echo $chainegenre; ?> - 
<?php echo $nbArt; ?> résultat(s)<span class="titre-right"><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">retour</a></span></div>
<?php
									if($nbArt > 0){
									while($row = $req->fetch()){

?>
<div class="jaquette"><a href="infos.html?option=<?php echo $row['id']; ?>">
<img src="<?php echo $row['url_jaquette']; ?>" width="150" height="222" class="jaquette"><span><?php echo $row['qualite']; ?></span></a>
</div>
<?php 
}
echo '<div class="clear"></div>';

		if($cPage != 1 && $cPage < $nbPage){
			$str_q = str_replace(' ', '+', $chainegenre);
			echo '<a href="recherche.html?genre='.$str_q.'&p=',$cPage-1,'"><div class="pagination_preview">Precedent</div></a>';
		}elseif($cPage != 1){
			$str_q = str_replace(' ', '+', $chainegenre);
			echo '<a href="recherche.html?genre='.$str_q.'&p=',$cPage-1,'"><div class="pagination_next_solo">Precedent</div></a>';
		}

		if($cPage < $nbPage && $cPage == 1){
			$str_q = str_replace(' ', '+', $chainegenre);
			echo '<a href="recherche.html?genre='.$str_q.'&p=',$cPage+1,'"><div class="pagination_next_solo">Suivant</div></a>';
		}elseif($cPage < $nbPage && $cPage != 1){
			$str_q = str_replace(' ', '+', $chainegenre);
			echo '<a href="recherche.html?genre='.$str_q.'&p=',$cPage+1,'"><div class="pagination_next">Suivant</div></a>';
		}

	
}else{
	echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Aucun(s) résultat(s) !</center></div>';
}

}elseif(!empty($_GET['qualite'])){
									$chainegenre = addslashes($_GET['qualite']);
									$chainegenre = filter_var(htmlentities($chainegenre), FILTER_SANITIZE_STRING);
									$q = $chainegenre;

									$retour = $bdd->query("SELECT COUNT(*) AS nbArt FROM film WHERE qualite = '$q' AND video_hs != 5 AND pending = 0");
									$donnees = $retour->fetch();

									$nbArt = $donnees['nbArt'];
									$perPage = 18;
									$nbPage = ceil($nbArt/$perPage);
									
									if(isset($_GET['p']) && $_GET['p'] > 0 && $_GET['p'] <= $nbPage){
									$cPage = $_GET['p'];
									}else{
									$cPage = 1;
									}

									$req = $bdd->prepare("SELECT * FROM film WHERE qualite = :mot AND (video_hs != '5' AND pending = '0') ORDER BY id DESC LIMIT ".(($cPage-1)*$perPage).",$perPage");
									$req->execute(array(
									'mot' => $chainegenre));

?>
<div class="titre"><i class="fa fa-search" aria-hidden="true"></i> Recherche : <?php echo $chainegenre; ?> - 
<?php echo $nbArt; ?> résultat(s)<span class="titre-right"><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">retour</a></span></div>
<?php
									if($nbArt > 0){
									while($row = $req->fetch()){

?>
<div class="jaquette"><a href="infos.html?option=<?php echo $row['id']; ?>">
<img src="<?php echo $row['url_jaquette']; ?>" width="150" height="222" class="jaquette"><span><?php echo $row['qualite']; ?></span></a>
</div>
<?php 
}
echo '<div class="clear"></div>';

		if($cPage != 1 && $cPage < $nbPage){
			$str_q = str_replace(' ', '+', $q);
			echo '<a href="recherche.html?qualite='.$str_q.'&p=',$cPage-1,'"><div class="pagination_preview">Precedent</div></a>';
		}elseif($cPage != 1){
			$str_q = str_replace(' ', '+', $q);
			echo '<a href="recherche.html?qualite='.$str_q.'&p=',$cPage-1,'"><div class="pagination_next_solo">Precedent</div></a>';
		}

		if($cPage < $nbPage && $cPage == 1){
			$str_q = str_replace(' ', '+', $q);
			echo '<a href="recherche.html?qualite='.$str_q.'&p=',$cPage+1,'"><div class="pagination_next_solo">Suivant</div></a>';
		}elseif($cPage < $nbPage && $cPage != 1){
			$str_q = str_replace(' ', '+', $q);
			echo '<a href="recherche.html?qualite='.$str_q.'&p=',$cPage+1,'"><div class="pagination_next">Suivant</div></a>';
		}

}else{
	echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Aucun(s) résultat(s) !</center></div>';
}

}elseif(!empty($_GET['film']) && ($_GET['film'] == 'exclusivite' || $_GET['film'] == 'tous')){
									$chainegenre = addslashes($_GET['film']);
									$ml = addslashes($_GET['nom']);
									if($chainegenre == 'exclusivite'){
									$q = 1;
									$t = 'Éxclusivité';
									}elseif($chainegenre == 'tous'){
									$t = 'Tous les films';
									}

									if($chainegenre == 'exclusivite'){
									$retour = $bdd->query("SELECT COUNT(*) AS nbArt FROM film WHERE exclusivite = $q AND video_hs != 5 AND pending = 0");
									}elseif($chainegenre == 'tous'){
									$retour = $bdd->query("SELECT COUNT(*) AS nbArt FROM film WHERE video_hs != 5 AND pending = 0");
									}
									$donnees = $retour->fetch();

									$nbArt = $donnees['nbArt'];
									$perPage = 18;
									$nbPage = ceil($nbArt/$perPage);
									
									if(isset($_GET['p']) && $_GET['p'] > 0 && $_GET['p'] <= $nbPage){
									$cPage = $_GET['p'];
									}else{
									$cPage = 1;
									}

									if($ml == 'asc'){

									if($chainegenre == 'exclusivite'){
									$req = $bdd->prepare("SELECT * FROM film WHERE exclusivite = :mot AND (video_hs != '5' AND pending = '0') ORDER BY titre ASC LIMIT ".(($cPage-1)*$perPage).",$perPage");
									$req->execute(array(
									'mot' => $q));
									}elseif($chainegenre == 'tous'){
									$req = $bdd->prepare("SELECT * FROM film WHERE (video_hs != '5' AND pending = '0') ORDER BY titre ASC LIMIT ".(($cPage-1)*$perPage).",$perPage");
									$req->execute();
									}

									}elseif($ml == 'desc'){

									if($chainegenre == 'exclusivite'){
									$req = $bdd->prepare("SELECT * FROM film WHERE exclusivite = :mot AND (video_hs != '5' AND pending = '0') ORDER BY titre DESC LIMIT ".(($cPage-1)*$perPage).",$perPage");
									$req->execute(array(
									'mot' => $q));
									}elseif($chainegenre == 'tous'){
									$req = $bdd->prepare("SELECT * FROM film WHERE (video_hs != '5' AND pending = '0') ORDER BY titre DESC LIMIT ".(($cPage-1)*$perPage).",$perPage");
									$req->execute();
									}

									}else{

									if($chainegenre == 'exclusivite'){
									$req = $bdd->prepare("SELECT * FROM film WHERE exclusivite = :mot AND (video_hs != '5' AND pending = '0') ORDER BY id DESC LIMIT ".(($cPage-1)*$perPage).",$perPage");
									$req->execute(array(
									'mot' => $q));
									}elseif($chainegenre == 'tous'){
									$req = $bdd->prepare("SELECT * FROM film WHERE (video_hs != '5' AND pending = '0') ORDER BY id DESC LIMIT ".(($cPage-1)*$perPage).",$perPage");
									$req->execute();
									}

									}
									

?>
<div class="titre"><i class="fa fa-search" aria-hidden="true"></i> Recherche : <?php echo $t; ?> - 
<?php echo $nbArt; ?> résultat(s)
<span class="titre-right">Trier par nom : <a href="<?php echo 'recherche.html?film='.$chainegenre.'&nom=asc'; ?>">&uarr;</a> | <a href="<?php echo 'recherche.html?film='.$chainegenre.'&nom=desc'; ?>">&darr;</a> - <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">retour</a></span></div>
<?php
									if($nbArt > 0){
									while($row = $req->fetch()){

?>
<div class="jaquette"><a href="infos.html?option=<?php echo $row['id']; ?>">
<img src="<?php echo $row['url_jaquette']; ?>" width="150" height="222" class="jaquette"><span><?php echo $row['qualite']; ?></span></a>
</div>
<?php 
}

if($ml == 'asc' || $ml == 'desc'){
		echo '<div class="clear"></div>';

		if($cPage != 1 && $cPage < $nbPage){
			echo '<a href="recherche.html?film='.$chainegenre.'&nom='.$ml.'&p=',$cPage-1,'"><div class="pagination_preview">Precedent</div></a>';
		}elseif($cPage != 1){
			echo '<a href="recherche.html?film='.$chainegenre.'&nom='.$ml.'&p=',$cPage-1,'"><div class="pagination_next_solo">Precedent</div></a>';
		}

		if($cPage < $nbPage && $cPage == 1){
			echo '<a href="recherche.html?film='.$chainegenre.'&p=',$cPage+1,'"><div class="pagination_next_solo">Suivant</div></a>';
		}elseif($cPage < $nbPage && $cPage != 1){
			echo '<a href="recherche.html?film='.$chainegenre.'&p=',$cPage+1,'"><div class="pagination_next">Suivant</div></a>';
		}

}else{
		echo '<div class="clear"></div>';
		
		if($cPage != 1 && $cPage < $nbPage){
			echo '<a href="recherche.html?film='.$chainegenre.'&p=',$cPage-1,'"><div class="pagination_preview">Precedent</div></a>';
		}elseif($cPage != 1){
			echo '<a href="recherche.html?film='.$chainegenre.'&p=',$cPage-1,'"><div class="pagination_next_solo">Precedent</div></a>';
		}

		if($cPage < $nbPage && $cPage == 1){
			echo '<a href="recherche.html?film='.$chainegenre.'&p=',$cPage+1,'"><div class="pagination_next_solo">Suivant</div></a>';
		}elseif($cPage < $nbPage && $cPage != 1){
			echo '<a href="recherche.html?film='.$chainegenre.'&p=',$cPage+1,'"><div class="pagination_next">Suivant</div></a>';
		}

	}

}else{
	echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Aucun(s) résultat(s) !</center></div>';
}

}else{
	echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Tu t\'és perdu ?</center></div><meta http-equiv="refresh" content="1;index.html" />';
}

 ?>
<div class="clear"></div>
</div>
<?php include 'system/footer.php'; 
 } ?>