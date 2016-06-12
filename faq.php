<?php require './system/config_inc.php';

$namePage = 'F.A.Q';

	$req = $bdd->prepare("SELECT * FROM core WHERE id = :id");
					$req->execute(array(
						'id' => 1));
					$row_core = $req->fetch();

	if($row_core['maintenance'] == 1 && $_SESSION['rank'] < 3){

		include './system/maintenance.php';

	}else{ 
			
?>
<?php include 'system/header.php'; ?>

<div class="wrap">

			<div class="clear"></div>
<div class="titre"><i class="fa fa-question-circle" aria-hidden="true"></i>  F.A.Q : Blocage des pubs pour les videos<span class="titre-right"><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">retour</a></span></div>
<p style="font-size: 12px;">Pour évité les pubs des vidéos sur le site.<br>
<br>
Installer cette éxtension pour votre navigateur : <a href="https://adblockplus.org/fr/">https://adblockplus.org/fr</a><br>
<br>
Cela vous permettra de ne plus avoir de pubs et de lancé directement la vidéo.<br>
C'est gratuit et fonctionne parfaitement bien.</p>

<div class="titre"><i class="fa fa-question-circle" aria-hidden="true"></i> F.A.Q : L'inscription</div>
<p style="font-size: 12px;">L'inscription est gratuite et n'est pas obligatoire.<br>
<br>
Elle vous permet :<br>
- D'ajouter des films sur le site<br>
- D'ajouter des commentaires sur les fiches des films<br>
<br>
Néanmoins une validation par mail vous sera envoyée, regarder vos SPAMS si vous ne la trouvé pas.<br>
Vous avez aussi la possibilité de vous faire renvoyé ce mail.</p>

<div class="titre"><i class="fa fa-question-circle" aria-hidden="true"></i> F.A.Q : L'ajout de film</div>
<p style="font-size: 12px;">1 - Pour la sélection des GENRES, seul le premier GENRE est obligatoire.<br>
<br>
2 - Pour le numero de la vidéo, voici quoi rentrer :<br>
<br>
<img src="http://image.prntscr.com/image/6630c0d45748491c9c2eca091c6cec77.png"><br>
<img src="http://image.prntscr.com/image/a77eabc29ec34fd0acad21b1015086da.png"><br>
<img src="http://image.prntscr.com/image/db69a66754b444b2aeaa9acbd627b48b.png"><br>
<br>
Et ainsi de suite pour les autres hébergeurs<br>
<br>
3 - Une fois votre film envoyé, il sera placé en PENDING.<br>
Ou il sera validé sous 24h par notre équipe.
</p>

<div class="titre"><i class="fa fa-question-circle" aria-hidden="true"></i> F.A.Q : Vidéo HS</div>
<p style="font-size: 12px;">Un bouton VIDEO HS est disponible en dessous de chaque affiche de film.<br>
Il vous permettra de déclarer si la vidéo du film fonctionne toujours ou pas.<br>
Arrivé à 5 signalements, le film est déclassé du site et ne sera remis qu'une fois le problème réglé.
</p>

<div class="titre"><i class="fa fa-question-circle" aria-hidden="true"></i> F.A.Q : Les rangs</div>
<p style="font-size: 12px;">
<span class="rank4">Administrateur</span><br>
<span class="rank3">Modérateur</span><br>
<span class="rank2">V.I.P</span><br>
<span class="rank1">Membre</span><br>
<span class="rank0">Banni(e)</span>
</p>

<div class="titre"><i class="fa fa-question-circle" aria-hidden="true"></i> F.A.Q : Upload de vidéo</div>
<p style="font-size: 12px;">
Voici la liste des hebergeurs vidéos compatible avec MoDz-Stream :<br>
<br>
<a href="http://vidto.me/">http://vidto.me/</a><br>
<a href="http://streamin.to/">http://streamin.to/</a><br>
<a href="http://videomega.tv/">http://videomega.tv/</a><br>
<a href="http://vid.ag/">http://vid.ag/</a><br>
<a href="http://allvid.ch/">http://allvid.ch/</a>
</p>

<div class="titre"><i class="fa fa-question-circle" aria-hidden="true"></i> F.A.Q : Commentaires</div>
<p style="font-size: 12px;">
Voici la liste d'un BAN définitif du site pour un commentaire :<br>
<br>
- Insulte(s)<br>
- Pub(s)<br>
- Tous propos déplacé ,raciste ,ou qui n'a rien à faire ici<br>
<br>
Cette décision est irrèversible.
</p>

<div class="clear"></div>
</div>
<?php include 'system/footer.php'; 
 } ?>