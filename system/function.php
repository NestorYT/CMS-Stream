<?php
require 'config_inc.php';

function VerifierAdresseMail($email)
{
  //Adresse mail trop longue (254 octets max)
	if(strlen($email)>254)
	{
		return '<p>Votre adresse est trop longue.</p>';
	}
  //Caractères non-ASCII autorisés dans un nom de domaine .eu :

	$nonASCII='ďđēĕėęěĝğġģĥħĩīĭįıĵķĺļľŀłńņňŉŋōŏőoeŕŗřśŝsťŧ';
	$nonASCII.='ďđēĕėęěĝğġģĥħĩīĭįıĵķĺļľŀłńņňŉŋōŏőoeŕŗřśŝsťŧ';
	$nonASCII.='ũūŭůűųŵŷźżztșțΐάέήίΰαβγδεζηθικλμνξοπρςστυφ';
	$nonASCII.='χψωϊϋόύώабвгдежзийклмнопрстуфхцчшщъыьэюяt';
	$nonASCII.='ἀἁἂἃἄἅἆἇἐἑἒἓἔἕἠἡἢἣἤἥἦἧἰἱἲἳἴἵἶἷὀὁὂὃὄὅὐὑὒὓὔ';
	$nonASCII.='ὕὖὗὠὡὢὣὤὥὦὧὰάὲέὴήὶίὸόὺύὼώᾀᾁᾂᾃᾄᾅᾆᾇᾐᾑᾒᾓᾔᾕᾖᾗ';
	$nonASCII.='ᾠᾡᾢᾣᾤᾥᾦᾧᾰᾱᾲᾳᾴᾶᾷῂῃῄῆῇῐῑῒΐῖῗῠῡῢΰῤῥῦῧῲῳῴῶῷ';
  // note : 1 caractète non-ASCII vos 2 octets en UTF-8


	$syntaxe="#^[[:alnum:][:punct:]]{1,64}@[[:alnum:]-.$nonASCII]{2,253}\.[[:alpha:].]{2,6}$#";

	if(preg_match($syntaxe,$email))
	{
		return '<p>Votre adresse est valide.</p>';
	}
	else
	{
		return '<p>Votre adresse e-mail n\'est pas valide.</p>';
	}
}

function get_ip() {
	// IP si internet partagé
	if (isset($_SERVER['HTTP_CLIENT_IP'])) {
		return $_SERVER['HTTP_CLIENT_IP'];
	}
	// IP derrière un proxy
	elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		return $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	// Sinon : IP normale
	else {
		return (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
	}
}

function random($car) {
	$string = "";
	$chaine = "AZERTYUIOPQSDFGHJKLMWXCVBN123456789";
	srand((double)microtime()*1000000);
	for($i=0; $i<$car; $i++) {
		$string .= $chaine[rand()%strlen($chaine)];
	}
	return $string;
}
function format_octets($octets) {
    if($octets >= 1024 && $octets < pow(1024, 2))
        $returnstr = number_format($octets/1024, 2, ".", ",") . " Ko";
    elseif($octets >= pow(1024, 2) && $octets < pow(1024, 3))
        $returnstr = number_format($octets/pow(1024, 2), 2, ".", ",") . " Mo";
    elseif($octets >= pow(1024, 3) && $octets < pow(1024, 4))
        $returnstr = number_format($octets/pow(1024, 3), 2, ".", ",") . " Go";
    elseif($octets >= pow(1024, 4))
        $returnstr = number_format($octets/pow(1024, 4), 2, ".", ",") . " To";
    elseif($octets < 1024)
        $returnstr = $octets . " o";
    return $returnstr;
}
?>
