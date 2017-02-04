Stripe.setPublishableKey('pk_test_76RxzmtPNonDTwWveVUcoi7s');

var $form = $('#checkoutform');
$form.submit(function (event) {
    $('#charge-error').addClass('hidden');
    $form.find('button').prop('disabled',true);
    Stripe.card.createToken({
        number: $('#cardno').val(),
        cvc: $('#cvc').val(),
        exp_month: $('#expmonth').val(),
        exp_year: $('#expyear').val(),
    }, stripeResponseHandler);
    return false;
})

function stripeResponseHandler(status,response) {
    if(response.error){
        $('#charge-error').removeClass('hidden');
        $('#charge-error').text(response.error.message);
        $form.find('button').prop('disabled',false);
    }else{
        var token = response.id;
        $form.append($('<input type="hidden" name="stripeToken"/>').val(token));
        $form.get(0).submit();
    }
}
