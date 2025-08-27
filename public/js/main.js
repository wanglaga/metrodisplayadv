const navbar = document.getElementById('navbar');
const companyName = document.getElementById('company_name');
const navItem = document.querySelectorAll('.nav-item');
const navKontak = document.querySelectorAll('.nav-kontak');
const menuBtn = document.getElementById('menuBtn');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');
const navbarLogo = document.getElementById('navbarLogo');

function updateNavbarScroll() {
    if (window.scrollY > 10) {
        navbar.classList.remove('bg-transparent');
        navbar.classList.add('bg-slate-900');
        companyName.classList.add('text-white');
        companyName.classList.remove('text-slate-900');
        navItem.forEach(item => {
            item.classList.add('text-white');
            item.classList.remove('text-slate-900');
        });
        navKontak.forEach(kontak => {
            kontak.classList.add('bg-white');
            kontak.classList.remove('bg-slate-900');
            kontak.classList.add('text-slate-900');
            kontak.classList.remove('text-white');
            kontak.classList.add('hover:bg-white');
            kontak.classList.remove('hover:bg-slate-900');
        });
        navbarLogo.src = navbarLogo.dataset.white;
    } else {
        navbar.classList.add('bg-transparent');
        navbar.classList.remove('bg-slate-900');
        companyName.classList.remove('text-white');
        companyName.classList.add('text-slate-900');
        navItem.forEach(item => {
            item.classList.remove('text-white');
            item.classList.add('text-slate-900');
        });
        navKontak.forEach(kontak => {
            kontak.classList.remove('bg-white');
            kontak.classList.add('bg-slate-900');
            kontak.classList.remove('text-slate-900');
            kontak.classList.add('text-white');
            kontak.classList.remove('hover:bg-white');
            kontak.classList.add('hover:bg-slate-900');
        });
        navbarLogo.src = navbarLogo.dataset.dark;
    }
}

// Pastikan fungsi scroll dijalankan saat:
// 1. Scroll dilakukan
// 2. Halaman pertama kali dimuat (termasuk reload)
window.addEventListener('scroll', updateNavbarScroll);
window.addEventListener('load', updateNavbarScroll);

// Toggle sidebar
menuBtn.addEventListener('click', () => {
    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
});

overlay.addEventListener('click', () => {
    sidebar.classList.add('-translate-x-full');
    overlay.classList.add('hidden');
});

//Gesture Detection
let touchStartX = 0;
let touchEndX = 0;

document.addEventListener('touchstart', e => {
    touchStartX = e.changedTouches[0].screenX;
});

document.addEventListener('touchend', e => {
    touchEndX = e.changedTouches[0].screenX;
    handleGesture();
});

function handleGesture() {
    const distance = touchEndX - touchStartX;

    // Geser dari kiri ke kanan (buka sidebar)
    if (touchStartX < 50 && distance > 60) {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    }

    // Geser dari kanan ke kiri (tutup sidebar)
    if (touchStartX > 100 && distance < -60) {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.accordion-btn');
    const contents = document.querySelectorAll('.accordion-content');
    const icons = document.querySelectorAll('.accordion-btn svg');

    let active = null;

    buttons.forEach((btn, index) => {
        btn.addEventListener('click', () => {
            contents.forEach((c, i) => {
                c.style.maxHeight = '0px';
                icons[i].classList.remove('rotate-180');
            });

            if (active !== index) {
                contents[index].style.maxHeight = contents[index].scrollHeight + 'px';
                icons[index].classList.add('rotate-180');
                active = index;
            } else {
                active = null;
            }
        });
    });
});