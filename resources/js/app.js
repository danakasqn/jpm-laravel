// Axios (dla AJAX)
import './bootstrap';

// Bootstrap (JS dla collapse, modali itd.)
import 'bootstrap';
import { Collapse } from 'bootstrap';

// Alpine.js
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Wymuszenie aktywacji collapse po załadowaniu strony (ważne dla Vite/production)
document.addEventListener('DOMContentLoaded', () => {
    const collapseElements = document.querySelectorAll('.collapse');
    collapseElements.forEach(el => {
        // tylko jeśli ma klasę 'show' (czyli otwarta)
        if (el.classList.contains('show')) {
            new Collapse(el, { toggle: false });
        }
    });
});
