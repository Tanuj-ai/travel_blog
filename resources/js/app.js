import './bootstrap';
import Alpine from 'alpinejs';

// Import Leaflet
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

// Make Leaflet available globally
window.L = L;

// Fix Leaflet icon paths
delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
    iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
    iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
    shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png'
});

// Initialize Alpine.js
window.Alpine = Alpine;
Alpine.start();

// Log that app.js has loaded
console.log('app.js loaded, Leaflet available:', typeof window.L !== 'undefined');

