$(function(){

    $('.tabitem').bind('click', function(){
        $('.tabitem').removeClass('activetab');
        $(this).addClass('activetab');

        var item = $(this).index();
        $('.tabbody').hide();
        $('.tabbody').eq(item).show();
    });
    $('.tabitem').eq(0).addClass('activetab');
    $('.tabbody').eq(0).show();

    $('#busca').on('focus', function(){
        $(this).animate({
            width:'250px'
        }, 'fast');
    });

    $('#busca').on('blur', function(){
        if($(this).val() == ''){
            $(this).animate({
                width:'100px'
            }, 'fast');
        }

        setTimeout(function(){
            $('.searchresults').hide();
        }, 1000);

    });

    $('#busca').on('keyup', function(){
        var datatype = $(this).attr('data-type');
        var q = $(this).val();

        if(datatype != ''){
            $.ajax({
                url:BASE_URL + "/ajax/" + datatype,
                type:'GET',
                data:{q:q},
                dataType:'json',
                success:function(json){
                    if($('.searchresults').length == 0){
                        $('#busca').after('<div class="searchresults"></div>');
                    }

                    // Alinha a div com a classe '.searchresults'
                    // a esquerda do controle com o id '#busca'.
                    $('.searchresults').css('left', $('#busca').offset().left+'px');

                    // Coloca a div com a classe '.searchresults',
                    // abaixo do tag com id '#busca'.
                    $('.searchresults').css('top'), $('#busca').offset().top +
                        $('#busca').height()+'px';


                    var html = '';

                    for(var item in json){
                        html += '<div class="si"><a href="'
                                + json[item].link + '">'
                                + json[item].name +
                                '</a></div>';
                        console.log(html);
                    }

                    $('.searchresults').html(html);

                    // Reexibe pois no método blur, o controle é oculto.
                    $('.searchresults').show();


                }
            });
        }
    });

});
