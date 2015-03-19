(function(_, $) {
    $(document).on('click', 'button[type=submit][name^="dispatch[checkout.add"]', function() {

        var form_name = $(this).parents('form').prop('name');

        var product_id = form_name.split('_').slice(-1)[0];

        $.ceEvent('one', 'ce.formajaxpost_' + form_name, function(form, elm) {

                try { rrApi.addToBasket(product_id) } catch(e) {}

        });
    });
}(Tygh, jQuery));
