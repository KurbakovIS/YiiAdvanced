if (!window.WebSocket) {
    alert("Ваш браузер стар");
}
var taskId = window.location.search.split('&')[0].split('%')[1].split('F')[0];
var userId = window.location.search.split('&')[1].split('=')[1];
var dateTime = new Date();
var xhr = new XMLHttpRequest();

dateTime.toLocaleString();

var webSocket = new WebSocket("ws://localhost:8080");

document.getElementById('chat_form').addEventListener('submit', function (e) {
    var textMessage = this.message.value;
    webSocket.send('{"message":"' + textMessage + '",' +
        ' "id_User":"' + userId + '",' +
        '"id_Task":"' + taskId + '",' +
        '"timeMessage":"' + dateTime.toLocaleString() + '"}');
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