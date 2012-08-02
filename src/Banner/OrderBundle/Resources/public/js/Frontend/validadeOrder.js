$(function(){

$('#order_cupom').blur(function(e) {
    var cupom = $(this).val();
    if(cupom!=""  && cupom.substr(0,4) !="PACK"){
        $.post("https://webbanners/desconto/check",{cupom:cupom}, function(data) {
            if(data==0){
                alert("Esse cupom não existe. Favor conferir.");
                $('#order_cupom').val('');
                $('#desconto').html('');
            }else{
                $('#desconto').html('Desconto: '+ (parseFloat(data)).toFixed(2));
            }
    
        })
    }else{
        $('#order_cupom').val('');
        $('#desconto').html('');
    }
});

});