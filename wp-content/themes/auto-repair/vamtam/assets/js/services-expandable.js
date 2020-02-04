(function($, undefined) {
	"use strict";

	var logError = function( message ) {
		if ( 'console' in window ) {
			console.error( message );
		}
	};

	$.WPV.expandable = function(el, options) {
		el = $(el);

		var self = this,
			open = el.find('>.open'),
			closed = el.find('>.closed');

		self.doOpen = function() {
			requestAnimationFrame( function() {
				var duration = $.WPV.MEDIA.layout['layout-below-max'] ? Math.max(options.duration, 400) : options.duration,
					oheight = open.outerHeight();

				if(!oheight) {
					open.css({height: 'auto'});
					oheight = open.outerHeight();
					open.css({height: 0});
				}

				duration = Math.max(duration, oheight/200*duration);

				closed.queue(closed.queue().slice(0,1));
				open.queue(open.queue().slice(0,1));

				el.addClass('state-hover');

				requestAnimationFrame( function() {
					closed.transition({
						y: -oheight
					}, duration, options.easing, function() {
						el.removeClass('state-closed').addClass('state-open');
					});

					open.transition({
						y: -oheight,
						scaleY: 1
					}, duration, options.easing);
				} );
			} );
		};

		self.doClose = function() {
			requestAnimationFrame( function() {
				var duration = $.WPV.MEDIA.layout['layout-below-max'] ? Math.max(options.duration, 400) : options.duration,
					oheight = open.outerHeight();

				if(!oheight) {
					open.css({height: 'auto'});
					oheight = open.outerHeight();
					open.css({height: 0});
				}

				duration = Math.max(duration, oheight/200*duration);

				closed.queue(closed.queue().slice(0,1));
				open.queue(open.queue().slice(0,1));

				el.removeClass('state-hover');

				requestAnimationFrame( function() {
					closed.transition({
						y: 0
					}, duration, options.easing, function() {
						el.removeClass('state-open').addClass('state-closed');
					});

					open.transition({
						y: 0,
						scaleY: 0
					}, duration, options.easing);
				} );
			} );
		};

		self.init = function() {
			el.addClass('state-closed');

			el.addClass( 'expandable-animation-3d' );

			if ( ! Modernizr.touch ) {
				el
					.bind('mouseenter.expandable', self.doOpen)
					.bind('mouseleave.expandable', self.doClose);

				el.find('a').bind('click', function(e) {
					if(el.hasClass('state-closed'))
						e.preventDefault();
				});
			}
		};

		var defaults = {
			duration: 250,
			easing: 'linear'
		};
		options = $.extend({}, defaults, options);

		this.init();
	};

	$.fn.wpv_expandable = function(options, callback){
		if ( typeof options === 'string' ) {
			// call method
			var args = Array.prototype.slice.call( arguments, 1 );

			this.each(function() {
				var instance = $.data( this, 'wpv_expandable' );
				if ( !instance ) {
					logError( "cannot call methods on expandable prior to initialization; attempted to call method '" + options + "'" );
					return;
				}
				if ( !$.isFunction( instance[options] ) || options.charAt(0) === "_" ) {
					logError( "no such method '" + options + "' for expandable instance" );
					return;
				}

				// apply method
				$.WPV.expandable[ options ].apply( instance, args );
			});
		} else {
			this.each(function() {
				var instance = $.data( this, 'wpv_expandable' );
				if ( instance ) {
					// apply options & init
					instance.option( options );
					instance._init( callback );
				} else {
					// initialize new instance
					$.data( this, 'wpv_expandable', new $.WPV.expandable( this, options, callback ) );
				}
			});
		}

		return this;
	};

	$('.services.has-more').wpv_expandable();
})(jQuery);