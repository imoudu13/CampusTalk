document.addEventListener('DOMContentLoaded', function () {

    document.getElementById('edit-info-form').addEventListener('submit', updateUserInfo);
    document.getElementById('new-password-form').addEventListener('submit', function(){
        let pw = document.getElementById('new-password');
        let confirm = document.getElementById('new-password-confirm');
        if(pw.value !== confirm.value){
            document.getElementById('new-password-label').textContent = "Passwords must match";
            document.getElementById('new-password-confirm-label').textContent = "Passwords must match";
            document.getElementById('new-password-label').style.color = "red";
            document.getElementById('new-password-confirm-label').style.color = "red";
        }else {
            updatePassword();
        }
    });
});
function updateUserInfo(){
    let formData = new FormData(document.getElementById("edit-info-form"));

            // Send the form data to the PHP file using AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../processing/update_user_info.php', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        try {
                            let response = JSON.parse(xhr.responseText);
                            if (response.error) {
                                // Handle duplicate username error
                                console.log(xhr);
                                console.log("Some error");
                            }
                            if (response.success) {
                                // Redirect to the previous page upon successful registration
                                window.location.href = response.redirect;
                            }
                        } catch (error) {
                            console.log(xhr);
                            console.error('Error parsing JSON: ' + error);
                            console.log(xhr.responseText);
                            // Handle the case where the response is not valid JSON
                        }
                    } else {
                        console.error('AJAX error: ' + xhr.status + ' - ' + xhr.statusText);
                    }
                }
            };
            xhr.send(formData);
}
function updatePassword(){
    let formData = new FormData(document.getElementById("new-password-form"));

    // Send the form data to the PHP file using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../processing/updatepassword.php', true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                try {
                    let response = JSON.parse(xhr.responseText);
                    if (response.error) {
                        // Handle duplicate username error
                        console.log(xhr);
                        console.log("Some error");
                    }
                    if (response.success) {
                        // Redirect to the previous page upon successful registration
                        window.location.href = response.redirect;
                    }
                } catch (error) {
                    console.log(xhr);
                    console.error('Error parsing JSON: ' + error);
                    console.log(xhr.responseText);
                    // Handle the case where the response is not valid JSON
                }
            } else {
                console.error('AJAX error: ' + xhr.status + ' - ' + xhr.statusText);
            }
        }
    };
    xhr.send(formData);
}