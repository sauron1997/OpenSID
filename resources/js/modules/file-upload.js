const $ = window.jQuery;

$(document).ready(() => {
  function initFileUpload(suffix) {
    const browserId = '#file_browser' + suffix;
    const fileId = '#file' + suffix;
    const pathId = '#file_path' + suffix;

    $(browserId).click((e) => {
      e.preventDefault();
      $(fileId).click();
    });

    $(fileId).change(function () {
      $(pathId).val($(this).val());
      if (suffix === '') {
        if ($(this).val() === '') {
          $('#' + $(this).data('submit')).attr('disabled', 'disabled');
        } else {
          $('#' + $(this).data('submit')).removeAttr('disabled');
        }
      }
    });

    $(pathId).click(() => {
      $(browserId).click();
    });
  }

  initFileUpload('');
  initFileUpload('1');
  initFileUpload('2');
  initFileUpload('3');
  initFileUpload('4');
});
