function selectClient(obj){
    var id = $(obj).attr('data-id');
    var name = $(obj).html();

    $('.searchresults').hide();
    $('#client_name').val(name);
    $('input[name=client_id]').val(id);

    // Apagar resultado.
    $('.searchresult').hide();
}
function updateSubtotal(obj){
    var quant = $(obj).val();
    if(quant <= 0) {
        $(obj).val(1);
        quant = 1;
    }
    var price = $(obj).attr('data-price');
    var subtotal = price * quant;

    $(obj).closest('tr').find('.subtotal').html('R$ ' + subtotal);

    updateTotal();
}

function updateTotal(){
    var total = 0;

    for(var q = 0; q < $('.p_quant').length; q++){
        var subtotal = 0;
        var quant = $('.p_quant').eq(q);
        var price = quant.attr('data-price');
        var subtotal = price * parseInt(quant.val());

        total += subtotal;
    }

    $('input[name=total_price]').val(total);
}

function excluirProd(obj){
    $(obj).closest('tr').remove();
}

function addProd(obj){
    $('#add_prod').val('');
    var id = $(obj).attr('data-id');
    var name = $(obj).attr('data-name')
    var price = $(obj).attr('data-price');

    $('.searchresults').hide();

    // Só permitir inserir o mesmo produto uma única vez.
    if( $('input[name="quant['+ id +']"').length == 0) {
        var tr = '<tr>' +
            '<td>' + name + '</td>' +
            '<td>' +
            '<input type="number" name="quant[' + id + ']" class="p_quant" value="1" onchange="updateSubtotal(this)" data-price="' + price + '"/>' +
            '<td>R$ ' + price + '</td>' +
            '<td class="subtotal">R$' + price + '</td>' +
            '<td><a href="javascript:;" onclick="excluirProd(this)">Excluir</a></td>' +
            '</tr>';
        $('#products_table').append(tr);
    }

    updateTotal();
}


$(function(){
    $('input[name=total_price]').mask('000.000.000.000.000,00',
        {reverse:true, placeholder:'0.00'}
    );


    $('.client_add_button').on('click', function(e){
        e.preventDefault();


        var name= $('#client_name').val();

        if(name != '' && name.length >= 4){

            if(confirm('Você deseja adicionar um cliente com nome: ' + name + " ?")){

                $.ajax({
                    url:BASE_URL + '/ajax/add_client',
                    type:'POST',
                    data: {name:name},
                    dataType: 'json',
                    success: function(json){
                        $('.searchresults').hide();
                        //$('#client_name').attr('data-id', json.id);
                        $('input[name=client_id]').val(json.id);
                    }
                });

                return false;
            }
        }
    });


    $('#client_name').on('keyup', function(){
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
                        $('#client_name').after('<div class="searchresults"></div>');
                    }

                    // Alinha a div com a classe '.searchresults'
                    // a esquerda do controle com o id '#busca'.
                    $('.searchresults').css('left', $('#client_name').offset().left+'px');

                    // Coloca a div com a classe '.searchresults',
                    // abaixo do tag com id '#busca'.
                    $('.searchresults').css('top', $('#client_name').offset().top +
                    $('#client_name').height()+'px');

                    var html = '';
                    console.log(json);
                    for(var i in json){
                        html += '<div class="si"><a href="javascript:;" onclick="selectClient(this)"' +
                            'data-id="' + json[i].id + '">' + json[i].name + '</a></div>';
                    }

                    $('.searchresults').html(html);

                    // Reexibe pois no método blur, o controle é oculto.
                    $('.searchresults').show();


                }
            });
        }
    });

    $('#add_prod').on('keyup', function(){
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
                        $('#add_prod').after('<div class="searchresults"></div>');
                    }

                    // Alinha a div com a classe '.searchresults'
                    // a esquerda do controle com o id '#busca'.
                    $('.searchresults').css('left', $('#add_prod').offset().left+'px');

                    // Coloca a div com a classe '.searchresults',
                    // abaixo do tag com id '#busca'.
                    // var topo = $('#add_prod').offset().top + $('#add_prod').offset().top;
                    $('.searchresults').css('top', $('#add_prod').offset().top +
                    $('#add_prod').height()+'px');




                    var html = '';
                    console.log(json);
                    for(var i in json){
                        html += '<div class="si"><a href="javascript:;" onclick="addProd(this)"' +
                            ' data-id="' + json[i].id + '"' +
                            ' data-price="'+ json[i].price + '"' +
                            ' data-name="' + json[i].name + '">' + json[i].name +
                            ' - R$ ' + json[i].price +
                            '</a></div>';
                    }

                    $('.searchresults').html(html);

                    // Reexibe pois no método blur, o controle é oculto.
                    $('.searchresults').show();


                }
            });
        }
    });
});