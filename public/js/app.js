jQuery(function() {
    window.incrementQuantity = function(productId) {
        updateQuantity(productId, 1);
    }

    window.decrementQuantity = function(productId) {
        updateQuantity(productId, -1);
    }

    function updateQuantity (productId, change) {
        var quantityInput = $('#quantity-' + productId);
        var currentQuantity = parseInt(quantityInput.val());
        var newQuantity = Math.max(0, currentQuantity + change);    
        quantityInput.attr("value",newQuantity);
    }

    var ListProductsMass = false;

    window.switchListProducts = function() {
        ListProductsMass = !ListProductsMass;
        if (ListProductsMass) {
            $('#products-container-one').hide();
            $('#products-container-mass').show();
            $('#switchListProducts').html('Przełącz widok na pojedyncze dodawanie produktów');
        } else {
            $('#products-container-one').show();
            $('#products-container-mass').hide();
            $('#switchListProducts').html('Przełącz widok na masowe dodawanie produktów');
        }
    }

    window.massAddToCart = function() {
        var products = $('.form-control[value!="0"]');
        var dataToSend = [];

        products.each(function () {
            dataToSend.push({
                productId: parseInt($(this).attr('productId')),
                quantity: parseInt($(this).val()),
            });
        });

        send(dataToSend);
    }

    window.oneAddToCart = function(productId) {
        var dataToSend = [];

        dataToSend.push({
            productId: productId,
            quantity: 1,
        });

        send(dataToSend)
    }

    function send(dataToSend) {
        $.ajax({
            type: 'POST',
            url: '/create_order',
            data: JSON.stringify(dataToSend),
            contentType: 'application/json',
            success: function (response) {
                console.log(response);
            },
            error: function (error) {
                console.error(error);
            },
        });
    }
});