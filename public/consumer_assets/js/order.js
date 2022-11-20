function getDeliveryAddrress() {
    var deliveryAddresses = document.getElementsByName("delivery_address");
    for (var deliveryAddress of deliveryAddresses) {
        if (deliveryAddress.checked) {
            return deliveryAddress.value;
        }
    }
}

function getPaymentMethod() {
    var paymentMethods = document.getElementsByName("payment_method");
    for (var paymentMethod of paymentMethods) {
        if (paymentMethod.checked) {
            return paymentMethod.value;
        }
    }
}

function getOrderTotal() {
    $total = document.getElementById("total_cost").innerHTML;
    $total = $total.substring(1);
    return parseFloat($total);
}

function getCartDetailIds() {
    var cartDetailIds = Object.values(document.getElementsByClassName("cart_detail_id")).map(function(element) {
        return element.value;
    });
    return cartDetailIds;
}

function getProductDetailIds() {
    var productDetailIds = Object.values(document.getElementsByClassName("product_detail_id")).map(function(element) {
        return element.value;
    });
    return productDetailIds;
}

function getQuantityItems() {
    var quantityItems = Object.values(document.getElementsByClassName("quantity_item")).map(function(element) {
        return element.value;
    });
    return quantityItems;
}

function getTotalPriceItems() {
    var totalPriceItems = Object.values(document.getElementsByClassName("total_price_item")).map(function(element) {
        return element.innerHTML;
    });
    return totalPriceItems;
}

function placeOrder() {
    var deliveryAddress = getDeliveryAddrress();
    var paymentMethod = getPaymentMethod();
    var total = getOrderTotal();
    var cartDetailIds = getCartDetailIds();
    var productDetailIds = getProductDetailIds();
    var quantityItems = getQuantityItems();
    var totalPriceItems = getTotalPriceItems();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });
    ajaxUrl = '/place_order';
    $.ajax({
        type: "POST",
        data: {
            delivery_address: JSON.stringify(deliveryAddress),
            payment_method: JSON.stringify(paymentMethod),
            total: JSON.stringify(total),
            cart_detail_ids: JSON.stringify(cartDetailIds),
            product_detail_ids: JSON.stringify(productDetailIds),
            quantity_items: JSON.stringify(quantityItems),
            total_price_items: JSON.stringify(totalPriceItems)
        },
        url: ajaxUrl,
        success: function(data) {
            if (data.place_order_mess.includes("successful")) {
                window.location.href = "/my_order/Incomplete";
            } else {
                Swal.fire({
                    title: "Oops...",
                    text: data.place_order_mess,
                    icon: "error",
                    customClass: "swal-wide",
                });
            }

        },
        error: function(data) {}
    });
}

function checkOrderDetailQuantites() {
    var cartDetailIds = getCartDetailIds();
    var productDetailIds = getProductDetailIds();
    var quantityItems = getQuantityItems();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });
    ajaxUrl = '/checkout/check_order_detail_quantity';
    $.ajax({
        type: "POST",
        data: {
            cart_detail_ids: JSON.stringify(cartDetailIds),
            product_detail_ids: JSON.stringify(productDetailIds),
            quantity_items: JSON.stringify(quantityItems)
        },
        url: ajaxUrl,
        success: function(data) {
            if (!data.check_order_detail_quantity_mess.includes("is not enough")) {
                placeOrder();
            } else {
                Swal.fire({
                    title: "Oops...",
                    text: data.check_order_detail_quantity_mess,
                    icon: "error",
                    customClass: "swal-wide",
                });
            }
        },
        error: function(data) {

        }
    });
}

document.getElementById("place_order").addEventListener("click", function() {
    checkOrderDetailQuantites();
});