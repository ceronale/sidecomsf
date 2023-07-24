$(document).ready(function(){
	$('ul.tabs li a:first').addClass('active');
	$('.secciones article').hide();
	$('.secciones article:first').show();
	dselect(document.querySelector('#relacionesInternas'), {
		search: true,
		multiple: true
	})
	dselect(document.querySelector('#relacionesExternas'), {
		search: true,
		multiple: true
	})
	$('ul.tabs li a').click(function(){
		$('ul.tabs li a').removeClass('active');
		$(this).addClass('active');
		$('.secciones article').hide();

		var activeTab = $(this).attr('href');
		$(activeTab).show();
		return false;
	});
});