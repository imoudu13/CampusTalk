document.addEventListener('DOMContentLoaded', function() {
    let navSearchBar = document.getElementById('nav-search-bar');
    let navSearchForm = document.getElementById('nav-search-form');
    if (navSearchBar && navSearchForm){
        navSearchForm.addEventListener('submit', function (event) {
            event.preventDefault();
            //display posts from all departments with the specified key in their title or body
           displayPostsOnLoad('all',navSearchBar.value);
        });
    }
});


