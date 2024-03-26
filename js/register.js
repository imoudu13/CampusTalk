document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('signupform').addEventListener('submit', function (e) {
        let password = document.getElementById('password').value;
        let confirm = document.getElementById('confirmpassword').value;

        if (password !== confirm) {
            alert('Please make sure your passwords match');
            e.preventDefault();
        } else {
            let formData = new FormData(document.getElementById("signupform"));

            // Send the form data to the PHP file using AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../processing/signup.php', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        try {
                            let response = JSON.parse(xhr.responseText);
                            if (response.error) {
                                // Handle duplicate username error
                                console.log("Username is not unique");
                                document.getElementById('errorMessage').textContent = "Username is not unique";
                                document.getElementById('errorMessage').style.color = "red";
                            }
                            if (response.success) {
                                // Redirect to the previous page upon successful registration
                                window.location.href = response.redirect;
                            }
                        } catch (error) {
                            console.log("Please enter a unique username");
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
    });
});
