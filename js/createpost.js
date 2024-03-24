document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('submit-post').addEventListener('click', verifyPost);
    getDepartmentIds();
});
function verifyPost() {
    resetLabels(false);

    let postTitle = document.getElementById('post-title').value;


    if (postTitle === "") {
        //force them to enter a title
        resetLabels(true);
    } else {
        //send to the php file for insertion
        sendToPhp();
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
                    console.log(xhr);
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
//this function gets the department ids from the department column, then puts those ids in the drop down menu
function getDepartmentIds() {
    let deptContainer = document.getElementById("department-container");
    
    let pTags = deptContainer.getElementsByTagName("p");
    
    for(let i = 0; i < pTags.length; i++){
        let aTag = pTags[i].firstChild;
        console.log("inside the loop");
        // Do something with each <p> element, for example:
        console.log(aTag.textContent);
    }
}
//add the departments for this user to the dropdown on load
function displayDepartmentsForPost() {

}