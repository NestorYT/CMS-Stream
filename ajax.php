<?php require './system/config_inc.php';

if(!empty($_GET['now'])){







									$chainesearch = addslashes($_GET['now']);
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
										$sql.="((titre LIKE '%$mot%') OR (genre_1 LIKE '%$mot%') OR (genre_2 LIKE '%$mot%') OR (genre_3 LIKE '%$mot%') OR (qualite LIKE '%$mot%'))";
										$i++;
									}}
									$sql = $bdd->query($sql);
									$donnees = $sql->fetch();

									$nbArt = $donnees['nbArt'];

									if(strlen($chainesearch) >= 3){
									$s=explode(" ",$chainesearch);
									$sql="SELECT * FROM film";
									$i=0;
									foreach($s as $mot){
									if(strlen($mot) > 3){
									if($i==0){
										$sql.=" WHERE (video_hs != '5' AND pending = '0') AND ";
									}else{
										$sql.=" AND ";
									}
										$sql.="((titre LIKE '%$mot%') OR (genre_1 LIKE '%$mot%') OR (genre_2 LIKE '%$mot%') OR (genre_3 LIKE '%$mot%') OR (qualite LIKE '%$mot%'))";
										$i++;
									}
									}
									$sql2=" LIMIT 5";
									$sql = $bdd->prepare($sql.$sql2);
									$sql->execute();

									if($nbArt > 0){
									while($row = $sql->fetch()){

?>
<div class="now_block">
<div class="now_jaquette">
<a href="infos.html?option=<?php echo $row['id']; ?>"><img src="<?php echo $row['url_jaquette']; ?>" width="70" height="95" class="jaquette"></a>
</div>
</div>
<?php 
}
echo '<div class="clear"></div>';
		
}else{
	echo '<center style="font-size: 12px; color: #d14836;"><i class="fa fa-exclamation-triangle"></i> Aucun résultat pour '.$chainesearch.' !</center>';
}
}else{
	echo '<center style="font-size: 12px; color: #d14836;"><i class="fa fa-exclamation-triangle"></i> Merci de rentrer 3 caractères minimum !</center>';
}








}
?>