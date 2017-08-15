var warning = true;
window.onbeforeunload = function() {
  if (warning) {
    return true;
  }
}

$('.nounloadask').click(function() {
	warning = false;
});

var article = -1;
var articles_in = true;

function change_articles_in_sign() {
    $('#articles_in').find(".amount_hidden").each(function(index, el) {
            $(el).val(parseInt($(el).val()) * -1);
    });
    $('#articles_in').find(".amount").each(function(index, el) {
            $(el).html(parseInt($(el).html()) * -1);
    });
}
change_articles_in_sign();

$('#BillEditForm').submit(function(e) {
    change_articles_in_sign();
});

$('.article').click(function(e) {
    $('#select_article_amount').css('top', e.pageY-90).css('left', e.pageX-90).fadeIn();
    article = $(this);
    //restore standard
    $('.num_select').each(function() {
        $(this).children().html($(this).children().data('standard'));
    });
});

$('#add_ten').click(function(e) {
    $('.num_select').each(function() {
        $(this).children().html(parseInt($(this).children().html()) + 10);
    });
});

$('#sub_ten').click(function(e) {
    $('.num_select').each(function() {
        var old_val = parseInt($(this).children().html());
        //if (old_val <= 9) return;
        $(this).children().html(old_val - 10);
    });
});

$('.num_select').click(function(e) {
    var amount = parseInt($(this).children().html());
    $('#select_article_amount').fadeOut();
    if (amount == 0) return;
    
    var singleprice = parseFloat(article.data('price'))+
                    ((article.data('deposit') == "") ? 0 : parseFloat(article.data('deposit')));
    var name = article.find('.name').html();

    var el = $('#articles_' + ((articles_in) ? 'in' : 'out')).find("div[data-article-id="+article.data('id')+"]");
    if (el.length <= 0) {
        el = $('<div class="list" data-article-id="'+article.data('id')+'" data-singleprice="'+singleprice+'"><div class="list-content">'
                    + '<span class="list-title"><span class="amount">0</span>x '+name+'<span class="place-right fg-crimson"><span class="total">0</span> €</span></span>'
                    + '<span class="list-subtitle">Einzelpreis <span class="place-right">'+article.data('price')+' €<span class="fg-gray">+ '+article.data('deposit')+' €</span></span>'
                    + '<input type="hidden" name="data[Article]['+next_article_id+'][ArticlesBill][article_id]" value="'+article.data('id')+'" id="Article'+next_article_id+'ArticlesBillArticleId">'
                    + '<input type="hidden" name="data[Article]['+next_article_id+'][ArticlesBill][amount]" value="0" class="amount_hidden" id="Article'+(next_article_id++)+'ArticlesBillAmount">'
                + '</span></div></div>').appendTo('#articles_' + ((articles_in) ? 'in' : 'out'));
    }
    
    var amount_span = el.find('.amount');
    var amount_hidden = el.find('.amount_hidden');
    var new_amount = parseInt(amount_span.html()) + amount;
    amount_span.html(new_amount);
    amount_hidden.val(new_amount);
    
    el.find('.total').html((parseFloat(el.data('singleprice'))*new_amount).toFixed(2));
    
    if (popup) popup.addArticle({id: article.data('id'), name: name, price: article.data('price'), deposit: article.data('deposit')}, amount, articles_in);
});

//save standard
$('.num_select').each(function() {
    $(this).children().data('standard', parseInt($(this).children().html()));
});

//toggle in_out
$('#in_out').click(function() {
    if ($(this).data('state') == 'in') {
        $(this).data('state', 'out');
        $(this).text('Einkauf');
        
        $('#articles_in').parent(".list-group").addClass('collapsed').children(".group-content").slideUp();
        $('#articles_out').parent(".list-group").removeClass('collapsed').children(".group-content").slideDown();
        
    }
    else {
        $(this).data('state', 'in');
        $(this).text('Rückgabe');
        
        $('#articles_out').parent(".list-group").addClass('collapsed').children(".group-content").slideUp();
        $('#articles_in').parent(".list-group").removeClass('collapsed').children(".group-content").slideDown();
    }   
    articles_in = !articles_in; 
});
$('#articles_out').parent(".list-group").addClass('collapsed').children(".group-content").css('display', 'none');
