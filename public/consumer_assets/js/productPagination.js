document.getElementById("page_index").addEventListener("change", function(){
    var pageIndex = parseInt(this.value);
    var pageCount = parseInt(this.getAttribute("max"));
    if (pageIndex <= pageCount){
        var categorySlug = document.getElementById("category_slug").value;
        var pageSize = document.getElementById("page_size").value;
        window.location.href = "/category_page/" + categorySlug + "/" + pageIndex + "/" + pageSize;
    }
    else {
        Swal.fire({
            title: "Oops...",
            text: "The page index must be between >=1 and <=" + pageCount,
            icon: "error",
            customClass: "swal-wide",
        });
    }
});

document.getElementById("page_size").addEventListener("change", function(){
    var categorySlug = document.getElementById("category_slug").value;
    var pageSize = this.value;
    window.location.href = "/category_page/" + categorySlug + "/" + 1 + "/" + pageSize;
});

document.getElementById("go_to_first_btn").addEventListener("click", function(event){
    var categorySlug = document.getElementById("category_slug").value;
    var pageIndexElement = document.getElementById("page_index");
    var pageIndex = parseInt(pageIndexElement.value);
    var pageSize = document.getElementById("page_size").value;
    if (pageIndex > 1){
        pageIndex = 1;
        pageIndexElement.value = pageIndex;
        window.location.href = "/category_page/" + categorySlug + "/" + pageIndex + "/" + pageSize;
    }
    else event.preventDefault();
});

document.getElementById("previous_btn").addEventListener("click", function(event){
    var categorySlug = document.getElementById("category_slug").value;
    var pageIndexElement = document.getElementById("page_index");
    var pageIndex = parseInt(pageIndexElement.value);
    var pageSize = document.getElementById("page_size").value;
    if (pageIndex > 1){
        pageIndex -= 1;
        pageIndexElement.value = pageIndex;
        window.location.href = "/category_page/" + categorySlug + "/" + pageIndex + "/" + pageSize;
    }   
    else event.preventDefault();
});

document.getElementById("go_to_last_btn").addEventListener("click", function(event){
    var categorySlug = document.getElementById("category_slug").value;
    var pageIndexElement = document.getElementById("page_index");
    var pageIndex = parseInt(pageIndexElement.value);
    var pageCount = parseInt(pageIndexElement.getAttribute("max"));
    var pageSize = document.getElementById("page_size").value;
    if (pageIndex < pageCount){
        pageIndex = pageCount;
        pageIndexElement.value = pageIndex;
        window.location.href = "/category_page/" + categorySlug + "/" + pageIndex + "/" + pageSize;
    }
    else event.preventDefault();
});

document.getElementById("next_btn").addEventListener("click", function(event){
    var categorySlug = document.getElementById("category_slug").value;
    var pageIndexElement = document.getElementById("page_index");
    var pageIndex = parseInt(pageIndexElement.value);
    var pageCount = parseInt(pageIndexElement.getAttribute("max"));
    var pageSize = document.getElementById("page_size").value;
    if (pageIndex < pageCount){
        pageIndex += 1;
        pageIndexElement.value = pageIndex;
        window.location.href = "/category_page/" + categorySlug + "/" + pageIndex + "/" + pageSize;
    }
    else event.preventDefault();
});