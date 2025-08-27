const hero = document.querySelectorAll('.hero-fade');
let current = 0;

setInterval(() => {
    hero[current].classList.remove('opacity-100');
    hero[current].classList.add('opacity-0');

    current = (current + 1) % hero.length;

    hero[current].classList.remove('opacity-0');
    hero[current].classList.add('opacity-100');
}, 3000); // 3 detik