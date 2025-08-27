
const toggleBtn = document.getElementById('toggleBtn');
const specContent = document.getElementById('specContent');
const fadeMask = document.getElementById('fadeMask');
const collapsedHeight = 340;
let expanded = false;

specContent.style.maxHeight = collapsedHeight + 'px';

toggleBtn.addEventListener('click', () => {
    expanded = !expanded;
    if (expanded) {
        specContent.style.maxHeight = specContent.scrollHeight + 'px';
        fadeMask.classList.replace('fade-visible', 'fade-hidden');
        toggleBtn.textContent = 'Show less';
        setTimeout(() => {
            specContent.style.maxHeight = 'none';
        }, 700);
        setTimeout(() => {
            specContent.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 100);
    } else {
        specContent.style.maxHeight = specContent.scrollHeight + 'px'; // reset first
        fadeMask.classList.replace('fade-hidden', 'fade-visible');
        toggleBtn.textContent = 'Show more';
        requestAnimationFrame(() => {
            specContent.style.maxHeight = collapsedHeight + 'px';
        });
        setTimeout(() => {
            specContent.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 100);
    }
});