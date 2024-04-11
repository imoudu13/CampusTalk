document.addEventListener('DOMContentLoaded', function () {
    let cid = getParameterByName('cid');

    // getMessages(cid);
    const messageContainer1 = document.querySelector(".course-message-container");
    messageContainer1.scrollTop = messageContainer1.scrollHeight;
    // the shit for sending a message
    document.getElementById('send-message').addEventListener('click', function () {
        let content = getText();

        sendMessage(cid, content);
    });
});
function getText() {
    return document.getElementById('message-input-id').value;
}
function sendMessage(cid, content) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '../processing/sendmessage.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    let requestData = {
        courseid: cid,
        content: content
    };

    let jsonData = JSON.stringify(requestData);

    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 400) {
            console.log(xhr);
            let responseData = JSON.parse(xhr.responseText);

            if (responseData.success) window.location.reload();
        } else {
            console.log('Error joining courses:', xhr.statusText);
        }
    };

    xhr.send(jsonData);
}
function getMessages(cid) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '../processing/coursemessages.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 400) {

            console.log(xhr);
            let responseData = JSON.parse(xhr.responseText);

            console.log(responseData);

            displayMessages(responseData.messages);

            // use response data to display comments
        } else {
            console.log('Error joining courses:', xhr.statusText);
        }
    };

    let params = 'cid=' + encodeURIComponent(cid);

    xhr.send(params);
}

function displayMessages(messageinfo) {
    messagesContainer = document.getElementById('message-container');

    messageinfo.forEach(function (message) {
        let messagesDiv = document.createElement('div');
        messagesDiv.classList.add('comment-container');
        messagesDiv.setAttribute('data-id', message.commentID); // Set data-id attribute
        // Create a new h5 element for the username
        let h5 = document.createElement('h5');
        h5.classList.add('username');
        h5.textContent = message.username; // Set username content

        // Create a new p element for the comment text
        let p = document.createElement('p');
        p.classList.add('comment-text');
        p.textContent = message.content; // Set comment text content

        // Append username and comment text elements to the comment container
        messagesDiv.appendChild(h5);
        messagesDiv.appendChild(p);

        // Append the comment container to the main container
        messagesContainer.appendChild(messagesDiv);
    });
}
function getParameterByName(name) {
    let url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    let regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}
