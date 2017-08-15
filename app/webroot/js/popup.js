var killtimer;
function startKillTimer() {
    killtimer = setTimeout(window.close, 5000);
}

function stopKillTimer() {
    clearTimeout(killtimer); 
}

function setCustomer(user) {
    console.log(user);
    $('#customer').html(user);
	if (user == '') {
		$('#customer-icon').hide();
	}
	else {
		$('#customer-icon').show();
	}
}

function clearScreen() {
	$('.ppage').hide();
	setCustomer('');
}

function setUnpaidBills(data) {
    $('.ppage').hide();
    $('#unpaid-bills').fadeIn();

    $('#unpaid-bills').find('.clone').remove();
    var template = $('#unpaid-bill-template');

    $(data).each(function(id, billdata) {
        if (!billdata) return;
        var bill = template.clone().addClass('clone');
        bill.find('.list-title').text(billdata.date);
        bill.find('.list-subtitle').html(billdata.total + ' &euro;');
        bill.find('.list-remark').text(billdata.user);
        bill.data('id', billdata.id);
        bill.insertBefore(template).delay((id + 1) * 500).fadeTo(1000, 1);
    });
}

$('#unpaid-bills-total').fadeTo(0, 0);
function setUnpaidBillsSelection(selection, total) {
    $('#unpaid-bills-total-value').text(total);
    if (selection.length > 1) {
        $('#unpaid-bills-total').fadeIn();
    } else {
        $('#unpaid-bills-total').fadeOut();
    }

    $('.unpaid-bill').each(function(id, el) {
        $(el).removeClass('selected');
        if ($(el).data('id') && $.inArray($(el).data('id'), selection) > -1) {
            $(el).addClass('selected');
            console.log([0, $(el).data('id'), selection]);
        } 
    });
}

function newBill() {
    $('.ppage').hide();
    $('#bill').fadeIn();
    $('#bill').find('.clone').remove();
	$('#bill-total').html('0.00');
}

function addArticle(articledata, amount, direction) {
    console.log([articledata, amount, direction]);
    var table = $('#articles-' + ((direction) ? 'in' : 'out'));

    var article;
    table.find('tr').each(function() {
        if ($(this).data('id') == articledata.id) {
            article = $(this);
            amount += parseInt(article.find('.amount').text());
        }
    });

    if (!article) {
        article = $('#bill-article-template').clone().addClass('clone').css({opacity: 0});
        article.data('id', articledata.id);
        article.find('.name').text(articledata.name);
        article.find('.price').html(articledata.price + ' &euro;');
        article.find('.deposit').html((articledata.deposit || '0.00') + ' &euro;');
        article.appendTo(table.find('tbody')).fadeTo(1000, 1);
    }

    article.find('.amount').text(amount);
	var total = ((parseFloat(articledata.price) + (parseFloat(articledata.deposit) || 0)) * amount).toFixed(2);
    article.find('.total').html(total + ' &euro;');

	_updateBillTotal();
}

function _updateBillTotal() {
	var total = 0.0;

	$('#articles-in').find('.clone').each(function(index, el) {
        total -= parseFloat($(this).find('.total').html().replace(' &euro;', ''));
    });

	$('#articles-out').find('.clone').each(function() {
        total += parseFloat($(this).find('.total').html().replace(' &euro;', ''));
    });

	$('#bill-total').html(total.toFixed(2));
}

function _updateDatetime() {
    var currentdate = new Date(); 
    $('#date').text(currentdate.getDate() + "." + (currentdate.getMonth()+1)  + "." + currentdate.getFullYear());
    $('#time').text(currentdate.getHours() + ":" + ('0'  + currentdate.getMinutes()).slice(-2));
}

setInterval(_updateDatetime, 5000);
$(_updateDatetime);
