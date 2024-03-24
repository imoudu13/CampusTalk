document.addEventListener('DOMContentLoaded', function(){

    //get user data when the page loads up
    getUserProfile();

    //For password form submission 
    document.getElementById('passwordForm').addEventListener('submit', function(e){
        e.preventDefault();
        const newPassword = document.getElementById('newPassword').value;
        changePassword(newPassword);
    })

});


function getUserProfile(){
    fetch('../processing/get_userprofile.php')
        .then(response => response.json())
        .then(data =>{
            displayUserProfile(data);
        })
        .catch(error => console.error('Error fetching user data: ', error));
}


function displayUserProfile(user){
    document.getElementById('username').textContent = user.username;
    document.getElementById('email').textContent = user.email;
    document.getElementById('firstName').textContent = user.firstName;
    document.getElementById('lastName').textContent = user.lastName;
    document.getElementById('createdAt').textContent = user.createdAt;
}


function changePassword(newPassword){

    fetch('changepassword.php', {
        method: 'POST',
        headers:{
            'Content - Type': 'application/json'
        },
        body: JSON.stringify({newPassword: newPassword})
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('message').textContent = data.message;
    })
    .catch(error => console.error('Error changing password: ', error));
    alert('An error occured while changing password. Please try again.')

}