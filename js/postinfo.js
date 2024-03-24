document.addEventListener('DOMContentLoaded', function () {
    displayDepartmentsOnLoad();
});
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