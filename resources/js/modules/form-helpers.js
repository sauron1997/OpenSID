const $ = window.jQuery;

export function checkAll(id = '#checkall') {
  $(id).click(function () {
    if ($('.table ' + id).is(':checked')) {
      $('.table input[type=checkbox]').each(function () {
        $(this).prop('checked', true);
      });
    } else {
      $('.table input[type=checkbox]').each(function () {
        $(this).prop('checked', false);
      });
    }
    $('.table input[type=checkbox]').change();
    enableHapusTerpilih();
  });
  $('[data-toggle=tooltip]').tooltip();
}

export function enableHapusTerpilih() {
  if ($("input[name='id_cb[]']:checked:not(:disabled)").length <= 0) {
    $('.hapus-terpilih').addClass('disabled');
    $('.hapus-terpilih').attr('href', '#');
  } else {
    $('.hapus-terpilih').removeClass('disabled');
    $('.hapus-terpilih').attr('href', '#confirm-delete');
  }
}

export function deleteAllBox(idForm, action) {
  $('#confirm-delete').modal('show');
  $('#ok-delete').click(function () {
    $('#' + idForm).attr('action', action);
    $('#' + idForm).submit();
  });
  return false;
}

export function aksiBorongan(idForm, action) {
  $('#confirm-status').modal('show');
  $('#ok-status').click(function () {
    $('#' + idForm).attr('action', action);
    $('#' + idForm).submit();
  });
  return false;
}

export function modalBox() {
  $('#modalBox').on('show.bs.modal', function (e) {
    var link = $(e.relatedTarget);
    var title = link.data('title');
    var modal = $(this);
    modal.find('.modal-title').text(title);
    $(this).find('.fetched-data').load(link.attr('href'));
  });
  return false;
}

export function mapBox() {
  $('#mapBox').on('show.bs.modal', function (e) {
    var link = $(e.relatedTarget);
    $('.modal-header #myModalLabel').html(link.attr('data-title'));
    $(this).find('.fetched-data').load(link.attr('href'));
  });
}

export function formAction(idForm, action, target = '') {
  if (target !== '') {
    $('#' + idForm).attr('target', target);
  }
  $('#' + idForm).attr('action', action);
  $('#' + idForm).submit();
}

export function cari_nik() {
  $('#cari_nik').change(function () {
    $('#main').submit();
  });
  $('#cari_nik_suami').change(function () {
    $('#main').submit();
  });
  $('#cari_nik_istri').change(function () {
    $('#main').submit();
  });
}

export function select_options(select, params) {
  var url_data = select.attr('data-source') + params;
  select
    .find('option').not('.placeholder')
    .remove()
    .end();

  $.ajax({
    url: url_data,
  }).then(function (options) {
    JSON.parse(options).forEach(function (option) {
      var option_elem = $('<option>');
      option_elem
        .val(option[select.attr('data-valueKey')])
        .text(option[select.attr('data-displayKey')]);
      select.append(option_elem);
    });
  });
}

// Expose on window for legacy callers
window.checkAll = checkAll;
window.enableHapusTerpilih = enableHapusTerpilih;
window.deleteAllBox = deleteAllBox;
window.aksiBorongan = aksiBorongan;
window.modalBox = modalBox;
window.mapBox = mapBox;
window.formAction = formAction;
window.cari_nik = cari_nik;
window.select_options = select_options;
