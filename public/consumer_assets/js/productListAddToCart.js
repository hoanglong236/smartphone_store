function defaultAddToCart(productDetailId) {
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
            quantity: JSON.stringify(1)
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