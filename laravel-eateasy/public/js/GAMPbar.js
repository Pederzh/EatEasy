/* definizione delle variabili per i nomi dei css */
$css_colours = "style_clean.css";
$css_font = "inc_font_style.css";
$css_desaturation = "desaturation_style.css";


//Cookies -> nome_cookie=valore_cookie; expires=data di scadenza in formato UTC; path=dominio e percorso in cui è attivo il cookie (path=/  utilizzo cookie su tutto il sito)
//CREAZIONE COOKIE
function createCookie(nomeCookie, valoreCookie, durataCookie){
	var scadenza = new Date();
	var adesso = new Date();
	scadenza.setTime(adesso.getTime() + (parseInt(durataCookie) * 60000));
	//salvataggio cookie 
	document.cookie = nomeCookie + '=' + escape(valoreCookie) + '; expires=' + scadenza.toGMTString() + '; path=/';
}

//LETTURA COOKIE
function readCookie(nomeCookie){
	var nameEQ = nomeCookie + '=';
	var strblock = document.cookie.split(';');	//divisione della stringa in blocchi separati dal ;
	for (var i = 0; i < strblock.length; i++) {
		var str = strblock[i]; 
		//analisi blocco per blocco 
		while (str.charAt(0) === ' ') {		//trim della stringa
			str = str.substring(1, str.length);
		}
		//controllo  nome_cookie sia presente 
		if (str.indexOf(nameEQ) === 0) { 
			return str.substring(nameEQ.length, str.length);
		}
	}
	return null;
}

//CANCELLARE COOKIE -> data di scadenza antecedente 
function eraseCookie(nomeCookie){
	createCookie(nomeCookie,'');
}

//INSERIMENTO FIXED BAR
$('body').prepend("<div class='fixed-action-btn vertical click-to-toggle' style='bottom: 10px; right: 10px;'><a class='btn-floating btn-large blue darken-3'><i class='large mdi-navigation-menu'></i></a><ul><li><a id='normal_style'  class='btn-floating blue darken-1 toggle-color' ><i class='material-icons'>visibility</i></a></li><li><a id='normal_saturation' class='btn-floating blue darken-1 toggle-saturation'><i class='material-icons'>invert_colors</i></a></li><li><a id='normal_font' class='btn-floating blue darken-1 toggle-font'><i class='material-icons'>sort_by_alpha</i></a></li></ul></div>");

/* FUNZIONI JAVASCRIPT */

/* CAMBIO CSS (NEGATIVO) function */
/*check Cookies */
if (readCookie("toggle-color")){
	$("head").append('<link href="/laravel-eateasy/public/css/' + $css_colours + '" type="text/css" rel="stylesheet" media="screen,projection" id="new_color_css"/>');
	$('.toggle-color').attr("id","new_style"); //cambio id button
}
/* funzione cambio del css applicata all'onclick sull'oggetto di classe toggle-color*/
$('.toggle-color').on('click', function() {                
	 if ($(this).attr("id") === "normal_style"){
		//cambio del CSS 
		$("head").append('<link href="/laravel-eateasy/public/css/' + $css_colours + '"  type="text/css" rel="stylesheet" media="screen,projection" id="new_color_css"/>');
		$(this).attr("id","new_style"); //cambio id button
		//creazione cookie 
		createCookie("toggle-color","1");
	}
	else{
		//ritorno normale 
		//eliminare cookie 
		eraseCookie("toggle-color");
		$("#new_color_css").remove();
		$(this).attr("id","normal_style");
	}
});

/* SATURAZIONE function */
/*check Cookies */
if (readCookie("toggle-saturation")){
	$("head").append('<link href="/laravel-eateasy/public/css/'+ $css_desaturation +'" type="text/css" rel="stylesheet" media="screen,projection" id="desaturated_css"/>');
	$('.toggle-saturation').attr('id','is_desaturated');
}

$('.toggle-saturation').on('click', function(){
	if($(this).attr('id') === 'normal_saturation'){
		$("head").append('<link href="/laravel-eateasy/public/css/'+ $css_desaturation +'" type="text/css" rel="stylesheet" media="screen,projection" id="desaturated_css"/>');
		$(this).attr('id','is_desaturated');
		 //creazione cookie 
		 createCookie("toggle-saturation","1");
	}
	else{
		//eliminare cookie 
		eraseCookie("toggle-saturation");
		$('#desaturated_css').remove();
		$(this).attr('id','normal_saturation');
	}      
});
	
/* FONT function */
/*check Cookies */
if (readCookie("toggle-font")){
	$("head").append('<link href="/laravel-eateasy/public/css/' + $css_font + '" type="text/css" rel="stylesheet" media="screen,projection" id="increased_font_css"/>');
	$('.toggle-font').attr('id', 'increased_font');
}

$('.toggle-font').on('click', function(){
	if($(this).attr('id') === 'normal_font'){
		$("head").append('<link href="/laravel-eateasy/public/css/' + $css_font + '" type="text/css" rel="stylesheet" media="screen,projection" id="increased_font_css"/>');
		$(this).attr('id', 'increased_font');
		//creazione cookie 
		createCookie("toggle-font","1");
	}
	else{
		//eliminare cookie 
		eraseCookie("toggle-font");
		$('#increased_font_css').remove();
		$(this).attr('id', 'normal_font'); 
	}
});
