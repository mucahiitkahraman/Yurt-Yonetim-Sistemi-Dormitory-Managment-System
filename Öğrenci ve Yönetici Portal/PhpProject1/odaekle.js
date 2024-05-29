// Oda Ekleme Modalı
var addRoomBtn = document.getElementById("addRoomBtn");
var addRoomModal = document.getElementById("addRoomModal");
var closeRoomBtn = addRoomModal.getElementsByClassName("close")[0];

addRoomBtn.onclick = function() {
    addRoomModal.style.display = "block";
}

closeRoomBtn.onclick = function() {
    addRoomModal.style.display = "none";
}

// Modal dışında tıklanınca kapatma
window.onclick = function(event) {
    if (event.target == addRoomModal) {
        addRoomModal.style.display = "none";
    }
}
