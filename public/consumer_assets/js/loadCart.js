function updateTotalPriceItem(target, cartDetailId, productDetailId){
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        }
    });
    var ajaxUrl = '/get_stock_quantity/' + productDetailId;
    console.log(ajaxUrl);
    $.ajax({
        type: 'GET',
        url: ajaxUrl,
        success: function(data) {
            var tdParent = target.parentElement;
            var trParent = tdParent.parentElement;
            var trChildrenCount = trParent.children.length;
            var isUpdateTotalPrice = false;
            var price = 0;
            var oldTotalPrice = 0.00;
            var quantity = 0;
            for (var index = 0; index < trChildrenCount; index++){
                if (trParent.children[index].getAttribute("class") === "check_item"){
                    isUpdateTotalPrice = trParent.children[index].firstElementChild.checked;
                }
                if (trParent.children[index].getAttribute("class") === "price_item"){
                    price = trParent.children[index].innerHTML;
                }
                if (trParent.children[index].getAttribute("class") === "total_price_item"){
                    if (isUpdateTotalPrice){
                        oldTotalPrice = parseFloat(trParent.children[index].innerHTML);
                    }
                    quantity = target.value;
                    var stockQuantity = data.stock_quantity;
                    if (quantity > stockQuantity && stockQuantity != -1){
                        target.value = stockQuantity;
                        quantity = stockQuantity;
                        Swal.fire({
                            title: "Sorry! Stock quantity is not enough.",
                            text: "The number of products left is " + stockQuantity,
                            icon: "warning",
                            customClass: "swal-wide"
                        });
                    }
                    if (stockQuantity == -1){
                        Swal.fire({
                            title: "Opps...",
                            text: "Something went wrong! Please reload the page",
                            icon: "error",
                            customClass: "swal-wide"
                        });
                    }
                    trParent.children[index].innerHTML = (price * quantity).toFixed(2);
                    updateCartItemQuantity(cartDetailId, quantity);
                    break;
                }  
            }
            if (isUpdateTotalPrice){
                var subTotalElement = document.getElementById("sub_total");
                var subTotal = parseFloat(subTotalElement.innerHTML.substring(1));
                subTotal = subTotal - oldTotalPrice + price * quantity;
                subTotalElement.innerHTML = '$' + subTotal.toFixed(2);
            }
        },
        error: function(data) {}
    });
}

function updateCartItemQuantity(cartDetailId, quantity){
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        }
    });
    var ajaxUrl = '/update_cart_detail_quantity/' + cartDetailId + '/' + quantity;
    console.log(ajaxUrl);
    $.ajax({
        type: 'GET',
        url: ajaxUrl,
        success: function(data) {},
        error: function(data) {}
    });
}

function removeAllElementChild(target){
    while(target.hasChildNodes()){
        removeAllElementChild(target.childNodes[0]);
        target.removeChild(target.childNodes[0]);
    }
}

function deleteItem(cartDetailId){
    Swal.fire({
        icon: "warning",
        title: 'Delete Item',
        text: "Are you sure?",
        showCancelButton: true,
        confirmButtonText: 'Yes',
        customClass: "swal-wide",
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                }
            });
            var ajaxUrl = '/delete_cart_detail/' + cartDetailId;
            $.ajax({
                type: 'GET',
                url: ajaxUrl,
                success: function(data) {
                    var mess = data.cart_detail_message;
                    if (mess.includes("Error")){
                        Swal.fire({
                            title: "Error",
                            text: mess,
                            icon: "error",
                            customClass: "swal-wide"
                        });
                    }
                    else {
                        window.location.reload();
                    }
                },
                error: function(data) {}
            });
        }
    });
}

function updateSubTotalWhenItemChecked(target){
    var subTotalElement = document.getElementById("sub_total");
    var subTotal = parseFloat(subTotalElement.innerHTML.substring(1));
    var trParent = target.parentElement.parentElement;
    for (element of trParent.children){
        if (element.hasAttribute("class") && element.getAttribute("class") === "total_price_item"){
            if (target.checked) subTotal += parseFloat(element.innerHTML);
            else subTotal -= parseFloat(element.innerHTML);
            subTotalElement.innerHTML = '$' + subTotal.toFixed(2);
            break;
        }
    }
}

function createSessionStorageToStoreSelectedCartItem(event){
    event.preventDefault();
    var cartDetailIds = Object.values(document.getElementsByClassName("cart_detail_id")).map(function(item){
        return item.value;
    });

    var checkItems = Object.values(document.getElementsByClassName("check_item")).map(function(item){
        return item.firstElementChild;
    });

    var checkedItemIds = [];
    var checkedItemRowElements = [];
    for (var index=0; index<checkItems.length; index++){
        if (checkItems[index].checked){
            checkedItemIds.push(cartDetailIds[index]);
            checkedItemRowElements.push(checkItems[index].parentElement.parentElement);
        }
    }
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });
    ajaxUrl = '/create_session_checkout';
    $.ajax({
        type: "POST",
        data: { cart_item_ids : JSON.stringify(checkedItemIds) },
        url: ajaxUrl,
        success: function(data){
            if (data.checkout_session_mess === "created"){
                window.location.href = "/checkout";
            }
        },
        error: function(data){
            Swal.fire({
                title: "Oops...",
                text: "Something went wrong! Please reload the page",
                icon: "error",
                customClass: "swal-wide"
            });
        }
    });
}