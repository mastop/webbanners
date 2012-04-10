// usage: log('inside coolFunc', this, arguments);
// paulirish.com/2009/log-a-lightweight-wrapper-for-consolelog/
window.log = function(){
  log.history = log.history || [];   // store logs to an array for reference
  log.history.push(arguments);
  if(this.console) {
    arguments.callee = arguments.callee.caller;
    var newarr = [].slice.call(arguments);
    (typeof console.log === 'object' ? log.apply.call(console.log, console, newarr) : console.log.apply(console, newarr));
  }
};

// make it safe to use console.log always
(function(b){function c(){}for(var d="assert,clear,count,debug,dir,dirxml,error,exception,firebug,group,groupCollapsed,groupEnd,info,log,memoryProfile,memoryProfileEnd,profile,profileEnd,table,time,timeEnd,timeStamp,trace,warn".split(","),a;a=d.pop();){b[a]=b[a]||c}})((function(){try
{console.log();return window.console;}catch(err){return window.console={};}})());


// place any jQuery/helper plugins in here, instead of separate, slower script files.


// Tooltips
$("a[rel=tooltip]").tooltip();
// Popovers
$("a[rel=popover]").popover({offset: 10});
// Alerts
$(".alert-message").alert();





$(function(){
    // Todos os alertas são exibidos após o carregamento da página
    $('.alert').slideDown('slow');
    $('#topNL').slideDown('slow');
    // Ao clicar no "fechar" do alerta, remove o mesmo do DOM
    $(".closeAlert").click(function (e) {
        $(this).parent().parent().parent().slideUp('slow', function(){
            $(this).remove();
        });
        e.preventDefault();
        return false;
    });
    $("#closeNL").click(function (e) {
        $(this).parent().parent().parent().slideUp('slow', function(){
            $(this).remove();
            $.cookie('hideNL', '1', {
                expires: 1, 
                path: '/'
            });
        });
        e.preventDefault();
        return false;
    });
    // Validação do form topo
    $("#formNL").submit(function() {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        var email = $('#mailNL').val();
        if(email == '' || email == 'Digite seu email'){
            alert('Digite um e-mail');
            $('#mailNL').addClass("errorField").focus();
            return false;
        }else if(!emailReg.test(email)) {
            alert('Digite um e-mail VÁLIDO');
            $('#mailNL').addClass("errorField").focus();
            return false;
        }
        return true;
    });
    // Validação do form busca
    $("#searchForm").submit(function() {
        var q = $('#q');
        var term = q.val();
        if(term == '' || term == 'Encontre cupons de compra coletiva'){
            q.focus();
            q.pulse({
                backgroundColor: ['#F00', '#FFF']
            }, 100, 1, 'linear', function(){
                $(this).css('background-color', '');
                $(this).addClass("errorField");
            });
            return false;
        }
        return true;
    });
    // Todos os selects com class "chzn-select" são ransformados em "chosen" (plugin jquery)
    $("select.chzn-select").chosen();
    // Facebook (só funciona se tem um div com id "fb-root" na página
    var e = document.createElement('script');
    e.async = true;
    e.src = document.location.protocol + '//connect.facebook.net/pt_BR/all.js';
    $('#fb-root').append(e);
    $(".fbLoginBtn").click(function (e) {
        fblogin();
        e.preventDefault();
        return false;
    });
    // Combo e Lista de Cidades
    $("#cityCombo a, #closeCities").click(function (e) {
        $('#listCities').slideToggle();
        if ( $('#listCities').is(':visible')){
            $('html,body').animate({
                scrollTop: $("#cityCombo").offset().top
            },'slow');
        }
        e.preventDefault();
        return false;
    });
    // Hover para ofertas
    $("div.deal").live("mouseover mouseout", function(e) {
        if ( e.type == "mouseover" ) {
            $(this).addClass("over");
        } else {
            $(this).removeClass("over");
        }
    });
    // Ajax para Ofertas
    $("a.dealSort").live('click', function (e) {
        if($(this).hasClass('active')){
            e.preventDefault();
            return false;
        }
        var dealBox = $(this).parent().parent().next().next();
        var id = $(this).attr('id');
        var cat = $(this).parent().find('input[name="cat"]').val();
        var sort = $(this).parent().find('input[name="sort"]');
        var q = $(this).parent().find('input[name="dealSearch"]').val();
        var thisVal = $(this).html();
        $(this).html('&nbsp;<img src="/bundles/mastopsystem/images/load.gif" />&nbsp;');
        $(dealBox).load('/ofertas/ajax', {
            pg: 1, 
            cat: cat, 
            sort: id, 
            q: q
        }, function(){
            $('#'+sort.val()).removeClass('active');
            $('#'+id).addClass('active').html(thisVal);
            sort.val(id);
            $.cookie('dealsort', id, {
                path: '/'
            });
        });
        e.preventDefault();
        return false;
    });
    $("a.dealPag").live('click', function (e) {
        if($(this).hasClass('active')){
            e.preventDefault();
            return false;
        }
        var dealBox = $(this).parent().parent();
        var id = $(this).attr('id');
        var cat = $('#dealActions').find('input[name="cat"]').val();
        var sort = $('#dealActions').find('input[name="sort"]');
        var q = $('#dealActions').find('input[name="dealSearch"]').val();
        var thisVal = $(this).html();
        var pgActive = $(this).parent().find('a.active');
        $(this).html('&nbsp;<img src="/bundles/mastopsystem/images/load.gif" />&nbsp;');
        $(dealBox).load('/ofertas/ajax', {
            pg: id, 
            cat: cat, 
            sort: sort.val(), 
            q: q
        });
        e.preventDefault();
        return false;
    });

});
