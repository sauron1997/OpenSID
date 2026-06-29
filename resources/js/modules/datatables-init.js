import { base_url } from './utils.js';

const $ = window.jQuery;

$(document).ready(() => {
  $('#tabel1').DataTable();
  $('#tabel2').DataTable({
    'paging': false,
    'lengthChange': false,
    'searching': false,
    'ordering': false,
    'info': false,
    'autoWidth': false,
    'scrollX': true
  });
  $('#tabel3').DataTable({
    'paging': true,
    'lengthChange': true,
    'searching': true,
    'ordering': true,
    'info': true,
    'autoWidth': false,
    'scrollX': true
  });

  // formatting datatable Program Bantuan
  $('#table-program').DataTable({
    "paging": false,
    "info": false,
    "searching": false,
    "columnDefs": [
      {
        "targets": [0, 1, 3, 4, 5, 6, 7],
        "orderable": false
      },
      {
        "targets": [4],
        "className": "text-center"
      },
      {
        "targets": [7],
        "render": function (data, type, full, meta) {
          if (data == 0) {
            return "Tidak Aktif";
          }
          return "Aktif";
        }
      }
    ]
  });

  // Penggunaan datatable di inventaris
  var t = $('#tabel4').DataTable({
    'paging': true,
    'lengthChange': true,
    'searching': true,
    'ordering': true,
    'info': true,
    'autoWidth': false,
    'language': {
      'url': base_url + '/assets/bootstrap/js/dataTables.indonesian.lang'
    }
  });
  t.on('order.dt search.dt', function () {
    t.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
      cell.innerHTML = i + 1;
    });
  }).draw();
});
