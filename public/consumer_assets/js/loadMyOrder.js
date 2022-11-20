var cancelOrderBtns = document.getElementsByName("cancel_order");

cancelOrderBtns.forEach(cancelOrderBtn => {
    cancelOrderBtn.addEventListener("click", function(){
        var orderId = parseInt(this.getAttribute("id"));
        Swal.fire({
            icon: "warning",
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            showCancelButton: true,
            confirmButtonText: "Yes",
            customClass: "swal-wide",
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                });
                var ajaxUrl = "/cancel_order/" + orderId;
                $.ajax({
                    type: "POST",
                    url: ajaxUrl,
                    success: function (data) {
                        if (data.cancel_order_mess.includes("Error")){
                            Swal.fire({
                                title: "Oops...",
                                text: data.cancel_order_mess,
                                icon: "error",
                                customClass: "swal-wide",
                            });
                        }
                        else {
                            window.location.reload();
                        }
                    },
                    error: function () {
                        console.log("Something went wrong");
                    },
                });
            }
        });
    });
});