$('#Userform_email').blur(function(e) {
    var email = $(this).val();
    if(email!=""){
        $.post("http://webbanners/usuario/check",{email:email}, function(data) {
            if(data==0){
                alert("Esse e-mail já existe. Digite um e-mail válido ou faça o Login");
                $('#Userform_email').val('');
            }
    
        })
    }
});
$('#Userform_cpf').blur(function(e) {
    var cpf = $(this).val();
    if(cpf!=""){
        $.post(ajaxCPF,{cpf:cpf}, function(data) {
            if(data==0){
                alert("Já existe um cadastro com este CPF. Digite outro.");
                $('#Userform_cpf').val('');
            }
    
        })
    }
});
$('#Userformedit_email').blur(function(e) {
    
    var email = $(this).val();
    var id = $("#Userformedit_id").val();
    if(email!=""){
        $.post(ajaxPath2,{email:email,id:id}, function(data) {
            if(data==0){
                alert(emailExiste);
                $('#Userform_email').val('');
            }
    
        })
    }
});