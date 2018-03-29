/* -------------------------------------------------+
	Title: Mate Rio - Admin Template
	Framework: Materialize
    Version: 1.0 stable
	Author: Jozef Dvorský, http://www.creatingo.com
+-------------------------------------------------- */

(function($){
  $(function(){

    "use strict";
  
    var window_width = $(window).width();
	
	// Color Palette - convert rgb to hex value string
    function rgb2hex(rgb) {
      if (/^#[0-9A-F]{6}$/i.test(rgb)) { return rgb; }

      rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);

      if (rgb === null) { return "N/A"; }

      function hex(x) {
          return ("0" + parseInt(x).toString(16)).slice(-2);
      }

      return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
    }
	
	// Color Palette - auto add color captions
    $('.dynamic-color .col').each(function () {
      $(this).children().each(function () {
        var color = $(this).css('background-color'),
            classes = $(this).attr('class');
        $(this).html(rgb2hex(color) + " " + classes);
        if (classes.indexOf("darken") >= 0 || $(this).hasClass('black')) {
          $(this).css('color', 'rgba(255,255,255,.9');
        } else {
          $(this).css('color', 'rgba(0,0,0,.9');
        }
      });
    });
  
	$('.slider').slider({full_width: true});
    $('.button-collapse').sideNav();
	$('.datepicker').pickadate({selectYears: 20});
    $('select').not('.disabled').material_select();
	$('.materialboxed').materialbox();
	$('.modal-trigger').leanModal();
	$('.tabs-wrapper').pushpin({ top: 240 });
	$('.scrollspy').scrollSpy();

  
	// Handlig window resize actions, after resize event is done
  
	var rtime;
	var timeout = false;
	var delta = 200;
	$(window).resize(function() {
		rtime = new Date();
		if (timeout === false) {
			timeout = true;
			setTimeout(resizeend, delta);
		}
	});

	function resizeend() {
		if (new Date() - rtime < delta) {
			setTimeout(resizeend, delta);
		} else {
			timeout = false;
			// Here goes custom actions
			$('#slide-menu').simplebar('recalculate');
		}               
	}
	
	
	// Set checkbox on forms.html to indeterminate
    var indeterminateCheckbox = document.getElementById('indeterminate-checkbox');
    if (indeterminateCheckbox !== null)
      indeterminateCheckbox.indeterminate = true;

  
	// Floating-Fixed table of contents
    if ($('nav').length) {
      $('.toc-wrapper').pushpin({ top: $('nav').height() });
    }
    else if ($('#index-banner').length) {
      $('.toc-wrapper').pushpin({ top: $('#index-banner').height() });
    }
    else {
      $('.toc-wrapper').pushpin({ top: 0 });
    }

}); // end of document ready
})(jQuery); // end of jQuery name space