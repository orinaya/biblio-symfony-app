import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');


window.toggleAccordion = function(id) {
    const submenu = document.getElementById(id);
    submenu.classList.toggle('hidden');

    const button = document.querySelector(`button[onclick="toggleAccordion('${id}')"]`);
    button.classList.toggle('active');
}
