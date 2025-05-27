import './bootstrap';
import 'bootstrap'; // ← to jest kluczowe!

import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

import { Collapse } from 'bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const collapseElements = document.querySelectorAll('.collapse');
    collapseElements.forEach(el => new Collapse(el));
});