const thumbsContainer = document.getElementById('thumbs');
const mainImage = document.getElementById("mainImage");
const thumbnails = document.querySelectorAll('.thumbnail-img');

// Fungsi ubah gambar utama
function changeImage(button, imageUrl) {
    mainImage.classList.remove("opacity-100");
    mainImage.classList.add("opacity-0");

    setTimeout(() => {
        mainImage.src = imageUrl;
        mainImage.onload = () => {
            mainImage.classList.remove("opacity-0");
            mainImage.classList.add("opacity-100");
        };
    }, 150);

    thumbnails.forEach(img => {
        img.classList.remove("border-slate-500");
        img.classList.add("border-slate-300");
    });

    const selectedImg = button.querySelector("img");
    selectedImg.classList.remove("border-slate-300");
    selectedImg.classList.add("border-slate-500");
}

// Tombol prev dan next pakai scrollBy
document.getElementById("nextBtn").addEventListener("click", () => {
    thumbsContainer.scrollBy({
        left: 120,
        behavior: "smooth"
    });
});
document.getElementById("prevBtn").addEventListener("click", () => {
    thumbsContainer.scrollBy({
        left: -120,
        behavior: "smooth"
    });
});

// Swipe dengan jari (touch)
let isTouching = false;
let startX = 0;
let scrollLeft = 0;

thumbsContainer.addEventListener('touchstart', (e) => {
    isTouching = true;
    startX = e.touches[0].pageX - thumbsContainer.offsetLeft;
    scrollLeft = thumbsContainer.scrollLeft;
}, { passive: true });

thumbsContainer.addEventListener('touchmove', (e) => {
    if (!isTouching) return;
    const x = e.touches[0].pageX - thumbsContainer.offsetLeft;
    const walk = startX - x;
    thumbsContainer.scrollLeft = scrollLeft + walk;
}, { passive: true });

thumbsContainer.addEventListener('touchend', () => {
    isTouching = false;
});