$(function(){
    $("#novo").click(function(){
        var banner = '';
        var max = parseInt(document.getElementById("maxBanner").value);
        var total = 0;
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
        banner = banner + '<input class="psd" id="psd'+i+'" name=" banner['+i+'][psd] " type="checkbox"/> PSD + ';
        banner = banner + '<a href="#" onclick="remove('+i+')" class="btn btn-danger rm" >-</a><BR><BR>';
        banner = banner + '</div>';
        $('#newBanner').append(banner);
        total = parseInt(document.getElementById("order_quantity").value) + 1;
        document.getElementById("order_quantity").value = total;
        if(total>(max-1)){
            $('#btnnew').hide();
        }
         
    });
});

function remove(id){
    var banner = document.getElementById("banner"+id);
    var total = 0;
    var max = parseInt(document.getElementById("maxBanner").nodeValue);
    banner.parentNode.removeChild(banner);          
    total = document.getElementById("order_quantity").value-1;
    if(total<max){
        $('#btnnew').show();
    }
    document.getElementById("order_quantity").value = total;
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

function fechar(upload) { document.getElementById(upload).style.visibility = "hidden"; }

function abrir(upload) {
    document.getElementById(upload).style.visibility="visible";
}

function SaveFile(fname){
    img.document.execCommand('saveas', null ,fname)
}
