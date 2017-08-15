var ac_skip = 0;
var ac_article_id = 0;
var ac_prefix_length = 0;

var ac_direction_in = true;

$('#BillPaid').change(function(e) {
    $('#BillPaidDate').prop('disabled', $(this).is(":checked"));
});

$('#BillEditForm').submit(function(e) {
    //if ($('#BillPaid').is(":checked") && !confirm('Rechnung ')) return false;

    $('#articles_in').find("input[name$='\\[amount\\]']").each(function(index, el) {
        $(el).val(parseInt($(el).val()) * -1);
    });
});

$('#articles_in').find("input[name$='\\[amount\\]']").each(function(index, el) {
        $(el).val(parseInt($(el).val()) * -1);
});

function add_amount_event() {
    $('.amounts').change(function(e) {
        update_line($(this).parent().parent());
    });
}
add_amount_event();


//TODO schöner tr
function update_line(line) {
    var article_id = parseInt(line.find("input[name$='\\[article_id\\]']").val());
    var intern_id = -1;
    
    for (var i = 0; i < articles_id.length; i++) {
        if (articles_id[i] == article_id) {
            intern_id = i;
            break;
        }
    }
    
    var amount_input = line.find("input[name$='\\[amount\\]']");
    
    var amount = parseInt(amount_input.val());
    var deposit = articles_deposit[intern_id];
    var price = articles_price[intern_id];
    if (!deposit) deposit = 0;
    var sum = (price+deposit)*amount;
    if (line.parent().parent().attr("id") == "articles_in") sum = sum*-1;
    
    line.find(".sum").html(sum.toFixed(2) + " &euro;");
    
    var table = line.parent().parent();
    var total = 0;
    table.find(".sum").each(function(index, el) {
        var value = $(el).html();
        total += parseFloat(value.substr(0, value.length - 2));
    });
    table.next().html(total.toFixed(2) + " &euro;");
}

$('#add_article').keyup(function(event) {
    console.log(event);
    
    if ((event.which >= 48 && event.which <= 57 && $('#add_article').val().length == 0)) {
        event.preventDefault();
        return;
    }
    
    if (event.keyCode == 13) { //enter
        var amount = parseInt($('#add_article_amount').text());
        
        var box = '#articles_in';
        if (ac_direction_in == false) box = '#articles_out';
        
        var create_new = true;

        var el = $(box).find("input[name$='\\[article_id\\]'][value="+articles_id[ac_article_id]+"]");
        if (el.length > 0) {
            var amount_input = $('#'+el.attr("id").replace("ArticleId", "Amount"));
            amount_input.val(parseInt(amount_input.val()) + amount);
            amount_input.animate({'background-color': 'yellow'}).delay(1000).animate({'background-color': 'white'});
            
            update_line(el.parent());
            
            create_new = false;
        }
        
        if (create_new) {
            var article_id = articles_id[ac_article_id];
            var deposit = articles_deposit[ac_article_id];
            var price = articles_price[ac_article_id];
            if (!deposit) deposit = 0; 
            var sum = (price+deposit)*amount;
            if (ac_direction_in) sum = sum*-1;
            
            var newline = $('<tr style="display: none;"><input type="hidden" name="data[Article]['+ next_article_id +'][ArticlesBill][article_id]" value="'+article_id+'" id="Article'+ next_article_id +'ArticlesBillArticleId"/>'+
            '<td><input class="amounts" name="data[Article]['+ next_article_id +'][ArticlesBill][amount]" value="'+amount+'" type="number" id="Article'+ next_article_id +'ArticlesBillAmount"/></td>'+
            '<td>'+articles[ac_article_id]+'</td>' + 
            '<td style="text-align: right;">'+deposit.toFixed(2)+' &euro;</td>'+
            '<td style="text-align: right;">'+price.toFixed(2)+' &euro;</td>'+
            '<td style="text-align: right;" class="sum">'+sum.toFixed(2)+' &euro;</td></tr>');
            
            next_article_id++;
            $(box).append(newline);
            update_line(newline);
            newline.fadeIn();
        }
        
        this.value = '';
        $('#add_article_amount').text('0');
        return;
    }
    
    if (event.keyCode == 17) { //Strg
        ac_direction_in = !ac_direction_in;
        if (ac_direction_in) $('#add_article_direction').html('&#8680;');
        else $('#add_article_direction').html('&#8678;');
     
        return;
    }
    
    if (event.keyCode == 16 || event.keyCode == 38 || event.keyCode == 40) return;

    ac_skip = 0;
    if (calc_ac(this.value) == false) {
        if (this.value.length > 0)
            this.value = this.value.substr(0, this.value.length - 1);
    }
    update_ac();

}).keydown(function(event) {
    if (event.keyCode == 8) {
        if ($('#add_article').val().length == 0 && $('#add_article_amount').text().length > 0) {
            $('#add_article_amount').text($('#add_article_amount').text().substr(0, $('#add_article_amount').text().length -1));
            if ($('#add_article_amount').text().length == 0)
                $('#add_article_amount').text('0');
        }
    }

    if ((event.which >= 48 && event.which <= 57 && $('#add_article').val().length == 0)) {
        $('#add_article_amount').append(event.which - 48);
        $('#add_article_amount').text(parseInt($('#add_article_amount').text()));
        event.preventDefault();
        return;
    }
    
    if (event.keyCode == 40 || event.keyCode == 38) {
        event.preventDefault();
    
        if (event.keyCode == 40) ac_skip++;
        if (event.keyCode == 38 && ac_skip != 0) ac_skip--;
        calc_ac(this.value);
        update_ac();
    }
});

function sublist_char_at(list, char, position) {
    var new_pa = [];
    for (var e = 0; e < list.length; e++) {
        if (list[e].toLowerCase().charAt(position) == char.toLowerCase())
            new_pa[new_pa.length] = list[e];
    }
    
    return new_pa;
}

function calc_ac(value) {
    var possible_articles = [];
    
    for (var i = 0; i < articles.length; i++) {
        if (articles_basic[i] == 1 || !$('#basic').prop('checked')) possible_articles.push(articles[i]);
    }
    
    ac_prefix_length = 0;
    for (var i = 0; i < value.length; i++) {
        
        possible_articles = sublist_char_at(possible_articles, value.charAt(i), ac_prefix_length);
        
        while(possible_articles.length > 1 && sublist_char_at(possible_articles, possible_articles[0].charAt(ac_prefix_length), ac_prefix_length).length == possible_articles.length)
            ac_prefix_length++;
    }
    
    if (possible_articles.length == 0) {
        return false;
    }
    
    if (possible_articles.length == 1) ac_prefix_length = possible_articles[0].length;
    
    for (var i = 0; i < articles.length; i++) {
        if (possible_articles[ac_skip % possible_articles.length] == articles[i])
            ac_article_id = i;
    }
    
    return true;
}

function update_ac() {
    var selected_article = articles[ac_article_id];
    
    $('#add_article_ac').html('<strong>' + selected_article.substr(0, ac_prefix_length) + '</strong>' + selected_article.substr(ac_prefix_length));

}

