(function($, undefined) {
	"use strict";

	$(function() {
		$('.wpv-progress.pie').one('wpv-progress-visible', function() {
			$(this).addClass('started').easyPieChart({
				animate: 1000,
				scaleLength: 0,
				lineWidth: 3,
				size: 130,
				lineCap: 'square',
				onStep: function(from, to, value) {
					$(this.el).find('span:first').text(~~value);
				}
			});
		});

		$('.wpv-progress.number').each(function() {
			$(this).one('wpv-progress-visible', function() {
				$(this).addClass('started').wpvAnimateNumber({
					onStep: function(from, to, value) {
						$(this).find('span:first').text(~~value);
					}
				});
			});
		});

		var win = $(window),
			win_height = 0;

		var mobileSafari = navigator.userAgent.match(/(iPod|iPhone|iPad)/) && navigator.userAgent.match(/AppleWebKit/);

		win.imagesLoaded(function() {
			setTimeout(function() {
				$(window).scroll(function() {
					win_height = win.height();

					var all_in    = $(window).scrollTop() + win_height;

					$('.wpv-progress:not(.started)').each(function() {
						var el_height = $(this).outerHeight();
						var visible   = all_in > $(this).offset().top + el_height * ( el_height > 100 ? 0.3 : 0.6 );

						if ( visible || mobileSafari ) {
							$(this).trigger('wpv-progress-visible');
						}
					});
				}).scroll();
			}, 1000);
		});
	});

})(jQuery);