jQuery(function($){

	$('.kd_social_share').find('a').not('.email').on('click',function(e){

		window.open( $(this).attr('href'), '_blank', 'left=50,top=50,width=500,height=400,toolbar=0,location=0,menubar=0' );
		e.preventDefault();

	});

});