const $ = window.jQuery;

$(document).ready(() => {
  // Format Tanggal dan Jam
  $('.datepicker').datepicker({
    weekStart: 1,
    language: 'id',
    format: 'dd-mm-yyyy',
    autoclose: true
  });

  $('#tgl_mulai').datetimepicker({
    locale: 'id',
    format: 'DD-MM-YYYY',
    useCurrent: false,
    date: moment(new Date())
  });
  $('#tgl_akhir').datetimepicker({
    locale: 'id',
    format: 'DD-MM-YYYY',
    useCurrent: false,
    minDate: moment(new Date()).add(-1, 'day'),
    date: moment(new Date()).add(1, 'M')
  });
  $('#tgl_mulai').datetimepicker().on('dp.change', function (e) {
    $('#tgl_akhir').data('DateTimePicker').minDate(moment(new Date(e.date)));
    $(this).data('DateTimePicker').hide();
    var tglAkhir = moment(new Date(e.date));
    tglAkhir.add(1, 'M');
    $('#tgl_akhir').data('DateTimePicker').date(tglAkhir);
  });

  $('#tgljam_mulai').datetimepicker({
    locale: 'id',
    format: 'DD-MM-YYYY HH:mm',
    useCurrent: false,
    date: moment(new Date()),
    sideBySide: true
  });
  $('#tgljam_akhir').datetimepicker({
    locale: 'id',
    format: 'DD-MM-YYYY HH:mm',
    useCurrent: false,
    minDate: moment(new Date()).add(-1, 'day'),
    date: moment(new Date()).add(1, 'day'),
    sideBySide: true
  });
  $('#tgljam_mulai').datetimepicker().on('dp.change', function (e) {
    $('#tgljam_akhir').data('DateTimePicker').minDate(moment(new Date(e.date)));
    var tglAkhir = moment(new Date(e.date));
    tglAkhir.add(1, 'day');
    $('#tgljam_akhir').data('DateTimePicker').date(tglAkhir);
  });

  $('.tgl_jam').datetimepicker({
    format: 'DD-MM-YYYY HH:mm:ss',
    locale: 'id'
  });
  $('.tgl').datetimepicker({
    format: 'DD-MM-YYYY',
    useCurrent: false,
    locale: 'id'
  });

  $('#tgl_1').datetimepicker({ format: 'DD-MM-YYYY', locale: 'id' });
  $('.tgl_1').datetimepicker({ format: 'DD-MM-YYYY', locale: 'id' });
  $('#tgl_2').datetimepicker({ format: 'DD-MM-YYYY', locale: 'id' });
  $('#tgl_3').datetimepicker({ format: 'DD-MM-YYYY', locale: 'id' });
  $('#tgl_4').datetimepicker({ format: 'DD-MM-YYYY', locale: 'id' });
  $('#tgl_5').datetimepicker({ format: 'DD-MM-YYYY', locale: 'id' });
  $('#tgl_6').datetimepicker({ format: 'DD-MM-YYYY', locale: 'id' });

  $('#jam_1').datetimepicker({ format: 'HH:mm:ss', locale: 'id' });
  $('#jam_2').datetimepicker({ format: 'HH:mm:ss', locale: 'id' });
  $('#jam_3').datetimepicker({ format: 'HH:mm:ss', locale: 'id' });

  $('#jammenit_1').datetimepicker({ format: 'HH:mm', locale: 'id' });
  $('#jammenit_2').datetimepicker({ format: 'HH:mm', locale: 'id' });
  $('#jammenit_3').datetimepicker({ format: 'HH:mm', locale: 'id' });

  // set otomatis hari
  $('.datepicker.data_hari').change(function () {
    var hari = {
      0: 'Minggu', 1: 'Senin', 2: 'Selasa', 3: 'Rabu', 4: 'Kamis', 5: 'Jumat', 6: 'Sabtu'
    };
    var t = $(this).datepicker('getDate');
    var i = t.getDay();
    $(this).closest('.form-group').find('.hari').val(hari[i]);
  });
});
