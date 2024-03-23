document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('loginform').addEventListener('submit', submission);
});

function submission(e) {
    resetLabels();

    let password = document.getElementsByName('password')[0].value;
    let username = document.getElementsByName('username')[0].value;

    if (username === "") {    // make sure username is entered
        document.getElementById('usernamelabel').textContent = "Please enter a username";
        document.getElementById('usernamelabel').style.color = "red";
    } else if (password === "") {  // make sure pw is entered
        document.getElementById('passwordlabel').textContent = "Please enter a password";
        document.getElementById('passwordlabel').style.color = "red";
    } else {  
        // if both are entered then process the info in php
        sendData();
    }
}
function sendData() {
    let formData = new FormData(document.getElementById("loginform"));

    // Send the form data to the login processing file
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../processing/login.php', true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                try {
                    let response = JSON.parse(xhr.responseText);
                    if (response.error === "no result") {
                        // Unrecognized username
                        logout();
                        document.getElementById('usernamelabel').textContent = "Incorrect username";
                        document.getElementById('usernamelabel').style.color = "red";
                    }
                    if (response.error === "incorrect password") {
                        // Unrecognized username
                        logout();
                        document.getElementById('passwordlabel').textContent = "Incorrect password";
                        document.getElementById('passwordlabel').style.color = "red";
                    }
                    if (response.success) {
                        // Redirect to the previous page upon successful registration
                        window.location.href = response.redirect;
                        login();
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
//this functions resets the labels to username and password on a click so that it's not still displaying the previous error message
function resetLabels() {
    document.getElementById('usernamelabel').textContent = "Username";
    document.getElementById('usernamelabel').style.color = "black";

    document.getElementById('passwordlabel').textContent = "Password";
    document.getElementById('passwordlabel').style.color = "black";
}

// these functions are responsible for display or hidding the login/logout buttons when a user logs in or out
function login() {
    document.getElementById("loginbutton").style.display = 'none';
    console.log('User is logged in');

    document.getElementById("logout").style.display = 'inline';
}
function logout() {
    document.getElementById('loginbutton').style.display = 'block';
    console.log('User is logged out');

    document.getElementById("logout").style.display = 'none';
}