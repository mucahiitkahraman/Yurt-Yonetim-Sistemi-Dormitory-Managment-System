// Modal elementi
var modal = document.getElementById("imageModal");
var modalImg = document.getElementById("modalImage");
var captionText = document.getElementById("caption");

// Tüm img elementlerini seç
var imgs = document.querySelectorAll(".image-cell img");
imgs.forEach(function(img) {
    img.onclick = function() {
        modal.style.display = "block";
        modalImg.src = this.src;
        captionText.innerHTML = this.alt;
    }
});

// Kapatma butonu
var span = document.getElementsByClassName("close")[0];
span.onclick = function() {
    modal.style.display = "none";
}

// Yurt Ekleme Modalı
var addDormitoryBtn = document.getElementById("addDormitoryBtn");
var addDormitoryModal = document.getElementById("addDormitoryModal");
var closeBtn = addDormitoryModal.getElementsByClassName("close")[0];

addDormitoryBtn.onclick = function() {
    addDormitoryModal.style.display = "block";
}

closeBtn.onclick = function() {
    addDormitoryModal.style.display = "none";
}

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
    if (event.target == addDormitoryModal) {
        addDormitoryModal.style.display = "none";
    } else if (event.target == addRoomModal) {
        addRoomModal.style.display = "none";
    } else if (event.target == modal) {
        modal.style.display = "none";
    }
}

// Yurt Silme İşlemi
document.querySelectorAll('.delete-btn').forEach(function(button) {
    button.onclick = function() {
        var yurt_ID = this.getAttribute('data-id');
        if (confirm("Bu yurdu silmek istediğinizden emin misiniz?")) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "yurtsil.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                if (xhr.status == 200) {
                    alert(xhr.responseText);
                    location.reload(); // Sayfayı yenileyin
                } else {
                    alert("Bir hata oluştu.");
                }
            };
            xhr.send("yurt_ID=" + yurt_ID);
        }
    };
});
