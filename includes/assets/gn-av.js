/**! GN Age Verify */
(function ($) {
  $(document).ready(function () {
    // Check Verification!
    var verified = readCookie('gn-age-verified');
    if (verified) {
      // Already verified
      $('#gn-av-overlay-wrap').remove();
      return;
    } else {
      // Show the verification
      $('#gn-av-overlay-wrap').show();

      // Verification Handler
      $('#gn_av_verify').click(function (event) {
        event.preventDefault();

        if ($('#gn_av_verify_confirm').is(':checked')) {
          // Age verified!
          writeCookie('gn-age-verified', '1', 3);

          $('#gn-av-overlay-wrap').fadeOut(function () {
            $(this).remove();
          });

          return;
        }
      });
    }

    function writeCookie(name, value, days) {
      var expires = '';
      if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = '; expires=' + date.toGMTString();
      }

      document.cookie = name + '=' + value + expires + '; path=/';
    }

    function readCookie(name) {
      var nameEQ = name + '=';
      var ca = document.cookie.split(';');
      for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
      }

      return null;
    }

    function eraseCookie(name) {
      createCookie(name, '', -1);
    }
  });
})(jQuery);
