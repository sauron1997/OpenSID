/**
 * OpenSID Admin Bundle Entry
 * @since Fase 2 - Build Pipeline
 * @updated Fase 3 - Import semua modul JS
 * @updated Fase 4 - AdminLTE 3 + Bootstrap 4
 */

// Vendor CSS (AdminLTE 3, Bootstrap 4, Font Awesome 5, etc.)
import '../css/admin-vendor.entry.css';

// Custom CSS
import '../css/admin-custom.css';

// Core utilities (base_url, formatRupiah, notification, dll)
import './modules/utils.js';

// jQuery-dependent initializations
import './modules/select2-init.js';
import './modules/file-upload.js';
import './modules/datetime-pickers.js';
import './modules/datatables-init.js';
import './modules/form-helpers.js';
import './modules/ui-helpers.js';

// Window load: auto-scroll to active menu
window.addEventListener('load', function () {
  var $ = window.jQuery;
  var activated_menu = $('li.treeview.active.menu-open')[0];
  if (activated_menu) {
    activated_menu.scrollIntoView({ behavior: 'smooth' });
  }
});

console.info('[OpenSID] Admin bundle loaded - Phase 3');
