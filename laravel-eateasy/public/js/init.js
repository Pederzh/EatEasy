$( document ).ready(function() {
	
	/* menu dropdown della navbar */
	$(".dropdown-button").dropdown({
		belowOrigin: true
	});

	/* menu a tendina negli schermi med-and-down */
	$(".button-collapse").sideNav();
	
	/* caricamento delle select */
	$("select").material_select();

	/* slider */
	$(".slider").slider({
		indicators: false
	});
	
	/* datepicker */
	$(".datepicker").pickadate({
		selectMonths: true,		// Creates a dropdown to control month
		selectYears: 200,		// Creates a dropdown of 200 years to control year
        format:'yyyy-mm-dd'	// Date format
	});

	/* carousel immagini */
	$('.carousel').carousel();
	$('.carousel').carousel();
	//Visualizzare modal con info domande
	$(function(){
    	// the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    	$('.modal-trigger').leanModal();
	});

    /*_____AUTOCOMPLETE____________*/    
     /*
   $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });*/
    
    $( "#comune" ).autocomplete({
        minLength:3, 
        autoFocus: true,
        source: 'getdata', 
        select: function(event, ui) {
            $('#comune').val(ui.item.value);
        }
    });

});