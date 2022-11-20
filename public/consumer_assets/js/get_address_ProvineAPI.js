function getDataFromProvineAPI(){
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        }
    });
    var ajax_url = 'https://provinces.open-api.vn/api/?depth=3';
    $.ajax({
        type: 'GET',
        url: ajax_url,
        success: function(data) {
            loadAllProvine(data);
        },
        error: function() {
            console.log('Something went wrong');
        }
    });
}

function loadAllProvine(provines){
    var provine_select = document.getElementById("provine_select");
    provines.forEach(element => {
        var option = document.createElement("option");
        option.value = element.name;
        option.innerHTML = element.name;
        provine_select.appendChild(option);
    });
    loadAllDistrictFromProvine(provines);
    provine_select.addEventListener("change", function(){
        loadAllDistrictFromProvine(provines);
    });
}

function loadAllDistrictFromProvine(provines){
    var provineName = document.getElementById("provine_select").value;
    $("#district_select").empty();
    var districts = getAllDistrictFromProvine(provines, provineName);
    var district_select = document.getElementById("district_select");
    districts.forEach((element) => {
        var option = document.createElement("option");
        option.value = element.name;
        option.innerHTML = element.name;
        district_select.appendChild(option);
    });
    loadAllWardFromDistrict(districts);
    $("#district_select").off("change").change(function(){
        loadAllWardFromDistrict(districts);
    });
}

function loadAllWardFromDistrict(districts){
    var districtName = document.getElementById("district_select").value;
    $("#ward_select").empty();
    var wards = getAllWardFromDistrict(districts, districtName);
    var ward_select = document.getElementById("ward_select");
    wards.forEach((element) => {
        var option = document.createElement("option");
        option.value = element.name;
        option.innerHTML = element.name;
        ward_select.appendChild(option);
    });
}

function getAllDistrictFromProvine(provinces, provineName){
    for (element of provinces){
        if (element.name === provineName){
            return element.districts;
        }
    }
    return null;
}

function getAllWardFromDistrict(districts, districtName){
    for (element of districts){
        if (element.name === districtName){
            return element.wards;
        }
    }
    return null;
}

getDataFromProvineAPI();