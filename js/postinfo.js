document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('toggle-columns').addEventListener('click', function() {
        document.querySelector('.left').classList.toggle('collapsed');
        document.querySelector('.right').classList.toggle('collapsed');
    });
    displayDepartmentsOnLoad();

    // setInterval(refreshPage, 10000);
    let editButton = document.getElementById('edit-post-button');
    if (editButton){
        editButton.addEventListener('click', function () {
            resetLabelsForEdit(false);
            let postTitle = document.getElementById('edit-post-title').value;

            if (postTitle === '') {
                //force user to enter a title
                resetLabelsForEdit(true);
            } else {
                sendToEditPost();
            }
        });
    }


    
    let postId = sessionStorage.getItem('postId');

    let deleteButton = document.getElementById('delete-post');
    if (deleteButton){
        deleteButton.addEventListener('click', function () {
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
    }

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
                            if(response.error === "You must login/signup to create a post"){
                                let loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                                loginModal.show();
                            }else{
                                alert(response.error);
                                console.error('Error: ' + response.error);
                            }
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
    //stuff for admin
    if(document.getElementById('admin-search-form')) {
        document.getElementById('admin-search-form').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission

            // Fetch the search query from the input field for adminsa
            let searchQuery = document.getElementById('admin-search-bar').value;
            let searchType = document.getElementById('userInformationAdminSelect').value;

            handleAdminSearch(searchQuery, searchType);
        });
    }
});
//stuff for admin
function handleAdminSearch(query, type) {
    // Display modal based on admin input
    if (query === '') {
        document.getElementById('admin-search-bar').style.setProperty('border-color', 'red', 'important');
    } else {
        document.getElementById('admin-search-bar').style.removeProperty('border-color');

        let xhr = new XMLHttpRequest();
        xhr.open('POST', '../processing/search_users.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                let responseData = JSON.parse(xhr.responseText);
                displayUsersModal(responseData.users);
            } else {
                console.error('Error searching users:', xhr.statusText);
            }
        };

        xhr.onerror = function() {
            console.error('Error searching users:', xhr.statusText);
        };

        // Send the query and type as POST data
        let postData = `searchTerm=${encodeURIComponent(query)}&searchType=${encodeURIComponent(type)}`;
        xhr.send(postData);
    }
}

function displayUsersModal(users) {
    const modalBody = document.getElementById('userModalBody');

    // Clear previous content
    modalBody.innerHTML = '';

    // Populate modal with fetched users
    users.forEach(user => {
        const userContainer = document.createElement('div');
        userContainer.classList.add('user-container');
        userContainer.style.display = 'flex';
        userContainer.style.alignItems = 'center';
        userContainer.style.margin = '0.25em';

        const userElement = document.createElement('p');
        userElement.textContent = user.username;
        userElement.style.flexGrow = '1';
        userContainer.appendChild(userElement);
        // Check if the user is enabled
        if (user.isEnabled == 1) {
            // If enabled, display disable button
            const disableButton = document.createElement('button');
            disableButton.textContent = 'Disable';
            disableButton.classList.add('btn', 'btn-sm', 'btn-danger', 'disable-btn');
            disableButton.style.marginLeft = '10px';
            disableButton.setAttribute('data-user-id', user.userID);
            disableButton.addEventListener('click', disableUser);
            userContainer.appendChild(disableButton);
        } else {
            // If disabled, display enable button
            const enableButton = document.createElement('button');
            enableButton.textContent = 'Enable';
            enableButton.classList.add('btn', 'btn-sm', 'btn-success', 'enable-btn');
            enableButton.style.marginLeft = '10px';
            enableButton.setAttribute('data-user-id', user.userID);
            enableButton.addEventListener('click', enableUser);
            userContainer.appendChild(enableButton);
        }


        modalBody.appendChild(userContainer);
    });

    // Show the modal
    const userModal = new bootstrap.Modal(document.getElementById('userModal'));
    userModal.show();
}

function enableUser(){
    let userID = this.getAttribute('data-user-id');
    let newIsEnabledValue = 1;
    toggleEnabled(userID,newIsEnabledValue);
}
function disableUser(){
    let userID = this.getAttribute('data-user-id');
    let newIsEnabledValue = 0;
    toggleEnabled(userID,newIsEnabledValue);
}
function toggleEnabled(userID, newIsEnabledValue){

    let xhr = new XMLHttpRequest();
    xhr.open('POST', '../processing/enable_disable_user.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            let responseData = JSON.parse(xhr.responseText);

            // Find the button associated with the user ID
            const button = document.querySelector(`button[data-user-id="${userID}"]`);

            if (newIsEnabledValue == 0) { // Enabling
                button.classList.remove('btn-danger', 'disable-btn');
                button.classList.add('btn-success', 'enable-btn');
                button.textContent = 'Enable';
                button.removeEventListener('click', disableUser);
                button.addEventListener('click', enableUser);
            } else { // Disabling
                button.classList.remove('btn-success', 'enable-btn');
                button.classList.add('btn-danger', 'disable-btn');
                button.textContent = 'Disable';
                button.removeEventListener('click', enableUser);
                button.addEventListener('click', disableUser);
            }

        } else {
            console.error('Error disabling/enabling users', xhr.statusText);
        }
    };

    xhr.onerror = function() {
        console.error('Error disabling/enabling users', xhr.statusText);
    };

    // Send the query and type as POST data
    let enabledData = `userID=${encodeURIComponent(userID)}&newIsEnabledValue=${encodeURIComponent(newIsEnabledValue)}`;
    xhr.send(enabledData);

}
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
                    window.location.href = 'index.php?dataId=' + encodeURIComponent(this.getAttribute('data-id'));
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