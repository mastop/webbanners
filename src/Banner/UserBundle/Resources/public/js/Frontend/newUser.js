$('#Userform_email').blur(function(e) {
    var email = $(this).val();
    if(email!=""){
        $.post("https://webbanners/usuario/check",{email:email}, function(data) {
            if(data==0){
                alert("Esse e-mail já existe. Faça o Login para fazer um pedido.");
                $('#Userform_email').val('');
                window.location ="https://webbanners/login";
            }
    
        })
    }
});