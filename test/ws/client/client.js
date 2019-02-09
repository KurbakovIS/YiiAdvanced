if (!window.WebSocket) {
    alert("Ваш браузер стар")
}

let webSocket = new WebSocket("ws://localhost:8080");

document.getElementById('chat_form')
    .addEventListener('submit', function (e) {
        let textMessage = this.message.value;
        webSocket.send(textMessage);
        e.preventDefault();
        return false
    });

webSocket.onmessage = function (e) {
    let data = e.data,
        messageContainer = document.createElement('div'),
        textNode = document.createTextNode(data);

    messageContainer.appendChild(textNode);
    document.getElementById("root_chat")
        .appendChild(messageContainer);
};