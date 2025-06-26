import './bootstrap';
import Alpine from 'alpinejs';
import './image-fallback';

window.Alpine = Alpine;
Alpine.start();

// Log that app.js has loaded
console.log('app.js loaded, Leaflet available:', typeof window.L !== 'undefined');


