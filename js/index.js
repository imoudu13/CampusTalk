document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('toggle-columns').addEventListener('click', function() {
        document.querySelector('.left').classList.toggle('collapsed');
        document.querySelector('.right').classList.toggle('collapsed');
    });
    //display most recent posts on page load. This is for registered and non-registered users
    const initialPostDepartment = "all"
    displayPostsOnLoad(initialPostDepartment);
    //display all departments on load
    displayDepartmentsOnLoad();
});
function displayPostsOnLoad(department){
    let postsContainer = document.querySelector('.posts-container');
    postsContainer.innerHTML = '';
    // Make an AJAX request to fetch posts data from get_posts.php
    let xhr = new XMLHttpRequest();
    xhr.open('GET', `../processing/get_posts.php?department=${department}`, true);
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
            // Parse the JSON response. This will return an array of posts
            let posts = JSON.parse(xhr.responseText);

            // Iterate through the posts and display them
            posts.forEach(function(post) {
                // Create HTML elements for post title, content, and image
                let link = document.createElement('div');
                link.classList.add('post-link');

                link.addEventListener('click', function(event) {
                    if (!event.target.classList.contains('like-btn') && !event.target.classList.contains('comment-input')) {
                        // Store the data-id in session storage
                        let postId = post.postID; // Assuming post.postID contains the ID
                        sessionStorage.setItem('postId', postId);
                        // Redirect to post.php
                        window.location.href = 'post.php';
                    }
                });
                

                let postContainer = document.createElement('div');
                postContainer.classList.add('post-container');
                postContainer.setAttribute('data-id', post.postID);

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

                let userInputContainer = document.createElement('div');
                userInputContainer.classList.add('user-input-post');

                let commentInput = document.createElement('input');
                commentInput.classList.add('form-control', 'comment-input');
                commentInput.setAttribute('type', 'text');
                commentInput.setAttribute('placeholder', 'Write a comment...');

                let likeButton = document.createElement('button');
                likeButton.classList.add('btn', 'btn-primary', 'like-btn');
                likeButton.setAttribute('data-post-id', post.postID);
                likeButton.textContent = 'Like ';

                let likeCount = document.createElement('span');
                likeCount.classList.add('badge', 'bg-secondary', 'like-count');
                likeCount.textContent = "Number of likes";
                likeButton.appendChild(likeCount);

                userInputContainer.appendChild(commentInput);
                userInputContainer.appendChild(likeButton);

                imageContainer.appendChild(imageElement);
                postContainer.appendChild(titleElement);
                postContainer.appendChild(contentElement);
                postContainer.appendChild(imageContainer);
                postContainer.appendChild(userInputContainer);
                link.appendChild(postContainer);
                postsContainer.appendChild(link);
            });
        }    else {
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
                departmentP.classList.add('sidebar-item', 'left-item', 'department');

                let link = document.createElement('a');
                link.setAttribute('data-id', department.departmentID);
                link.setAttribute('href','#');
                link.textContent = department.departmentName;
                link.onclick = function() {
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
    xhr.onerror = function() {
        console.error('Error fetching posts:', xhr.statusText);
    };
    xhr.send();
}
