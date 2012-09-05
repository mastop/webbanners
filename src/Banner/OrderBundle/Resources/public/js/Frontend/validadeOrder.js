$(function(){

$('#order_cupom').blur(function(e) {
    var cupom = $(this).val();
    if(cupom!=""  && cupom.substr(0,4) !="PACK"){
        $.post("https://webbanners/desconto/check",{cupom:cupom}, function(data) {
            if(data==0){
                $(this).val('');
                $('#desconto').html('Esse cupom não existe. Favor conferir.');
            }else{
                $('#desconto').html('Desconto: '+ (parseFloat(data)).toFixed(2));
            }

        })
    }else{
        $(this).val('');
        $('#desconto').html('Digite um cupom válido.');
    }
});

});