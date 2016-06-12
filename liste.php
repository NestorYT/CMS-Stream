<?php
require './system/config_inc.php';
require './system/function.php';

if($_GET['option'] == 'membre'){
$namePage = 'Liste des membres';
}elseif($_GET['option'] == 'banni'){
$namePage = 'Liste des membres banni(e)s';
}elseif($_GET['option'] == 'inactif'){
$namePage = 'Liste des membres inactif';
}elseif($_GET['option'] == 'staff'){
$namePage = 'Liste des membres du personnel';
}elseif($_GET['option'] == 'qualite'){
$namePage = 'Liste des qualitées vidéo';
}elseif($_GET['option'] == 'genre'){
$namePage = 'Liste des genres';
}elseif($_GET['id'] == $_SESSION['id'] && $_GET['option'] == 'mes_films'){
$namePage = 'Liste de mes films';
}elseif($_GET['option'] == 'film'){
$namePage = 'Liste des films';
}elseif($_GET['option'] == 'exclusivite'){
$namePage = 'Liste des films en exclusivite';
}elseif($_GET['option'] == 'pending'){
$namePage = 'Liste des films en pending';
}elseif($_GET['option'] == 'video_hs'){
$namePage = 'Liste des vidéo hs';
}elseif($_GET['option'] == 'commentaires'){
$namePage = 'Liste des commentaires';
}elseif($_GET['option'] == 'news'){
$namePage = 'Liste des news';
}                                      

include './system/header.php'; 
?>

<div class="wrap">
			<div class="clear"></div>
<?php
if(!isset($_SESSION['pseudo'])){
		header('Location: connexion.html');
	}else{
if(($_SESSION['rank'] == 1 && $_GET['option'] == 'mes_films' && $_GET['id'] == $_SESSION['id']) || ($_SESSION['rank'] == 2 && $_GET['option'] == 'mes_films' && $_GET['id'] == $_SESSION['id']) || ($_SESSION['rank'] == 3 && $_GET['option'] == 'mes_films' && $_GET['id'] == $_SESSION['id']) || ($_SESSION['rank'] == 4 && $_GET['option'] == 'mes_films' && $_GET['id'] == $_SESSION['id'])){

if('http://'.$_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] == $adresseSite . 'liste.html?id='.$_GET['id'].'&option='.$_GET['option']){		
if($_GET['option'] == 'mes_films' && $_SESSION['id'] == $_GET['id']){
$retour = $bdd->query('SELECT COUNT(*) AS nbre_entrees FROM film WHERE uploader_id = '.$_SESSION['id'].'');
		$donnees_verif = $retour->fetch();

		if($donnees_verif['nbre_entrees'] > 0){
	
	
					if($_GET['option'] == 'mes_films'){
					$result_get = 'Liste de mes films';
					} ?>
					<div class="titre"><i class="fa fa-film" aria-hidden="true"></i> <?php echo $result_get; ?><span class="titre-right"><a href="/mon_profile.html">Retour à mon profile</a></span></div>
							<table id="members"  class="table table-bordered">
								<thead>
									<tr>
										<th>Nom du film</th>
										<th>Statut</th>
										<th>Vidéo HS</th>
										<th>Modifié</th>
										<th>Effacé?</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if($_GET['option'] == 'mes_films'){
									$req = $bdd->prepare("SELECT * FROM film WHERE uploader_id = ".$_SESSION['id']." ORDER BY id DESC");}
									$req->execute();
									while($row = $req->fetch()){
		
										?>
										<tr>
											<td><a href="infos.html?mon_pending=<?php echo $row['id']; ?>" class="monpending"><?php echo $row['titre']; ?></a></td>
											<td class="coulor_net"><b><?php if($row['pending'] == 0){
											echo 'Validé';
											}elseif($row['pending'] == 1){
											echo '<font color="#e67e22">En Attente</font>';
											}elseif($row['pending'] == 2){
											echo '<font color="#C0392B">Non-Validé</font>';
											}elseif($row['pending'] == 3){
											echo '<font color="#e67e22">À Corrigé</font>';
											} ?></b></td>
											<td class="coulor_net"><b><?php if($row['video_hs'] != 5){
											echo 'Non';
											}elseif($row['video_hs'] == 5){
											echo '<font color="#C0392B">Oui</font>';
											} ?></b></td>
											<td><?php if($row['video_hs'] == 5 || $row['pending'] == 1 || $row['pending'] == 3){
											echo '<a href="modifier.html?id='.htmlspecialchars(htmlentities($row['id'])).'&option='.htmlspecialchars(htmlentities($_GET['option'])).'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>'; 
											}else{}
											?></td>
											<td><?php if($row['video_hs'] == 5 || $row['pending'] == 1 || $row['pending'] == 2 || $row['pending'] == 3){ ?>
											<a href="effacer.html?id=<?php echo htmlspecialchars(htmlentities($row['id'])); ?>&option=<?php echo htmlspecialchars(htmlentities($_GET['option'])); ?>"><i class="fa fa-trash-o" aria-hidden="true"></i>
											<?php }else{} ?>
											</td>
										</tr>
										<?php
									}
									?>
								</tbody>
							</table>
					<script>
			$(document).ready(function(){
				$('#members').after('<div style="text-align: center;"><div id="nav" style="display: inline-block;"></div></div>');
				var rowsShown = 15;
				var rowsTotal = $('#members tbody tr').length;
				var numPages = rowsTotal/rowsShown;
				for(i = 0;i < numPages;i++) {
					var pageNum = i + 1;
					$('#nav').append('<a href="#" class="link_membres" rel="'+i+'">'+pageNum+'</a> ');
				}
				$('#members tbody tr').hide();
				$('#members tbody tr').slice(0, rowsShown).show();
				$('#nav a:first').addClass('active');
				$('#nav a').bind('click', function(){

					$('#nav a').removeClass('active');
					$(this).addClass('active');
					var currPage = $(this).attr('rel');
					var startItem = currPage * rowsShown;
					var endItem = startItem + rowsShown;
					$('#members tbody tr').css('opacity','0.0').hide().slice(startItem, endItem).
					css('display','table-row').animate({opacity:1}, 300);
				});
			});
		</script>

<?php
}else{
echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Aucun(s) film(s) dans la base de donnée</center></div><meta http-equiv="refresh" content="2;mon_profile.html" />';
}

}else{
	echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Tu t\'és perdu ?</center></div>';
}
}else{
	echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Tu t\'és perdu ?</center></div>';
}

}elseif($_SESSION['rank'] == 0){




}elseif($_SESSION['rank'] > 2 && $_GET['option'] == 'news'){





$retour = $bdd->query('SELECT COUNT(*) AS nbre_entrees FROM news WHERE id');
		$donnees_verif = $retour->fetch();
	
	if($donnees_verif['nbre_entrees'] > 0){
					if($_GET['option'] == 'news'){
					$result_get = 'Liste des news';
					} ?>
					<div class="titre"><i class="fa fa-film" aria-hidden="true"></i> <?php echo $result_get; ?><span class="titre-right"><a href="/admin.html">Retour à l'administration</a></span></div>
							<table id="members"  class="table table-bordered">
								<thead>
									<tr>
										<th>Pseudo</th>
										<th>News</th>
										<th>Modifié</th>
										<?php if($_SESSION['rank'] > 3){ ?><th>Effacé?</th><?php }else{} ?>
									</tr>
								</thead>
								<tbody>
									<?php
									if($_GET['option'] == 'news'){
									$req = $bdd->prepare("SELECT * FROM news ORDER BY id DESC");}
									$req->execute();
									while($row = $req->fetch()){

									$req1 = $bdd->prepare("SELECT * FROM membres WHERE id = ".$row['pseudo_id']);
									$req1->execute();
									$row1 = $req1->fetch();
										?>
										<tr>
											<td><?php if(empty($row1['pseudo'])){ echo '<span class="rank">Inconnu</span>'; }else{ echo '<span class="rank'.$row1['rank'].'">'.$row1['pseudo'].'</span>'; } ?></td>
											<td><?php echo $row['news']; ?></td>
											<td>
											<?php
											echo '<a href="modifier.html?id='.htmlspecialchars(htmlentities($row['id'])).'&option='.htmlspecialchars(htmlentities($_GET['option'])).'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
											?>
											</td>
											<?php if($_SESSION['rank'] > 3){ ?>
											<td><a href="effacer.html?id=<?php echo htmlspecialchars(htmlentities($row['id'])); ?>&option=<?php echo htmlspecialchars(htmlentities($_GET['option'])); ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
											<?php }else{} ?> 	
										</tr>
										<?php
									}
									?>
								</tbody>
							</table>
					<script>
			$(document).ready(function(){
				$('#members').after('<div style="text-align: center;"><div id="nav" style="display: inline-block;"></div></div>');
				var rowsShown = 15;
				var rowsTotal = $('#members tbody tr').length;
				var numPages = rowsTotal/rowsShown;
				for(i = 0;i < numPages;i++) {
					var pageNum = i + 1;
					$('#nav').append('<a href="#" class="link_membres" rel="'+i+'">'+pageNum+'</a> ');
				}
				$('#members tbody tr').hide();
				$('#members tbody tr').slice(0, rowsShown).show();
				$('#nav a:first').addClass('active');
				$('#nav a').bind('click', function(){

					$('#nav a').removeClass('active');
					$(this).addClass('active');
					var currPage = $(this).attr('rel');
					var startItem = currPage * rowsShown;
					var endItem = startItem + rowsShown;
					$('#members tbody tr').css('opacity','0.0').hide().slice(startItem, endItem).
					css('display','table-row').animate({opacity:1}, 300);
				});
			});
		</script>

<?php
}else{
echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Aucun(s) new(s) dans la base de donnée</center></div><meta http-equiv="refresh" content="2;'.$_SERVER['HTTP_REFERER'].'" />';
}






}elseif(($_SESSION['rank'] > 2 && $_GET['option'] == 'membre') || ($_SESSION['rank'] > 2 && $_GET['option'] == 'banni') || ($_SESSION['rank'] > 2 && $_GET['option'] == 'inactif') || ($_SESSION['rank'] > 2 && $_GET['option'] == 'staff') || ($_SESSION['rank'] > 2 && $_GET['option'] == 'qualite') || ($_SESSION['rank'] > 2 && $_GET['option'] == 'genre') || ($_SESSION['rank'] > 2 && $_GET['option'] == 'film') || ($_SESSION['rank'] > 2 && $_GET['option'] == 'exclusivite') || ($_SESSION['rank'] > 2 && $_GET['option'] == 'video_hs') || ($_SESSION['rank'] > 2 && $_GET['option'] == 'pending') || ($_SESSION['rank'] > 2 && $_GET['option'] == 'commentaires')){
	
	if('http://'.$_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] == $adresseSite . 'liste.html?option='.$_GET['option']){		
		if(!isset($_GET['option']) OR $_GET['option'] == 'membre' OR $_GET['option'] == 'banni' OR $_GET['option'] == 'inactif' OR $_GET['option'] == 'staff'){
	$retour = $bdd->query('SELECT COUNT(*) AS nbre_entrees FROM membres WHERE id');
	$donnees_verif = $retour->fetch();

	$retour = $bdd->query('SELECT COUNT(*) AS nbre_entrees FROM membres WHERE rank = 0');
	$donnees_verif_ban = $retour->fetch();
	
	$retour = $bdd->query('SELECT COUNT(*) AS nbre_entrees FROM membres WHERE actif = 0');
	$donnees_verif_inactif = $retour->fetch();

	if(($donnees_verif_inactif['nbre_entrees'] > 0 && $_GET['option'] == 'inactif') || ($donnees_verif_inactif['nbre_entrees'] >= 0 && $_GET['option'] == 'banni') || ($donnees_verif_inactif['nbre_entrees'] >= 0 && $_GET['option'] == 'staff') || ($donnees_verif_inactif['nbre_entrees'] >= 0 && $_GET['option'] == 'membre')){
	if(($donnees_verif_ban['nbre_entrees'] > 0 && $_GET['option'] == 'banni') || ($donnees_verif_ban['nbre_entrees'] >= 0 && $_GET['option'] == 'inactif') || ($donnees_verif_ban['nbre_entrees'] >= 0 && $_GET['option'] == 'staff') || ($donnees_verif_ban['nbre_entrees'] >= 0 && $_GET['option'] == 'membre')){
	if($donnees_verif['nbre_entrees'] > 0){
	
					if($_GET['option'] == 'membre'){
					$result_get = 'Liste des membres';
					}elseif($_GET['option'] == 'banni'){
					$result_get = 'Liste des membres banni(e)s';
					}elseif($_GET['option'] == 'inactif'){
					$result_get = 'Liste des membres inactif';
					}elseif($_GET['option'] == 'staff'){
					$result_get = 'Liste du personnels';
					}?>
					<div class="titre"><i class="fa fa-users" aria-hidden="true"></i> <?php echo $result_get; ?><span class="titre-right"><a href="/admin.html">Retour à l'administration</a></span></div>
							<table id="members"  class="table table-bordered">
								<thead>
									<tr>
										<th>#</th>
										<th>Pseudo</th>
										<th>Email</th>
										<th>Inscription</th>
										<th>Activé</th>
										<th>IP</th>
										<th><center>Rang</center></th>
										<?php if($_SESSION['rank'] > 3){ ?><th>Effacé?</th><?php }else{} ?>
									</tr>
								</thead>
								<tbody>
									<?php
									if($_GET['option'] == 'membre'){
									$req = $bdd->prepare("SELECT * FROM membres ORDER BY id DESC");
									}elseif($_GET['option'] == 'banni'){
									$req = $bdd->prepare("SELECT * FROM membres WHERE rank = 0");
									}elseif($_GET['option'] == 'staff'){
									$req = $bdd->prepare("SELECT * FROM membres WHERE rank IN (3,4)");
									}elseif($_GET['option'] == 'inactif'){
									$req = $bdd->prepare("SELECT * FROM membres WHERE actif = 0");
									}
									$req->execute();
									while($row = $req->fetch()){
										
										$originalDate = $row['date'];
										$newDate = date("d-m-Y", strtotime($originalDate));
		
										?>
										<tr>
											<td><?php echo htmlspecialchars(htmlentities($row['id'])); ?></td>
											<td><?php echo '<span class="rank'.$row['rank'].'">'.$row['pseudo'].'</span>'; ?></td>
											<td><?php echo htmlspecialchars(htmlentities($row['email'])); ?></td>
											<td><?php echo htmlspecialchars(htmlentities($newDate)); ?></td>
											<td class="coulor_net"><center><?php if($row['actif'] == 1){echo "Oui";}else{echo "<span style='color:#d14836;'>Non</span>";} ?></center></td>
											
											<td><?php echo htmlspecialchars(htmlentities($row['ip'])); ?></td>
											
											<td>
											<?php if($row['rank'] == 0){
											echo '<span class="rank0">Banni(e)</span> - <a href="modifier.html?id='.htmlspecialchars(htmlentities($row['id'])).'&option='.htmlspecialchars(htmlentities($_GET['option'])).'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
											}elseif($row['rank'] == 1){
											echo '<span class="rank1">Membre</span> - <a href="modifier.html?id='.htmlspecialchars(htmlentities($row['id'])).'&option='.htmlspecialchars(htmlentities($_GET['option'])).'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
											}elseif($row['rank'] == 2){
											echo '<span class="rank2">V.I.P</span> - <a href="modifier.html?id='.htmlspecialchars(htmlentities($row['id'])).'&option='.htmlspecialchars(htmlentities($_GET['option'])).'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
											}elseif($row['rank'] == 3){
												if($_SESSION['rank'] > 3){
											echo '<span class="rank3">Modérateur</span> - <a href="modifier.html?id='.htmlspecialchars(htmlentities($row['id'])).'&option='.htmlspecialchars(htmlentities($_GET['option'])).'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
												}else{
											echo '<span class="rank3">Modérateur</span>';	
												}
											}elseif($row['rank'] == 4){
												if($_SESSION['rank'] > 3){
											echo '<span class="rank4">Administrateur</span> - <a href="modifier.html?id='.htmlspecialchars(htmlentities($row['id'])).'&option='.htmlspecialchars(htmlentities($_GET['option'])).'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
												}else{
											echo '<span class="rank4">Administrateur</span>';	
												}
											}
											?>
							 
							
							
											</td>
											<?php if($_SESSION['rank'] > 3){ ?>
											<td><a href="effacer.html?id=<?php echo htmlspecialchars(htmlentities($row['id'])); ?>&option=<?php echo htmlspecialchars(htmlentities($_GET['option'])); ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
											<?php }else{} ?> 	
										</tr>
										<?php
									}
									?>
								</tbody>
							</table>
					<script>
			$(document).ready(function(){
				$('#members').after('<div style="text-align: center;"><div id="nav" style="display: inline-block;"></div></div>');
				var rowsShown = 15;
				var rowsTotal = $('#members tbody tr').length;
				var numPages = rowsTotal/rowsShown;
				for(i = 0;i < numPages;i++) {
					var pageNum = i + 1;
					$('#nav').append('<a href="#" class="link_membres" rel="'+i+'">'+pageNum+'</a> ');
				}
				$('#members tbody tr').hide();
				$('#members tbody tr').slice(0, rowsShown).show();
				$('#nav a:first').addClass('active');
				$('#nav a').bind('click', function(){

					$('#nav a').removeClass('active');
					$(this).addClass('active');
					var currPage = $(this).attr('rel');
					var startItem = currPage * rowsShown;
					var endItem = startItem + rowsShown;
					$('#members tbody tr').css('opacity','0.0').hide().slice(startItem, endItem).
					css('display','table-row').animate({opacity:1}, 300);
				});
			});
		</script>

<?php
}else{
echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Aucun(s) membre(s) dans la base de donnée</center></div><meta http-equiv="refresh" content="2;'.$_SERVER['HTTP_REFERER'].'" />';
}}else{
echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Aucun(s) membre(s) banni(s) dans la base de donnée</center></div><meta http-equiv="refresh" content="2;'.$_SERVER['HTTP_REFERER'].'" />';
}}else{
echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Aucun(s) membre(s) inactif(s) dans la base de donnée</center></div><meta http-equiv="refresh" content="2;'.$_SERVER['HTTP_REFERER'].'" />';
}
}elseif($_SESSION['rank'] > 2 && $_GET['option'] == 'genre'){		
		$retour = $bdd->query('SELECT COUNT(*) AS nbre_entrees FROM genres WHERE id');
		$donnees_verif = $retour->fetch();
	
	if($donnees_verif['nbre_entrees'] > 0){
					if($_GET['option'] == 'genre'){
					$result_get = 'Liste des genres';
					} ?>
					<div class="titre"><i class="fa fa-film" aria-hidden="true"></i> <?php echo $result_get; ?><span class="titre-right"><a href="/admin.html">Retour à l'administration</a></span></div>
							<table id="members"  class="table table-bordered">
								<thead>
									<tr>
										<th>Genres</th>
										<th>Modifié</th>
										<?php if($_SESSION['rank'] > 3){ ?><th>Effacé?</th><?php }else{} ?>
									</tr>
								</thead>
								<tbody>
									<?php
									if($_GET['option'] == 'genre'){
									$req = $bdd->prepare("SELECT * FROM genres ORDER BY id DESC");}
									$req->execute();
									while($row = $req->fetch()){
		
										?>
										<tr>
											<td><?php echo $row['titre']; ?></td>
											<td>
											<?php
											echo '<a href="modifier.html?id='.htmlspecialchars(htmlentities($row['id'])).'&option='.htmlspecialchars(htmlentities($_GET['option'])).'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
											?>
											</td>
											<?php if($_SESSION['rank'] > 3){ ?>
											<td><a href="effacer.html?id=<?php echo htmlspecialchars(htmlentities($row['id'])); ?>&option=<?php echo htmlspecialchars(htmlentities($_GET['option'])); ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
											<?php }else{} ?> 	
										</tr>
										<?php
									}
									?>
								</tbody>
							</table>
					<script>
			$(document).ready(function(){
				$('#members').after('<div style="text-align: center;"><div id="nav" style="display: inline-block;"></div></div>');
				var rowsShown = 15;
				var rowsTotal = $('#members tbody tr').length;
				var numPages = rowsTotal/rowsShown;
				for(i = 0;i < numPages;i++) {
					var pageNum = i + 1;
					$('#nav').append('<a href="#" class="link_membres" rel="'+i+'">'+pageNum+'</a> ');
				}
				$('#members tbody tr').hide();
				$('#members tbody tr').slice(0, rowsShown).show();
				$('#nav a:first').addClass('active');
				$('#nav a').bind('click', function(){

					$('#nav a').removeClass('active');
					$(this).addClass('active');
					var currPage = $(this).attr('rel');
					var startItem = currPage * rowsShown;
					var endItem = startItem + rowsShown;
					$('#members tbody tr').css('opacity','0.0').hide().slice(startItem, endItem).
					css('display','table-row').animate({opacity:1}, 300);
				});
			});
		</script>

<?php
}else{
echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Aucun(s) genre(s) dans la base de donnée</center></div><meta http-equiv="refresh" content="2;'.$_SERVER['HTTP_REFERER'].'" />';
}
}elseif($_SESSION['rank'] > 2 && $_GET['option'] == 'commentaires'){
	$retour = $bdd->query('SELECT COUNT(*) AS nbre_entrees FROM commentaires');
	$donnees_verif = $retour->fetch();
	if($donnees_verif['nbre_entrees'] > 0){
?>



<div class="titre"><i class="fa fa-comments" aria-hidden="true"></i> Liste des commentaires<span class="titre-right"><a href="/admin.html">Retour à l'administration</a></span></div>
							<table id="members"  class="table table-bordered">
								<thead>
									<tr>
										<th>#</th>
										<th>Pseudo</th>
										<th>Film</th>
										<th>Commentaire</th>
										<th>Effacé?</th>
									</tr>
								</thead>
								<tbody>
									<?php
									
									$req = $bdd->prepare("SELECT * FROM commentaires ORDER BY id DESC");
									$req->execute();
									while($row = $req->fetch()){
									
									$req1 = $bdd->prepare("SELECT * FROM membres WHERE id = ".$row['pseudo_id']);
									$req1->execute();
									$row1 = $req1->fetch();

									$req2 = $bdd->prepare("SELECT * FROM film WHERE id = ".$row['film_id']);
									$req2->execute();
									$row2 = $req2->fetch();
		
										?>
										<tr>
											<td><?php echo htmlspecialchars(htmlentities($row['id'])); ?></td>
											<td><?php if(empty($row1['pseudo'])){ echo '<span class="rank">Inconnu</span>'; }else{ echo '<span class="rank'.$row1['rank'].'">'.$row1['pseudo'].'</span>'; } ?></td>
											<td><?php echo htmlspecialchars(htmlentities($row2['titre'])); ?></td>
											<td><?php echo htmlspecialchars(htmlentities($row['commentaire'])); ?></td>
											<td><a href="effacer.html?id=<?php echo htmlspecialchars(htmlentities($row['id'])); ?>&option=<?php echo htmlspecialchars(htmlentities($_GET['option'])); ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
										</tr>
										<?php
									}
									?>
								</tbody>
							</table>
					<script>
			$(document).ready(function(){
				$('#members').after('<div style="text-align: center;"><div id="nav" style="display: inline-block;"></div></div>');
				var rowsShown = 15;
				var rowsTotal = $('#members tbody tr').length;
				var numPages = rowsTotal/rowsShown;
				for(i = 0;i < numPages;i++) {
					var pageNum = i + 1;
					$('#nav').append('<a href="#" class="link_membres" rel="'+i+'">'+pageNum+'</a> ');
				}
				$('#members tbody tr').hide();
				$('#members tbody tr').slice(0, rowsShown).show();
				$('#nav a:first').addClass('active');
				$('#nav a').bind('click', function(){

					$('#nav a').removeClass('active');
					$(this).addClass('active');
					var currPage = $(this).attr('rel');
					var startItem = currPage * rowsShown;
					var endItem = startItem + rowsShown;
					$('#members tbody tr').css('opacity','0.0').hide().slice(startItem, endItem).
					css('display','table-row').animate({opacity:1}, 300);
				});
			});
		</script>

<?php
}else{
echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Aucun(s) commentaire(s) dans la base de donnée</center></div><meta http-equiv="refresh" content="2;'.$_SERVER['HTTP_REFERER'].'" />';
}





}elseif($_SESSION['rank'] > 2 && $_GET['option'] == 'qualite'){		
		$retour = $bdd->query('SELECT COUNT(*) AS nbre_entrees FROM qualiter WHERE id');
		$donnees_verif = $retour->fetch();
	
		if($donnees_verif['nbre_entrees'] > 0){
	
	
					if($_GET['option'] == 'qualite'){
					$result_get = 'Liste des qualitées vidéo';
					} ?>
					<div class="titre"><i class="fa fa-film" aria-hidden="true"></i> <?php echo $result_get; ?><span class="titre-right"><a href="/admin.html">Retour à l'administration</a></span></div>
							<table id="members"  class="table table-bordered">
								<thead>
									<tr>
										<th>Qualitée(s) Vidéo</th>
										<th>Modifié</th>
										<?php if($_SESSION['rank'] > 3){ ?><th>Effacé?</th><?php }else{} ?>
									</tr>
								</thead>
								<tbody>
									<?php
									if($_GET['option'] == 'qualite'){
									$req = $bdd->prepare("SELECT * FROM qualiter ORDER BY id DESC");}
									$req->execute();
									while($row = $req->fetch()){
		
										?>
										<tr>
											<td><?php echo $row['titre']; ?></td>
											<td><?php echo '<a href="modifier.html?id='.htmlspecialchars(htmlentities($row['id'])).'&option='.htmlspecialchars(htmlentities($_GET['option'])).'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>'; ?></td>
											<?php if($_SESSION['rank'] > 3){ ?>
											<td><a href="effacer.html?id=<?php echo htmlspecialchars(htmlentities($row['id'])); ?>&option=<?php echo htmlspecialchars(htmlentities($_GET['option'])); ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
											<?php }else{} ?> 	
										</tr>
										<?php
									}
									?>
								</tbody>
							</table>
					<script>
			$(document).ready(function(){
				$('#members').after('<div style="text-align: center;"><div id="nav" style="display: inline-block;"></div></div>');
				var rowsShown = 15;
				var rowsTotal = $('#members tbody tr').length;
				var numPages = rowsTotal/rowsShown;
				for(i = 0;i < numPages;i++) {
					var pageNum = i + 1;
					$('#nav').append('<a href="#" class="link_membres" rel="'+i+'">'+pageNum+'</a> ');
				}
				$('#members tbody tr').hide();
				$('#members tbody tr').slice(0, rowsShown).show();
				$('#nav a:first').addClass('active');
				$('#nav a').bind('click', function(){

					$('#nav a').removeClass('active');
					$(this).addClass('active');
					var currPage = $(this).attr('rel');
					var startItem = currPage * rowsShown;
					var endItem = startItem + rowsShown;
					$('#members tbody tr').css('opacity','0.0').hide().slice(startItem, endItem).
					css('display','table-row').animate({opacity:1}, 300);
				});
			});
		</script>

<?php
}else{
echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Aucune(s) qualitée(s) vidéo dans la base de donnée</center></div><meta http-equiv="refresh" content="2;'.$_SERVER['HTTP_REFERER'].'" />';
}
}elseif($_SESSION['rank'] > 2 && $_GET['option'] == 'film'){
$retour = $bdd->query('SELECT COUNT(*) AS nbre_entrees FROM film WHERE id');
		$donnees_verif = $retour->fetch();
	
		if($donnees_verif['nbre_entrees'] > 0){
	
	
					if($_GET['option'] == 'film'){
					$result_get = 'Liste des films ';
					} ?>
					<div class="titre"><i class="fa fa-film" aria-hidden="true"></i> <?php echo $result_get; ?><span class="titre-right"><a href="/admin.html">Retour à l'administration</a></span></div>
							<table id="members"  class="table table-bordered">
								<thead>
									<tr>
										<th>Nom du film</th>
										<th>Qualité</th>
										<th>Pending</th>
										<th>Vidéo HS</th>
										<th>Modifié</th>
										<th>Effacé?</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if($_GET['option'] == 'film'){
									$req = $bdd->prepare("SELECT * FROM film ORDER BY id DESC");}
									$req->execute();
									while($row = $req->fetch()){
		
										?>
										<tr>
											<td><a href="infos.html?pending=<?php echo $row['id']; ?>" class="monpending"><?php echo $row['titre']; ?></a></td>
											<td><?php echo $row['qualite']; ?></td>
											<td class="coulor_net"><b><?php if($row['pending'] == 0){
											echo 'Validé';
											}elseif($row['pending'] == 1){
											echo '<font color="#e67e22">En attente</font>';
											}elseif($row['pending'] == 2){
											echo '<font color="#C0392B">Non-Validé</font>';
											}elseif($row['pending'] == 3){
											echo '<font color="#e67e22">À Corrigé</font>';
											} ?></b></td>
											<td class="coulor_net"><b><?php if($row['video_hs'] != 5){
											echo 'Non';
											}elseif($row['video_hs'] == 5){
											echo '<font color="#C0392B">Oui</font>';
											} ?></b></td>
											<td><?php echo '<a href="modifier.html?id='.htmlspecialchars(htmlentities($row['id'])).'&option='.htmlspecialchars(htmlentities($_GET['option'])).'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>'; ?></td>
											<td><a href="effacer.html?id=<?php echo htmlspecialchars(htmlentities($row['id'])); ?>&option=<?php echo htmlspecialchars(htmlentities($_GET['option'])); ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
										</tr>
										<?php
									}
									?>
								</tbody>
							</table>
					<script>
			$(document).ready(function(){
				$('#members').after('<div style="text-align: center;"><div id="nav" style="display: inline-block;"></div></div>');
				var rowsShown = 15;
				var rowsTotal = $('#members tbody tr').length;
				var numPages = rowsTotal/rowsShown;
				for(i = 0;i < numPages;i++) {
					var pageNum = i + 1;
					$('#nav').append('<a href="#" class="link_membres" rel="'+i+'">'+pageNum+'</a> ');
				}
				$('#members tbody tr').hide();
				$('#members tbody tr').slice(0, rowsShown).show();
				$('#nav a:first').addClass('active');
				$('#nav a').bind('click', function(){

					$('#nav a').removeClass('active');
					$(this).addClass('active');
					var currPage = $(this).attr('rel');
					var startItem = currPage * rowsShown;
					var endItem = startItem + rowsShown;
					$('#members tbody tr').css('opacity','0.0').hide().slice(startItem, endItem).
					css('display','table-row').animate({opacity:1}, 300);
				});
			});
		</script>

<?php
}else{
echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Aucun(s) film(s) dans la base de donnée</center></div><meta http-equiv="refresh" content="2;'.$_SERVER['HTTP_REFERER'].'" />';
}
}elseif($_SESSION['rank'] > 2 && $_GET['option'] == 'exclusivite'){
$retour = $bdd->query('SELECT COUNT(*) AS nbre_entrees FROM film WHERE exclusivite');
		$donnees_verif = $retour->fetch();
	
		if($donnees_verif['nbre_entrees'] > 0){
	
	
					if($_GET['option'] == 'exclusivite'){
					$result_get = 'Liste des films (exclusivité)';
					} ?>
					<div class="titre"><i class="fa fa-film" aria-hidden="true"></i> <?php echo $result_get; ?><span class="titre-right"><a href="/admin.html">Retour à l'administration</a></span></div>
							<table id="members"  class="table table-bordered">
								<thead>
									<tr>
										<th>Nom du film</th>
										<th>Qualité</th>
										<th>Pending</th>
										<th>Vidéo HS</th>
										<th>Modifié</th>
										<th>Effacé?</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if($_GET['option'] == 'exclusivite'){
									$req = $bdd->prepare("SELECT * FROM film WHERE exclusivite = '1' ORDER BY id DESC");}
									$req->execute();
									while($row = $req->fetch()){
		
										?>
										<tr>
											<td><a href="infos.html?pending=<?php echo $row['id']; ?>" class="monpending"><?php echo $row['titre']; ?></a></td>
											<td><?php echo $row['qualite']; ?></td>
											<td class="coulor_net"><b><?php if($row['pending'] == 0){
											echo 'Validé';
											}elseif($row['pending'] == 1){
											echo '<font color="#e67e22">En attente</font>';
											}elseif($row['pending'] == 2){
											echo '<font color="#C0392B">Non-Validé</font>';
											}elseif($row['pending'] == 3){
											echo '<font color="#e67e22">À Corrigé</font>';
											} ?></b></td>
											<td class="coulor_net"><b><?php if($row['video_hs'] != 5){
											echo 'Non';
											}elseif($row['video_hs'] == 5){
											echo '<font color="#C0392B">Oui</font>';
											} ?></b></td>
											<td><?php echo '<a href="modifier.html?id='.htmlspecialchars(htmlentities($row['id'])).'&option='.htmlspecialchars(htmlentities($_GET['option'])).'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>'; ?></td>
											<td><a href="effacer.html?id=<?php echo htmlspecialchars(htmlentities($row['id'])); ?>&option=<?php echo htmlspecialchars(htmlentities($_GET['option'])); ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
										</tr>
										<?php
									}
									?>
								</tbody>
							</table>
					<script>
			$(document).ready(function(){
				$('#members').after('<div style="text-align: center;"><div id="nav" style="display: inline-block;"></div></div>');
				var rowsShown = 15;
				var rowsTotal = $('#members tbody tr').length;
				var numPages = rowsTotal/rowsShown;
				for(i = 0;i < numPages;i++) {
					var pageNum = i + 1;
					$('#nav').append('<a href="#" class="link_membres" rel="'+i+'">'+pageNum+'</a> ');
				}
				$('#members tbody tr').hide();
				$('#members tbody tr').slice(0, rowsShown).show();
				$('#nav a:first').addClass('active');
				$('#nav a').bind('click', function(){

					$('#nav a').removeClass('active');
					$(this).addClass('active');
					var currPage = $(this).attr('rel');
					var startItem = currPage * rowsShown;
					var endItem = startItem + rowsShown;
					$('#members tbody tr').css('opacity','0.0').hide().slice(startItem, endItem).
					css('display','table-row').animate({opacity:1}, 300);
				});
			});
		</script>

<?php
}else{
echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Aucun(s) film(s) en éxclusivité(s) dans la base de donnée</center></div><meta http-equiv="refresh" content="2;'.$_SERVER['HTTP_REFERER'].'" />';
}
}elseif($_SESSION['rank'] > 2 && $_GET['option'] == 'video_hs'){
$retour = $bdd->query('SELECT COUNT(*) AS nbre_entrees FROM film WHERE video_hs');
		$donnees_verif = $retour->fetch();
	
		if($donnees_verif['nbre_entrees'] > 0){
	
	
					if($_GET['option'] == 'video_hs'){
					$result_get = 'Liste des films (Vidéo HS)';
					} ?>
					<div class="titre"><i class="fa fa-film" aria-hidden="true"></i> <?php echo $result_get; ?><span class="titre-right"><a href="/admin.html">Retour à l'administration</a></span></div>
							<table id="members"  class="table table-bordered">
								<thead>
									<tr>
										<th>Nom du film</th>
										<th>Qualité</th>
										<th>Pending</th>
										<th>Vidéo HS</th>
										<th>Modifié</th>
										<th>Effacé?</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if($_GET['option'] == 'video_hs'){
									$req = $bdd->prepare("SELECT * FROM film WHERE video_hs > 0 ORDER BY id DESC");}
									$req->execute();
									while($row = $req->fetch()){
		
										?>
										<tr>
											<td><a href="infos.html?pending=<?php echo $row['id']; ?>" class="monpending"><?php echo $row['titre']; ?></a></td>
											<td><?php echo $row['qualite']; ?></td>
											<td class="coulor_net"><b><?php if($row['pending'] == 0){
											echo 'Validé';
											}elseif($row['pending'] == 1){
											echo '<font color="#e67e22">En attente</font>';
											}elseif($row['pending'] == 2){
											echo '<font color="#C0392B">Non-Validé</font>';
											}elseif($row['pending'] == 3){
											echo '<font color="#e67e22">À Corrigé</font>';
											} ?></b></td>
											<td class="coulor_net"><b><?php if($row['video_hs'] != 5){
											echo 'Non';
											}elseif($row['video_hs'] == 5){
											echo '<font color="#C0392B">Oui</font>';
											} ?></b></td>
											<td><?php echo '<a href="modifier.html?id='.htmlspecialchars(htmlentities($row['id'])).'&option='.htmlspecialchars(htmlentities($_GET['option'])).'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>'; ?></td>
											<td><a href="effacer.html?id=<?php echo htmlspecialchars(htmlentities($row['id'])); ?>&option=<?php echo htmlspecialchars(htmlentities($_GET['option'])); ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
										</tr>
										<?php
									}
									?>
								</tbody>
							</table>
					<script>
			$(document).ready(function(){
				$('#members').after('<div style="text-align: center;"><div id="nav" style="display: inline-block;"></div></div>');
				var rowsShown = 15;
				var rowsTotal = $('#members tbody tr').length;
				var numPages = rowsTotal/rowsShown;
				for(i = 0;i < numPages;i++) {
					var pageNum = i + 1;
					$('#nav').append('<a href="#" class="link_membres" rel="'+i+'">'+pageNum+'</a> ');
				}
				$('#members tbody tr').hide();
				$('#members tbody tr').slice(0, rowsShown).show();
				$('#nav a:first').addClass('active');
				$('#nav a').bind('click', function(){

					$('#nav a').removeClass('active');
					$(this).addClass('active');
					var currPage = $(this).attr('rel');
					var startItem = currPage * rowsShown;
					var endItem = startItem + rowsShown;
					$('#members tbody tr').css('opacity','0.0').hide().slice(startItem, endItem).
					css('display','table-row').animate({opacity:1}, 300);
				});
			});
		</script>

<?php
}else{
echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Aucun(s) film(s) en HS dans la base de donnée</center></div><meta http-equiv="refresh" content="2;'.$_SERVER['HTTP_REFERER'].'" />';
}
}elseif($_SESSION['rank'] > 2 && $_GET['option'] == 'pending'){
$retour = $bdd->query('SELECT COUNT(*) AS nbre_entrees FROM film WHERE pending');
		$donnees_verif = $retour->fetch();
	
		if($donnees_verif['nbre_entrees'] > 0){
	
	
					if($_GET['option'] == 'pending'){
					$result_get = 'Liste des films (Pending)';
					} ?>
					<div class="titre"><i class="fa fa-film" aria-hidden="true"></i> <?php echo $result_get; ?><span class="titre-right"><a href="/admin.html">Retour à l'administration</a></span></div>
							<table id="members"  class="table table-bordered">
								<thead>
									<tr>
										<th>Nom du film</th>
										<th>Qualité</th>
										<th>Pending</th>
										<th>Vidéo HS</th>
										<th>Modifié</th>
										<th>Effacé?</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if($_GET['option'] == 'pending'){
									$req = $bdd->prepare("SELECT * FROM film WHERE pending > 0 ORDER BY id DESC");}
									$req->execute();
									while($row = $req->fetch()){
		
										?>
										<tr>
											<td><a href="infos.html?pending=<?php echo $row['id']; ?>" class="monpending"><?php echo $row['titre']; ?></a></td>
											<td><?php echo $row['qualite']; ?></td>
											<td class="coulor_net"><b><?php if($row['pending'] == 0){
											echo 'Validé';
											}elseif($row['pending'] == 1){
											echo '<font color="#e67e22">En attente</font>';
											}elseif($row['pending'] == 2){
											echo '<font color="#C0392B">Non-Validé</font>';
											}elseif($row['pending'] == 3){
											echo '<font color="#e67e22">À Corrigé</font>';
											} ?></b></td>
											<td class="coulor_net"><b><?php if($row['video_hs'] != 5){
											echo 'Non';
											}elseif($row['video_hs'] == 5){
											echo '<font color="#C0392B">Oui</font>';
											} ?></b></td>
											<td><?php echo '<a href="modifier.html?id='.htmlspecialchars(htmlentities($row['id'])).'&option='.htmlspecialchars(htmlentities($_GET['option'])).'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>'; ?></td>
											<td><a href="effacer.html?id=<?php echo htmlspecialchars(htmlentities($row['id'])); ?>&option=<?php echo htmlspecialchars(htmlentities($_GET['option'])); ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
										</tr>
										<?php
									}
									?>
								</tbody>
							</table>
					<script>
			$(document).ready(function(){
				$('#members').after('<div style="text-align: center;"><div id="nav" style="display: inline-block;"></div></div>');
				var rowsShown = 15;
				var rowsTotal = $('#members tbody tr').length;
				var numPages = rowsTotal/rowsShown;
				for(i = 0;i < numPages;i++) {
					var pageNum = i + 1;
					$('#nav').append('<a href="#" class="link_membres" rel="'+i+'">'+pageNum+'</a> ');
				}
				$('#members tbody tr').hide();
				$('#members tbody tr').slice(0, rowsShown).show();
				$('#nav a:first').addClass('active');
				$('#nav a').bind('click', function(){

					$('#nav a').removeClass('active');
					$(this).addClass('active');
					var currPage = $(this).attr('rel');
					var startItem = currPage * rowsShown;
					var endItem = startItem + rowsShown;
					$('#members tbody tr').css('opacity','0.0').hide().slice(startItem, endItem).
					css('display','table-row').animate({opacity:1}, 300);
				});
			});
		</script>

<?php
}else{
echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Aucun(s) film(s) en pending dans la base de donnée</center></div><meta http-equiv="refresh" content="2;'.$_SERVER['HTTP_REFERER'].'" />';
}
}else{
	echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Tu t\'és perdu ?</center></div>';
}
}else{
	echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Tu t\'és perdu ?</center></div>';
}

}else{
	echo '<div id="reptoperror"><center><i class="fa fa-exclamation-triangle"></i> Tu t\'és perdu ?</center></div>';
}
} 
					?>
</div>
<?php include './system/footer.php'; ?>