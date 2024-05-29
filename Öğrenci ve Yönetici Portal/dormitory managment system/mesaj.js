// Mesajları yükleme fonksiyonu
function loadMessages(ogrenci_ID) {
    document.getElementById("alanOgrenci_ID").value = ogrenci_ID;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("chat_messages").innerHTML = this.responseText;
        }
    };
    xhr.open("GET", "mesajgonder.php?alanOgrenci_ID=" + ogrenci_ID, true);
    xhr.send();
}

// Mesaj gönderme fonksiyonu
// Mesaj gönderme fonksiyonu
function sendMessage() {
    var mesajInput = document.getElementById("mesaj").value.trim();
    if (mesajInput === "") {
        document.getElementById("message_status").innerHTML = "Mesaj boş bırakılamaz!";
        return;
    }

    var formData = new FormData(document.getElementById("message_form"));
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("message_status").innerHTML = this.responseText;
            document.getElementById("mesaj").value = ""; // Formun içeriğini temizle
            // Gönderilen mesajı mesaj listesine ekleyin
            var newMessage = document.createElement('div');
            newMessage.classList.add('message');
            newMessage.innerHTML = this.responseText;
            document.getElementById("chat_messages").appendChild(newMessage);
        } else if (this.readyState == 4 && this.status != 200) {
            document.getElementById("message_status").innerHTML = "Bir hata oluştu!";
        }
    };
    xhr.open("POST", "mesajgonder.php", true);
    xhr.send(formData);
}

setInterval(function() {
    loadMessages(document.getElementById("alanOgrenci_ID").value);
}, 500);
