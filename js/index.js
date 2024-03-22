document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('toggle-columns').addEventListener('click', function() {
        document.querySelector('.left').classList.toggle('collapsed');
        document.querySelector('.right').classList.toggle('collapsed');
    });
    //display most recent posts on page load. This is for registered and non-registered users
    displayPostsOnLoad();
    //display all departments on load
    displayDepartmentsOnLoad();
});
function displayPostsOnLoad(){
    let postsContainer = document.querySelector('.posts-container');

    // Make an AJAX request to fetch posts data from get_posts.php
    let xhr = new XMLHttpRequest();
    xhr.open('GET', '../processing/get_posts.php', true);
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
            // Parse the JSON response. This will return an array of posts
            let posts = JSON.parse(xhr.responseText);

            // Iterate through the posts and display them
            posts.forEach(function(post) {
                // Create HTML elements for post title, content, and image
                let link = document.createElement('a');
                link.setAttribute('href', 'post.php');

                let postContainer = document.createElement('div');
                postContainer.classList.add('post-container');

                let titleElement = document.createElement('h2');
                titleElement.classList.add('post-title');
                titleElement.innerHTML = post.title + " - <span style='font-size: 0.5em;'>" + post.departmentName + "</span>";


                let contentElement = document.createElement('p');
                contentElement.classList.add('post-text');
                contentElement.textContent = post.content;

                let imageContainer = document.createElement('p');
                imageContainer.classList.add('image-container', 'post-img');

                let imageElement = document.createElement('img');
                imageElement.src = 'data:image/png;base64,' + post.postImage;

                // Append elements to the container
                imageContainer.appendChild(imageElement);
                postContainer.appendChild(titleElement);
                postContainer.appendChild(contentElement);
                postContainer.appendChild(imageContainer);
                link.appendChild(postContainer);
                postsContainer.appendChild(link);
            });
        } else {
            console.error('Error fetching posts:', xhr.statusText);
        }
    };
    xhr.onerror = function() {
        console.error('Error fetching posts:', xhr.statusText);
    };
    xhr.send();
}

function displayDepartmentsOnLoad(){
    let departmentContainer = document.querySelector('#department-container');

    // Make an AJAX request to fetch posts data from get_posts.php
    let xhr = new XMLHttpRequest();
    xhr.open('GET', '../processing/get_departments.php', true);
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
            // Parse the JSON response. This will return an array of posts
            let departments = JSON.parse(xhr.responseText);

            // Iterate through the posts and display them
            departments.forEach(function(department) {
                // Create HTML elements for post title, content, and image
                let departmentP = document.createElement('p');
                departmentP.classList.add('sidebar-item', 'left-item');

                let link = document.createElement('a');
                link.setAttribute('href', '#');
                link.setAttribute('data-id', department.departmentID);
                link.textContent = department.departmentName;



                // Append elements to the container
                departmentP.appendChild(link);
                departmentContainer.appendChild(departmentP);
            });
        } else {
            console.error('Error fetching departments:', xhr.statusText);
        }
    };
    xhr.onerror = function() {
        console.error('Error fetching posts:', xhr.statusText);
    };
    xhr.send();
}
