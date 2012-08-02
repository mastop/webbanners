$(function(){
    
    $('#pedidobanner').submit(function(){
        var checked = false;
        var elems = document.getElementsByName("pacote");
        if(elems.length > 0){
            // vamos percorrer os elementos encontrados
            for(var i = 0; i < elems.length; i++){
                // vamos verificar se este radio button está selecionado
                if(elems[i].checked){
                    checked = true;
                }
            }
        }
        if(checked != true){
            if($('#width0').val() == ''){
                document.getElementById('width0').style.backgroundColor = '#FF0000';
            }
            if($('#height0').val() == ''){
                document.getElementById('height0').style.backgroundColor = '#FF0000';
            }
            var top = $('#pack1').position().top;
            $(window).scrollTop( top );
            $('#0').popover({title:"Tamanho dos banners", content: "Digite um tamanho de banner ou selecione algum dos pacotes.", type:"warning"})
            $('#0').popover('show');
            if($('#height0').val() == '' && $('#width0').val() == ''){
                return false;
            }
        }
        return true;
    });
    $('a[rel*=facebox]').facebox();
    $("a.rm").live("click", function(e){
        $(this).parent().remove();
        var i = 0;
        var total = 0;
        var max = parseInt(document.getElementById("maxBanner").value);  

        for (i = 0 ; i < max ; i++) {
            if(i==0){   
                if(document.getElementById("width"+i)){
                    total = total + first;
                }
            }
            else 
            {
                if(document.getElementById("width"+i)){
                    total = total + others;
                }
            }
            if (document.getElementById("psd"+i) != undefined){
                if (document.getElementById('psd'+i).checked == true){
                    total = total + psd;
                }
            }
        }
        document.getElementById("order_total").value = total.toFixed(2);
        e.preventDefault();

    });
    $("a.rmupload").live("click", function(e){ 
        $(this).parent().parent().remove();
        e.preventDefault();
    }); 
    $("a.guide").live("click", function(e){
        var stateObj = {foo: "bar"};
        var qtde = e.target.id;
        var first = (e.target.href).split("#")[1];
        var url = (e.target.href).split("/");
        if(parseInt(qtde) == parseInt(url.length)){
            first = url[(qtde-1)].split("#")[0]+"/"+first;
        }
        history.pushState(stateObj, "/", first);
        e.preventDefault();
    });
    
    $("input.ling").live("change", function(e){
        var max = parseInt(document.getElementById("maxLing").value);
        var i = 0;
        var j = 0;
        for (i = 0 ; i < max ; i++) {
            if (document.getElementById("ling["+i+"]") != undefined){
                if(document.getElementById("ling["+i+"]").value != ""){
                    document.getElementById("ling["+i+"]").style.visibility = "hidden";
                    var html = document.getElementById("ling["+i+"]").value;
                    if(html != ""){
                            $("#ling"+i).html(html);
                    }
                }else{
                    j=0;
                }
            }else{
                if(j!=1){
                    var image = '<div id="ling_file'+i+'"><spam id="ling'+i+'"></spam><input id="ling['+i+']" class="ling" type="file" name="ling['+i+']"><br /></div>';
                    $('#ling').append(image);
                    j=1;
                }
            }
        }
        e.preventDefault();
    });

    $("input.banner").live("change", function(e){
        var max = parseInt(document.getElementById("maxPreview").value);
        var i = 0;
        var j = 0;
        for (i = 0 ; i < max ; i++) {
            if (document.getElementById("banner["+i+"]") != undefined){
                if(document.getElementById("banner["+i+"]").value != ""){
                    document.getElementById("banner["+i+"]").style.visibility = "hidden";
                    var html = document.getElementById("banner["+i+"]").value;
                    if(html != ""){
                            $("#banner"+i).html(html);
                    }
                }else{
                    j=0;
                }
            }else{
                if(j!=1){
                    var image = '<div id="banner_file'+i+'"><spam id="banner'+i+'"></spam><input id="banner['+i+']" class="banner" type="file" name="banner['+i+']"><br /></div>';
                    $('#banner').append(image);
                    j=1;
                }
            }
        }
        e.preventDefault();
        });
    $("input.upload").live("change", function(e){
        var max = parseFloat(document.getElementById("maxUpload").value);
        var i = 0;
        var j = 0;
        for (i = 0 ; i < max ; i++) {
            if (document.getElementById("upload_file["+i+"]") != undefined){
                if(document.getElementById("upload_file["+i+"]").value != ""){
                    document.getElementById("upload_file["+i+"]").style.visibility = "hidden";
                    var html = document.getElementById("upload_file["+i+"]").value;
                    if(html != ""){
                            html = html + "  <a href='#' class='rmupload badge badge-important'>x</a>";
                            $("#upload"+i).html(html);
                    }
                }else{
                    j=0;
                }
            }else{
                if(j!=1){
                    var image = '<div id="upload_file'+i+'"><spam id="upload'+i+'"></spam><input id="upload_file['+i+']" class="upload" type="file" name="upload['+i+']"><br /></div>';
                    $('#upload').append(image);
                    j=1;
                }
            }
        }
        e.preventDefault();
    });
    $("#novo").click(function(e){
        if( document.getElementById("width0").value  != '' && document.getElementById("height0").value != ''){
            var banner = '';
            var max = parseInt(document.getElementById("maxBanner").value);
            var total = 0;
            for (i = 0 ; i < max ; i++) {
                if (document.getElementById("width"+i) == undefined){
                    break;
                }
            }

            banner = banner + '<div id="banner'+i+'" class="span6">'
            banner = banner + '    <input type="hidden" value="0" />'
            banner = banner + '    <input class="width soma" id="width'+i+'" name=" banner['+i+'][width] " maxlength="3" type="text" required="required" />'
            banner = banner + '    <span class="x">x</span>'
            banner = banner + '    <input class="height soma" id="height'+i+'" name=" banner['+i+'][height] " maxlength="3" type="text" required="required"/>'
            banner = banner + '    <ul class="nav nav-pills banner">'
            banner = banner + '        <li class="dropdown" id="menu1">'
            banner = banner + '            <a href="#" class="selectButton" id="'+i+'" data-toggle="dropdown" href="#menu1"><b class="caret"></b></a>'
            banner = banner + '            <ul id="size'+i+'" class="size dropdown-menu">'
            banner = banner + '            </ul>'
            banner = banner + '        </li>'
            banner = banner + '    </ul>'
            banner = banner + '<span class="price">  R$ '+others.toFixed(2)+'</span>';
            banner = banner + '    <input class="psd soma" id="psd'+i+'" name=" banner['+i+'][psd] " type="checkbox"/> PSD'
            banner = banner + ' <span class="price"> + R$ '+psd.toFixed(2)+'</span>';
            banner = banner + ' <a href="#" class="badge badge-warning rm">-</a>'
            banner = banner + ' <input class="value" id="value'+i+'" name=" banner['+i+'][value] " type="hidden" value="'+others.toFixed(2)+'" />'
            banner = banner + '    <br />'
            banner = banner + '    <br />'
            banner = banner + '</div>'
            $('#newBanner').append(banner);
            total = parseInt(document.getElementById("order_quantity").value) + 1;
            document.getElementById("order_quantity").value = total;
            if(total>(max-1)){
                $('#btnnew').hide();
            }
        }else{
            alert("Adicione um valor para o primeiro banner.");
        }
        e.preventDefault();
    });
     $("input.just").live("change", function(e){
        var id = e.target.id;
        if(document.getElementById("just('"+id+"')") == undefined){
            var justific = "Justificativa: <textarea id=just('"+id+"') name='just["+id+"]' required='required'></textarea> <br />" ;
            $('#just'+id).append(justific);
        }
        e.preventDefault();
    });
     $("input.rmjust").live("change", function(e){
        var id = e.target.id;
        if(document.getElementById("just"+id) != undefined){
            $('#just'+id).html("");
        }  
        e.preventDefault();
     });
     $("a.link-size").live("click", function(e){
        var id = $(this).attr("id");
        var value = $(this).parent().attr("id");
        var size = value.split('x');
        document.getElementById("width"+id).value = size[0];
        document.getElementById("height"+id).value = size[1];
        document.getElementById("width"+id).style.backgroundColor = "#FFF";
        document.getElementById("height"+id).style.backgroundColor = "#FFF";
        e.preventDefault();
     });
     $("a.selectButton").live("mouseover", function(e){
        var id = $(this).attr("id");
        var size = $("#size").html();    
        var pos = size.indexOf('NUM');   
        while (pos > -1){
            size = size.replace('NUM',id);
            pos = size.indexOf('NUM');
	}
        if($("#size"+id).html().replace(/^\s+|\s+$/g,"") == ""){ 
            $("#size"+id).append(size);
        }
        e.preventDefault();
     });
    $(".pacote").live("click", function(e){
        var elems = document.getElementsByName("pacote");
        for(var i = 0; i < elems.length; i++){
            // vamos verificar se este radio button está selecionado
            if(elems[i].checked){
                document.getElementById("packpsd["+(i+1)+"]").removeAttribute("readonly");
            }
            else 
            {
                document.getElementById("packpsd["+(i+1)+"]").setAttribute('readonly','readonly');
            }
        }
    });
    $(".nostyle").live("click", function(e){
        e.preventDefault();
    });
    $(".soma").live("click change", function(e){
        var max = parseInt(document.getElementById("maxBanner").value);
        var total = 0;
        var value = 0;
        var qtd = 0;

        for (i = 0 ; i < max ; i++) {
            if(document.getElementById("width"+i)){
                if(document.getElementById("width"+i).value != "" && document.getElementById("height"+i).value != ""){
                    if (document.getElementById("width"+i).getAttribute("readonly") != "readonly"){
                        if(i==0){  
                                total = total + first;
                                value = first;
                        }
                        else 
                        {
                            total = total + others;
                            value = others;
                        }
                        if (document.getElementById("psd"+i) != undefined){
                            if (document.getElementById("psd"+i).checked == true){
                                    total = total + psd;
                                    value = value + psd;
                            }
                        }
                    }
                    qtd += 1;
                }
            }
            if (document.getElementById("value"+i) != undefined){
                document.getElementById("value"+i).value = value.toFixed(2);
            }
        }
        
        var value = 0;
        var elems = document.getElementsByName("pacote");
        if(elems.length > 0){
            // vamos percorrer os elementos encontrados
            for(var i = 0; i < elems.length; i++){
                // vamos verificar se este radio button está selecionado
                if(elems[i].checked){
                    value = i+1;
                }
            }
            if(value == 1){
                total = total + 174;
                qtd += 3;
                if(document.getElementById("packpsd[1]").checked == true){
                    total = total + (3*psd);
                }
            }
            if(value == 2){
                total = total + 240;
                qtd += 5;
                if(document.getElementById("packpsd[2]").checked == true){
                    total = total + (5*psd);
                }
            }
            if(value == 3){
                total = total + 320;
                qtd += 7;
                if(document.getElementById("packpsd[3]").checked == true){
                    total = total + (7*psd);
                }
            }
            if(value == 4){
                total = total + 400;
                qtd += 9;
                if(document.getElementById("packpsd[4]").checked == true){
                    total = total + (9*psd);
                }
            }
            if(value == 5){
                total = total + 480;
                qtd += 11;
                if(document.getElementById("packpsd[5]").checked == true){
                    total = total + (11*psd);
                }
            }
            if(value == 6){
                total = total + 560;
                qtd += 13;
                if(document.getElementById("packpsd[6]").checked == true){
                    total = total + (13*psd);
                }
            }
        }
        if (document.getElementById("order_rush").checked == true){   
            total = total + (qtd*rush);
       }
        var cupom = document.getElementById("order_cupom").value;
        if(cupom!=""){
            $.post("https://webbanners/desconto/check",{cupom:cupom}, function(data) {
                total = total - parseFloat(data);
               if(total > 0){
                    $("#order_total").val(total.toFixed(2));
                }else{
                    $("#order_total").val((0).toFixed(2));
                }  
            })
        }else{
            if(total > 0){
                $("#order_total").val(total.toFixed(2));
            }else{
                $("#order_total").val((0).toFixed(2));
            }
        }
    });
    
});



