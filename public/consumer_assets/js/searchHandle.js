document.getElementById("search_btn").addEventListener("click", function() {
    console.log("test");
    var keyword = document.getElementById("search_field").value;
    window.location.href = "/search_result_page/" + keyword + "/" + 1 + "/" + 9;
})