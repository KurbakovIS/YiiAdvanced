if (!window.WebSocket) {
    alert("Ваш браузер стар");
}
var taskId = window.location.search.split('&')[1].split('=')[1];
// var dateTime = new Date();
// var xhr = new XMLHttpRequest();
//
// dateTime.toLocaleString();

var webSocket = new WebSocket('ws://localhost:8080/?id_Task=' + taskId);

document.getElementById('chat_form').addEventListener('submit', function (e) {
    var data = {
        message: this.message.value,
        id_Task: this.id_Task.value,
        id_User: this.id_User.value,
    };
    webSocket.send(JSON.stringify(data));
    e.preventDefault();
    return false;
});

webSocket.onmessage = function (e) {
    var data = e.data,
        messageContainer = document.createElement('div'),
        textNode = document.createTextNode(data);

    messageContainer.appendChild(textNode);
    document.getElementById("root_chat")
        .appendChild(messageContainer);
};