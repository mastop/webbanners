$(function(){
    function formatResult(row) {
		return row[1].replace(/(<.+?>)/gi, '');
	}
        function formatItem(row) {
		return row[0] +  row[1] ;
	}
    $('#banner_user').autocomplete(ajaxPath,{});
    $('#banner_user').focus(function(){
        $('#banner_user').val('');
    });
    $("#banner_user").result(function(event, data, formatted) {
        $('#userName').html(data[0]);
        $("#bannerEnviar").addClass('hidden');
    });
});