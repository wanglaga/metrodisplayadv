const carousel = document.getElementById("carousel-benefit");
const images = carousel.querySelectorAll("img");
let currentIndex = 0;

function showImage(index) {
    images.forEach((img, i) => {
        img.style.opacity = i === index ? "1" : "0";
    });
}

function nextImage() {
    currentIndex = (currentIndex + 1) % images.length;
    showImage(currentIndex);
}

// Inisialisasi
showImage(currentIndex);

// Jalankan otomatis tiap 3 detik
setInterval(nextImage, 3000);