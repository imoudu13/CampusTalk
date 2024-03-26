document.addEventListener('DOMContentLoaded', function () {
    displayDepartmentsOnLoad();

    // setInterval(refreshPage, 10000);
    document.getElementById('edit-post-button').addEventListener('click', function () {
        resetLabelsForEdit(false);
        let postTitle = document.getElementById('edit-post-title').value;

        if (postTitle === '') {
            //force user to enter a title
            resetLabelsForEdit(true);
        } else {
            sendToEditPost();
        }
    });
    
    let postId = sessionStorage.getItem('postId');

    document.getElementById('delete-post').addEventListener('click', function () {
        let formData = new FormData();
        formData.append('postId', postId); // Append postId to the form data

        let xhr = new XMLHttpRequest();
        xhr.open('POST', '../processing/removepost.php', true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    try {
                        let response = JSON.parse(xhr.responseText);
                        if (response.error) {
                            // there is an error
                            console.log(xhr);
                        }
                        if (response.success) {
                            // Redirect to the previous page upon successful registration
                            window.location.href = 'index.php';
                        }
                    } catch (error) {
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
    });
    document.getElementById('commentButton').addEventListener('click', function () {
        let content = document.getElementById('commentBox').value;

        let requestData = {
            postId: postId,
            content: content
        };
        // Convert the data object to JSON
        let jsonData = JSON.stringify(requestData);

        let xhr = new XMLHttpRequest();
        xhr.open('POST', '../processing/comment.php', true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    try {
                        console.log(xhr);
                        let response = JSON.parse(xhr.responseText);
                        if (response.error) {
                            // print to console
                            console.error('Error: ' + response.error);
                        }
                        if (response.success) {
                            window.location.href = response.redirect;
                            console.log('Comment submitted successfully');
                        }
                    } catch (error) {
                        console.error('Error parsing JSON: ' + error);
                    }
                } else {
                    console.error('AJAX error: ' + xhr.status + ' - ' + xhr.statusText);
                }
            }
        };
        xhr.send(jsonData);
    });
});
function displayDepartmentsOnLoad() {
    let departmentContainer = document.querySelector('#department-container');
    // Make an AJAX request to fetch posts data from get_posts.php
    let xhr = new XMLHttpRequest();
    xhr.open('GET', '../processing/get_departments.php', true);
    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 400) {
            // Parse the JSON response. This will return an array of posts
            let departments = JSON.parse(xhr.responseText);

            // Iterate through the posts and display them
            departments.forEach(function (department) {
                // Create HTML elements for post title, content, and image
                let departmentP = document.createElement('p');
                departmentP.classList.add('sidebar-item', 'left-item', 'department');

                let link = document.createElement('a');
                link.setAttribute('data-id', department.departmentID);
                link.setAttribute('href', '#');
                link.textContent = department.departmentName;
                link.onclick = function () {
                    displayPostsOnLoad(this.getAttribute('data-id'));
                };


                // Append elements to the container
                departmentP.appendChild(link);
                departmentContainer.appendChild(departmentP);
            });
        } else {
            console.error('Error fetching departments:', xhr.statusText);
        }
    };
    xhr.onerror = function () {
        console.error('Error fetching posts:', xhr.statusText);
    };
    xhr.send();
}
// Function to refresh the page
function refreshPage() {
    location.reload(); // Reload the current page
}
//if the title is blank it will change the label to red and display a message otherewise the label will be Title and black
function resetLabelsForEdit(error) {
    document.getElementById('edit-title-label').textContent = error ? "You must enter a title" : "Title";
    document.getElementById('edit-title-label').style.color = error ? "red" : "black";
}
//this function sends the information edited information to php for processing
function sendToEditPost() {
    let formData = new FormData(document.getElementById("edit-post-form"));
    console.log("here");
    // Send the form data to the login processing file
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '../processing/editpost.php', true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                try {
                    let response = JSON.parse(xhr.responseText);
                    if (response.error) {
                        // there is an error
                        console.log(xhr);
                    }
                    if (response.success) {
                        // Redirect to the previous page upon successful registration
                        window.location.href = response.redirect;
                    }
                } catch (error) {
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