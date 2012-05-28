$(function(){
    $('a[rel*=facebox]').facebox() 
    $("a.rm").live("click", function(e){
        $(this).parent().remove();
        var i = 0;
        var psd = parseFloat(document.getElementById("PSDBanner").firstChild.nodeValue);
        var others = parseFloat(document.getElementById("othersBanner").firstChild.nodeValue);
        var first = parseFloat(document.getElementById("firstBanner").firstChild.nodeValue);
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
        var nodes = document.ATTRIBUTE_NODE;
        var stateObj = {foo: "bar"};
        var first = url[qtde].split("#")[0];
        var url = (e.target.href).split("/");
        var qtde = e.target.id;
        alert(parseInt(qtde) == url.length);
        if(parseInt(qtde) == url.length){
            url = (url[0]).split("/")[0]+"/"+url[1];
        }
        history.pushState(stateObj, "/", url);
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
        var max = parseFloat(document.getElementById("maxUpload").firstChild.nodeValue);
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
        var banner = '';
        var max = parseInt(document.getElementById("maxBanner").value);
        var total = 0;
        var others = parseFloat(document.getElementById("othersBanner").firstChild.nodeValue);
        var psd = parseFloat(document.getElementById("PSDBanner").firstChild.nodeValue);
        for (i = 0 ; i < max ; i++) {
            if (document.getElementById("width"+i) == undefined){
                break;
            }
        }
        
        banner = banner + '<div id="banner{{i}}" class="span6">'
        banner = banner + '    <input type="hidden" value="0" />'
        banner = banner + '    <input class="width" id="width'+i+'" name=" banner['+i+'][width] " maxlength="3" value="728" type="number" required="required" />'
        banner = banner + '    <span class="x">x</span>'
        banner = banner + '    <input class="height" id="height'+i+'" name=" banner['+i+'][height] " maxlength="3" value="60" type="number" required="required"/>'
        banner = banner + '    <ul class="nav nav-pills banner">'
        banner = banner + '        <li class="dropdown" id="menu1">'
        banner = banner + '            <a href="#" class="selectButton" id="'+i+'" data-toggle="dropdown" href="#menu1"><b class="caret"></b></a>'
        banner = banner + '            <ul id="size'+i+'" class="size dropdown-menu">'
        banner = banner + '            </ul>'
        banner = banner + '        </li>'
        banner = banner + '    </ul>'
        banner = banner + 'R$ '+others.toFixed(2);
        banner = banner + '    <input class="psd" id="psd{{i}}" name=" banner['+i+'][psd] " type="checkbox" onclick="total()"/> PSD'
        banner = banner + ' + R$ '+psd.toFixed(2);
        banner = banner + '    <br />'
        banner = banner + '    <br />'
        banner = banner + '</div>'
        $('#newBanner').append(banner);
        total = parseInt(document.getElementById("order_quantity").value) + 1;
        document.getElementById("order_quantity").value = total;
        if(total>(max-1)){
            $('#btnnew').hide();
        }
        total = 0;
        i = 0
        var first = parseFloat(document.getElementById("firstBanner").firstChild.nodeValue);
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
     $("input.just").live("change", function(e){
        var id = e.target.id;
        if(document.getElementById("just('"+id+"')") == undefined){
            var justific = "Justificativa: <textarea id=just('"+id+"') name='just["+id+"]' required='required'></textarea> <br />" ;
            $('#just'+id).append(justific);
        }
    });
     $("input.rmjust").live("change", function(e){
        var id = e.target.id;
        if(document.getElementById("just"+id) != undefined){
            $('#just'+id).html("");
        }  
     });
     $("a.link-size").live("click", function(e){
        var id = $(this).attr("id");
        var value = $(this).parent().attr("id");
        var size = value.split('x');
        document.getElementById("width"+id).value = size[0];
        document.getElementById("height"+id).value = size[1];
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
    
});


function total(){
    var max = parseInt(document.getElementById("maxBanner").value);
    var total = 0;
    var psd = parseFloat(document.getElementById("PSDBanner").firstChild.nodeValue);
    var others = parseFloat(document.getElementById("othersBanner").firstChild.nodeValue);
    var first = parseFloat(document.getElementById("firstBanner").firstChild.nodeValue);

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
}
