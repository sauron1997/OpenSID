import { formatRupiah } from './utils.js';

const $ = window.jQuery;

$(document).ready(() => {
  // Confirm Delete Modal
  $('#confirm-delete').on('show.bs.modal', function (e) {
    var string = document.getElementById('confirm-delete').innerHTML;
    var hasil = string.replace('fa fa-text-width text-yellow', 'fa fa-exclamation-triangle text-red');
    document.getElementById('confirm-delete').innerHTML = hasil;

    var string2 = document.getElementById('confirm-delete').innerHTML;
    var hasil2 = string2.replace('Konfirmasi', '&nbspKonfirmasi');
    document.getElementById('confirm-delete').innerHTML = hasil2;
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });

  $('#confirm-status').on('show.bs.modal', function (e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });

  // Delay Alert (notification)
  setTimeout(function () {
    $('#notification').fadeIn('slow');
  }, 500);
  setTimeout(function () {
    $('#notification').fadeOut('slow');
  }, 2000);

  $('[checked="checked"]').parent().addClass('active');

  // Popover
  $('[data-rel="popover"]').popover({
    html: true,
    trigger: 'hover'
  });

  // Color picker
  $('.my-colorpicker2').colorpicker();

  // Text Editor
  $('#min-textarea').wysihtml5();

  // Sidebar menu expand scroll
  $('ul.sidebar-menu').on('expanded.tree', function (e) {
    e.stopImmediatePropagation();
    setTimeout(scrollTampil($('li.treeview.menu-open')[0]), 500);
  });

  // Tanda tangan laporan dan surat
  $('select[name=pamong_ttd]').change(function () {
    $('input[name=jabatan_ttd]').val($(this).find(':selected').data('jabatan'));
  });
  $('select[name=pamong_ketahui]').change(function () {
    $('input[name=jabatan_ketahui]').val($(this).find(':selected').data('jabatan'));
  });
  $('select[name=pamong_ttd]').trigger('change');
  $('select[name=pamong_ketahui]').trigger('change');

  // Input rupiah di form surat
  $('.rupiah').keyup(function () {
    var nilai = formatRupiah($(this).val(), 'Rp. ');
    $(this).val(nilai);
  });

  // #op_item checkbox styling
  $('#op_item input:checked').parent().css({ 'background': '#c9cdff', 'border': '0.5px solid #7a82eb' });
  $('#op_item input').change(function () {
    if ($(this).is('input:checked')) {
      $('#op_item input').parent().css({ 'background': '#fafafa' });
      $('#op_item input:checked').parent().css({ 'background': '#c9cdff', 'border': '0.5px solid #7a82eb' });
      $(this).parent().css({ 'background': '#c9cdff' });
    } else {
      $(this).parent().css({ 'background': '#fafafa', 'border': '0px' });
    }
  });
  $('#op_item label').click(function () {
    $(this).prev().trigger('click');
  });

  // Table responsive dropdown visibility fix
  $('.table-responsive').on('show.bs.dropdown', function (e) {
    var table = $(this),
      menu = $(e.target).find('.dropdown-menu'),
      tableOffsetHeight = table.offset().top + table.height(),
      menuOffsetHeight = $(e.target).offset().top + $(e.target).outerHeight(true) + menu.outerHeight(true);

    if (menuOffsetHeight > tableOffsetHeight) {
      table.css('padding-bottom', menuOffsetHeight - tableOffsetHeight);
      $('.table-responsive')[0].scrollIntoView(false);
    }
  });

  $('.table-responsive').on('hide.bs.dropdown', function () {
    $(this).css('padding-bottom', 0);
  });
});
