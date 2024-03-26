document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('submit-post').addEventListener('click', verifyPost);
});
function verifyPost() {
    resetLabels(false);
    let isGoodPost = true;
    let postTitle = document.getElementById('post-title').value;
    let departmentSelect = document.getElementById('departmentSelect');
    let selectedValue = departmentSelect.value;
    if (postTitle === "") {
        //force them to enter a title
        isGoodPost = false;
        resetLabels(true);
    }if(selectedValue === '0'){
        isGoodPost = false
        document.getElementById('departmentLabel').style.setProperty('color', 'red', 'important');
    }
    else {
        let isEnabled = sessionStorage.getItem('isEnabled');
        //send to the php file for insertion

        if(isEnabled == 1){
            if (isGoodPost) sendToPhp();
        }
        else {
            alert("You have been disabled by an admin. Cannot create post :(")
        }

    }
}

//if the title is blank it will change the label to red and display a message otherewise the label will be Title and black
function resetLabels(error) {
    document.getElementById('title-label').textContent = error ? "You must enter a title" : "Title";
    document.getElementById('title-label').style.color = error ? "red" : "black";
}

//this function send shit to php
function sendToPhp() {
    let formData = new FormData(document.getElementById("create-post-form"));
    // Send the form data to the login processing file
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../processing/createpost.php', true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                try {
                    let response = JSON.parse(xhr.responseText);
                    if (response.error) {
                        // there is an error
                    }
                    if (response.success) {
                        // Redirect to the previous page upon successful registration
                        window.location.href = response.redirect;
                    }
                } catch (error) {
                    console.log("Some error");
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

