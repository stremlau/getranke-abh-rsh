var popup = null;

var ua = window.navigator.userAgent;
var msie = ua.indexOf("MSIE ");
var is_ie = msie > 0;

if (is_ie) {
    popup = window.external;
}

function bindPopupReference() {
    if (is_ie) {
        popup = window.external;
        return;
    }
    popup = window.open("", "GetraenkeSecondScreen");
    if (popup.location.href == "about:blank") {
        popup.location.href = '/popup.html';
    }
}

if (document.cookie.indexOf("popup=open") > -1) {
    bindPopupReference();
    if (popup.stopKillTimer)
        popup.stopKillTimer();
}

$(window).unload(function() {
    if (popup) popup.startKillTimer();
});

function printPage(amount) {
    if (is_ie) {
        popup.printPage(amount);
    }
    else {
        window.print();
    }
}

$(function() {
    $('.change_user').click(function() {
        var id = $(this).attr('id').replace('cu_', '');
        var name = $(this).html();
        
        $('#session_user').html(name);
        document.cookie = "user=" + id + "; path=/;"
    });

    $('.change_term').click(function() {
        var id = $(this).attr('id').replace('ct_', '');
        var name = $(this).html();
        
        $('#session_term').html(name);
        document.cookie = "term=" + id + "; path=/;"
        location.reload();
    });

    //Offene Rechnungen
    var unpaid_bills_selection = [];
    var unpaid_bills_total = 0;
    $('.unpaid-bill').click(function(e) {
        var bill = $(this);
        bill.toggleClass('selected');
        if (bill.hasClass('selected')) {
            unpaid_bills_selection.push(bill.data('id'));
            $('#view_unpaid_bills').prop('disabled', false);
            unpaid_bills_total += parseFloat(bill.data('total'));
        }
        else {
            unpaid_bills_selection.splice( $.inArray(bill.data('id'), unpaid_bills_selection), 1 );
            if (unpaid_bills_selection.length == 0) $('#view_unpaid_bills').prop('disabled', true);
            unpaid_bills_total -= parseFloat(bill.data('total'));
        }
        
        $('#edit_unpaid_bills').prop('disabled', (unpaid_bills_selection.length != 1));
        
        $('#unpaid_bills_total').html('Auswahl: '+unpaid_bills_total.toFixed(2)+' &euro;');
        if ((unpaid_bills_selection.length > 1)) {
            $('#unpaid_bills_total').fadeIn();
        } else {
            $('#unpaid_bills_total').fadeOut();
        }

        if (popup) popup.setUnpaidBillsSelection(unpaid_bills_selection, unpaid_bills_total.toFixed(2));
    }).last().click();
    $('#edit_unpaid_bills').click(function() {
        window.location = '/bill/edit/' + unpaid_bills_selection[0];
    });
    $('#view_unpaid_bills').click(function() {
        window.location = '/bill/view/' + unpaid_bills_selection.join('-');
    });

    //Kassenporuegfunvnfdsdjkffsd
    var inputs = $('.money_table input');
    inputs.keyup(function(e) {
        var sum = 0;
        inputs.each(function() {
            sum += this.value * $(this).data('value');
        });
        $('#credit_total').html(sum.toFixed(2));
        var debit_difference = (sum - parseFloat($('#debit_total').html())).toFixed(2);
        $('#debit_difference').html(debit_difference);
        $('#credit_input').val(sum);

        if (e.keyCode == 13 || e.keyCode == 9) {
            e.preventDefault();
            var that = this;
            var next = inputs[0];
            inputs.each(function(index) {
                if (that == this && index + 1 < inputs.length) {
                    next = inputs[index + 1];
                }
            });
            next.focus();
            next.select();
        }
    }).keydown(function(e) {
        if (e.key == 'Tab') e.preventDefault();
    });


    //Second Screen
    if (popup) {
        $('#open-second-screen').toggleClass('fg-red');
    }

    $('#open-second-screen').click(function(e) {
        $('#open-second-screen').toggleClass('fg-red');
        if (e) e.preventDefault();

        if ($('#open-second-screen').hasClass('fg-red')) {
            document.cookie = "popup=open; path=/;"
            bindPopupReference();
        }
        else {
            document.cookie = "popup=closed; path=/;"
            popup.close();
        }
    });
});
