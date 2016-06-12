$(document).ready(function(){
	$('#recherche').keyup(function(){
	var recherche = $(this).val();
	var data = 'now=' + recherche;
	if(recherche.length>3){

		$.ajax({
		type : 'GET',
		url : 'ajax.html',
		data : data,
		success: function(server_response){

			$('#resultat').html(server_response).show();
		}
		});
	}else{
			$('#resultat').hide();
	}
	});
});