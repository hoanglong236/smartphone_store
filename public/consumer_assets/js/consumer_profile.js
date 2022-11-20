var updateProfile = document.getElementById("update_profile");
var cancel = document.getElementById("cancel");
var save = document.getElementById("save");

function setupEventListener(){
    var firstName = document.getElementById("firstname");
    var lastName = document.getElementById("lastname");
    var gender = document.getElementById("gender");
    var phone = document.getElementById("phone");
    var email = document.getElementById("email");

    var originalFirstName = firstName.value;
    var originalLastName = lastName.value;
    var originalGender = gender.value;
    var originalPhone = phone.value;
    var originalEmail = email.value;

    var updateProfileHandlerFunc = function updateProfileHandler(e){
        e.preventDefault();
        firstName.removeAttribute("disabled");
        lastName.removeAttribute("disabled");
        gender.removeAttribute("disabled");
        phone.removeAttribute("disabled");
        email.removeAttribute("disabled");

        cancel.removeAttribute("disabled");
        cancel.addEventListener("click", cancelUpdateProfileHandlerFunc);
        save.removeAttribute("disabled");
        save.addEventListener("click", saveProfileHandlerFunc);
        
        this.setAttribute("disabled", "");
        this.removeEventListener("click", updateProfileHandlerFunc);
    };

    var cancelUpdateProfileHandlerFunc = function cancelUpdateProfileHandler(e){
        e.preventDefault();
        firstName.value = originalFirstName;
        lastName.value = originalLastName;
        gender.value = originalGender;
        phone.value = originalPhone;
        email.value = originalEmail;

        firstName.setAttribute("disabled", "");
        lastName.setAttribute("disabled", "");
        gender.setAttribute("disabled", "");
        phone.setAttribute("disabled", "");
        email.setAttribute("disabled", "");

        save.setAttribute("disabled", "");
        save.removeEventListener("click", saveProfileHandlerFunc);
        updateProfile.removeAttribute("disabled");
        updateProfile.addEventListener("click", updateProfileHandlerFunc);

        this.setAttribute("disabled", "");
        this.removeEventListener("click", cancelUpdateProfileHandlerFunc);
    }

    var saveProfileHandlerFunc = function saveProfileHandler(e){
        e.preventDefault();
        var profile = {
            'firstname': firstName.value,
            'lastname': lastName.value,
            'gender': gender.value,
            'phone': phone.value,
            'email': email.value
        }
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            }
        });
        var ajax_url = '/update_profile_handle';
        $.ajax({
            type: 'POST',
            data: { profile: profile },
            dataType: 'json',
            url: ajax_url,
            success: function(data) {
                Swal.fire({
                    title: "Successfully!",
                    text: data.customer_message,
                    icon: "success",
                    customClass: "swal-wide"
                });
                document.getElementById("customer_name").firstChild.nodeValue = profile.firstname;
            },
            error: function() {
                console.log('Something went wrong');
            }
        });

        firstName.setAttribute("disabled", "");
        lastName.setAttribute("disabled", "");
        gender.setAttribute("disabled", "");
        phone.setAttribute("disabled", "");
        email.setAttribute("disabled", "");

        cancel.setAttribute("disabled", "");
        cancel.removeEventListener("click", cancelUpdateProfileHandlerFunc);
        updateProfile.removeAttribute("disabled");
        updateProfile.addEventListener("click", updateProfileHandlerFunc);

        this.setAttribute("disabled", "");
        this.removeEventListener("click", saveProfileHandlerFunc);
    }

    updateProfile.addEventListener("click", updateProfileHandlerFunc);
}

setupEventListener();