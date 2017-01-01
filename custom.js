$(document).ready(function() {
	
	$('.message a').click(function(){
		$('form').animate({height: "toggle", opacity: "toggle"}, "slow");
	});
	
	if (s == true)
		$('.success').fadeIn(400).delay(3000).fadeOut(400);
	
});