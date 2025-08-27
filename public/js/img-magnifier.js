const zoomContainer = document.getElementById('zoomContainer');
const mainImage = document.getElementById('mainImage');

zoomContainer.addEventListener('mousemove', (e) => {
    const {
        left,
        top,
        width,
        height
    } = zoomContainer.getBoundingClientRect();
    const x = ((e.clientX - left) / width) * 100;
    const y = ((e.clientY - top) / height) * 100;

    mainImage.style.transformOrigin = `${x}% ${y}%`;
    mainImage.style.transform = 'scale(2)'; // level zoom
});

zoomContainer.addEventListener('mouseleave', () => {
    mainImage.style.transformOrigin = 'center center';
    mainImage.style.transform = 'scale(1)';
});