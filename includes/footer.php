<footer class="page-footer grey lighten-3 z-depth-2">
		<div class="footer-copyright grey-text text-darken-3 center-align">
			<div class="container">&copy; 2018 Botnet 2018 hakanonymos</div>
		</div>
</footer>
    <script src="assets/js/jquery-2.1.4.min.js" type="text/javascript"></script> 
    <script>
    if (!window.jQuery) { document.write('<script src="assets/js/jquery-2.1.4.min.js"><\/script>'); }
    </script> <!-- jQuery Plugins --> 
    <script src="assets/js/materialize.min.js" type="text/javascript"></script>
    <script src="assets/js/initialize.js" type="text/javascript"></script>
    <script>
       window.onload = function(){
       $('.preloader-wrapper').css({ display: "none" });
       /* Fade to page */
       $('.stage').velocity({ opacity: 0 }, 1000, function() { 
           $('body').removeClass('loading');
       });
       }
       $('.datepicker').pickadate({
        format: 'yyyy-mm-dd',
        selectYears: true,
        selectMonths: true,
        selectYears: 50,
        max: true
      })
      $("select[required]").css({display: "inline", height: 0, padding: 0, width: 0});
      var x = document.getElementById("dob").required;
      var x = document.getElementById("profile_pic").required;
      $('#logo-link').css('cursor', 'pointer');
      $('#logo-link').click(function(){
         window.location.href='./';
      })
    </script>
</body>
</html>
