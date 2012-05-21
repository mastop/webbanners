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
        var stateObj = { foo: "bar" };
        var url = (e.target.href).split("#")[1];
        history.pushState(stateObj, "/", url);
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
        banner = banner + '<div id="banner'+i+'">';
        banner = banner + '<input type="hidden" value="'+i+'" />';
        banner = banner + '<input class="width" id="width'+i+'" maxlength="3" name=" banner['+i+'][width] " value="728" type="number" required="required" />';
        banner = banner + '<span id="x'+i+'" class="x">x</span>';
        banner = banner + '<input class="height" id="height'+i+'" maxlength="3" name=" banner['+i+'][height] " value="90" type="number" required="required" />';
        banner = banner + 'R$ '+others.toFixed(2);
        banner = banner + ' <input class="psd" id="psd'+i+'" name=" banner['+i+'][psd] " type="checkbox" onclick="total()"/> PSD ';
        banner = banner + '+ R$ '+psd.toFixed(2);
        banner = banner + '  <a href="#" class="rm badge badge-important">-</a><BR><BR>';
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
    
});

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
