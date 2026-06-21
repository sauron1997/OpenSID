// base_url detection - adapted for Vite bundle
var scripts = document.getElementsByTagName('script');
var last_script = scripts[scripts.length - 1];
var file_ini = last_script.src;
var base_url = file_ini.replace(/assets\/.*$/, '');
const $ = window.jQuery;

export function formatRupiah(angka, prefix, nol_sen = true) {
  var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split = number_string.split(','),
    sisa = split[0].length % 3,
    rupiah = split[0].substr(0, sisa),
    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

  if (ribuan) {
    var separator = sisa ? '.' : '';
    rupiah += separator + ribuan.join('.');
  }

  rupiah = split[1] != undefined ? rupiah + (nol_sen ? '' : ',' + split[1]) : rupiah;
  return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}

export function scrollTampil(elem) {
  elem.scrollIntoView({ behavior: 'smooth' });
}

export function _calculateAge(birthday) {
  if (birthday) {
    var parts = birthday.split('-');
    var birthdate = new Date(parts[2], parts[1] - 1, parts[0]);
    var ageDifMs = (new Date()).getTime() - birthdate.getTime();
    var ageDate = new Date(ageDifMs);
    return Math.abs(ageDate.getUTCFullYear() - 1970);
  }
}

export function urlencode(str) {
  str = (str + '').toString();
  return encodeURIComponent(str)
    .replace(/!/g, '%21')
    .replace(/'/g, '%27')
    .replace(/\(/g, '%28')
    .replace(/\)/g, '%29')
    .replace(/\*/g, '%2A');
}

export function notification(type, message) {
  if (type === '') { return; }
  $('#maincontent').prepend(''
    + '<div id="notification" class="alert alert-' + type + ' alert-dismissible">'
    + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
    + message + ''
    + '</div>'
    + ''
  );
}

// Expose on window AND export for internal use
export { base_url };
window.base_url = base_url;
window.formatRupiah = formatRupiah;
window.scrollTampil = scrollTampil;
window._calculateAge = _calculateAge;
window.urlencode = urlencode;
window.notification = notification;
