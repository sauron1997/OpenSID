const $ = window.jQuery;

$(document).ready(() => {
  // Select2 dengan fitur pencarian
  $('.select2').select2();

  $('.select2-nik-ajax').select2({
    ajax: {
      url: function () {
        return $(this).data('url');
      },
      dataType: 'json',
      delay: 250,
      data: function (params) {
        return {
          q: params.term || '',
          page: params.page || 1,
          filter_sex: $(this).data('filter-sex')
        };
       },
      processResults: function (data, params) {
        return {
          results: data.results,
          pagination: data.pagination
        };
      },
      cache: true
    },
    templateResult: function (penduduk) {
      if (!penduduk.id) {
        return penduduk.text;
      }
      var _tmpPenduduk = penduduk.text.split('\n');
      var $penduduk = $(
        '<div>' + _tmpPenduduk[0] + '</div><div>' + _tmpPenduduk[1] + '</div>'
      );
      return $penduduk;
    },
    placeholder: '--  Cari NIK / Tag ID Card / Nama Penduduk --',
    minimumInputLength: 0,
  });

  $('.select2-nik').select2({
    templateResult: function (penduduk) {
      if (!penduduk.id) {
        return penduduk.text;
      }
      var _tmpPenduduk = penduduk.text.split('\n');
      var $penduduk = $(
        '<div>' + _tmpPenduduk[0] + '</div><div>' + _tmpPenduduk[1] + '</div>'
      );
      return $penduduk;
    }
  });

  // Select2 dengan fitur pencarian dan boleh isi sendiri
  $('.select2-tags').select2( {
    tags: true
  });

  // Select2 untuk disposisi pae  form surat masuk
  $('#disposisi_kepada').select2({
    placeholder: "Pilih tujuan disposisi"
  });

  // Reset select2 ke nilai asli
  $('button[type="reset"]').click(function (e) {
    e.preventDefault();
    $(this).closest('form').get(0).reset();
    $('.select2').trigger('change');
  });
});
