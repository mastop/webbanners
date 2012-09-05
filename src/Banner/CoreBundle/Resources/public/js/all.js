$(function(){
    fadeIn("fade",1);
    $('.wbbody_padrao').addClass('banner'+(Math.round(Math.random() * 2)))
    $('.banner0 #header-04_').html('Fácil, prático e rápido');
    $('.banner1 #header-04_').html('Qualquer tamanho de<br><br><br>banner por <span class="big">R$</span>80,00');
    $('.banner2 #header-04_').html('Diversos pacotes com<br><br><br>banners grátis');
    $('.banner0 #header-05_').html('Crie suas campanhas de marketing digital com poucos cliques');
    $('.banner1 #header-05_').html('Ideal para sua loja virtual, seu site ou blog');
    $('.banner2 #header-05_').html('Escolha um dos pacotes prontos e ganhe até <span class="big">6</span> Banners');
    $('#abanner0').live('click',function(e){
        fadeIn("fade",1);
        $('body').addClass('banner0');
        $('body').removeClass('banner1');
        $('body').removeClass('banner2');
        $('#header-04_').html('Fácil, prático e rápido');
        $('#header-05_').html('Crie suas campanhas de marketing digital com poucos cliques');
        e.preventDefault();
    });
    $('#abanner1').live('click',function(e){
        fadeIn("fade",1);
        $('body').removeClass('banner0');
        $('body').addClass('banner1');
        $('body').removeClass('banner2');
        $('#header-04_').html('Qualquer tamanho de<br><br><br>banner por <span class="big">R$</span>80,00');
        $('#header-05_').html('Ideal para sua loja virtual, seu site ou blog');
        e.preventDefault();
    });
    $('#abanner2').live('click',function(e){
        fadeIn("fade",1);
        $('body').removeClass('banner0');
        $('body').removeClass('banner1');
        $('body').addClass('banner2');
        $('#header-04_').html('Diversos pacotes com<br><br><br>banners grátis');
        $('#header-05_').html('Escolha um dos pacotes prontos e ganhe até <span class="big">6</span> Banners');
        e.preventDefault();
    });
});

function fadeOut(id, time) {
    fade(id, time, 100, 0);
}
function fadeIn(id, time) {
    fade(id, time, 0, 100);
}
function fade(id, time, ini, fin) {
    var target = document.getElementById(id);
    var alpha = ini;
    var inc;
    target.style.opacity = 0;
    if (fin >= ini) {
        inc = 5;
    } else {
        inc = -5;
    }
    timer = (time * 1000) / 50;
    var i = setInterval(
        function() {
            if ((inc > 0 && alpha >= fin) || (inc < 0 && alpha <= fin)) {
                clearInterval(i);
            }
            setAlpha(target, alpha);
            alpha += inc;
        }, timer);
}
function setAlpha(target, alpha) {
    target.style.filter = "alpha(opacity="+ alpha +")";
    target.style.opacity = alpha/100;
}