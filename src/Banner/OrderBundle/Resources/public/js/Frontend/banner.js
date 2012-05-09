$(function(){
    $("#novo").click(function(){
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
        banner = banner + '<div id="banner'+i+'">';
        banner = banner + '<input type="hidden" value="'+i+'" />';
        banner = banner + '<input class="width" id="width'+i+'" maxlength="3" name=" banner['+i+'][width] " value="728" type="number" required="required" />';
        banner = banner + '<span id="x'+i+'" class="x">x</span>';
        banner = banner + '<input class="height" id="height'+i+'" maxlength="3" name=" banner['+i+'][height] " value="90" type="number" required="required" />';
        banner = banner + 'R$ '+others.toFixed(2);
        banner = banner + ' <input class="psd" id="psd'+i+'" name=" banner['+i+'][psd] " type="checkbox" onclick="total()"/> PSD ';
        banner = banner + '+ R$ '+psd.toFixed(2);
        banner = banner + '<a href="#" onclick="remove('+i+')" class="btn btn-danger rm" >-</a><BR><BR>';
        banner = banner + '</div>';
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
    });
});

function remove(id){
    var banner = document.getElementById("banner"+id);
    var total = 0;
    var max = parseInt(document.getElementById("maxBanner").value);    
    banner.parentNode.removeChild(banner);          
    total = document.getElementById("order_quantity").value-1;
    if(total<max){
        $('#btnnew').show();
    }
    document.getElementById("order_quantity").value = total;

    total = 0;
    var i = 0;
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
};    

function upload(){
    var caminho = document.getElementById("upload_file");
    var i = 0;
    while(true){
        if (document.getElementById("upload_file["+i+"]") == undefined){
            if (document.getElementById("upload_file["+(i-1)+"]").value != ""){
                var image = '<input id="upload_file['+i+']" type="file" onchange="upload()" name="upload['+i+']"><br />';
                $('#upload').append(image);
            }
            break;
        }
        i++;
    }
};

function just(id){
    if(document.getElementById("just('"+id+"')") == undefined){
        var justific = "Justificativa: <textarea id=just('"+id+"') name='just["+id+"]' required='required'></textarea> <br />" ;
        $('#just'+id).append(justific);
    }
};

function rmjust(id){
    if(document.getElementById("just"+id) != undefined){
        $('#just'+id).html("");
    }
};

function banner(){
    var max = parseInt(document.getElementById("maxPreview").value);
    for (i = 0 ; i < max ; i++) {
        if (document.getElementById("banner"+i) == undefined){
            break;
        }
    }
    var i = 0;
    while(i<max){
        if (document.getElementById("banner["+i+"]") == undefined){
            if (document.getElementById("banner["+(i-1)+"]").value != ""){
                var image = '<input id="banner['+i+']" type="file" onchange="banner()" name="banner['+i+']"><br />';
                $('#banner').append(image);
            }
            break;
        }
        i++;
    }
};

function ling(){
    var max = parseInt(document.getElementById("maxLing").value);
    for (i = 0 ; i < max ; i++) {
        if (document.getElementById("ling["+i+"]") == undefined){
            break;
        }
    }
    var i = 0;
    while(i<max){
        if (document.getElementById("ling["+i+"]") == undefined){
            if (document.getElementById("ling["+(i-1)+"]").value != ""){
                var image = '<input id="ling['+i+']" type="file" onchange="ling()" name="ling['+i+']"><br />';
                $('#ling').append(image);'{{i}}'
            }
            break;
        }
        i++;
    }
};

function fechar(upload) {document.getElementById(upload).style.visibility = "hidden";}

function abrir(upload) {
    document.getElementById(upload).style.visibility="visible";
}

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
