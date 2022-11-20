// product option show
function activeDefaultOptionValue1() {
    var optionValue1s = document.getElementsByName("option_value_1");
    if (optionValue1s.length > 0) {
        optionValue1s[0].setAttribute("class", "option-active");
    }
}

function unactiveAllOptionValue1() {
    var optionValue1s = document.getElementsByName("option_value_1");
    optionValue1s.forEach((optionValue1) => {
        optionValue1.removeAttribute("class");
    });
}

function activeDefaultOptionValue2() {
    var optionValue2s = document.getElementsByName("option_value_2");
    if (optionValue2s.length > 0) {
        optionValue2s[0].setAttribute("class", "option-active");
    }
}

function unactiveAllOptionValue2() {
    var optionValue2s = document.getElementsByName("option_value_2");
    optionValue2s.forEach((optionValue2) => {
        optionValue2.removeAttribute("class");
    });
}

function activeDefaultOptionValue3() {
    var optionValue3s = document.getElementsByName("option_value_3");
    if (optionValue3s.length > 0) {
        optionValue3s[0].setAttribute("class", "option-active");
    }
}

function unactiveAllOptionValue3() {
    var optionValue3s = document.getElementsByName("option_value_3");
    optionValue3s.forEach((optionValue3) => {
        optionValue3.removeAttribute("class");
    });
}

function removeAllChild(element) {
    while (element.hasChildNodes()) {
        removeAllChild(element.firstChild);
        element.removeChild(element.firstChild);
    }
}

function getProductOption1(productId) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    var ajaxUrl =
        "/product_detail/" + productId + "/get_product_detail_option_1";
    $.ajax({
        type: "POST",
        url: ajaxUrl,
        success: function (data) {
            var productOptionName1 = data.result.option_name_1;
            var productOptionValue1s = data.result.option_value_1;

            var option1Element = document.getElementById("option_part1");
            removeAllChild(option1Element);

            if (productOptionName1 != null) {
                // add option name
                var optionNameElement = document.createElement("h4");
                optionNameElement.innerHTML = productOptionName1;
                option1Element.appendChild(optionNameElement);
                // add option value
                var optionValueElement = document.createElement("div");
                optionValueElement.setAttribute("class", "aa-product-option");
                option1Element.appendChild(optionValueElement);
                productOptionValue1s.forEach((productOptionValue1) => {
                    var optionValueSubElement = document.createElement("a");
                    optionValueSubElement.setAttribute(
                        "name",
                        "option_value_1"
                    );
                    optionValueSubElement.setAttribute("href", "#");
                    optionValueSubElement.setAttribute(
                        "onclick",
                        "event.preventDefault();getProductOption2(" +
                            productId +
                            ", '" +
                            productOptionValue1 +
                            "');this.setAttribute('class', 'option-active');"
                    );
                    optionValueSubElement.innerHTML = productOptionValue1;
                    optionValueElement.appendChild(optionValueSubElement);
                });
                getProductOption2(productId, productOptionValue1s[0]);
                activeDefaultOptionValue1();
            } else {
                getProductDetail(productId, "", "", "", "", "");
            }
        },
        error: function (data) {
            console.log("error!!!");
        },
    });
}

function getProductOption2(productId, productOptionValue1) {
    unactiveAllOptionValue1();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    var ajaxUrl =
        "/product_detail/" + productId + "/get_product_detail_option_2";
    $.ajax({
        type: "POST",
        url: ajaxUrl,
        data: {
            product_option_value_1: JSON.stringify(productOptionValue1),
        },
        success: function (data) {
            var productOptionName2 = data.result.option_name_2;
            var productOptionValue2s = data.result.option_value_2;

            var option2Element = document.getElementById("option_part2");
            removeAllChild(option2Element);

            if (productOptionName2 != null) {
                var optionNameElement = document.createElement("h4");
                optionNameElement.innerHTML = productOptionName2;
                option2Element.appendChild(optionNameElement);
                // <div class="aa-product-option">
                var optionValueElement = document.createElement("div");
                optionValueElement.setAttribute("class", "aa-product-option");
                option2Element.appendChild(optionValueElement);
                productOptionValue2s.forEach((productOptionValue2) => {
                    var optionValueSubElement = document.createElement("a");
                    optionValueSubElement.setAttribute(
                        "name",
                        "option_value_2"
                    );
                    optionValueSubElement.setAttribute("href", "#");
                    optionValueSubElement.setAttribute(
                        "onclick",
                        "event.preventDefault();getProductOption3(" +
                            productId +
                            ", '" +
                            productOptionValue1 +
                            "', '" +
                            productOptionName2 +
                            "', '" +
                            productOptionValue2 +
                            "');this.setAttribute('class', 'option-active');"
                    );
                    optionValueSubElement.innerHTML = productOptionValue2;
                    optionValueElement.appendChild(optionValueSubElement);
                });
                getProductOption3(
                    productId,
                    productOptionValue1,
                    productOptionName2,
                    productOptionValue2s[0]
                );
                activeDefaultOptionValue2();
            } else {
                getProductDetail(productId, productOptionValue1, "", "", "", "");
            }
        },
        error: function (data) {
            console.log("error!!!");
        },
    });
}

function getProductOption3(
    productId,
    productOptionValue1,
    productOptionName2,
    productOptionValue2
) {
    unactiveAllOptionValue2();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    var ajaxUrl =
        "/product_detail/" + productId + "/get_product_detail_option_3";

    $.ajax({
        type: "POST",
        url: ajaxUrl,
        data: {
            product_option_value_1: JSON.stringify(productOptionValue1),
            product_option_name_2: JSON.stringify(productOptionName2),
            product_option_value_2: JSON.stringify(productOptionValue2),
        },
        success: function (data) {
            var productOptionName3 = data.result.option_name_3;
            var productOptionValue3s = data.result.option_value_3;

            var option3Element = document.getElementById("option_part3");
            removeAllChild(option3Element);

            if (productOptionName3 != null) {
                var optionNameElement = document.createElement("h4");
                optionNameElement.innerHTML = productOptionName3;
                option3Element.appendChild(optionNameElement);
                // <div class="aa-product-option">
                var optionValueElement = document.createElement("div");
                optionValueElement.setAttribute("class", "aa-product-option");
                option3Element.appendChild(optionValueElement);
                productOptionValue3s.forEach((productOptionValue3) => {
                    var optionValueSubElement = document.createElement("a");
                    optionValueSubElement.setAttribute(
                        "name",
                        "option_value_3"
                    );
                    optionValueSubElement.setAttribute("href", "#");
                    optionValueSubElement.setAttribute(
                        "onclick",
                        "event.preventDefault();getProductDetail(" +
                            productId +
                            ",'" +
                            productOptionValue1 +
                            "','" +
                            productOptionName2 +
                            "','" +
                            productOptionValue2 +
                            "','" +
                            productOptionName3 +
                            "','" +
                            productOptionValue3 +
                            "');this.setAttribute('class', 'option-active');"
                    );
                    optionValueSubElement.innerHTML = productOptionValue3;
                    optionValueElement.appendChild(optionValueSubElement);
                });
                getProductDetail(
                    productId,
                    productOptionValue1,
                    productOptionName2,
                    productOptionValue2,
                    productOptionName3,
                    productOptionValue3s[0]
                );
                activeDefaultOptionValue3();
            } else {
                getProductDetail(
                    productId,
                    productOptionValue1,
                    productOptionName2,
                    productOptionValue2,
                    "",
                    ""
                );
            }
        },
        error: function (data) {
            console.log("error");
        },
    });
}

function getProductDetail(
    productId,
    productOptionValue1,
    productOptionName2,
    productOptionValue2,
    productOptionName3,
    productOptionValue3
) {
    unactiveAllOptionValue3();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    var ajaxUrl = "/product_detail/" + productId + "/get_product_detail";
    $.ajax({
        type: "POST",
        url: ajaxUrl,
        data: {
            product_option_value_1: JSON.stringify(productOptionValue1),
            product_option_name_2: JSON.stringify(productOptionName2),
            product_option_value_2: JSON.stringify(productOptionValue2),
            product_option_name_3: JSON.stringify(productOptionName3),
            product_option_value_3: JSON.stringify(productOptionValue3),
        },
        success: function (data) {
            var productDetailId = data.result.product_detail.id;
            document
                .getElementById("product_detail_id")
                .setAttribute("value", productDetailId);

            var shortDescription = data.result.product_detail.short_desc;
            var shortDescElement = document.getElementById("short_desc");
            removeAllChild(shortDescElement);
            if (shortDescription != null && shortDescription != "") {
                // set short description title
                var shortDescriptionTitleElement = document.createElement("p");
                shortDescriptionTitleElement.innerHTML = "Short description";
                shortDescElement.appendChild(shortDescriptionTitleElement);
                // set short description content
                var shortDescriptionContentElement =
                    document.createElement("p");
                shortDescriptionContentElement.innerHTML =
                    shortDescription.trim();
                shortDescElement.appendChild(shortDescriptionContentElement);
            }

            var price = data.result.product_detail.price;
            var priceElement = document.getElementById("price");
            removeAllChild(priceElement);
            priceElement.innerHTML = "$" + price;

            var quantity = data.result.product_detail.quantity;
            var stockStatusElement = document.getElementById("stock_status");
            removeAllChild(stockStatusElement);

            if (quantity > 0) stockStatusElement.innerHTML = "In stock";
            else {
                stockStatusElement.innerHTML = "In stock";
                var addToCartBtn = document.getElementById("add_to_cart");
                removeAllChild(addToCartBtn);
                addToCartBtn.parentElement.removeChild(addToCartBtn);
            }

            var stockQuantityElement =
                document.getElementById("stock_quantity");
            stockQuantityElement.value = quantity;
        },
        error: function (data) {
            console.log("error");
        },
    });
}

getProductOption1(document.getElementById("product_id").value);
activeDefaultOptionValue1();

// incr, decr number of product
document.getElementById("incr_btn").addEventListener("click", function () {
    var stockQuantityElement = document.getElementById("stock_quantity");
    var stockQuantity = parseInt(stockQuantityElement.value);
    var productQuantityElement = document.getElementById("product_quantity");
    var productQuantity = parseInt(productQuantityElement.value);

    if (productQuantity + 1 <= stockQuantity) {
        productQuantityElement.value = productQuantity + 1;
    } else {
        displayQuantityErrorAlert(
            "The current stock quantity is " + stockQuantity
        );
    }
});

document.getElementById("decr_btn").addEventListener("click", function () {
    var productQuantityElement = document.getElementById("product_quantity");
    var productQuantity = parseInt(productQuantityElement.value);

    if (productQuantity - 1 >= 0) {
        productQuantityElement.value = productQuantity - 1;
    } else {
        displayQuantityErrorAlert(
            "The product quantity must be a positive integer"
        );
    }
});

function displayQuantityErrorAlert(errorMessage) {
    Swal.fire({
        title: "Stock quantity is not enough!",
        text: errorMessage,
        icon: "warning",
        customClass: "swal-wide",
    });
}

document.getElementById("product_quantity").addEventListener("change", function () {
    var productQuantity = parseInt(this.value);
    var stockQuantityElement = document.getElementById("stock_quantity");
    var stockQuantity = stockQuantityElement.value;

    var addToCartBtn = document.getElementById("add_to_cart");
    if (productQuantity < 0) {
        displayQuantityErrorAlert("Product quantity must be a positive integer.");
        addToCartBtn.removeEventListener("click", addToCart);
    }
    else if (productQuantity > stockQuantity) {
        displayQuantityErrorAlert("Exceed the quantity in stock. The stock quantity is " + stockQuantity);
        addToCartBtn.removeEventListener("click", addToCart);
    }
    else {
        addToCartBtn.addEventListener("click", addToCart);
    }
});

document.getElementById("add_to_cart").addEventListener("click", addToCart);

function addToCart() {
    var productDetailIdElement = document.getElementById("product_detail_id");
    var quantityElement = document.getElementById("product_quantity");

    var productDetailId = productDetailIdElement.value;
    var quantity = quantityElement.value;

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    var ajaxUrl = "/add_to_cart";
    $.ajax({
        type: "POST",
        url: ajaxUrl,
        data: {
            product_detail_id: JSON.stringify(productDetailId),
            quantity: JSON.stringify(quantity)
        },
        success: function (data) {
            if (data.is_logged_in) {
                Swal.fire({
                    title: "Successfully!",
                    text: data.add_to_cart_mess,
                    icon: "success",
                    customClass: "swal-wide",
                });
            } else {
                Swal.fire({
                    icon: "warning",
                    title: "You must login before continuing.",
                    text: "Do you want to login?",
                    showCancelButton: true,
                    confirmButtonText: "Yes",
                    customClass: "swal-wide",
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        window.location.href = "/register";
                    }
                });
            }
        },
        error: function () {
            console.log("Something went wrong");
        },
    });
}

// product image slider
var smallImageElements = document.getElementsByName("small_image_frame");
var mainImageElement = document.getElementById("main_image_frame");

function setImageToMainImageElement(imgSrc) {
    mainImageElement.src = imgSrc;
}

smallImageElements.forEach((smallImageElement) => {
    smallImageElement.addEventListener("mouseover", function () {
        setImageToMainImageElement(this.src);
    });
});


