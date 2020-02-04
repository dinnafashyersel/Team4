/**
 * Often used vanilla js functions, so that we don't need
 * to use all of underscore/jQuery
 */
(function( undefined ) {
	"use strict";

	var v = ( window.VAMTAM = window.VAMTAM || {} ); // Namespace

	// Returns a function, that, as long as it continues to be invoked, will not
	// be triggered. The function will be called after it stops being called for
	// N milliseconds. If `immediate` is passed, trigger the function on the
	// leading edge, instead of the trailing.
	v.debounce = function( func, wait, immediate ) {
		var timeout;
		return function() {
			var context = this, args = arguments;
			var later = function() {
				timeout = null;
				if ( ! immediate ) func.apply( context, args );
			};
			var callNow = immediate && ! timeout;
			clearTimeout( timeout );
			timeout = setTimeout( later, wait );
			if ( callNow ) func.apply( context, args );
		};
	};

	// vanilla jQuery.fn.offset() replacement
	// @see https://plainjs.com/javascript/styles/get-the-position-of-an-element-relative-to-the-document-24/

	v.offset = function( el ) {
		var rect = el.getBoundingClientRect(),
		scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,
		scrollTop = window.pageYOffset || document.documentElement.scrollTop;
		return { top: rect.top + scrollTop, left: rect.left + scrollLeft };
	};

	// Faster scroll-based animations

	v.scroll_handlers = [];
	v.latestKnownScrollY = 0;

	var ticking = false;

	v.addScrollHandler = function( handler ) {
		requestAnimationFrame( function() {
			handler.init();
			v.scroll_handlers.push( handler );

			handler.measure( v.latestKnownScrollY );
			handler.mutate( v.latestKnownScrollY );
		} );
	};

	v.onScroll = function() {
		v.latestKnownScrollY = window.pageYOffset;

		if ( ! ticking ) {
			ticking = true;

			requestAnimationFrame( function() {
				var i;

				for ( i = 0; i < v.scroll_handlers.length; i++ ) {
					v.scroll_handlers[i].measure( v.latestKnownScrollY );
				}

				for ( i = 0; i < v.scroll_handlers.length; i++ ) {
					v.scroll_handlers[i].mutate( v.latestKnownScrollY );
				}

				ticking = false;
			} );
		}
	};

	window.addEventListener( 'scroll', v.onScroll, { passive: true } );

	// Load an async script
	v.load_script = function( src, callback ) {
		var s = document.createElement('script');
		s.type = 'text/javascript';
		s.async = true;
		s.src = src;

		if ( callback ) {
			s.onload = callback;
		}

		document.getElementsByTagName('script')[0].before( s );
	};
})();
/**
 * jQuery gMap - Google Maps API V3
 *
 * @url     http://github.com/marioestrada/jQuery-gMap
 * @author  Mario Estrada <me@mario.ec> based on original plugin by Cedric Kastner <cedric@nur-text.de>
 * @version 2.1.1
 */
(function($, undefined) {
	"use strict";

	// Main plugin function
	$.fn.gMap = function(options, methods_options) {
		var $this, args;
		//Asynchronously load Maps API
		if ( (!window.google || !google.maps) && !window.google_maps_api_loading) {
			$this = this;
			args = arguments;
			var cb = 'callback_' + Math.random().toString().replace('.', '');

			window.google_maps_api_loading = cb;

			window[cb] = function() {
				$.fn.gMap.apply($this, args);
				$(window).trigger('google-maps-async-loading');
				window[cb] = null;
				try {
					delete window[cb];
				} catch(e) {}
			};

			var key = window.VAMTAM_FRONT && window.VAMTAM_FRONT.gmap_api_key ? '&key=' + VAMTAM_FRONT.gmap_api_key : '';

			$.getScript(location.protocol + '//maps.googleapis.com/maps/api/js?v=3&sensor=false&callback=' + cb + key);
			return this;
		} else if ( (!window.google || !google.maps) && window.google_maps_api_loading) {
			$this = this;
			args = arguments;

			$(window).bind('google-maps-async-loading', function() {
				$.fn.gMap.apply($this, args);
			});

			return this;
		}

		// Optional methods
		switch (options) {
			case 'addMarker':
				return $(this).trigger('gMap.addMarker', [methods_options.latitude, methods_options.longitude, methods_options.content, methods_options.icon, methods_options.popup]);
			case 'centerAt':
				return $(this).trigger('gMap.centerAt', [methods_options.latitude, methods_options.longitude, methods_options.zoom]);
		}

		// Build main options before element iteration
		var opts = $.extend({}, $.fn.gMap.defaults, options);

		// Iterate through each element
		return this.each(function() {
			// Create map and set initial options
			var $gmap = new google.maps.Map(this);

			// Create new object to geocode addresses
			var $geocoder = new google.maps.Geocoder();

			// Check for address to center on
			if (opts.address) {
				// Get coordinates for given address and center the map
				$geocoder.geocode({
					address: opts.address
				}, function(gresult) {
					if (gresult && gresult.length) $gmap.setCenter(gresult[0].geometry.location);
				});
			} else {
				// Check for coordinates to center on
				if (opts.latitude && opts.longitude) {
					// Center map to coordinates given by option
					$gmap.setCenter(new google.maps.LatLng(opts.latitude, opts.longitude));
				} else {
					// Check for a marker to center on (if no coordinates given)
					if ($.isArray(opts.markers) && opts.markers.length > 0) {
						// Check if the marker has an address
						if (opts.markers[0].address) {
							// Get the coordinates for given marker address and center
							$geocoder.geocode({
								address: opts.markers[0].address
							}, function(gresult) {
								if (gresult && gresult.length > 0) $gmap.setCenter(gresult[0].geometry.location);
							});
						} else {
							// Center the map to coordinates given by marker
							$gmap.setCenter(new google.maps.LatLng(opts.markers[0].latitude, opts.markers[0].longitude));
						}
					} else {
						// Revert back to world view
						$gmap.setCenter(new google.maps.LatLng(34.885931, 9.84375));
					}
				}
			}
			$gmap.setZoom(opts.zoom);

			// Set the preferred map type
			$gmap.setMapTypeId(google.maps.MapTypeId[opts.maptype]);

			// Set scrollwheel option
			var map_options = {
				scrollwheel: opts.scrollwheel,
				disableDoubleClickZoom: !opts.doubleclickzoom
			};
			// Check for map controls
			if (opts.controls === false) {
				$.extend(map_options, {
					disableDefaultUI: true
				});
			} else if (opts.controls.length !== 0) {
				$.extend(map_options, opts.controls, {
					disableDefaultUI: true
				});
			}

			$gmap.setOptions($.extend(map_options, opts.custom));

			// Create new icon
			var gicon = new google.maps.Marker();

			// Set icon properties from global options
			var marker_icon = new google.maps.MarkerImage(opts.icon.image);
			marker_icon.size = new google.maps.Size(opts.icon.iconsize[0], opts.icon.iconsize[1]);
			marker_icon.anchor = new google.maps.Point(opts.icon.iconanchor[0], opts.icon.iconanchor[1]);
			gicon.setIcon(marker_icon);

			if (opts.icon.shadow) {
				var marker_shadow = new google.maps.MarkerImage(opts.icon.shadow);
				marker_shadow.size = new google.maps.Size(opts.icon.shadowsize[0], opts.icon.shadowsize[1]);
				marker_shadow.anchor = new google.maps.Point(opts.icon.shadowanchor[0], opts.icon.shadowanchor[1]);
				gicon.setShadow(marker_shadow);
			}

			// Bind actions
			$(this).bind('gMap.centerAt', function(e, latitude, longitude, zoom) {
				if (zoom) $gmap.setZoom(zoom);

				$gmap.panTo(new google.maps.LatLng(parseFloat(latitude), parseFloat(longitude)));
			});

			var last_infowindow;
			$(this).bind('gMap.addMarker', function(e, latitude, longitude, content, icon, popup) {
				var glatlng = new google.maps.LatLng(parseFloat(latitude), parseFloat(longitude));

				var gmarker = new google.maps.Marker({
					position: glatlng
				});

				if (icon) {
					marker_icon = new google.maps.MarkerImage(icon.image);
					marker_icon.size = new google.maps.Size(icon.iconsize[0], icon.iconsize[1]);
					marker_icon.anchor = new google.maps.Point(icon.iconanchor[0], icon.iconanchor[1]);
					gmarker.setIcon(marker_icon);

					if (icon.shadow) {
						marker_shadow = new google.maps.MarkerImage(icon.shadow);
						marker_shadow.size = new google.maps.Size(icon.shadowsize[0], icon.shadowsize[1]);
						marker_shadow.anchor = new google.maps.Point(icon.shadowanchor[0], icon.shadowanchor[1]);
						gicon.setShadow(marker_shadow);
					}
				} else {
					gmarker.setIcon(gicon.getIcon());
					gmarker.setShadow(gicon.getShadow());
				}

				if (content) {
					if (content === '_latlng') content = latitude + ', ' + longitude;

					var infowindow = new google.maps.InfoWindow({
						content: opts.html_prepend + content + opts.html_append
					});

					google.maps.event.addListener(gmarker, 'click', function() {
						if(last_infowindow)
							last_infowindow.close();
						infowindow.open($gmap, gmarker);
						last_infowindow = infowindow;
					});

					if(popup)
						infowindow.open($gmap, gmarker);
				}
				gmarker.setMap($gmap);
			});

			var addMarker = function(marker, $this) {
				return function(gresult) {
					// Create marker
					if (gresult && gresult.length > 0) {
						$($this).trigger('gMap.addMarker', [gresult[0].geometry.location.lat(), gresult[0].geometry.location.lng(), marker.html, marker.icon, marker.popup]);
					}
				};
			};

			// Loop through marker array
			for (var j = 0; j < opts.markers.length; j++) {
				// Get the options from current marker
				var marker = opts.markers[j];

				// Check if address is available
				if (marker.address) {
					// Check for reference to the marker's address
					if (marker.html === '_address') marker.html = marker.address;

					// Get the point for given address
					var $this = this;
					$geocoder.geocode({
						address: marker.address
					}, (addMarker)(marker, $this));
				} else {
					$(this).trigger('gMap.addMarker', [marker.latitude, marker.longitude, marker.html, marker.icon, marker.popup]);
				}
			}
		});

	};

	// Default settings
	$.fn.gMap.defaults = {
		address: '',
		latitude: 0,
		longitude: 0,
		zoom: 1,
		markers: [],
		controls: [],
		scrollwheel: false,
		doubleclickzoom: true,
		maptype: 'ROADMAP',
		html_prepend: '<div class="gmap_marker">',
		html_append: '</div>',
		icon: {
			image: "https://www.google.com/mapfiles/marker.png",
			shadow: "https://www.google.com/mapfiles/shadow50.png",
			iconsize: [20, 34],
			shadowsize: [37, 34],
			iconanchor: [9, 34],
			shadowanchor: [6, 34]
		}
	};

})(jQuery);
/*! Magnific Popup - v0.9.5 - 2013-08-21
* http://dimsemenov.com/plugins/magnific-popup/
* Copyright (c) 2013 Dmitry Semenov; */
;(function($) {
  "use strict";
/*>>core*/
/**
 *
 * Magnific Popup Core JS file
 *
 */


/**
 * Private static constants
 */
var CLOSE_EVENT = 'Close',
	BEFORE_CLOSE_EVENT = 'BeforeClose',
	AFTER_CLOSE_EVENT = 'AfterClose',
	BEFORE_APPEND_EVENT = 'BeforeAppend',
	MARKUP_PARSE_EVENT = 'MarkupParse',
	OPEN_EVENT = 'Open',
	CHANGE_EVENT = 'Change',
	NS = 'mfp',
	EVENT_NS = '.' + NS,
	READY_CLASS = 'mfp-ready',
	REMOVING_CLASS = 'mfp-removing',
	PREVENT_CLOSE_CLASS = 'mfp-prevent-close';


/**
 * Private vars
 */
var mfp, // As we have only one instance of MagnificPopup object, we define it locally to not to use 'this'
	MagnificPopup = function(){},
	_isJQ = !!(window.jQuery),
	_prevStatus,
	_window = $(window),
	_body,
	_document,
	_prevContentType,
	_wrapClasses,
	_currPopupType;


/**
 * Private functions
 */
var _mfpOn = function(name, f) {
		mfp.ev.on(NS + name + EVENT_NS, f);
	},
	_getEl = function(className, appendTo, html, raw) {
		var el = document.createElement('div');
		el.className = 'mfp-'+className;
		if(html) {
			el.innerHTML = html;
		}
		if(!raw) {
			el = $(el);
			if(appendTo) {
				el.appendTo(appendTo);
			}
		} else if(appendTo) {
			appendTo.appendChild(el);
		}
		return el;
	},
	_mfpTrigger = function(e, data) {
		mfp.ev.triggerHandler(NS + e, data);

		if(mfp.st.callbacks) {
			// converts "mfpEventName" to "eventName" callback and triggers it if it's present
			e = e.charAt(0).toLowerCase() + e.slice(1);
			if(mfp.st.callbacks[e]) {
				mfp.st.callbacks[e].apply(mfp, $.isArray(data) ? data : [data]);
			}
		}
	},
	_setFocus = function() {
		(mfp.st.focus ? mfp.content.find(mfp.st.focus).eq(0) : mfp.wrap).focus();
	},
	_getCloseBtn = function(type) {
		if(type !== _currPopupType || !mfp.currTemplate.closeBtn) {
			mfp.currTemplate.closeBtn = $( mfp.st.closeMarkup.replace('%title%', mfp.st.tClose ) );
			_currPopupType = type;
		}
		return mfp.currTemplate.closeBtn;
	},
	// Initialize Magnific Popup only when called at least once
	_checkInstance = function() {
		if(!$.magnificPopup.instance) {
			mfp = new MagnificPopup();
			mfp.init();
			$.magnificPopup.instance = mfp;
		}
	},
	// Check to close popup or not
	// "target" is an element that was clicked
	_checkIfClose = function(target) {

		if($(target).hasClass(PREVENT_CLOSE_CLASS)) {
			return;
		}

		var closeOnContent = mfp.st.closeOnContentClick;
		var closeOnBg = mfp.st.closeOnBgClick;

		if(closeOnContent && closeOnBg) {
			return true;
		} else {

			// We close the popup if click is on close button or on preloader. Or if there is no content.
			if(!mfp.content || $(target).hasClass('mfp-close') || (mfp.preloader && target === mfp.preloader[0]) ) {
				return true;
			}

			// if click is outside the content
			if(  (target !== mfp.content[0] && !$.contains(mfp.content[0], target))  ) {
				if(closeOnBg) {
					// last check, if the clicked element is in DOM, (in case it's removed onclick)
					if( $.contains(document, target) ) {
						return true;
					}
				}
			} else if(closeOnContent) {
				return true;
			}

		}
		return false;
	},
	// CSS transition detection, http://stackoverflow.com/questions/7264899/detect-css-transitions-using-javascript-and-without-modernizr
	supportsTransitions = function() {
		var s = document.createElement('p').style, // 's' for style. better to create an element if body yet to exist
			v = ['ms','O','Moz','Webkit']; // 'v' for vendor

		if( s.transition !== undefined ) {
			return true;
		}

		while( v.length ) {
			if( v.pop() + 'Transition' in s ) {
				return true;
			}
		}

		return false;
	};



/**
 * Public functions
 */
MagnificPopup.prototype = {

	constructor: MagnificPopup,

	/**
	 * Initializes Magnific Popup plugin.
	 * This function is triggered only once when $.fn.magnificPopup or $.magnificPopup is executed
	 */
	init: function() {
		var appVersion = navigator.appVersion;
		mfp.isIE7 = appVersion.indexOf("MSIE 7.") !== -1;
		mfp.isIE8 = appVersion.indexOf("MSIE 8.") !== -1;
		mfp.isLowIE = mfp.isIE7 || mfp.isIE8;
		mfp.isAndroid = (/android/gi).test(appVersion);
		mfp.isIOS = (/iphone|ipad|ipod/gi).test(appVersion);
		mfp.supportsTransition = supportsTransitions();

		// We disable fixed positioned lightbox on devices that don't handle it nicely.
		// If you know a better way of detecting this - let me know.
		mfp.probablyMobile = (mfp.isAndroid || mfp.isIOS || /(Opera Mini)|Kindle|webOS|BlackBerry|(Opera Mobi)|(Windows Phone)|IEMobile/i.test(navigator.userAgent) );
		_body = $(document.body);
		_document = $(document);

		mfp.popupsCache = {};
	},

	/**
	 * Opens popup
	 * @param  data [description]
	 */
	open: function(data) {

		var i;

		if(data.isObj === false) {
			// convert jQuery collection to array to avoid conflicts later
			mfp.items = data.items.toArray();

			mfp.index = 0;
			var items = data.items,
				item;
			for(i = 0; i < items.length; i++) {
				item = items[i];
				if(item.parsed) {
					item = item.el[0];
				}
				if(item === data.el[0]) {
					mfp.index = i;
					break;
				}
			}
		} else {
			mfp.items = $.isArray(data.items) ? data.items : [data.items];
			mfp.index = data.index || 0;
		}

		// if popup is already opened - we just update the content
		if(mfp.isOpen) {
			mfp.updateItemHTML();
			return;
		}

		mfp.types = [];
		_wrapClasses = '';
		if(data.mainEl && data.mainEl.length) {
			mfp.ev = data.mainEl.eq(0);
		} else {
			mfp.ev = _document;
		}

		if(data.key) {
			if(!mfp.popupsCache[data.key]) {
				mfp.popupsCache[data.key] = {};
			}
			mfp.currTemplate = mfp.popupsCache[data.key];
		} else {
			mfp.currTemplate = {};
		}



		mfp.st = $.extend(true, {}, $.magnificPopup.defaults, data );
		mfp.fixedContentPos = mfp.st.fixedContentPos === 'auto' ? !mfp.probablyMobile : mfp.st.fixedContentPos;

		if(mfp.st.modal) {
			mfp.st.closeOnContentClick = false;
			mfp.st.closeOnBgClick = false;
			mfp.st.showCloseBtn = false;
			mfp.st.enableEscapeKey = false;
		}


		// Building markup
		// main containers are created only once
		if(!mfp.bgOverlay) {

			// Dark overlay
			mfp.bgOverlay = _getEl('bg').on('click'+EVENT_NS, function() {
				mfp.close();
			});

			mfp.wrap = _getEl('wrap').attr('tabindex', -1).on('click'+EVENT_NS, function(e) {
				if(_checkIfClose(e.target)) {
					mfp.close();
				}
			});

			mfp.container = _getEl('container', mfp.wrap);
		}

		mfp.contentContainer = _getEl('content');
		if(mfp.st.preloader) {
			mfp.preloader = _getEl('preloader', mfp.container, mfp.st.tLoading);
		}


		// Initializing modules
		var modules = $.magnificPopup.modules;
		for(i = 0; i < modules.length; i++) {
			var n = modules[i];
			n = n.charAt(0).toUpperCase() + n.slice(1);
			mfp['init'+n].call(mfp);
		}
		_mfpTrigger('BeforeOpen');


		if(mfp.st.showCloseBtn) {
			// Close button
			if(!mfp.st.closeBtnInside) {
				mfp.wrap.append( _getCloseBtn() );
			} else {
				_mfpOn(MARKUP_PARSE_EVENT, function(e, template, values, item) {
					values.close_replaceWith = _getCloseBtn(item.type);
				});
				_wrapClasses += ' mfp-close-btn-in';
			}
		}

		if(mfp.st.alignTop) {
			_wrapClasses += ' mfp-align-top';
		}



		if(mfp.fixedContentPos) {
			mfp.wrap.css({
				overflow: mfp.st.overflowY,
				overflowX: 'hidden',
				overflowY: mfp.st.overflowY
			});
		} else {
			mfp.wrap.css({
				top: _window.scrollTop(),
				position: 'absolute'
			});
		}
		if( mfp.st.fixedBgPos === false || (mfp.st.fixedBgPos === 'auto' && !mfp.fixedContentPos) ) {
			mfp.bgOverlay.css({
				height: _document.height(),
				position: 'absolute'
			});
		}



		if(mfp.st.enableEscapeKey) {
			// Close on ESC key
			_document.on('keyup' + EVENT_NS, function(e) {
				if(e.keyCode === 27) {
					mfp.close();
				}
			});
		}

		_window.on('resize' + EVENT_NS, function() {
			mfp.updateSize();
		});


		if(!mfp.st.closeOnContentClick) {
			_wrapClasses += ' mfp-auto-cursor';
		}

		if(_wrapClasses)
			mfp.wrap.addClass(_wrapClasses);


		// this triggers recalculation of layout, so we get it once to not to trigger twice
		var windowHeight = mfp.wH = _window.height();


		var windowStyles = {};

		if( mfp.fixedContentPos ) {
            if(mfp._hasScrollBar(windowHeight)){
                var s = mfp._getScrollbarSize();
                if(s) {
                    windowStyles.paddingRight = s;
                }
            }
        }

		if(mfp.fixedContentPos) {
			if(!mfp.isIE7) {
				windowStyles.overflow = 'hidden';
			} else {
				// ie7 double-scroll bug
				$('body, html').css('overflow', 'hidden');
			}
		}



		var classesToadd = mfp.st.mainClass;
		if(mfp.isIE7) {
			classesToadd += ' mfp-ie7';
		}
		if(classesToadd) {
			mfp._addClassToMFP( classesToadd );
		}

		// add content
		mfp.updateItemHTML();

		_mfpTrigger('BuildControls');


		// remove scrollbar, add padding e.t.c
		$('html').css(windowStyles);

		// add everything to DOM
		mfp.bgOverlay.add(mfp.wrap).prependTo( document.body );



		// Save last focused element
		mfp._lastFocusedEl = document.activeElement;

		// Wait for next cycle to allow CSS transition
		setTimeout(function() {

			if(mfp.content) {
				mfp._addClassToMFP(READY_CLASS);
				_setFocus();
			} else {
				// if content is not defined (not loaded e.t.c) we add class only for BG
				mfp.bgOverlay.addClass(READY_CLASS);
			}

			// Trap the focus in popup
			_document.on('focusin' + EVENT_NS, function (e) {
				if( e.target !== mfp.wrap[0] && !$.contains(mfp.wrap[0], e.target) ) {
					_setFocus();
					return false;
				}
			});

		}, 16);

		mfp.isOpen = true;
		mfp.updateSize(windowHeight);
		_mfpTrigger(OPEN_EVENT);
	},

	/**
	 * Closes the popup
	 */
	close: function() {
		if(!mfp.isOpen) return;
		_mfpTrigger(BEFORE_CLOSE_EVENT);

		mfp.isOpen = false;
		// for CSS3 animation
		if(mfp.st.removalDelay && !mfp.isLowIE && mfp.supportsTransition )  {
			mfp._addClassToMFP(REMOVING_CLASS);
			setTimeout(function() {
				mfp._close();
			}, mfp.st.removalDelay);
		} else {
			mfp._close();
		}
	},

	/**
	 * Helper for close() function
	 */
	_close: function() {
		_mfpTrigger(CLOSE_EVENT);

		var classesToRemove = REMOVING_CLASS + ' ' + READY_CLASS + ' ';

		mfp.bgOverlay.detach();
		mfp.wrap.detach();
		mfp.container.empty();

		if(mfp.st.mainClass) {
			classesToRemove += mfp.st.mainClass + ' ';
		}

		mfp._removeClassFromMFP(classesToRemove);

		if(mfp.fixedContentPos) {
			var windowStyles = {paddingRight: ''};
			if(mfp.isIE7) {
				$('body, html').css('overflow', '');
			} else {
				windowStyles.overflow = '';
			}
			$('html').css(windowStyles);
		}

		_document.off('keyup' + EVENT_NS + ' focusin' + EVENT_NS);
		mfp.ev.off(EVENT_NS);

		// clean up DOM elements that aren't removed
		mfp.wrap.attr('class', 'mfp-wrap').removeAttr('style');
		mfp.bgOverlay.attr('class', 'mfp-bg');
		mfp.container.attr('class', 'mfp-container');

		// remove close button from target element
		if(mfp.st.showCloseBtn &&
		(!mfp.st.closeBtnInside || mfp.currTemplate[mfp.currItem.type] === true)) {
			if(mfp.currTemplate.closeBtn)
				mfp.currTemplate.closeBtn.detach();
		}


		if(mfp._lastFocusedEl) {
			$(mfp._lastFocusedEl).focus(); // put tab focus back
		}
		mfp.currItem = null;
		mfp.content = null;
		mfp.currTemplate = null;
		mfp.prevHeight = 0;

		_mfpTrigger(AFTER_CLOSE_EVENT);
	},

	updateSize: function(winHeight) {

		if(mfp.isIOS) {
			// fixes iOS nav bars https://github.com/dimsemenov/Magnific-Popup/issues/2
			var zoomLevel = document.documentElement.clientWidth / window.innerWidth;
			var height = window.innerHeight * zoomLevel;
			mfp.wrap.css('height', height);
			mfp.wH = height;
		} else {
			mfp.wH = winHeight || _window.height();
		}
		// Fixes #84: popup incorrectly positioned with position:relative on body
		if(!mfp.fixedContentPos) {
			mfp.wrap.css('height', mfp.wH);
		}

		_mfpTrigger('Resize');

	},

	/**
	 * Set content of popup based on current index
	 */
	updateItemHTML: function() {
		var item = mfp.items[mfp.index];

		// Detach and perform modifications
		mfp.contentContainer.detach();

		if(mfp.content)
			mfp.content.detach();

		if(!item.parsed) {
			item = mfp.parseEl( mfp.index );
		}

		var type = item.type;

		_mfpTrigger('BeforeChange', [mfp.currItem ? mfp.currItem.type : '', type]);
		// BeforeChange event works like so:
		// _mfpOn('BeforeChange', function(e, prevType, newType) { });

		mfp.currItem = item;





		if(!mfp.currTemplate[type]) {
			var markup = mfp.st[type] ? mfp.st[type].markup : false;

			// allows to modify markup
			_mfpTrigger('FirstMarkupParse', markup);

			if(markup) {
				mfp.currTemplate[type] = $(markup);
			} else {
				// if there is no markup found we just define that template is parsed
				mfp.currTemplate[type] = true;
			}
		}

		if(_prevContentType && _prevContentType !== item.type) {
			mfp.container.removeClass('mfp-'+_prevContentType+'-holder');
		}

		var newContent = mfp['get' + type.charAt(0).toUpperCase() + type.slice(1)](item, mfp.currTemplate[type]);
		mfp.appendContent(newContent, type);

		item.preloaded = true;

		_mfpTrigger(CHANGE_EVENT, item);
		_prevContentType = item.type;

		// Append container back after its content changed
		mfp.container.prepend(mfp.contentContainer);

		_mfpTrigger('AfterChange');
	},


	/**
	 * Set HTML content of popup
	 */
	appendContent: function(newContent, type) {
		mfp.content = newContent;

		if(newContent) {
			if(mfp.st.showCloseBtn && mfp.st.closeBtnInside &&
				mfp.currTemplate[type] === true) {
				// if there is no markup, we just append close button element inside
				if(!mfp.content.find('.mfp-close').length) {
					mfp.content.append(_getCloseBtn());
				}
			} else {
				mfp.content = newContent;
			}
		} else {
			mfp.content = '';
		}

		_mfpTrigger(BEFORE_APPEND_EVENT);
		mfp.container.addClass('mfp-'+type+'-holder');

		mfp.contentContainer.append(mfp.content);
	},




	/**
	 * Creates Magnific Popup data object based on given data
	 * @param  {int} index Index of item to parse
	 */
	parseEl: function(index) {
		var item = mfp.items[index],
			type = item.type;

		if(item.tagName) {
			item = { el: $(item) };
		} else {
			item = { data: item, src: item.src };
		}

		if(item.el) {
			var types = mfp.types;

			// check for 'mfp-TYPE' class
			for(var i = 0; i < types.length; i++) {
				if( item.el.hasClass('mfp-'+types[i]) ) {
					type = types[i];
					break;
				}
			}

			item.src = item.el.attr('data-mfp-src');
			if(!item.src) {
				item.src = item.el.attr('href');
			}
		}

		item.type = type || mfp.st.type || 'inline';
		item.index = index;
		item.parsed = true;
		mfp.items[index] = item;
		_mfpTrigger('ElementParse', item);

		return mfp.items[index];
	},


	/**
	 * Initializes single popup or a group of popups
	 */
	addGroup: function(el, options) {
		var eHandler = function(e) {
			e.mfpEl = this;
			mfp._openClick(e, el, options);
		};

		if(!options) {
			options = {};
		}

		var eName = 'click.magnificPopup';
		options.mainEl = el;

		if(options.items) {
			options.isObj = true;
			el.off(eName).on(eName, eHandler);
		} else {
			options.isObj = false;
			if(options.delegate) {
				el.off(eName).on(eName, options.delegate , eHandler);
			} else {
				options.items = el;
				el.off(eName).on(eName, eHandler);
			}
		}
	},
	_openClick: function(e, el, options) {
		var midClick = options.midClick !== undefined ? options.midClick : $.magnificPopup.defaults.midClick;


		if(!midClick && ( e.which === 2 || e.ctrlKey || e.metaKey ) ) {
			return;
		}

		var disableOn = options.disableOn !== undefined ? options.disableOn : $.magnificPopup.defaults.disableOn;

		if(disableOn) {
			if($.isFunction(disableOn)) {
				if( !disableOn.call(mfp) ) {
					return true;
				}
			} else { // else it's number
				if( _window.width() < disableOn ) {
					return true;
				}
			}
		}

		if(e.type) {
			e.preventDefault();

			// This will prevent popup from closing if element is inside and popup is already opened
			if(mfp.isOpen) {
				e.stopPropagation();
			}
		}


		options.el = $(e.mfpEl);
		if(options.delegate) {
			options.items = el.find(options.delegate);
		}
		mfp.open(options);
	},


	/**
	 * Updates text on preloader
	 */
	updateStatus: function(status, text) {

		if(mfp.preloader) {
			if(_prevStatus !== status) {
				mfp.container.removeClass('mfp-s-'+_prevStatus);
			}

			if(!text && status === 'loading') {
				text = mfp.st.tLoading;
			}

			var data = {
				status: status,
				text: text
			};
			// allows to modify status
			_mfpTrigger('UpdateStatus', data);

			status = data.status;
			text = data.text;

			mfp.preloader.html(text);

			mfp.preloader.find('a').on('click', function(e) {
				e.stopImmediatePropagation();
			});

			mfp.container.addClass('mfp-s-'+status);
			_prevStatus = status;
		}
	},


	/*
		"Private" helpers that aren't private at all
	 */
	_addClassToMFP: function(cName) {
		mfp.bgOverlay.addClass(cName);
		mfp.wrap.addClass(cName);
	},
	_removeClassFromMFP: function(cName) {
		this.bgOverlay.removeClass(cName);
		mfp.wrap.removeClass(cName);
	},
	_hasScrollBar: function(winHeight) {
		return (  (mfp.isIE7 ? _document.height() : document.body.scrollHeight) > (winHeight || _window.height()) );
	},
	_parseMarkup: function(template, values, item) {
		var arr;
		if(item.data) {
			values = $.extend(item.data, values);
		}
		_mfpTrigger(MARKUP_PARSE_EVENT, [template, values, item] );

		$.each(values, function(key, value) {
			if(value === undefined || value === false) {
				return true;
			}
			arr = key.split('_');
			if(arr.length > 1) {
				var el = template.find(EVENT_NS + '-'+arr[0]);

				if(el.length > 0) {
					var attr = arr[1];
					if(attr === 'replaceWith') {
						if(el[0] !== value[0]) {
							el.replaceWith(value);
						}
					} else if(attr === 'img') {
						if(el.is('img')) {
							el.attr('src', value);
						} else {
							el.replaceWith( '<img src="'+value+'" class="' + el.attr('class') + '" />' );
						}
					} else {
						el.attr(arr[1], value);
					}
				}

			} else {
				template.find(EVENT_NS + '-'+key).html(value);
			}
		});
	},

	_getScrollbarSize: function() {
		// thx David
		if(mfp.scrollbarSize === undefined) {
			var scrollDiv = document.createElement("div");
			scrollDiv.id = "mfp-sbm";
			scrollDiv.style.cssText = 'width: 99px; height: 99px; overflow: scroll; position: absolute; top: -9999px;';
			document.body.appendChild(scrollDiv);
			mfp.scrollbarSize = scrollDiv.offsetWidth - scrollDiv.clientWidth;
			document.body.removeChild(scrollDiv);
		}
		return mfp.scrollbarSize;
	}

}; /* MagnificPopup core prototype end */




/**
 * Public static functions
 */
$.magnificPopup = {
	instance: null,
	proto: MagnificPopup.prototype,
	modules: [],

	open: function(options, index) {
		_checkInstance();

		if(!options)
			options = {};

		options.isObj = true;
		options.index = index || 0;
		return this.instance.open(options);
	},

	close: function() {
		return $.magnificPopup.instance.close();
	},

	registerModule: function(name, module) {
		if(module.options) {
			$.magnificPopup.defaults[name] = module.options;
		}
		$.extend(this.proto, module.proto);
		this.modules.push(name);
	},

	defaults: {

		// Info about options is in docs:
		// http://dimsemenov.com/plugins/magnific-popup/documentation.html#options

		disableOn: 0,

		key: null,

		midClick: false,

		mainClass: '',

		preloader: true,

		focus: '', // CSS selector of input to focus after popup is opened

		closeOnContentClick: false,

		closeOnBgClick: true,

		closeBtnInside: true,

		showCloseBtn: true,

		enableEscapeKey: true,

		modal: false,

		alignTop: false,

		removalDelay: 0,

		fixedContentPos: 'auto',

		fixedBgPos: 'auto',

		overflowY: 'auto',

		closeMarkup: '<button title="%title%" type="button" class="mfp-close">&times;</button>',

		tClose: 'Close (Esc)',

		tLoading: 'Loading...'

	}
};



$.fn.magnificPopup = function(options) {
	_checkInstance();

	var jqEl = $(this);

	// We call some API method of first param is a string
	if (typeof options === "string" ) {

		if(options === 'open') {
			var items,
				itemOpts = _isJQ ? jqEl.data('magnificPopup') : jqEl[0].magnificPopup,
				index = parseInt(arguments[1], 10) || 0;

			if(itemOpts.items) {
				items = itemOpts.items[index];
			} else {
				items = jqEl;
				if(itemOpts.delegate) {
					items = items.find(itemOpts.delegate);
				}
				items = items.eq( index );
			}
			mfp._openClick({mfpEl:items}, jqEl, itemOpts);
		} else {
			if(mfp.isOpen)
				mfp[options].apply(mfp, Array.prototype.slice.call(arguments, 1));
		}

	} else {

		/*
		 * As Zepto doesn't support .data() method for objects
		 * and it works only in normal browsers
		 * we assign "options" object directly to the DOM element. FTW!
		 */
		if(_isJQ) {
			jqEl.data('magnificPopup', options);
		} else {
			jqEl[0].magnificPopup = options;
		}

		mfp.addGroup(jqEl, options);

	}
	return jqEl;
};


//Quick benchmark
/*
var start = performance.now(),
	i,
	rounds = 1000;

for(i = 0; i < rounds; i++) {

}
console.log('Test #1:', performance.now() - start);

start = performance.now();
for(i = 0; i < rounds; i++) {

}
console.log('Test #2:', performance.now() - start);
*/


/*>>core*/

/*>>inline*/

var INLINE_NS = 'inline',
	_hiddenClass,
	_inlinePlaceholder,
	_lastInlineElement,
	_putInlineElementsBack = function() {
		if(_lastInlineElement) {
			_inlinePlaceholder.after( _lastInlineElement.addClass(_hiddenClass) ).detach();
			_lastInlineElement = null;
		}
	};

$.magnificPopup.registerModule(INLINE_NS, {
	options: {
		hiddenClass: 'hide', // will be appended with `mfp-` prefix
		markup: '',
		tNotFound: 'Content not found'
	},
	proto: {

		initInline: function() {
			mfp.types.push(INLINE_NS);

			_mfpOn(CLOSE_EVENT+'.'+INLINE_NS, function() {
				_putInlineElementsBack();
			});
		},

		getInline: function(item, template) {

			_putInlineElementsBack();

			if(item.src) {
				var inlineSt = mfp.st.inline,
					el = $(item.src);

				if(el.length) {

					// If target element has parent - we replace it with placeholder and put it back after popup is closed
					var parent = el[0].parentNode;
					if(parent && parent.tagName) {
						if(!_inlinePlaceholder) {
							_hiddenClass = inlineSt.hiddenClass;
							_inlinePlaceholder = _getEl(_hiddenClass);
							_hiddenClass = 'mfp-'+_hiddenClass;
						}
						// replace target inline element with placeholder
						_lastInlineElement = el.after(_inlinePlaceholder).detach().removeClass(_hiddenClass);
					}

					mfp.updateStatus('ready');
				} else {
					mfp.updateStatus('error', inlineSt.tNotFound);
					el = $('<div>');
				}

				item.inlineElement = el;
				return el;
			}

			mfp.updateStatus('ready');
			mfp._parseMarkup(template, {}, item);
			return template;
		}
	}
});

/*>>inline*/

/*>>ajax*/
var AJAX_NS = 'ajax',
	_ajaxCur,
	_removeAjaxCursor = function() {
		if(_ajaxCur) {
			_body.removeClass(_ajaxCur);
		}
	};

$.magnificPopup.registerModule(AJAX_NS, {

	options: {
		settings: null,
		cursor: 'mfp-ajax-cur',
		tError: '<a href="%url%">The content</a> could not be loaded.'
	},

	proto: {
		initAjax: function() {
			mfp.types.push(AJAX_NS);
			_ajaxCur = mfp.st.ajax.cursor;

			_mfpOn(CLOSE_EVENT+'.'+AJAX_NS, function() {
				_removeAjaxCursor();
				if(mfp.req) {
					mfp.req.abort();
				}
			});
		},

		getAjax: function(item) {

			if(_ajaxCur)
				_body.addClass(_ajaxCur);

			mfp.updateStatus('loading');

			var opts = $.extend({
				url: item.src,
				success: function(data, textStatus, jqXHR) {
					var temp = {
						data:data,
						xhr:jqXHR
					};

					_mfpTrigger('ParseAjax', temp);

					mfp.appendContent( $(temp.data), AJAX_NS );

					item.finished = true;

					_removeAjaxCursor();

					_setFocus();

					setTimeout(function() {
						mfp.wrap.addClass(READY_CLASS);
					}, 16);

					mfp.updateStatus('ready');

					_mfpTrigger('AjaxContentAdded');
				},
				error: function() {
					_removeAjaxCursor();
					item.finished = item.loadError = true;
					mfp.updateStatus('error', mfp.st.ajax.tError.replace('%url%', item.src));
				}
			}, mfp.st.ajax.settings);

			mfp.req = $.ajax(opts);

			return '';
		}
	}
});







/*>>ajax*/

/*>>image*/
var _imgInterval,
	_getTitle = function(item) {
		if(item.data && item.data.title !== undefined)
			return item.data.title;

		var src = mfp.st.image.titleSrc;

		if(src) {
			if($.isFunction(src)) {
				return src.call(mfp, item);
			} else if(item.el) {
				return item.el.attr(src) || '';
			}
		}
		return '';
	};

$.magnificPopup.registerModule('image', {

	options: {
		markup: '<div class="mfp-figure">'+
					'<div class="mfp-close"></div>'+
					'<div class="mfp-img"></div>'+
					'<div class="mfp-bottom-bar">'+
						'<div class="mfp-title"></div>'+
						'<div class="mfp-counter"></div>'+
					'</div>'+
				'</div>',
		cursor: 'mfp-zoom-out-cur',
		titleSrc: 'title',
		verticalFit: true,
		tError: '<a href="%url%">The image</a> could not be loaded.'
	},

	proto: {
		initImage: function() {
			var imgSt = mfp.st.image,
				ns = '.image';

			mfp.types.push('image');

			_mfpOn(OPEN_EVENT+ns, function() {
				if(mfp.currItem.type === 'image' && imgSt.cursor) {
					_body.addClass(imgSt.cursor);
				}
			});

			_mfpOn(CLOSE_EVENT+ns, function() {
				if(imgSt.cursor) {
					_body.removeClass(imgSt.cursor);
				}
				_window.off('resize' + EVENT_NS);
			});

			_mfpOn('Resize'+ns, mfp.resizeImage);
			if(mfp.isLowIE) {
				_mfpOn('AfterChange', mfp.resizeImage);
			}
		},
		resizeImage: function() {
			var item = mfp.currItem;
			if(!item || !item.img) return;

			if(mfp.st.image.verticalFit) {
				var decr = 0;
				// fix box-sizing in ie7/8
				if(mfp.isLowIE) {
					decr = parseInt(item.img.css('padding-top'), 10) + parseInt(item.img.css('padding-bottom'),10);
				}
				item.img.css('max-height', mfp.wH-decr);
			}
		},
		_onImageHasSize: function(item) {
			if(item.img) {

				item.hasSize = true;

				if(_imgInterval) {
					clearInterval(_imgInterval);
				}

				item.isCheckingImgSize = false;

				_mfpTrigger('ImageHasSize', item);

				if(item.imgHidden) {
					if(mfp.content)
						mfp.content.removeClass('mfp-loading');

					item.imgHidden = false;
				}

			}
		},

		/**
		 * Function that loops until the image has size to display elements that rely on it asap
		 */
		findImageSize: function(item) {

			var counter = 0,
				img = item.img[0],
				mfpSetInterval = function(delay) {

					if(_imgInterval) {
						clearInterval(_imgInterval);
					}
					// decelerating interval that checks for size of an image
					_imgInterval = setInterval(function() {
						if(img.naturalWidth > 0) {
							mfp._onImageHasSize(item);
							return;
						}

						if(counter > 200) {
							clearInterval(_imgInterval);
						}

						counter++;
						if(counter === 3) {
							mfpSetInterval(10);
						} else if(counter === 40) {
							mfpSetInterval(50);
						} else if(counter === 100) {
							mfpSetInterval(500);
						}
					}, delay);
				};

			mfpSetInterval(1);
		},

		getImage: function(item, template) {

			var guard = 0,

				// image load complete handler
				onLoadComplete = function() {
					if(item) {
						if (item.img[0].complete) {
							item.img.off('.mfploader');

							if(item === mfp.currItem){
								mfp._onImageHasSize(item);

								mfp.updateStatus('ready');
							}

							item.hasSize = true;
							item.loaded = true;

							_mfpTrigger('ImageLoadComplete');

						}
						else {
							// if image complete check fails 200 times (20 sec), we assume that there was an error.
							guard++;
							if(guard < 200) {
								setTimeout(onLoadComplete,100);
							} else {
								onLoadError();
							}
						}
					}
				},

				// image error handler
				onLoadError = function() {
					if(item) {
						item.img.off('.mfploader');
						if(item === mfp.currItem){
							mfp._onImageHasSize(item);
							mfp.updateStatus('error', imgSt.tError.replace('%url%', item.src) );
						}

						item.hasSize = true;
						item.loaded = true;
						item.loadError = true;
					}
				},
				imgSt = mfp.st.image;


			var el = template.find('.mfp-img');
			if(el.length) {
				var img = document.createElement('img');
				img.className = 'mfp-img';
				item.img = $(img).on('load.mfploader', onLoadComplete).on('error.mfploader', onLoadError);
				img.src = item.src;

				// without clone() "error" event is not firing when IMG is replaced by new IMG
				// TODO: find a way to avoid such cloning
				if(el.is('img')) {
					item.img = item.img.clone();
				}
				if(item.img[0].naturalWidth > 0) {
					item.hasSize = true;
				}
			}

			mfp._parseMarkup(template, {
				title: _getTitle(item),
				img_replaceWith: item.img
			}, item);

			mfp.resizeImage();

			if(item.hasSize) {
				if(_imgInterval) clearInterval(_imgInterval);

				if(item.loadError) {
					template.addClass('mfp-loading');
					mfp.updateStatus('error', imgSt.tError.replace('%url%', item.src) );
				} else {
					template.removeClass('mfp-loading');
					mfp.updateStatus('ready');
				}
				return template;
			}

			mfp.updateStatus('loading');
			item.loading = true;

			if(!item.hasSize) {
				item.imgHidden = true;
				template.addClass('mfp-loading');
				mfp.findImageSize(item);
			}

			return template;
		}
	}
});



/*>>image*/

/*>>zoom*/
var hasMozTransform,
	getHasMozTransform = function() {
		if(hasMozTransform === undefined) {
			hasMozTransform = document.createElement('p').style.MozTransform !== undefined;
		}
		return hasMozTransform;
	};

$.magnificPopup.registerModule('zoom', {

	options: {
		enabled: false,
		easing: 'ease-in-out',
		duration: 300,
		opener: function(element) {
			return element.is('img') ? element : element.find('img');
		}
	},

	proto: {

		initZoom: function() {
			var zoomSt = mfp.st.zoom,
				ns = '.zoom';

			if(!zoomSt.enabled || !mfp.supportsTransition) {
				return;
			}

			var duration = zoomSt.duration,
				getElToAnimate = function(image) {
					var newImg = image.clone().removeAttr('style').removeAttr('class').addClass('mfp-animated-image'),
						transition = 'all '+(zoomSt.duration/1000)+'s ' + zoomSt.easing,
						cssObj = {
							position: 'fixed',
							zIndex: 9999,
							left: 0,
							top: 0,
							'-webkit-backface-visibility': 'hidden'
						},
						t = 'transition';

					cssObj['-webkit-'+t] = cssObj['-moz-'+t] = cssObj['-o-'+t] = cssObj[t] = transition;

					newImg.css(cssObj);
					return newImg;
				},
				showMainContent = function() {
					mfp.content.css('visibility', 'visible');
				},
				openTimeout,
				animatedImg;

			_mfpOn('BuildControls'+ns, function() {
				if(mfp._allowZoom()) {

					clearTimeout(openTimeout);
					mfp.content.css('visibility', 'hidden');

					// Basically, all code below does is clones existing image, puts in on top of the current one and animated it

					image = mfp._getItemToZoom();

					if(!image) {
						showMainContent();
						return;
					}

					animatedImg = getElToAnimate(image);

					animatedImg.css( mfp._getOffset() );

					mfp.wrap.append(animatedImg);

					openTimeout = setTimeout(function() {
						animatedImg.css( mfp._getOffset( true ) );
						openTimeout = setTimeout(function() {

							showMainContent();

							setTimeout(function() {
								animatedImg.remove();
								image = animatedImg = null;
								_mfpTrigger('ZoomAnimationEnded');
							}, 16); // avoid blink when switching images

						}, duration); // this timeout equals animation duration

					}, 16); // by adding this timeout we avoid short glitch at the beginning of animation


					// Lots of timeouts...
				}
			});
			_mfpOn(BEFORE_CLOSE_EVENT+ns, function() {
				if(mfp._allowZoom()) {

					clearTimeout(openTimeout);

					mfp.st.removalDelay = duration;

					if(!image) {
						image = mfp._getItemToZoom();
						if(!image) {
							return;
						}
						animatedImg = getElToAnimate(image);
					}


					animatedImg.css( mfp._getOffset(true) );
					mfp.wrap.append(animatedImg);
					mfp.content.css('visibility', 'hidden');

					setTimeout(function() {
						animatedImg.css( mfp._getOffset() );
					}, 16);
				}

			});

			_mfpOn(CLOSE_EVENT+ns, function() {
				if(mfp._allowZoom()) {
					showMainContent();
					if(animatedImg) {
						animatedImg.remove();
					}
				}
			});
		},

		_allowZoom: function() {
			return mfp.currItem.type === 'image';
		},

		_getItemToZoom: function() {
			if(mfp.currItem.hasSize) {
				return mfp.currItem.img;
			} else {
				return false;
			}
		},

		// Get element postion relative to viewport
		_getOffset: function(isLarge) {
			var el;
			if(isLarge) {
				el = mfp.currItem.img;
			} else {
				el = mfp.st.zoom.opener(mfp.currItem.el || mfp.currItem);
			}

			var offset = el.offset();
			var paddingTop = parseInt(el.css('padding-top'),10);
			var paddingBottom = parseInt(el.css('padding-bottom'),10);
			offset.top -= ( $(window).scrollTop() - paddingTop );


			/*

			Animating left + top + width/height looks glitchy in Firefox, but perfect in Chrome. And vice-versa.

			 */
			var obj = {
				width: el.width(),
				// fix Zepto height+padding issue
				height: (_isJQ ? el.innerHeight() : el[0].offsetHeight) - paddingBottom - paddingTop
			};

			// I hate to do this, but there is no another option
			if( getHasMozTransform() ) {
				obj['-moz-transform'] = obj.transform = 'translate(' + offset.left + 'px,' + offset.top + 'px)';
			} else {
				obj.left = offset.left;
				obj.top = offset.top;
			}
			return obj;
		}

	}
});



/*>>zoom*/

/*>>iframe*/

var IFRAME_NS = 'iframe',
	_emptyPage = '//about:blank',

	_fixIframeBugs = function(isShowing) {
		if(mfp.currTemplate[IFRAME_NS]) {
			var el = mfp.currTemplate[IFRAME_NS].find('iframe');
			if(el.length) {
				// reset src after the popup is closed to avoid "video keeps playing after popup is closed" bug
				if(!isShowing) {
					el[0].src = _emptyPage;
				}

				// IE8 black screen bug fix
				if(mfp.isIE8) {
					el.css('display', isShowing ? 'block' : 'none');
				}
			}
		}
	};

$.magnificPopup.registerModule(IFRAME_NS, {

	options: {
		markup: '<div class="mfp-iframe-scaler">'+
					'<div class="mfp-close"></div>'+
					'<iframe class="mfp-iframe" src="//about:blank" frameborder="0" allowfullscreen></iframe>'+
				'</div>',

		srcAction: 'iframe_src',

		// we don't care and support only one default type of URL by default
		patterns: {
			youtube: {
				index: 'youtube.com',
				id: 'v=',
				src: '//www.youtube.com/embed/%id%?autoplay=1'
			},
			vimeo: {
				index: 'vimeo.com/',
				id: '/',
				src: '//player.vimeo.com/video/%id%?autoplay=1'
			},
			gmaps: {
				index: '//maps.google.',
				src: '%id%&output=embed'
			}
		}
	},

	proto: {
		initIframe: function() {
			mfp.types.push(IFRAME_NS);

			_mfpOn('BeforeChange', function(e, prevType, newType) {
				if(prevType !== newType) {
					if(prevType === IFRAME_NS) {
						_fixIframeBugs(); // iframe if removed
					} else if(newType === IFRAME_NS) {
						_fixIframeBugs(true); // iframe is showing
					}
				}// else {
					// iframe source is switched, don't do anything
				//}
			});

			_mfpOn(CLOSE_EVENT + '.' + IFRAME_NS, function() {
				_fixIframeBugs();
			});
		},

		getIframe: function(item, template) {
			var embedSrc = item.src;
			var iframeSt = mfp.st.iframe;

			$.each(iframeSt.patterns, function() {
				if(embedSrc.indexOf( this.index ) > -1) {
					if(this.id) {
						if(typeof this.id === 'string') {
							embedSrc = embedSrc.substr(embedSrc.lastIndexOf(this.id)+this.id.length, embedSrc.length);
						} else {
							embedSrc = this.id.call( this, embedSrc );
						}
					}
					embedSrc = this.src.replace('%id%', embedSrc );
					return false; // break;
				}
			});

			var dataObj = {};
			if(iframeSt.srcAction) {
				dataObj[iframeSt.srcAction] = embedSrc;
			}
			mfp._parseMarkup(template, dataObj, item);

			mfp.updateStatus('ready');

			return template;
		}
	}
});



/*>>iframe*/

/*>>gallery*/
/**
 * Get looped index depending on number of slides
 */
var _getLoopedId = function(index) {
		var numSlides = mfp.items.length;
		if(index > numSlides - 1) {
			return index - numSlides;
		} else  if(index < 0) {
			return numSlides + index;
		}
		return index;
	},
	_replaceCurrTotal = function(text, curr, total) {
		return text.replace('%curr%', curr + 1).replace('%total%', total);
	};

$.magnificPopup.registerModule('gallery', {

	options: {
		enabled: false,
		arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>',
		preload: [0,2],
		navigateByImgClick: true,
		arrows: true,

		tPrev: 'Previous (Left arrow key)',
		tNext: 'Next (Right arrow key)',
		tCounter: '%curr% of %total%'
	},

	proto: {
		initGallery: function() {

			var gSt = mfp.st.gallery,
				ns = '.mfp-gallery',
				supportsFastClick = Boolean($.fn.mfpFastClick);

			mfp.direction = true; // true - next, false - prev

			if(!gSt || !gSt.enabled ) return false;

			_wrapClasses += ' mfp-gallery';

			_mfpOn(OPEN_EVENT+ns, function() {

				if(gSt.navigateByImgClick) {
					mfp.wrap.on('click'+ns, '.mfp-img', function() {
						if(mfp.items.length > 1) {
							mfp.next();
							return false;
						}
					});
				}

				_document.on('keydown'+ns, function(e) {
					if (e.keyCode === 37) {
						mfp.prev();
					} else if (e.keyCode === 39) {
						mfp.next();
					}
				});
			});

			_mfpOn('UpdateStatus'+ns, function(e, data) {
				if(data.text) {
					data.text = _replaceCurrTotal(data.text, mfp.currItem.index, mfp.items.length);
				}
			});

			_mfpOn(MARKUP_PARSE_EVENT+ns, function(e, element, values, item) {
				var l = mfp.items.length;
				values.counter = l > 1 ? _replaceCurrTotal(gSt.tCounter, item.index, l) : '';
			});

			_mfpOn('BuildControls' + ns, function() {
				if(mfp.items.length > 1 && gSt.arrows && !mfp.arrowLeft) {
					var markup = gSt.arrowMarkup,
						arrowLeft = mfp.arrowLeft = $( markup.replace('%title%', gSt.tPrev).replace('%dir%', 'left') ).addClass(PREVENT_CLOSE_CLASS),
						arrowRight = mfp.arrowRight = $( markup.replace('%title%', gSt.tNext).replace('%dir%', 'right') ).addClass(PREVENT_CLOSE_CLASS);

					var eName = supportsFastClick ? 'mfpFastClick' : 'click';
					arrowLeft[eName](function() {
						mfp.prev();
					});
					arrowRight[eName](function() {
						mfp.next();
					});

					// Polyfill for :before and :after (adds elements with classes mfp-a and mfp-b)
					if(mfp.isIE7) {
						_getEl('b', arrowLeft[0], false, true);
						_getEl('a', arrowLeft[0], false, true);
						_getEl('b', arrowRight[0], false, true);
						_getEl('a', arrowRight[0], false, true);
					}

					mfp.container.append(arrowLeft.add(arrowRight));
				}
			});

			_mfpOn(CHANGE_EVENT+ns, function() {
				if(mfp._preloadTimeout) clearTimeout(mfp._preloadTimeout);

				mfp._preloadTimeout = setTimeout(function() {
					mfp.preloadNearbyImages();
					mfp._preloadTimeout = null;
				}, 16);
			});


			_mfpOn(CLOSE_EVENT+ns, function() {
				_document.off(ns);
				mfp.wrap.off('click'+ns);

				if(mfp.arrowLeft && supportsFastClick) {
					mfp.arrowLeft.add(mfp.arrowRight).destroyMfpFastClick();
				}
				mfp.arrowRight = mfp.arrowLeft = null;
			});

		},
		next: function() {
			mfp.direction = true;
			mfp.index = _getLoopedId(mfp.index + 1);
			mfp.updateItemHTML();
		},
		prev: function() {
			mfp.direction = false;
			mfp.index = _getLoopedId(mfp.index - 1);
			mfp.updateItemHTML();
		},
		goTo: function(newIndex) {
			mfp.direction = (newIndex >= mfp.index);
			mfp.index = newIndex;
			mfp.updateItemHTML();
		},
		preloadNearbyImages: function() {
			var p = mfp.st.gallery.preload,
				preloadBefore = Math.min(p[0], mfp.items.length),
				preloadAfter = Math.min(p[1], mfp.items.length),
				i;

			for(i = 1; i <= (mfp.direction ? preloadAfter : preloadBefore); i++) {
				mfp._preloadItem(mfp.index+i);
			}
			for(i = 1; i <= (mfp.direction ? preloadBefore : preloadAfter); i++) {
				mfp._preloadItem(mfp.index-i);
			}
		},
		_preloadItem: function(index) {
			index = _getLoopedId(index);

			if(mfp.items[index].preloaded) {
				return;
			}

			var item = mfp.items[index];
			if(!item.parsed) {
				item = mfp.parseEl( index );
			}

			_mfpTrigger('LazyLoad', item);

			if(item.type === 'image') {
				item.img = $('<img class="mfp-img" />').on('load.mfploader', function() {
					item.hasSize = true;
				}).on('error.mfploader', function() {
					item.hasSize = true;
					item.loadError = true;
					_mfpTrigger('LazyLoadError', item);
				}).attr('src', item.src);
			}


			item.preloaded = true;
		}
	}
});

/*
Touch Support that might be implemented some day

addSwipeGesture: function() {
	var startX,
		moved,
		multipleTouches;

		return;

	var namespace = '.mfp',
		addEventNames = function(pref, down, move, up, cancel) {
			mfp._tStart = pref + down + namespace;
			mfp._tMove = pref + move + namespace;
			mfp._tEnd = pref + up + namespace;
			mfp._tCancel = pref + cancel + namespace;
		};

	if(window.navigator.msPointerEnabled) {
		addEventNames('MSPointer', 'Down', 'Move', 'Up', 'Cancel');
	} else if('ontouchstart' in window) {
		addEventNames('touch', 'start', 'move', 'end', 'cancel');
	} else {
		return;
	}
	_window.on(mfp._tStart, function(e) {
		var oE = e.originalEvent;
		multipleTouches = moved = false;
		startX = oE.pageX || oE.changedTouches[0].pageX;
	}).on(mfp._tMove, function(e) {
		if(e.originalEvent.touches.length > 1) {
			multipleTouches = e.originalEvent.touches.length;
		} else {
			//e.preventDefault();
			moved = true;
		}
	}).on(mfp._tEnd + ' ' + mfp._tCancel, function(e) {
		if(moved && !multipleTouches) {
			var oE = e.originalEvent,
				diff = startX - (oE.pageX || oE.changedTouches[0].pageX);

			if(diff > 20) {
				mfp.next();
			} else if(diff < -20) {
				mfp.prev();
			}
		}
	});
},
*/


/*>>gallery*/

/*>>retina*/

var RETINA_NS = 'retina';

$.magnificPopup.registerModule(RETINA_NS, {
	options: {
		replaceSrc: function(item) {
			return item.src.replace(/\.\w+$/, function(m) { return '@2x' + m; });
		},
		ratio: 1 // Function or number.  Set to 1 to disable.
	},
	proto: {
		initRetina: function() {
			if(window.devicePixelRatio > 1) {

				var st = mfp.st.retina,
					ratio = st.ratio;

				ratio = !isNaN(ratio) ? ratio : ratio();

				if(ratio > 1) {
					_mfpOn('ImageHasSize' + '.' + RETINA_NS, function(e, item) {
						item.img.css({
							'max-width': item.img[0].naturalWidth / ratio,
							'width': '100%'
						});
					});
					_mfpOn('ElementParse' + '.' + RETINA_NS, function(e, item) {
						item.src = st.replaceSrc(item, ratio);
					});
				}
			}

		}
	}
});

/*>>retina*/

/*>>fastclick*/
/**
 * FastClick event implementation. (removes 300ms delay on touch devices)
 * Based on https://developers.google.com/mobile/articles/fast_buttons
 *
 * You may use it outside the Magnific Popup by calling just:
 *
 * $('.your-el').mfpFastClick(function() {
 *     console.log('Clicked!');
 * });
 *
 * To unbind:
 * $('.your-el').destroyMfpFastClick();
 *
 *
 * Note that it's a very basic and simple implementation, it blocks ghost click on the same element where it was bound.
 * If you need something more advanced, use plugin by FT Labs https://github.com/ftlabs/fastclick
 *
 */

(function() {
	var ghostClickDelay = 1000,
		supportsTouch = 'ontouchstart' in window,
		unbindTouchMove = function() {
			_window.off('touchmove'+ns+' touchend'+ns);
		},
		eName = 'mfpFastClick',
		ns = '.'+eName;


	// As Zepto.js doesn't have an easy way to add custom events (like jQuery), so we implement it in this way
	$.fn.mfpFastClick = function(callback) {

		return $(this).each(function() {

			var elem = $(this),
				lock;

			if( supportsTouch ) {

				var timeout,
					startX,
					startY,
					pointerMoved,
					point,
					numPointers;

				elem.on('touchstart' + ns, function(e) {
					pointerMoved = false;
					numPointers = 1;

					point = e.originalEvent ? e.originalEvent.touches[0] : e.touches[0];
					startX = point.clientX;
					startY = point.clientY;

					_window.on('touchmove'+ns, function(e) {
						point = e.originalEvent ? e.originalEvent.touches : e.touches;
						numPointers = point.length;
						point = point[0];
						if (Math.abs(point.clientX - startX) > 10 ||
							Math.abs(point.clientY - startY) > 10) {
							pointerMoved = true;
							unbindTouchMove();
						}
					}).on('touchend'+ns, function(e) {
						unbindTouchMove();
						if(pointerMoved || numPointers > 1) {
							return;
						}
						lock = true;
						e.preventDefault();
						clearTimeout(timeout);
						timeout = setTimeout(function() {
							lock = false;
						}, ghostClickDelay);
						callback();
					});
				});

			}

			elem.on('click' + ns, function() {
				if(!lock) {
					callback();
				}
			});
		});
	};

	$.fn.destroyMfpFastClick = function() {
		$(this).off('touchstart' + ns + ' click' + ns);
		if(supportsTouch) _window.off('touchmove'+ns+' touchend'+ns);
	};
})();

/*>>fastclick*/
})(window.jQuery || window.Zepto);
(function( window, $, undefined ){

  /*!
   * imagesLoaded PACKAGED v4.1.0
   * JavaScript is all like "You images are done yet or what?"
   * MIT License
   */

  /**
   * EvEmitter v1.0.1
   * Lil' event emitter
   * MIT License
   */

  /* jshint unused: true, undef: true, strict: true */

  ( function( global, factory ) {
    // universal module definition
    /* jshint strict: false */ /* globals define, module */
    if ( typeof define == 'function' && define.amd ) {
      // AMD - RequireJS
      define( 'ev-emitter/ev-emitter',factory );
    } else if ( typeof module == 'object' && module.exports ) {
      // CommonJS - Browserify, Webpack
      module.exports = factory();
    } else {
      // Browser globals
      global.EvEmitter = factory();
    }

  }( this, function() {



  function EvEmitter() {}

  var proto = EvEmitter.prototype;

  proto.on = function( eventName, listener ) {
    if ( !eventName || !listener ) {
      return;
    }
    // set events hash
    var events = this._events = this._events || {};
    // set listeners array
    var listeners = events[ eventName ] = events[ eventName ] || [];
    // only add once
    if ( listeners.indexOf( listener ) == -1 ) {
      listeners.push( listener );
    }

    return this;
  };

  proto.once = function( eventName, listener ) {
    if ( !eventName || !listener ) {
      return;
    }
    // add event
    this.on( eventName, listener );
    // set once flag
    // set onceEvents hash
    var onceEvents = this._onceEvents = this._onceEvents || {};
    // set onceListeners array
    var onceListeners = onceEvents[ eventName ] = onceEvents[ eventName ] || [];
    // set flag
    onceListeners[ listener ] = true;

    return this;
  };

  proto.off = function( eventName, listener ) {
    var listeners = this._events && this._events[ eventName ];
    if ( !listeners || !listeners.length ) {
      return;
    }
    var index = listeners.indexOf( listener );
    if ( index != -1 ) {
      listeners.splice( index, 1 );
    }

    return this;
  };

  proto.emitEvent = function( eventName, args ) {
    var listeners = this._events && this._events[ eventName ];
    if ( !listeners || !listeners.length ) {
      return;
    }
    var i = 0;
    var listener = listeners[i];
    args = args || [];
    // once stuff
    var onceListeners = this._onceEvents && this._onceEvents[ eventName ];

    while ( listener ) {
      var isOnce = onceListeners && onceListeners[ listener ];
      if ( isOnce ) {
        // remove listener
        // remove before trigger to prevent recursion
        this.off( eventName, listener );
        // unset once flag
        delete onceListeners[ listener ];
      }
      // trigger listener
      listener.apply( this, args );
      // get next listener
      i += isOnce ? 0 : 1;
      listener = listeners[i];
    }

    return this;
  };

  return EvEmitter;

  }));

  /*!
   * imagesLoaded v4.1.0
   * JavaScript is all like "You images are done yet or what?"
   * MIT License
   */

  ( function( window, factory ) { 'use strict';
    // universal module definition

    /*global define: false, module: false, require: false */

    if ( typeof define == 'function' && define.amd ) {
      // AMD
      define( [
        'ev-emitter/ev-emitter'
      ], function( EvEmitter ) {
        return factory( window, EvEmitter );
      });
    } else if ( typeof module == 'object' && module.exports ) {
      // CommonJS
      module.exports = factory(
        window,
        require('ev-emitter')
      );
    } else {
      // browser global
      window.imagesLoaded = factory(
        window,
        window.EvEmitter
      );
    }

  })( window,

  // --------------------------  factory -------------------------- //

  function factory( window, EvEmitter ) {



  var $ = window.jQuery;
  var console = window.console;

  // -------------------------- helpers -------------------------- //

  // extend objects
  function extend( a, b ) {
    for ( var prop in b ) {
      a[ prop ] = b[ prop ];
    }
    return a;
  }

  // turn element or nodeList into an array
  function makeArray( obj ) {
    var ary = [];
    if ( Array.isArray( obj ) ) {
      // use object if already an array
      ary = obj;
    } else if ( typeof obj.length == 'number' ) {
      // convert nodeList to array
      for ( var i=0; i < obj.length; i++ ) {
        ary.push( obj[i] );
      }
    } else {
      // array of single index
      ary.push( obj );
    }
    return ary;
  }

  // -------------------------- imagesLoaded -------------------------- //

  /**
   * @param {Array, Element, NodeList, String} elem
   * @param {Object or Function} options - if function, use as callback
   * @param {Function} onAlways - callback function
   */
  function ImagesLoaded( elem, options, onAlways ) {
    // coerce ImagesLoaded() without new, to be new ImagesLoaded()
    if ( !( this instanceof ImagesLoaded ) ) {
      return new ImagesLoaded( elem, options, onAlways );
    }
    // use elem as selector string
    if ( typeof elem == 'string' ) {
      elem = document.querySelectorAll( elem );
    }

    this.elements = makeArray( elem );
    this.options = extend( {}, this.options );

    if ( typeof options == 'function' ) {
      onAlways = options;
    } else {
      extend( this.options, options );
    }

    if ( onAlways ) {
      this.on( 'always', onAlways );
    }

    this.getImages();

    if ( $ ) {
      // add jQuery Deferred object
      this.jqDeferred = new $.Deferred();
    }

    // HACK check async to allow time to bind listeners
    setTimeout( function() {
      this.check();
    }.bind( this ));
  }

  ImagesLoaded.prototype = Object.create( EvEmitter.prototype );

  ImagesLoaded.prototype.options = {};

  ImagesLoaded.prototype.getImages = function() {
    this.images = [];

    // filter & find items if we have an item selector
    this.elements.forEach( this.addElementImages, this );
  };

  /**
   * @param {Node} element
   */
  ImagesLoaded.prototype.addElementImages = function( elem ) {
    // filter siblings
    if ( elem.nodeName == 'IMG' ) {
      this.addImage( elem );
    }
    // get background image on element
    if ( this.options.background === true ) {
      this.addElementBackgroundImages( elem );
    }

    // find children
    // no non-element nodes, #143
    var nodeType = elem.nodeType;
    if ( !nodeType || !elementNodeTypes[ nodeType ] ) {
      return;
    }
    var childImgs = elem.querySelectorAll('img');
    // concat childElems to filterFound array
    for ( var i=0; i < childImgs.length; i++ ) {
      var img = childImgs[i];
      this.addImage( img );
    }

    // get child background images
    if ( typeof this.options.background == 'string' ) {
      var children = elem.querySelectorAll( this.options.background );
      for ( i=0; i < children.length; i++ ) {
        var child = children[i];
        this.addElementBackgroundImages( child );
      }
    }
  };

  var elementNodeTypes = {
    1: true,
    9: true,
    11: true
  };

  ImagesLoaded.prototype.addElementBackgroundImages = function( elem ) {
    var style = getComputedStyle( elem );
    if ( !style ) {
      // Firefox returns null if in a hidden iframe https://bugzil.la/548397
      return;
    }
    // get url inside url("...")
    var reURL = /url\((['"])?(.*?)\1\)/gi;
    var matches = reURL.exec( style.backgroundImage );
    while ( matches !== null ) {
      var url = matches && matches[2];
      if ( url ) {
        this.addBackground( url, elem );
      }
      matches = reURL.exec( style.backgroundImage );
    }
  };

  /**
   * @param {Image} img
   */
  ImagesLoaded.prototype.addImage = function( img ) {
    var loadingImage = new LoadingImage( img );
    this.images.push( loadingImage );
  };

  ImagesLoaded.prototype.addBackground = function( url, elem ) {
    var background = new Background( url, elem );
    this.images.push( background );
  };

  ImagesLoaded.prototype.check = function() {
    var _this = this;
    this.progressedCount = 0;
    this.hasAnyBroken = false;
    // complete if no images
    if ( !this.images.length ) {
      this.complete();
      return;
    }

    function onProgress( image, elem, message ) {
      // HACK - Chrome triggers event before object properties have changed. #83
      setTimeout( function() {
        _this.progress( image, elem, message );
      });
    }

    this.images.forEach( function( loadingImage ) {
      loadingImage.once( 'progress', onProgress );
      loadingImage.check();
    });
  };

  ImagesLoaded.prototype.progress = function( image, elem, message ) {
    this.progressedCount++;
    this.hasAnyBroken = this.hasAnyBroken || !image.isLoaded;
    // progress event
    this.emitEvent( 'progress', [ this, image, elem ] );
    if ( this.jqDeferred && this.jqDeferred.notify ) {
      this.jqDeferred.notify( this, image );
    }
    // check if completed
    if ( this.progressedCount == this.images.length ) {
      this.complete();
    }

    if ( this.options.debug && console ) {
      console.log( 'progress: ' + message, image, elem );
    }
  };

  ImagesLoaded.prototype.complete = function() {
    var eventName = this.hasAnyBroken ? 'fail' : 'done';
    this.isComplete = true;
    this.emitEvent( eventName, [ this ] );
    this.emitEvent( 'always', [ this ] );
    if ( this.jqDeferred ) {
      var jqMethod = this.hasAnyBroken ? 'reject' : 'resolve';
      this.jqDeferred[ jqMethod ]( this );
    }
  };

  // --------------------------  -------------------------- //

  function LoadingImage( img ) {
    this.img = img;
  }

  LoadingImage.prototype = Object.create( EvEmitter.prototype );

  LoadingImage.prototype.check = function() {
    // If complete is true and browser supports natural sizes,
    // try to check for image status manually.
    var isComplete = this.getIsImageComplete();
    if ( isComplete ) {
      // report based on naturalWidth
      this.confirm( this.img.naturalWidth !== 0, 'naturalWidth' );
      return;
    }

    // If none of the checks above matched, simulate loading on detached element.
    this.proxyImage = new Image();
    this.proxyImage.addEventListener( 'load', this );
    this.proxyImage.addEventListener( 'error', this );
    // bind to image as well for Firefox. #191
    this.img.addEventListener( 'load', this );
    this.img.addEventListener( 'error', this );
    this.proxyImage.src = this.img.src;
  };

  LoadingImage.prototype.getIsImageComplete = function() {
    return this.img.complete && this.img.naturalWidth !== undefined;
  };

  LoadingImage.prototype.confirm = function( isLoaded, message ) {
    this.isLoaded = isLoaded;
    this.emitEvent( 'progress', [ this, this.img, message ] );
  };

  // ----- events ----- //

  // trigger specified handler for event type
  LoadingImage.prototype.handleEvent = function( event ) {
    var method = 'on' + event.type;
    if ( this[ method ] ) {
      this[ method ]( event );
    }
  };

  LoadingImage.prototype.onload = function() {
    this.confirm( true, 'onload' );
    this.unbindEvents();
  };

  LoadingImage.prototype.onerror = function() {
    this.confirm( false, 'onerror' );
    this.unbindEvents();
  };

  LoadingImage.prototype.unbindEvents = function() {
    this.proxyImage.removeEventListener( 'load', this );
    this.proxyImage.removeEventListener( 'error', this );
    this.img.removeEventListener( 'load', this );
    this.img.removeEventListener( 'error', this );
  };

  // -------------------------- Background -------------------------- //

  function Background( url, element ) {
    this.url = url;
    this.element = element;
    this.img = new Image();
  }

  // inherit LoadingImage prototype
  Background.prototype = Object.create( LoadingImage.prototype );

  Background.prototype.check = function() {
    this.img.addEventListener( 'load', this );
    this.img.addEventListener( 'error', this );
    this.img.src = this.url;
    // check if image is already complete
    var isComplete = this.getIsImageComplete();
    if ( isComplete ) {
      this.confirm( this.img.naturalWidth !== 0, 'naturalWidth' );
      this.unbindEvents();
    }
  };

  Background.prototype.unbindEvents = function() {
    this.img.removeEventListener( 'load', this );
    this.img.removeEventListener( 'error', this );
  };

  Background.prototype.confirm = function( isLoaded, message ) {
    this.isLoaded = isLoaded;
    this.emitEvent( 'progress', [ this, this.element, message ] );
  };

  // -------------------------- jQuery -------------------------- //

  ImagesLoaded.makeJQueryPlugin = function( jQuery ) {
    jQuery = jQuery || window.jQuery;
    if ( !jQuery ) {
      return;
    }
    // set local variable
    $ = jQuery;
    // $().imagesLoaded()
    $.fn.imagesLoaded = function( options, callback ) {
      var instance = new ImagesLoaded( this, options, callback );
      return instance.jqDeferred.promise( $(this) );
    };
  };
  // try making plugin
  ImagesLoaded.makeJQueryPlugin();

  // --------------------------  -------------------------- //

  return ImagesLoaded;

  });

})( window, jQuery );
(function( window, $, undefined ){

  // ========================= smartresize ===============================

  /*
   * smartresize: debounced resize event for jQuery
   *
   * latest version and complete README available on Github:
   * https://github.com/louisremi/jquery.smartresize.js
   *
   * Copyright 2011 @louis_remi
   * Licensed under the MIT license.
   */

  var $event = $.event,
      dispatchMethod = $.event.handle ? 'handle' : 'dispatch',
      resizeTimeout;

  $event.special.smartresize = {
    setup: function() {
      $(this).bind( "resize", $event.special.smartresize.handler );
    },
    teardown: function() {
      $(this).unbind( "resize", $event.special.smartresize.handler );
    },
    handler: function( event, execAsap ) {
      // Save the context
      var context = this,
          args = arguments;

      // set correct event type
      event.type = "smartresize";

      if ( resizeTimeout ) { clearTimeout( resizeTimeout ); }
      resizeTimeout = setTimeout(function() {
        $event[ dispatchMethod ].apply( context, args );
      }, execAsap === "execAsap"? 0 : 100 );
    }
  };

  $.fn.smartresize = function( fn ) {
    return fn ? this.bind( "smartresize", fn ) : this.trigger( "smartresize", ["execAsap"] );
  };

})( window, jQuery );
/**!
 * easyPieChart
 * Lightweight plugin to render simple, animated and retina optimized pie charts
 *
 * @license Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php) and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 * @author Robert Fleischmann <rendro87@gmail.com> (http://robert-fleischmann.de)
 * @version 2.1.3
 **/

(function(root, factory) {
    if(typeof exports === 'object') {
        module.exports = factory(require('jquery'));
    }
    else if(typeof define === 'function' && define.amd) {
        define('EasyPieChart', ['jquery'], factory);
    }
    else {
        factory(root.jQuery);
    }
}(this, function($) {
/**
 * Renderer to render the chart on a canvas object
 * @param {DOMElement} el      DOM element to host the canvas (root of the plugin)
 * @param {object}     options options object of the plugin
 */
var CanvasRenderer = function(el, options) {
	var cachedBackground;
	var canvas = document.createElement('canvas');

	if (typeof(G_vmlCanvasManager) !== 'undefined') {
		G_vmlCanvasManager.initElement(canvas);
	}

	var ctx = canvas.getContext('2d');

	canvas.width = canvas.height = options.size;

	el.appendChild(canvas);

	// canvas on retina devices
	var scaleBy = 1;
	if (window.devicePixelRatio > 1) {
		scaleBy = window.devicePixelRatio;
		canvas.style.width = canvas.style.height = [options.size, 'px'].join('');
		canvas.width = canvas.height = options.size * scaleBy;
		ctx.scale(scaleBy, scaleBy);
	}

	// move 0,0 coordinates to the center
	ctx.translate(options.size / 2, options.size / 2);

	// rotate canvas -90deg
	ctx.rotate((-1 / 2 + options.rotate / 180) * Math.PI);

	var radius = (options.size - options.lineWidth) / 2;
	if (options.scaleColor && options.scaleLength) {
		radius -= options.scaleLength + 2; // 2 is the distance between scale and bar
	}

	// IE polyfill for Date
	Date.now = Date.now || function() {
		return +(new Date());
	};

	/**
	 * Draw a circle around the center of the canvas
	 * @param {strong} color     Valid CSS color string
	 * @param {number} lineWidth Width of the line in px
	 * @param {number} percent   Percentage to draw (float between -1 and 1)
	 */
	var drawCircle = function(color, lineWidth, percent) {
		percent = Math.min(Math.max(-1, percent || 0), 1);
		var isNegative = percent <= 0 ? true : false;

		ctx.beginPath();
		ctx.arc(0, 0, radius, 0, Math.PI * 2 * percent, isNegative);

		ctx.strokeStyle = color;
		ctx.lineWidth = lineWidth;

		ctx.stroke();
	};

	/**
	 * Draw the scale of the chart
	 */
	var drawScale = function() {
		var offset;
		var length;
		var i = 24;

		ctx.lineWidth = 1
		ctx.fillStyle = options.scaleColor;

		ctx.save();
		for (var i = 24; i > 0; --i) {
			if (i%6 === 0) {
				length = options.scaleLength;
				offset = 0;
			} else {
				length = options.scaleLength * .6;
				offset = options.scaleLength - length;
			}
			ctx.fillRect(-options.size/2 + offset, 0, length, 1);
			ctx.rotate(Math.PI / 12);
		}
		ctx.restore();
	};

	/**
	 * Request animation frame wrapper with polyfill
	 * @return {function} Request animation frame method or timeout fallback
	 */
	var reqAnimationFrame = (function() {
		return  window.requestAnimationFrame ||
				window.webkitRequestAnimationFrame ||
				window.mozRequestAnimationFrame ||
				function(callback) {
					window.setTimeout(callback, 1000 / 60);
				};
	}());

	/**
	 * Draw the background of the plugin including the scale and the track
	 */
	var drawBackground = function() {
		options.scaleColor && drawScale();
		options.trackColor && drawCircle(options.trackColor, options.lineWidth, 1);
	};

	/**
	 * Clear the complete canvas
	 */
	this.clear = function() {
		ctx.clearRect(options.size / -2, options.size / -2, options.size, options.size);
	};

	/**
	 * Draw the complete chart
	 * @param {number} percent Percent shown by the chart between -100 and 100
	 */
	this.draw = function(percent) {
		// do we need to render a background
		if (!!options.scaleColor || !!options.trackColor) {
			// getImageData and putImageData are supported
			if (ctx.getImageData && ctx.putImageData) {
				if (!cachedBackground) {
					drawBackground();
					cachedBackground = ctx.getImageData(0, 0, options.size * scaleBy, options.size * scaleBy);
				} else {
					ctx.putImageData(cachedBackground, 0, 0);
				}
			} else {
				this.clear();
				drawBackground();
			}
		} else {
			this.clear();
		}

		ctx.lineCap = options.lineCap;

		// if barcolor is a function execute it and pass the percent as a value
		var color;
		if (typeof(options.barColor) === 'function') {
			color = options.barColor(percent);
		} else {
			color = options.barColor;
		}

		// draw bar
		drawCircle(color, options.lineWidth, percent / 100);
	}.bind(this);

	/**
	 * Animate from some percent to some other percentage
	 * @param {number} from Starting percentage
	 * @param {number} to   Final percentage
	 */
	this.animate = function(from, to) {
		var startTime = Date.now();
		options.onStart(from, to);
		var animation = function() {
			var process = Math.min(Date.now() - startTime, options.animate);
			var currentValue = options.easing(this, process, from, to - from, options.animate);
			this.draw(currentValue);
			options.onStep(from, to, currentValue);
			if (process >= options.animate) {
				options.onStop(from, to);
			} else {
				reqAnimationFrame(animation);
			}
		}.bind(this);

		reqAnimationFrame(animation);
	}.bind(this);
};

var EasyPieChart = function(el, opts) {
	var defaultOptions = {
		barColor: '#ef1e25',
		trackColor: '#f9f9f9',
		scaleColor: '#dfe0e0',
		scaleLength: 5,
		lineCap: 'round',
		lineWidth: 3,
		size: 110,
		rotate: 0,
		animate: 1000,
		easing: function (x, t, b, c, d) { // more can be found here: http://gsgd.co.uk/sandbox/jquery/easing/
			t = t / (d/2);
			if (t < 1) {
				return c / 2 * t * t + b;
			}
			return -c/2 * ((--t)*(t-2) - 1) + b;
		},
		onStart: function(from, to) {
			return;
		},
		onStep: function(from, to, currentValue) {
			return;
		},
		onStop: function(from, to) {
			return;
		}
	};

	// detect present renderer
	if (typeof(CanvasRenderer) !== 'undefined') {
		defaultOptions.renderer = CanvasRenderer;
	} else if (typeof(SVGRenderer) !== 'undefined') {
		defaultOptions.renderer = SVGRenderer;
	} else {
		throw new Error('Please load either the SVG- or the CanvasRenderer');
	}

	var options = {};
	var currentValue = 0;

	/**
	 * Initialize the plugin by creating the options object and initialize rendering
	 */
	var init = function() {
		this.el = el;
		this.options = options;

		// merge user options into default options
		for (var i in defaultOptions) {
			if (defaultOptions.hasOwnProperty(i)) {
				options[i] = opts && typeof(opts[i]) !== 'undefined' ? opts[i] : defaultOptions[i];
				if (typeof(options[i]) === 'function') {
					options[i] = options[i].bind(this);
				}
			}
		}

		// check for jQuery easing
		if (typeof(options.easing) === 'string' && typeof(jQuery) !== 'undefined' && jQuery.isFunction(jQuery.easing[options.easing])) {
			options.easing = jQuery.easing[options.easing];
		} else {
			options.easing = defaultOptions.easing;
		}

		// create renderer
		this.renderer = new options.renderer(el, options);

		// initial draw
		this.renderer.draw(currentValue);

		// initial update
		if (el.dataset && el.dataset.percent) {
			this.update(parseFloat(el.dataset.percent));
		} else if (el.getAttribute && el.getAttribute('data-percent')) {
			this.update(parseFloat(el.getAttribute('data-percent')));
		}
	}.bind(this);

	/**
	 * Update the value of the chart
	 * @param  {number} newValue Number between 0 and 100
	 * @return {object}          Instance of the plugin for method chaining
	 */
	this.update = function(newValue) {
		newValue = parseFloat(newValue);
		if (options.animate) {
			this.renderer.animate(currentValue, newValue);
		} else {
			this.renderer.draw(newValue);
		}
		currentValue = newValue;
		return this;
	}.bind(this);

	init();
};

$.fn.easyPieChart = function(options) {
	return this.each(function() {
		var instanceOptions;

		if (!$.data(this, 'easyPieChart')) {
			instanceOptions = $.extend({}, options, $(this).data());
			$.data(this, 'easyPieChart', new EasyPieChart(this, instanceOptions));
		}
	});
};

}));

//
//  Responsive Elements
//  Copyright (c) 2013 Kumail Hunaid
//
//  Permission is hereby granted, free of charge, to any person obtaining a copy
//  of this software and associated documentation files (the "Software"), to deal
//  in the Software without restriction, including without limitation the rights
//  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
//  copies of the Software, and to permit persons to whom the Software is
//  furnished to do so, subject to the following conditions:
//
//  The above copyright notice and this permission notice shall be included in
//  all copies or substantial portions of the Software.
//
//  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
//  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
//  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
//  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
//  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
//  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
//  THE SOFTWARE.
//

(function($, undefined) {
	'use strict';

	$.WPV = $.WPV || {};

	$.WPV.ResponsiveElements = (function() {
		var self = {
			elementsAttributeName: 'data-respond',
			maxRefreshRate: 5,
			defaults: {
				// How soon should you start adding breakpoints
				start: 100,
				// When to stop adding breakpoints
				end: 900,
				// At what interval should breakpoints be added?
				interval: 50
			},
			init: function() {
				$(function() {
					self.el = {
						window: $(window),
						responsive_elements: $('[' + self.elementsAttributeName + ']')
					};

					self.events();
				});

				$(window).bind('wpv-ajax-content-loaded', self.resetElements);
			},
			resetElements: function() {
				self.el.responsive_elements = $('[' + self.elementsAttributeName + ']');
				self.unbind_events();
				self.events();
			},
			parseOptions: function(options_string) {
				// data-respond="start: 100px; end: 900px; interval: 50px; watch: true;"
				if (!options_string) return false;

				this._options_cache = this._options_cache || {};
				if (this._options_cache[options_string]) return this._options_cache[options_string];

				var options_array = options_string.replace(/\s+/g, '').split(';'),
					options_object = {};

				for (var i = 0; i < options_array.length; i++) {
					if (!options_array[i]) continue;
					var property_array = (options_array[i]).split(':');

					var key = property_array[0];
					var value = property_array[1];

					if (value.slice(-2) === 'px') {
						value = value.replace('px', '');
					}
					if (!isNaN(value)) {
						value = parseInt(value, 10);
					}
					options_object[key] = value;
				}

				this._options_cache[options_string] = options_object;
				return options_object;
			},
			generateBreakpointsOnAllElements: function() {
				self.el.responsive_elements.each(function(i, _el) {
					self.generateBreakpointsOnElement($(_el));
				});
			},
			generateBreakpointsOnElement: function(_el) {
				var options_string = _el.attr(this.elementsAttributeName),
					options = this.parseOptions(options_string) || this.defaults,
					breakpoints = this.generateBreakpoints(_el.width(), options);

				this.cleanUpBreakpoints(_el);
				_el.addClass(breakpoints.join(' '));
			},
			generateBreakpoints: function(width, options) {
				var start = options.start,
					end = options.end,
					interval = options.interval,
					i = interval > start ? interval : ~~(start / interval) * interval,
					classes = [];

				while (i <= end) {
					if (i < width) classes.push('gt' + i);
					if (i > width) classes.push('lt' + i);
					if (i === width) classes.push('lt' + i);

					i += interval;
				}

				return classes;
			},
			parseBreakpointClasses: function(breakpoints_string) {
				var classes = breakpoints_string.split(/\s+/),
					breakpointClasses = [];

				$(classes).each(function(i, className) {
					if (className.match(/^gt\d+|lt\d+$/)) breakpointClasses.push(className);
				});

				return breakpointClasses;
			},
			cleanUpBreakpoints: function(_el) {
				var classesToCleanup = this.parseBreakpointClasses(_el.attr('class'));
				_el.removeClass(classesToCleanup.join(' '));
			},
			events: function() {
				this.generateBreakpointsOnAllElements();

				this.el.window.bind('resize.responsive_elements', this.utils.debounce(
					this.generateBreakpointsOnAllElements, this.maxRefreshRate));
			},
			unbind_events: function() {
				this.el.window.unbind('resize.responsive_elements');
			},
			utils: {
				// Debounce is part of Underscore.js 1.5.2 http://underscorejs.org
				// (c) 2009-2013 Jeremy Ashkenas. Distributed under the MIT license.
				debounce: function(func, wait, immediate) {
					// Returns a function, that, as long as it continues to be invoked,
					// will not be triggered. The function will be called after it stops
					// being called for N milliseconds. If `immediate` is passed,
					// trigger the function on the leading edge, instead of the trailing.
					var result;
					var timeout = null;
					return function() {
						var context = this,
							args = arguments;
						var later = function() {
							timeout = null;
							if (!immediate) result = func.apply(context, args);
						};
						var callNow = immediate && !timeout;
						clearTimeout(timeout);
						timeout = setTimeout(later, wait);
						if (callNow) result = func.apply(context, args);
						return result;
					};
				}
			}
		};

		return self;
	})();

	$.WPV.ResponsiveElements.init();
})(jQuery);

(function($, undefined) {
	'use strict';

	$.fn.wpvDoubleTapClick = function() {
		var self = this;

		if(Modernizr.touch) {
			var currently_active;

			$(self).bind('click', function(e) {
				if(currently_active !== this) {
					e.preventDefault();
					currently_active = this;
				}

				e.stopPropagation();
			});

			$(window).bind('click.sub-menu-double-tap', function() {
				currently_active = undefined;
			});
		}

		return self;
	};
})(jQuery);
(function() {
	"use strict";

	// Namespace
	jQuery.WPV = jQuery.WPV || {};

	// jquery plugins
	(function($) {

		$.WPV.reduce_column_count = function(columns) {
			if (!$('body').hasClass('responsive-layout'))
				return columns;

			var win_width = $(window).width();

			if (win_width < 770)
				return 1;

			if (win_width >= 768 && win_width <= 1024)
				return Math.min(columns, 2);

			if (win_width > 1024 && win_width < 1280)
				return Math.min(columns, 3);

			return columns;
		};

		/**
		 * Modified version if the touchwipe plugin by  Andreas Waltl,
		 * netCU Internetagentur (http://www.netcu.de)
		 * We have added support for the desktop browsers, so it works the same with
		 * mouse events too.
		 */
		$.fn.touchwipe = function(settings) {
			var config = {
				min_move_x: 20,
				min_move_y: 20,
				wipeLeft: function() {},
				wipeRight: function() {},
				wipeUp: function() {},
				wipeDown: function() {},
				preventDefaultEvents: true,
				canUseEvent: function() {
					return true;
				}
			};

			if (settings) {
				$.extend(config, settings);
			}

			this.each(function(i, o) {
				var startX;
				var startY;
				var isMoving = false;

				function cancelTouch() {
					$(o).unbind("touchmove", onTouchMove);
					startX = null;
					isMoving = false;
				}

				function onTouchMove(e) {
					if (config.preventDefaultEvents) {
						e.preventDefault();
					}
					if (isMoving) {
						var x = e.originalEvent.touches ? e.originalEvent.touches[0].pageX : e.pageX;
						var y = e.originalEvent.touches ? e.originalEvent.touches[0].pageY : e.pageY;
						var dx = startX - x;
						var dy = startY - y;
						if (Math.abs(dx) >= config.min_move_x) {
							cancelTouch();
							if (dx > 0) {
								config.wipeLeft.call(o, e);
							} else {
								config.wipeRight.call(o, e);
							}
						} else if (Math.abs(dy) >= config.min_move_y) {
							cancelTouch();
							if (dy > 0) {
								config.wipeDown.call(o, e);
							} else {
								config.wipeUp.call(o, e);
							}
						}
					}
				}

				function onTouchStart(e) {
					if (!config.canUseEvent(e)) {
						return true;
					}
					if (e.originalEvent.touches) {
						if (e.originalEvent.touches.length > 1) {
							return true;
						}
						startX = e.originalEvent.touches[0].pageX;
						startY = e.originalEvent.touches[0].pageY;
					} else {
						startX = e.pageX;
						startY = e.pageY;
					}
					isMoving = true;
					$(o).bind("touchmove", onTouchMove);
					if (config.preventDefaultEvents) {
						e.preventDefault();
					}
					e.stopPropagation();
				}

				$(o).bind("touchstart", onTouchStart);
			});
			return this;
		};

	})(jQuery);
})();
;(function($) {
	"use strict";
	
	var readyStarted = false;
	var readyEnded = false;

	// This should be the FIRST ready handler to execute
	$(function() {
		readyStarted = true;
	});

	// This should be the LAST ready handler to execute
	$(document).bind("ready", function() {
		readyEnded = true;
	});

	$.rawContentHandler = function(cb) {
		if ($.isFunction(cb)) {
			if (!readyStarted) {
				$(function() {
					$.rawContentHandler(cb);
				});
			} else {
				if (!readyEnded) {
					var tgt = $("body")[0];
					cb.call(tgt, tgt.childNodes);
				}

				$(window).bind("rawContent", function(e, items) {
					cb.call(e.target, items || e.target.childNodes);
				});
			}
		}
	};
})(jQuery);
(function($){
	"use strict";

	var $window = $(window);

	// Function that returns true if the image is visible inside the "window"
	// (or specified container element)
	function _isInTheScreen($img, $ct, optionOffset) {
		$ct = $ct || $window;
		optionOffset = optionOffset || 0;
		var is_ct_window  = $ct[0] === window,
			ct_offset  = (is_ct_window ? { top:0, left:0 } : $ct.offset()),
			ct_top     = ct_offset.top + ( is_ct_window ? $ct.scrollTop() : 0),
			ct_left    = ct_offset.left + ( is_ct_window ? $ct.scrollLeft() : 0),
			ct_right   = ct_left + $ct.width(),
			ct_bottom  = ct_top + $ct.height(),
			img_offset = $img.offset(),
			img_width = $img.width(),
			img_height = $img.height();

		return (ct_top - optionOffset) <= (img_offset.top + img_height) &&
			(ct_bottom + optionOffset) >= img_offset.top &&
				(ct_left - optionOffset)<= (img_offset.left + img_width) &&
					(ct_right + optionOffset) >= img_offset.left;
	}

	function doLoadSingleImage($img, src, options) {
		$img.css("opacity", 0).attr("src", src).removeClass("loading").addClass("loaded").trigger("jailStartAnimation");

		$img.animate({
			opacity : 1
		},
		{
			duration : options.speed,
			easing   : "linear",
			queue    : false,
			complete : function() {
				if (options.resizeImages && this.originalCssHeight) {
					this.style.height = this.originalCssHeight;
					delete this.originalCssHeight;
				}
				$img.trigger("jailComplete");
				if (options.callbackAfterEachImage) {
					options.callbackAfterEachImage.call(this, $img, options);
				}
				if (options.images && options.callback && !options.callback.called && areAllImagesLoaded(options.images)) {
					options.callback.called = true;
					options.callback();
				}
			}
		});
	}

	function doLoadImages(event) {
		$("img.lazy[data-href]").each(function(i, o) {
			var $img = $(o);
			var options = $.extend({
				timeout                : 10,
				effect                 : false,
				speed                  : 400,
				selector               : null,
				offset                 : 0,
				event                  : 'scroll',
				callback               : jQuery.noop,
				callbackAfterEachImage : jQuery.noop,
				placeholder            : false,
				resizeImages           : true,
				container              : $window
			}, $img.data("jailOptions") || {});

			if (!event || event === "scroll" || event === "resize" || event === "orientationchange" || options.event === event) {
				if (!options.event || !(/scroll|resize|orientationchange/i).test(options.event) || _isInTheScreen($img, options.container)) {
					if (!$img.is(".loading")) {
						$img.addClass("loading");
						var img = new Image(), href = o.getAttribute("data-href");
						o.removeAttribute("data-href");
						img.onload = function() {
							doLoadSingleImage($img, href, options);
						};
						img.src = href;
					}
				}
			}
		});
	}

	function resizeImage(img) {
		var w = parseInt(img.getAttribute("width" ), 10);
		var h = parseInt(img.getAttribute("height"), 10);
		if (!isNaN(w) && !!isNaN(h)) {
			img.originalCssHeight = img.style.height || "";
			var q = img.offsetWidth / w;
			img.style.height = Math.floor(h * q) + "px";
		}
	}

	function areAllImagesLoaded($images) {
		var loaded = true;
		$images.each(function() {
			if (!$(this).hasClass("loaded")) {
				loaded = false;
				return false; // break each()
			}
		});
		return loaded;
	}

	$.fn.asynchImageLoader = $.fn.jail = function(options) {
		var cfg = $.extend({}, options || {}, { images: this });
		this.data("jailOptions", cfg);
		if (cfg.resizeImages !== false) {
			this.each(function() { resizeImage(this); });
		}
		if (!cfg.event) {
			doLoadImages();
		}
		return this;
	};

	$window.bind("scroll resize load orientationchange", function(e) { doLoadImages(e.type); });

	$(function() {
		setTimeout(function() { doLoadImages(); }, 1000);
	});

}(jQuery));
(function($, undefined) {
	'use strict';

	$.fn.wpvAnimateNumber = function(options) {
		var defaultOptions = {
			from: 0,
			to: 0,
			animate: 1000,
			easing: function (x, t, b, c, d) {
				t = t / (d/2);
				if (t < 1) {
					return c / 2 * t * t + b;
				}
				return -c/2 * ((--t)*(t-2) - 1) + b;
			},
			onStep: $.noop,
			el: null
		};

		options = $.extend(defaultOptions, options);

		if (typeof(options.easing) === 'string' && typeof(jQuery) !== 'undefined' && jQuery.isFunction(jQuery.easing[options.easing])) {
			options.easing = jQuery.easing[options.easing];
		} else {
			options.easing = defaultOptions.easing;
		}

		var reqAnimationFrame = (function() {
			return  window.requestAnimationFrame ||
					window.webkitRequestAnimationFrame ||
					window.mozRequestAnimationFrame ||
					function(callback) {
						window.setTimeout(callback, 1000 / 60);
					};
		}());

		$(this).each(function() {
			options.to = $(this).data('number') || options.to;
			var init = function() {
				var startTime = Date.now();
				var animation = function() {
					var process = Math.min(Date.now() - startTime, options.animate);
					var currentValue = options.easing(this, process, options.from, options.to - options.from, options.animate);
					options.onStep.call(this, options.from, options.to, currentValue);
					if (process < options.animate) {
						reqAnimationFrame(animation);
					}
				}.bind(this);

				reqAnimationFrame(animation);
			}.bind(this);

			init();
		});
	};
})(jQuery);

(function($, undefined) {
	'use strict';

	$(function() {
		$('.wpv-countdown').each(function() {
			var days = $('.wpvc-days .value', this);
			var hours = $('.wpvc-hours .value', this);
			var minutes = $('.wpvc-minutes .value', this);
			var seconds = $('.wpvc-seconds .value', this);

			var until = parseInt($(this).data('until'), 10);
			var done = $(this).data('done');

			var self = $(this);

			var updateTime = function() {
				var now = Math.round( (+new Date()) / 1000 );

				if(until <= now) {
					clearInterval(interval);
					self.html($('<span />').addClass('wpvc-done wpvc-block').html($('<span />').addClass('value').text(done)));
					return;
				}

				var left = until-now;

				seconds.text(left%60);

				left = Math.floor(left/60);
				minutes.text(left%60);

				left = Math.floor(left/60);
				hours.text(left%24);

				left = Math.floor(left/24);
				days.text(left);
			};

			var interval = setInterval(updateTime, 1000);
		});
	});
})(jQuery);
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
(function($, undefined) {
	"use strict";

	var J_WIN     = $(window);
	var J_HTML    = $("html");
	var IS_RESPONSIVE = $("body").hasClass("responsive-layout");

	// Namespace
	jQuery.WPV = jQuery.WPV || {};

	jQuery.WPV.MEDIA = jQuery.WPV.MEDIA || {
		layout: {}
	};

	var LAYOUT_SIZES = [
		{ min: 0   , max: 479     , className : "layout-smallest"},
		{ min: 480 , max: 958     , className : "layout-small"   },
		{ min: 959, max: Infinity, className : "layout-max"     },
		{ min: 959, max: 1280    , className : "layout-max-low"   },

		{ min: 0   , max: 958     , className : "layout-below-max"   }
	];

	if (IS_RESPONSIVE && 'matchMedia' in window) {
		var lastClass, sizesLength = LAYOUT_SIZES.length, i;

		J_WIN.bind('resize.sizeClass load.sizeClass', function () {

			var toAdd = [],
				toDel = [],
				map   = {};

			for (i = 0; i < sizesLength; i++) {
				var mq = '(min-width: '+LAYOUT_SIZES[i].min+'px)';
				if(LAYOUT_SIZES[i].max !== Infinity)
					mq += ' and (max-width: '+LAYOUT_SIZES[i].max+'px)';

				if (window.matchMedia(mq).matches) {
					toAdd.push(LAYOUT_SIZES[i].className);
					map[LAYOUT_SIZES[i].className] = true;
				}
				else {
					toDel.push(LAYOUT_SIZES[i].className);
					map[LAYOUT_SIZES[i].className] = false;
				}
			}

			jQuery.WPV.MEDIA.layout = map;

			toAdd = toAdd.join(" ");
			toDel = toDel.join(" ");
			if (lastClass !== toAdd) {
				lastClass = toAdd;

				// J_HTML.removeClass(toDel).addClass(toAdd);
				J_WIN.trigger("switchlayout");
			}
		});
	} else {
		J_HTML.removeClass("layout-smallest layout-small layout-medium layout-below-max") .addClass("layout-max");
		$.WPV.MEDIA.layout = { "layout-max" : true };
	}

	var delayedResizeTimeout;
	function delayedResizeHandler() {
		if (delayedResizeTimeout) {
			window.clearTimeout(delayedResizeTimeout);
		}
		delayedResizeTimeout = setTimeout(function() {
			J_WIN.trigger("delayedResize");
		}, 150);

	}
	J_WIN.bind('resize',  delayedResizeHandler);

	$.WPV.MEDIA.is_mobile = function() {
		var check = false;
		(function(a){if(/(android|ipad|playbook|silk|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true;})(navigator.userAgent||navigator.vendor||window.opera);
		return check;
	};
})(jQuery);
;(function($,undefined) {
	"use strict";

	$(function() {
		// lazy load images
		// The JAIL plugin is written in such a way that makes an error if it's 
		// applied in empty collection!
		var commonImages = $('img.lazy').not(".portfolios.sortable img, .portfolios.isotope img, .portfolios.scroll-x img, :animated, .wpv-wrapper img");
		if (commonImages.length) {
			commonImages.addClass("jail-started").jail({
				speed: 800
			});
		}

		var sliderImages = $('.wpv-wrapper img.lazy');
		if (sliderImages.length) {
			sliderImages.addClass("jail-started").jail({
				speed: 1400,
				event: 'load'
			});
		}
	});
})(jQuery);
(function($, undefined) {
	"use strict";

	$(function() {
		$('.wpv-overlay-search-trigger').click(function(e) {
			e.preventDefault();

			$.magnificPopup.open({
				type: 'inline',
				items: {
					src: '#wpv-overlay-search',
				},
				closeOnBgClick: false,
				callbacks: {
					open: function() {
						var self = this;

						setTimeout( function() {
							self.content.find( 'form' ).removeAttr( 'novalidate' );
							self.content.find( '[name="s"]' ).focus();
						}, 100 );
					}
				}
			});
		});

		var lightboxTitle = function(item) {
			var share = '';

			if ($('body').hasClass('cbox-share-googleplus')) {
				share += '<div><div class="g-plusone" data-size="medium"></div> <script type="text/javascript">' +
					'(function() {' +
					'	var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;' +
					'	po.src = "https://apis.google.com/js/plusone.js";' +
					'	var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);' +
					'})();' +
					'</script></div>';
			}

			if ($('body').hasClass('cbox-share-facebook')) {
				share += '<div><iframe src="//www.facebook.com/plugins/like.php?href=' + window.location.href + '&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:auto; height:21px;" allowTransparency="true"></iframe></div>';
			}

			if ($('body').hasClass('cbox-share-twitter')) {
				share += '<div><iframe allowtransparency="true" frameborder="0" scrolling="no" src="//platform.twitter.com/widgets/tweet_button.html" style="width:auto; height:20px;"></iframe></div>';
			}

			if ($('body').hasClass('cbox-share-pinterest')) {
				share += '<div><a href="http://pinterest.com/pin/create/button/" class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a></div>';
			}

			var title = (item.el && item.el.attr('title')) || '';

			return '<div id="lightbox-share">' + share + '</div><div id="lightbox-text-title">' + title + '</div>';
		};

		var lightboxGetType = function(el) {
			if (el.attr('data-iframe') === 'true')
				return 'iframe';
			if (el.attr('href').match(/^#/))
				return 'inline';

			return 'image';
		};

		// lightbox
		$.rawContentHandler(function() {
			var wc_lightbox = $('body').hasClass('woocommerce-page') ? ', div.product div.images a.zoom' : '';

			$(".vamtam-lightbox"+wc_lightbox, this)
				.not('.no-lightbox, .size-thumbnail, .cboxElement')
				.each(function() {

				var link = this;
				var $link = $(this);

				var galleryItems = $('[rel="'+$link.attr('rel')+'"]').filter('.vamtam-lightbox, a.zoom'),
					hasGallery = galleryItems.length;

				var items = [];

				var this_item = $.inArray( $link, galleryItems );

				if ( hasGallery ) {
					$( galleryItems ).each( function( i ) {
						if ( this === link ) {
							this_item = i;
						}

						items.push({
							src: $(this).attr('href'),
							type: lightboxGetType($(this))
						});
					} );
				} else {
					items.push({
						src: $link.attr('href'),
						type: lightboxGetType( $link )
					});

					this_item = 0;
				}

				$link.magnificPopup({
					items: items,
					midClick: true,
					preload: [1, 2],
					index: this_item,
					iframe: {
						patterns: {
							youtube: {
								id: function(url) {
									var matches = url.match(/youtu(?:\.be|be\.com)\/(?:.*v(?:\/|=)|(?:.*\/)?)([a-zA-Z0-9-_]+)/);
									if (matches[1]) return matches[1];

									return url;
								}
							},

							vimeo: {
								id: function(url) {
									var matches = url.match(/vimeo\.com\/(?:.*#|.*videos?\/)?([0-9]+)/);
									if (matches[1]) return matches[1];

									return url;
								}
							},

							dailymotion: {
								index: 'dailymotion.com',
								id: function(url) {
									var m = url.match(/^.+dailymotion.com\/(video|hub)\/([^_]+)[^#]*(#video=([^_&]+))?/);

									if (m !== null) {
										if (m[4] !== undefined)
											return m[4];
										return m[2];
									}
									return null;
								}
							}
						}
					},
					image: {
						titleSrc: lightboxTitle
					},
					gallery: {
						enabled: hasGallery
					},
					callbacks: {
						open: function() {
							$(window).resize();
						}
					}
				});
			});
		});
	});
})(jQuery);
(function($, undefined) {
	"use strict";

	$(function() {

		$.rawContentHandler(function() {
			if ( 'tabs' in $.fn ) {
				$('.wpv-tabs', this).each(function() {
					$(this).tabs({
						activate: function(event, ui) {
							var hash = ui.newTab.context.hash;
							var element = $(hash);
							element.attr('id', '');
							window.location.hash = hash;
							element.attr('id', hash.replace('#', ''));
						},
						heightStyle: 'content'
					});
				});
			}

			if ( 'accordion' in $.fn ) {
				$('.wpv-accordion', this).accordion({
					heightStyle: 'content'
				}).each(function() {
					if ($(this).attr('data-collapsible') === 'true') $(this).accordion('option', 'collapsible', true).accordion('option', 'active', false);
				});
			}
		});

	});

})(jQuery);

(function() {
	"use strict";

	var iOS = navigator.userAgent.match(/(iPad|iPhone|iPod)/g);
	if(!iOS) return;

	window.document.addEventListener('orientationchange', function() {
		var viewportmeta = document.querySelector('meta[name="viewport"]');
		if (viewportmeta) {
			if (viewportmeta.content.match(/width=device-width/)) {
				viewportmeta.content = viewportmeta.content.replace(/width=[^,]+/, 'width=1');
			}
			viewportmeta.content = viewportmeta.content.replace(/width=[^,]+/, 'width=' + window.innerWidth);
		}
	}, false);
})();
(function($, undefined) {
	"use strict";

	$(function() {
		if ( Modernizr.touch || true ) {
			var currently_active;

			$( '.fixed-header-box .menu-item-has-children > a' ).bind( 'touchend', function( e ) {
				this.had_touchend = e.timeStamp;
			} ).bind( 'click', function( e ) {
				if ( e.timeStamp - ( this.had_touchend || 0 ) > 1000 ) {
					return true;
				}

				if ( currently_active !== this ) {
					e.preventDefault();
					currently_active = this;
				}

				e.stopPropagation();
			} );

			$( window ).bind( 'click.sub-menu-double-tap', function() {
				currently_active = undefined;
			} );
		}

		$('#main-menu .menu-item > .sub-menu').each(function() {
			$(this).wrap('<div class="sub-menu-wrapper"></div>');
		});

		var mainHeader = $('header.main-header'),
			win = $(window),
			doc = $(document);

		// add left/right classes to submenus depending on resolution

		var allSubMenus   = $( '#main-menu .sub-menu, #top-nav-wrapper .sub-menu' );

		win.bind( 'smartresize.wpv-menu-classes', function() {
			var winWidth = win.width();

			allSubMenus.show().removeClass( 'invert-position' ).each( function() {
				if ( $( this ).offset().left + $( this ).width() > winWidth ) {
					$( this ).addClass( 'invert-position' );
				}
			} );
			allSubMenus.css( 'display', '' );
		} );

		// scrolling below

		var explorer = /MSIE (\d+)/.exec(navigator.userAgent);
		var hasStickyHeader = function() {
			return $('body').hasClass('sticky-header') &&
				!(explorer && parseInt(explorer[1], 10) === 8) &&
				!$.WPV.MEDIA.is_mobile() &&
				!$.WPV.MEDIA.layout["layout-below-max"];
		};

		var currentAnimation;

		var scrollToEl = function(el) {
			if(el.length > 0 && !currentAnimation) {
				currentAnimation = el;

				var firstAnimation = true,
					animationStart = +new Date();

				var getScrollPosition = function() {
					var header = mainHeader.offset().top + mainHeader.height() - $(window).scrollTop();
					var adminbar = ($('#wpadminbar') ? $('#wpadminbar').height() : 0);

					return ~~(el.offset().top - (hasStickyHeader() ? header : adminbar));
				};

				var advance = function(q) {
					return ~~((getScrollPosition() - win.scrollTop())*q);
				};

				var goToEl = function(done) {
					var move = advance(0.9),
						now = +new Date();

					if( done || Math.abs(move) <= 100 ) {
						if(now - animationStart > 300) {
							currentAnimation = void 0;
							$('html,body').stop().animate({
								scrollTop: getScrollPosition()
							}, 50, 'linear', function() {
								$.WPV.blockStickyHeaderAnimation = false;
							});
						} else {
							waitForFinish();
						}

						return;
					} else {
						$('html,body').stop().animate({
							scrollTop: "+="+move
						}, Math.abs(move)/4, 'linear', function() {
							if(!firstAnimation) {
								$.WPV.blockStickyHeaderAnimation = true;
							}

							firstAnimation = false;
							if(getScrollPosition() - win.scrollTop() > 50 && win.scrollTop() + win.height() < doc.height()) {
								goToEl();
							} else if(!done) {
								goToEl(true);
							}
						});
					}
				};

				var waitForFinish = function() {
					var now = +new Date();
					var timeLeft = now - animationStart;

					$('html,body').stop().animate({
						scrollTop: getScrollPosition()
					}, timeLeft/2, 'linear', function() {
						$('html,body').stop().animate({
							scrollTop: getScrollPosition()
						}, timeLeft/2, 'linear', function() {
							$('html,body').stop().animate({
								scrollTop: getScrollPosition()
							}, 50, 'linear', function() {
								currentAnimation = void 0;
								$.WPV.blockStickyHeaderAnimation = false;
							});
						});
					});
				};

				goToEl();
			}
		};

		$(document.body).on('click', '.wpv-animated-page-scroll[href], .wpv-animated-page-scroll [href], .wpv-animated-page-scroll [data-href]', function(e) {
			var href = $( this ).prop( 'href' ) || $( this ).data( 'href' );
			var el   = $( '#' + ( href ).split( "#" )[1] );

			var l  = document.createElement('a');
			l.href = href;

			if(el.length && l.pathname === window.location.pathname) {
				scrollToEl(el);
				e.preventDefault();
			}
		});

		if ( window.location.hash !== "" &&
			(
				$( '.wpv-animated-page-scroll[href*="' + window.location.hash + '"]' ).length ||
				$( '.wpv-animated-page-scroll [href*="' + window.location.hash + '"]').length ||
				$( '.wpv-animated-page-scroll [data-href*="'+window.location.hash+'"]' ).length ||
				$( '.wpv-tabs [href*="' + window.location.hash + '"]').length
			)
		) {
			var el = $( window.location.hash );

			if ( $( '.wpv-tabs [href*="' + window.location.hash + '"]').length ) {
				el = el.closest( '.wpv-tabs' );
			}

			if ( el.length > 0 ) {
				$( 'html,body' ).animate( {
					scrollTop: $( 'html' ).scrollTop() + 1
				}, 0 );
			}

			setTimeout( function() {
				scrollToEl( el );
			}, 400 );
		}

		// adds .current-menu-item classes

		var hashes = [
			// ['top', $('<div></div>'), $('#top')]
		];

		$('#main-menu').find('.menu').find('.maybe-current-menu-item, .current-menu-item').each(function() {
			var link = $('> a', this);

			if(link.prop('href').indexOf('#') > -1) {
				var link_hash = link.prop('href').split('#')[1];

				if('#'+link_hash !== window.location.hash) {
					$(this).removeClass('current-menu-item');
				}

				hashes.push([link_hash, $(this), $('#'+link_hash)]);
			}
		});

		if ( hashes.length ) {
			var winHeight = 0;
			var documentHeight = 0;

			var prev_upmost_data = null;

			win.scroll(function() {
				winHeight = win.height();
				documentHeight = $(document).height();

				var cpos = win.scrollTop();
				var upmost = Infinity;
				var upmost_data = null;

				for(var i=0; i<hashes.length; i++) {
					var el = hashes[i][2];

					if(el.length) {
						var top = el.offset().top + 10;

						if( top > cpos && top < upmost && ( top < cpos + winHeight/2 || ( top < cpos + winHeight && cpos + winHeight === documentHeight) ) ) {
							upmost_data = hashes[i];
							upmost = top;
						}

						hashes[i][1].removeClass('current-menu-item');
					}
				}

				if(upmost_data) {
					upmost_data[1].addClass('current-menu-item');

					if('history' in window && (prev_upmost_data !== null ? prev_upmost_data[0] : '') !== upmost_data[0]) {
						window.history.pushState(upmost_data[0], $('> a', upmost_data[1]).text(), (cpos !== 0 ? '#'+upmost_data[0] : location.href.replace(location.hash, '')));
						prev_upmost_data = $.extend({}, upmost_data);
					}
				} else if( upmost_data === null && prev_upmost_data !== null) {
					prev_upmost_data[1].addClass('current-menu-item');
				}
			});
		}
	});
})(jQuery);
(function($, undefined) {
	"use strict";

	$(function() {
		var win = $(window),
			win_width,
			body = $('body'),
			hbox = $('.fixed-header-box'),
			hbox_filler,
			header = $('header.main-header'),
			single_row_header = header.hasClass('layout-logo-menu'),
			type_over = body.hasClass('sticky-header-type-over'),
			type_half_over = header.hasClass('layout-standard') && body.hasClass('sticky-header-type-half-over'),
			middle = $('.header-middle.type-slider'),
			middle_filler,
			main_content = $('#main-content'),
			second_row = hbox.find('.second-row'),
			admin_bar_fix = body.hasClass('admin-bar') ? 32 : 0,
			logo_wrapper = hbox.find('.logo-wrapper'),
			logo_wrapper_height = 0,
			top_nav = $('.top-nav'),
			top_nav_height = 0,
			explorer = /MSIE (\d+)/.exec(navigator.userAgent),
			loaded = false,
			interval,
			small_logo_height = 46;

		var ok_to_load = function() {
			return ( body.hasClass( 'sticky-header' ) || body.hasClass( 'had-sticky-header' ) ) &&
				! ( explorer && parseInt( explorer[1], 10 ) === 8 ) &&
				! $.WPV.MEDIA.is_mobile() &&
				! $.WPV.MEDIA.layout["layout-below-max"] &&
				hbox.length && second_row.length;
		};

		var ok_to_load_middle = function() {
			return false && middle.length && $('#header-slider-container').length && $('.wpv-grid.parallax-bg').length === 0;
		};

		var init = function() {
			if ( ! ok_to_load() ) {
				if ( body.hasClass( 'sticky-header' ) ) {
					body.removeClass( 'sticky-header' ).addClass( 'had-sticky-header' );
				}
				return;
			}

			win_width = win.width();

			hbox_filler = hbox.clone().html('').css({
				'z-index': 0,
				visibility: 'hidden',
				height: type_over ? top_nav.outerHeight() : ( type_half_over ? logo_wrapper.outerHeight() : hbox.outerHeight() )
			}).insertAfter(hbox);

			hbox.css({
				position: 'fixed',
				top: hbox.offset().top,
				left: hbox.offset().left,
				width: hbox.outerWidth(),
				'-webkit-transform': 'translateZ(0)'
			});

			if(ok_to_load_middle()) {
				middle_filler = middle.clone().html('').css({
					'z-index': 0,
					visibility: 'hidden',
					height: middle.outerHeight()
				}).insertAfter(middle);

				middle.css({
					position: 'fixed',
					top: middle.offset().top,
					left: middle.offset().left,
					width: middle.outerWidth(),
					'z-index': 0
				});
			} else {
				middle_filler = null;
			}

			logo_wrapper_height = logo_wrapper.removeClass('scrolled').outerHeight();
			top_nav_height = top_nav.show().outerHeight();
			logo_wrapper.addClass('loaded');

			interval = setInterval(reposition, 41);

			loaded = true;

			win.scroll();
		};

		var destroy = function() {
			if(hbox_filler)
				hbox_filler.remove();

			hbox.removeClass('static-absolute fixed').css({
				position: '',
				top: '',
				left: '',
				width: '',
				'-webkit-transform': ''
			});

			if(middle_filler) {
				middle_filler.remove();

				middle.css({
					position: '',
					top: '',
					left: '',
					width: '',
					'z-index': 0
				});
			}

			logo_wrapper.removeClass('scrolled loaded');

			clearInterval(interval);

			loaded = false;
		};

		var chrome_video_bg_bug = $('.wpv-grid.has-video-bg').length > 0 &&  $('.wpv-grid.parallax-bg').length > 0,
			prev_cpos = -1,
			scrolling_down = true,
			scrolling_up = false,
			start_scrolling_up;

		var reposition = function() {
			if(!loaded)
				return;

			var cpos = win.scrollTop();

			if(single_row_header) {
				var delta = type_over ? top_nav_height : logo_wrapper_height - small_logo_height + top_nav_height;
				var trigger = chrome_video_bg_bug ? delta*1.5 : 0;

				if(!('blockStickyHeaderAnimation' in $.WPV) || !$.WPV.blockStickyHeaderAnimation) {
					scrolling_down = prev_cpos < cpos;
					scrolling_up = prev_cpos > cpos;

					if(scrolling_up && start_scrolling_up === undefined) {
						start_scrolling_up = cpos;
					} else if(scrolling_down) {
						start_scrolling_up = undefined;
					}

					prev_cpos = cpos;
				}

				if(!body.hasClass('no-sticky-header-animation') && !body.hasClass('no-sticky-header-animation-tmp')) {
					if( cpos > trigger && scrolling_down ) {
						if(!(logo_wrapper.hasClass('scrolled'))) {
							logo_wrapper.addClass('scrolled');

							hbox.css( 'transform', 'translateY(-' + top_nav_height + 'px)' );

							body.addClass('no-sticky-header-animation-tmp');
							setTimeout(function() {
								body.removeClass('no-sticky-header-animation-tmp');
							}, 350);
						}
					} else if(logo_wrapper.hasClass('scrolled') && scrolling_up && (start_scrolling_up - cpos > 60 || start_scrolling_up < 120) ) {
						logo_wrapper.removeClass('scrolled');

						hbox.css( 'transform', 'translateY(0px)' );

						body.addClass('no-sticky-header-animation-tmp');
						setTimeout(function() {
							body.removeClass('no-sticky-header-animation-tmp');
						}, 350);
					}
				}
			} else {
				var hbox_height = hbox.outerHeight(),
					second_row_height = second_row.height(),
					mcpos = main_content.offset().top - admin_bar_fix;

				if(mcpos <= cpos + hbox_height) {
					if( cpos + second_row_height <= mcpos) {
						hbox.css({
							position: 'absolute',
							top: mcpos - hbox_height,
							left: 0
						}).addClass('static-absolute').removeClass('fixed second-stage-active');
					} else {
						hbox.css({
							position: 'fixed',
							top: admin_bar_fix + second_row_height - hbox_height,
							left: hbox_filler.offset().left,
							width: hbox.outerWidth()
						}).addClass('second-stage-active');
					}
				} else {
					hbox.removeClass('static-absolute second-stage-active').css({
						position: 'fixed',
						top: hbox_filler.offset().top,
						left: hbox_filler.offset().left,
						width: hbox_filler.outerWidth()
					});
				}
			}

			if(!hbox.hasClass('fixed') && !hbox.hasClass('static-absolute') && !hbox.hasClass('second-stage-active')) {
				hbox.css({
					position: 'fixed',
					top: hbox_filler.offset().top,
					left: hbox_filler.offset().left,
					width: hbox.outerWidth()
				}).addClass('fixed');
			}

			body.toggleClass('wpv-scrolled', cpos > 0).toggleClass('wpv-not-scrolled', cpos === 0);
		};

		win.bind('scroll touchmove', reposition).smartresize(function() {
			if(win.width() !== win_width) {
				destroy();
				init();
			}
		});

		init();
	});
})(jQuery);
( function( $, undefined ) {
	'use strict';

	var win = $( window ),
		win_height = 0;

	var explorer = /MSIE (\d+)/.exec( navigator.userAgent ),
		mobileSafari = navigator.userAgent.match( /(iPod|iPhone|iPad)/ ) && navigator.userAgent.match( /AppleWebKit/ );

	win.resize(function() {
		win_height = win.height();

		if (
			( explorer && parseInt( explorer[1], 10 ) === 8 ) ||
			mobileSafari ||
			$.WPV.MEDIA.layout['layout-below-max']
		) {
			$( '.wpv-grid.animated-active' ).removeClass( 'animated-active' ).addClass( 'animated-suspended' );
		} else {
			$( '.wpv-grid.animated-suspended' ).removeClass( 'animated-suspended' ).addClass( 'animated-active' );
		}
	}).resize();

	win.bind( 'scroll touchmove load', function() {
		var win_height = win.height();
		var all_in = $(window).scrollTop() + win_height;

		$( '.wpv-grid.animated-active:not(.animation-ended)' ).each( function() {
			var el = $( this );
			var el_height = el.outerHeight();
			var visible   = all_in > el.offset().top + el_height * ( el_height > 100 ? 0.3 : 0.6 );

			if ( visible || mobileSafari ) {
				el.addClass( 'animation-ended' );
			} else {
				return false;
			}
		} );
	} ).scroll();
} )( jQuery );
(function($, undefined) {
	"use strict";

	var win = $(window),
		win_height = win.height();

	var explorer = /MSIE (\d+)/.exec(navigator.userAgent);

	win.bind('resize', function() {
		win_height = win.height();

		if(
			!Modernizr.csscalc ||
			(explorer && parseInt(explorer[1], 10) === 8) ||
			$.WPV.MEDIA.is_mobile() ||
			$.WPV.MEDIA.layout["layout-below-max"]
		) {
			$('.wpv-grid.parallax-bg').removeClass('parallax-bg').addClass('parallax-bg-suspended');
			$('.wpv-parallax-bg-img').css({
				'background-position': '50% 50%'
			});
		} else {
			$('.wpv-grid.parallax-bg-suspended').removeClass('parallax-bg-suspended').addClass('parallax-bg');
			win.scroll();
		}
	});

	var new_pos = function(method, x, top, cpos, inertia, height) {
		var vert = '';

		switch(method) {
			case 'fixed':
				vert = Math.round( (cpos - top) * inertia)  + "px";
			break;

			case 'to-centre':
				vert = 'calc(50% - '+ Math.round( (top + height/2 - cpos - win_height/2)*inertia ) + 'px)';
			break;
		}

		return x + ' ' +  vert;
	};

	win.bind('scroll touchmove load', _.throttle(function() {
		var cpos = win.scrollTop(),
			all_visible = cpos + win_height;

		$('.wpv-grid.parallax-bg').each(function() {
			var top = $(this).offset().top,
				height = $(this).outerHeight();

			if(top + height < cpos || top > all_visible)
				return;

			var fakebg = $('.wpv-parallax-bg-img', this);

			if(!fakebg.length) return;

			var method = $(this).data('parallax-method'),
				inertia = $(this).data('parallax-inertia'),
				bgpos = new_pos(method, '50%', top, cpos, inertia, height),
				css = {'background-position': bgpos};

			fakebg.css(css);
		});
	}, 41));

	var bgprops = 'position image color size attachment repeat'.split(' ');

	$(function() {
		$('.wpv-grid.parallax-bg:not(.parallax-loaded)').each(function() {
			var self = $(this);

			var local_bgprops = {};
			$.each(bgprops, function(i, p) {
				local_bgprops['background-'+p] = self.css('background-'+p);
			});

			self.addClass('parallax-loaded').wrapInner(function() {
				return $('<div></div>').addClass('wpv-parallax-bg-content');
			}).prepend(function() {
				var div = $('<div></div>')
					.addClass('wpv-parallax-bg-img')
					.css(local_bgprops);

				return div;
			}).css('background', '');
		});

		win.scroll();
	});
})(jQuery);
/* jshint multistr:true */
(function() {
	"use strict";

	jQuery.WPV = jQuery.WPV || {}; // Namespace

	(function ($, undefined) {
		var J_WIN     = $(window);

		$(function () {
			if(top !== window && /vamtam\.com/.test(document.location.href)) {
				var width = 0;

				setInterval(function() {
					if($(window).width() !== width) {
						$(window).resize();
						setTimeout(function() { $(window).resize(); }, 100);
						setTimeout(function() { $(window).resize(); }, 200);
						setTimeout(function() { $(window).resize(); }, 300);
						setTimeout(function() { $(window).resize(); }, 500);
						width = $(window).width();
					}
				}, 200);
			}

			var body = $('body');

			if ( body.is( '.responsive-layout' ) ) {
				J_WIN.triggerHandler('resize.sizeClass');
			}

			body.bind('wpv-content-resized', function() {
				setTimeout(function() {
					body.trigger('wpv-hide-splash-screen');
				}, 1000);

				body.imagesLoaded(function() {
					body.trigger('wpv-hide-splash-screen');
				});
			}).one('wpv-hide-splash-screen', function() {
				$('.wpv-splash-screen').fadeOut(500, function() {
					$(this).remove();
				});
			});

			// if ( $.fn.select2 ) {
			// 	$( '.wpcf7-form-control-wrap.dropdown select, .vamtam-select2' ).select2();
			// }

			// prevent hover when scrolling
			(function() {
				var box = document.querySelector( '.boxed-layout' ),
					timer;

				window.addEventListener( 'scroll', function() {
					clearTimeout(timer);

					requestAnimationFrame( function() {
						box.style.pointerEvents = 'none';

						timer = setTimeout( function() {
							box.style.pointerEvents = '';
						}, 300 );
					} );
				}, { passive: true } );
			})();

			if($('html').is('.placeholder')) {
				$.rawContentHandler(function() {
					$('.label-to-placeholder label[for]').each(function() {
						$('#' + $(this).prop('for')).attr('placeholder', $(this).text());
						$(this).hide();
					});
				});
			}

			if ( navigator.userAgent.match( /(iPod|iPhone|iPad)/ ) && navigator.userAgent.match( /AppleWebKit/ ) ) {
				var version = /Version\/(\d+)/.exec( navigator.userAgent );

				if ( version && parseInt( version[1], 10 ) <= 7 ) {
					$( 'html' ).addClass( 'bad-ios' );
				}
			}

			// Video resizing
			// =====================================================================
			J_WIN.bind('resize.vamtam-video load.video', function() {
				$('.portfolio-image-wrapper,\
					.boxed-layout .media-inner,\
					.boxed-layout .loop-wrapper.news .thumbnail,\
					.boxed-layout .portfolio-image .thumbnail,\
					.boxed-layout .wpv-video-frame').find('iframe, object, embed, video').each(function() {
					var v = $(this);

					if(v.prop('width') === '0' && v.prop('height') === '0') {
						v.css({width: '100%'}).css({height: v.width()*9/16});
					} else {
						v.css({height: v.prop('height')*v.width()/v.prop('width')});
					}

					v.trigger('vamtam-video-resized');
				});

				setTimeout(function() {
					$('.mejs-time-rail').css('width', '-=1px');
				}, 100);
			}).triggerHandler("resize.vamtam-video");

			if('mediaelementplayer' in $.fn) {
				$('.wpv-background-video').mediaelementplayer({
					videoWidth: '100%',
					videoHeight: '100%',
					loop: true,
					enableAutosize: true,
					features: []
				});
			}

			$('.wpv-grid.has-video-bg').addClass('video-bg-loaded');

			(function() {
				var body = $('body');
				var admin_bar_fix = body.hasClass('admin-bar') ? 32 : 0;

				J_WIN.smartresize(function() {
					$('body').trigger('wpv-content-resized');

					if( !(body.hasClass('boxed')) ) {
						var pos = ($('.wpv-grid.extended:first').outerWidth() - $(window).width())/2;
						$('.extended-column-inner > .wpv-video-bg,\
							.wpv-grid.extended.grid-1-1.parallax-bg > .wpv-parallax-bg-img,\
							.wpv-grid.extended.grid-1-1.parallax-bg-suspended > .wpv-parallax-bg-img').css({
							left: pos,
							right: pos
						});

						$('.extended-column-inner > .wpv-video-bg').each(function() {
							var mep = $('mediaelementwrapper > *', this),
								meph = mep.height(),
								thish = $(this).height(),
								thisw = $(this).width();

							var newvw = (thish/meph)*thisw,
								adj = (newvw - thisw)/2;

							if(adj > 0) {
								$(this).css({
									left: "-="+adj,
									right: "-="+adj
								});
							}
						});
					}

					var wheight = J_WIN.height() - admin_bar_fix;

					$('.wpv-grid[data-padding-top]').each(function() {
						var col = $(this);

						col.css('padding-top', 0);
						col.css('padding-top', wheight - col.outerHeight() + parseInt(col.data('padding-top'), 10));
					});

					$('.wpv-grid[data-padding-bottom]:not([data-padding-top])').each(function() {
						var col = $(this);

						col.css('padding-bottom', 0);
						col.css('padding-bottom', wheight - col.outerHeight() + parseInt(col.data('padding-bottom'), 10));
					});

					$('.wpv-grid[data-padding-top][data-padding-bottom]').each(function() {
						var col = $(this);

						col.css('padding-top', 0);
						col.css('padding-bottom', 0);

						var new_padding = (wheight - col.outerHeight() + parseInt(col.data('padding-top'), 10))/2;

						col.css({
							'padding-top': new_padding,
							'padding-bottom': new_padding
						});
					});
				});
			})();

			// Animated buttons
			// =====================================================================
			$(document).on('mouseover focus click', '.animated.flash, .animated.wiggle', function() {
				$(this).removeClass('animated');
			});

			// Tooltip
			// =====================================================================
			var tooltip_animation = 250;
			$('.shortcode-tooltip').hover(function () {
				var tt = $(this).find('.tooltip').fadeIn(tooltip_animation).animate({
					bottom: 25
				}, tooltip_animation);
				tt.css({ marginLeft: -tt.width() / 2 });
			}, function () {
				$(this).find('.tooltip').animate({
					bottom: 35
				}, tooltip_animation).fadeOut(tooltip_animation);
			});

			$('.sitemap li:not(:has(.children))').addClass('single');

			// Scroll to top button
			// =====================================================================
			$(window).bind('resize scroll', function () {
				$('#scroll-to-top').toggleClass("visible", window.pageYOffset > 0);
			});
			$('#scroll-to-top, .wpv-scroll-to-top').click(function (e) {
				$('html,body').animate({
					scrollTop: 0
				}, 300);

				e.preventDefault();
			});

		});

		$('#feedback.slideout').click(function(e) {
			$(this).parent().toggleClass("expanded");
			e.preventDefault();
		});

		// Equal height elements
		// =========================================================================
		(function() {
			var elements = [];

			$( ".row:has(> div.has-background)" ).each( function( i, row_el ) {
				var row = $( row_el ),
					columns = row.find( '> div' );

				if ( columns.length > 1 ) {
					row.addClass( 'has-nomargin-column' );
					elements.push( columns );
				}
			});

			$( ".row:has(> div > .linkarea)" ).each( function( i, row_el ) {
				var row = $( row_el ),
					columns = row.find( '> div > .linkarea' );

				if ( columns.length > 1 ) {
					elements.push( columns );
				}
			});

			$( ".row:has(> div > .services.has-more)" ).each( function( i, row_el ) {
				var row = $( row_el ),
					columns = row.find( '> div > .services.has-more > .closed' );

				if ( columns.length > 1 ) {
					elements.push( columns );
				}
			});

			$( '#footer-sidebars .row' ).each( function() {
				elements.push( $(this).find('aside') );
			});

			J_WIN.resize( _.throttle( function() {
				var i;
				if ( $.WPV.MEDIA.layout['layout-below-max'] ) {
					for ( i = 0; i < elements.length; ++i ) {
						elements[i].matchHeight( 'remove' );
					}
				} else {
					for ( i = 0; i < elements.length; ++i ) {
						elements[i].matchHeight( false );
					}
				}
			}, 600 ) );
		})();

		// LINKAREA
		// =========================================================================
		$( document )
		.on("mouseenter", ".linkarea[data-hoverclass]", function() {
			$(this).addClass(this.getAttribute("data-hoverclass"));
		})
		.on("mouseleave", ".linkarea[data-hoverclass]", function() {
			$(this).removeClass(this.getAttribute("data-hoverclass"));
		})
		.on("mousedown", ".linkarea[data-activeclass]", function() {
			$(this).addClass(this.getAttribute("data-activeclass"));
		})
		.on("mouseup", ".linkarea[data-activeclass]", function() {
			$(this).removeClass(this.getAttribute("data-activeclass"));
		})
		.on("click", ".linkarea[data-href]", function(e) {
			if (e.isDefaultPrevented()) {
				return false;
			}

			var href = this.getAttribute("data-href");
			if (href) {
				e.preventDefault();
				e.stopImmediatePropagation();
				try {
					var target = String(this.getAttribute("data-target") || "self").replace(/^_/, "");
					if (target === "blank" || target === "new") {
						window.open(href);
					} else {
						window[target].location = href;
					}
				} catch (ex) {}
			}
		});

		J_WIN.triggerHandler('resize.sizeClass');

		$(window).bind("load", function() {
			setTimeout(function() {
				$(window).trigger("resize");
			}, 1);
		});

	})(jQuery);

})();


( function( $, undefined ) {
	'use strict';


	$(function() {
		var cube_found = 'cubeportfolio' in $.fn;
		var cube_loading = false;

		var win = $(window);

		var cube_narrow = function( el ) {
			requestAnimationFrame( function() {
				var inner = el.find( '.cbp-wrapper' );
				var outer = el.find( '.cbp-wrapper-outer' );

				console.log( inner, outer );

				if ( inner.width() <= outer.width() ) {
					el.addClass( 'vamtam-cube-narrow' );
				} else {
					el.removeClass( 'vamtam-cube-narrow' );
				}
			} );
		};

		var attempt_cube_load_callback = function() {
			$( '.vamtam-cubeportfolio[data-options]:not(.vamtam-cube-loaded)' ).filter( ':visible' ).each( function() {
				var self    = $( this );
				var options = self.data( 'options' );

				if ( ! ( 'singlePageCallback' in options ) ) {
					options.singlePageDelegate = null;
				}

				options.singlePageCallback = cube_single_page[ options.singlePageCallback ] || null;

				self.on( 'initComplete.cbp', function() {
					if ( 'slider' === options.layoutMode ) {
						cube_narrow( self );

						win.on( 'resize.vamtamcube', function() {
							cube_narrow( self );
						} );
					}
				} );

				self.addClass( 'vamtam-cube-loaded' ).cubeportfolio( options );

				self.on( 'vamtam-video-resized', 'iframe, object, embed, video', function() {
					self.data('cubeportfolio').layoutAndAdjustment();
				} );

				this.addEventListener( 'vamtamlazyloaded', function() {
					self.data('cubeportfolio').layoutAndAdjustment();
				} );
			} );
		};

		// if there are cube instances, check that the script is loaded
		// otherwise - load it and prevent further calls to attempt_cube_load
		// until cube is available
		var attempt_cube_load = function() {
			if ( document.getElementsByClassName( 'vamtam-cubeportfolio' ).length ) {
				if ( cube_found ) {
					attempt_cube_load_callback();
				} else if ( ! cube_loading ) {
					cube_loading = true;

					var s = document.createElement('script');
					s.type = 'text/javascript';
					s.async = true;
					s.src = VAMTAM_FRONT.cube_path;
					s.onload = function() {
						cube_found = 'cubeportfolio' in $.fn;

						attempt_cube_load_callback();
					};

					document.getElementsByTagName('script')[0].before( s );
				}
			}
		};

		var cube_single_page = {
			portfolio: function( url ) {
				var t = this;

				$.ajax({
					url: url,
					type: 'GET',
					dataType: 'html'
				})
				.done(function(result) {
					t.updateSinglePage(result);

					attempt_cube_load();

					$( document ).trigger( 'vamtam-single-page-project-loaded' );
				})
				.fail(function() {
					t.updateSinglePage('AJAX Error! Please refresh the page!');
				});
			}
		};

		$( document ).on( 'vamtam-attempt-cube-load', attempt_cube_load );
		attempt_cube_load();

		window.addEventListener( 'resize', window.VAMTAM.debounce( attempt_cube_load, 100 ), false );

		window.addEventListener( 'load', function() {
			$( '.cbp' ).each( function() {
				try {
					this.data( 'cubeportfolio' ).layoutAndAdjustment();
				} catch ( e ) {}
			} );
		}, false );
	});
} )( jQuery );
(function($, undefined) {
	'use strict';

	$(function() {
		var dropdown = $('.fixed-header-box .cart-dropdown'),
			link = $('.vamtam-cart-dropdown-link'),
			count = $('.products', link),
			widget = $('.widget', dropdown),
			isVisible = false;

		$('body').bind('added_to_cart wc_fragments_refreshed wc_fragments_loaded', function() {
			var count_val = parseInt( Cookies.get( 'woocommerce_items_in_cart' ) || 0, 10 );

			if ( count_val > 0 ) {
				var count_real = 0;
				$( '.widget_shopping_cart:first li .quantity' ).each( function() {
					count_real += parseInt( $( this ).clone().children().remove().end().contents().text(), 10 );
				} );
				count.text( count_real );
				count.removeClass( 'cart-empty' );
				dropdown.removeClass( 'hidden' );
				$(this).addClass( 'header-cart-visible' );

			} else {
				count.addClass( 'cart-empty' );
				count.text( '0' );
				// dropdown.addClass('hidden');
				// $(this).removeClass('header-cart-visible');
			}

		});

		var open = 0;

		var showCart = function() {
			open = +new Date();
			dropdown.addClass('state-hover');
			widget.stop(true, true).fadeIn(300, function() {
				isVisible = true;
			});
		};

		var hideCart = function() {
			var elapsed = new Date() - open;

			if(elapsed > 1000) {
				dropdown.removeClass('state-hover');
				widget.stop(true, true).fadeOut(300, function() {
					isVisible = false;
				});
			} else {
				setTimeout(function() {
					if(!dropdown.is(':hover')) {
						hideCart();
					}
				}, 1000 - elapsed);
			}
		};

		dropdown.bind('mouseenter', function() {
			showCart();
		}).bind('mouseleave', function() {
			hideCart();
		});

		link.not('.no-dropdown').bind('click', function(e) {
			if(isVisible) {
				hideCart();
			} else {
				showCart();
			}

			e.preventDefault();
		});
	});
})(jQuery);
(function($, undefined) {
	"use strict";

	var show = function() {
		var self = $(this);

		if(self.closest('.animated-active:not(.animation-ended)').length > 0)
			return;

		if(self.data('closed-at') && (+new Date()) - self.data('closed-at') < 10)
			return;

		var	c = self.clone();

		setTimeout(function() {
			var parent_width = $.WPV.MEDIA.layout["layout-below-max"] ? self.width() : self.parent().width();

			c.css({
				width: parent_width,
				position: 'absolute',
				left: self.parent().position().left + parseFloat(self.parent().css('padding-left'), 10),
				top: self.parent().position().top,
				zIndex: 10000000000
			})
			.addClass('transitionable');

			if(!self.attr('id'))
				self.attr('id', 'hover-id-'+Math.round(Math.random()*100000000));

			if(!c.attr('id'))
				c.attr('id', 'hover-clone-id-'+Math.round(Math.random()*100000000));

			if($('#'+self.attr('id')+':hover').length === 0) return;

			self.css({visibility: 'hidden'});

			c.appendTo(self.closest('.row')).addClass('state-hover');

			c.find('.shrinking .icon').transit({
				'font-size': Math.min(100, parent_width - 15)
			}, 200, 'easeOutQuad');

			var content = c.find('.services-content').slideDown({
				duration: 200,
				easing: 'easeOutQuad'
			});

			var interval = setInterval(function() {
				if(!Modernizr.touch && $('#'+c.attr('id')+':hover').length === 0) {
					clearInterval(interval);
					c.trigger('mouseleave');
				}
			}, 500);

			var close = function() {
				if(!$(this).hasClass('state-hover')) return;

				c.removeClass('state-hover');

				c.find('.shrinking .icon').transit({
					'font-size': 60
				}, 500, 'easeOutQuad');

				content.slideUp({
					duration: 500,
					easing: 'easeOutQuad',
					complete: function() {
						c.remove();
						self.css({visibility: 'visible'}).data('closed-at', (+new Date()));
					}
				});
			};

			if ( ! Modernizr.touch ) {
				c.unbind('mouseleave.shrinking').bind('mouseleave.shrinking', close);
			}
		}, 20);
	};

	$.rawContentHandler(function() {
		var s = $('.services:has(.shrinking)');

		if ( ! Modernizr.touch ) {
			s.unbind('mouseenter.shrinking').bind('mouseenter.shrinking', show);
		}
	});

	var resize = function() {
		$('.services:not(.transitionable) .shrinking').each(function() {
			var _w = $(this).width();
				$(this).height(_w);
				$(this).find('.icon').css({'line-height': _w+'px'});

				$(this).closest('.services').prev().css({width: _w});
			});
	};

	$(window).bind('resize', resize);
	resize();

})(jQuery);
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
( function( $, v, undefined ) {

'use strict';

var Portfolio = function() {
	$( function() {
		this.init();
	}.bind( this ) );
};

Portfolio.prototype.init = function() {
	this.wrappers = $( '.portfolios' );

	$( '.page-content, .page-content > .row:first-child > .wpv-grid:first-child' ).find( ' > .portfolios:first-child > .portfolio-filters' ).appendTo( $( '.page-header-content' ) );

	this.wrappers.on( 'mouseenter', '.vamtam-project', this.mouseenter.bind( this ) );
	this.wrappers.on( 'mouseleave', '.vamtam-project', this.mouseleave.bind( this ) );
	this.wrappers.on( 'touchstart', '.vamtam-project', this.touchstart.bind( this ) );
	this.wrappers.on( 'touchmove', '.vamtam-project', this.touchmove.bind( this ) );
	this.wrappers.on( 'touchend', '.vamtam-project', this.touchend.bind( this ) );

	// close all open projects on touchstart anywhere outside a project
	document.body.addEventListener( 'touchstart', function( e ) {
		var closest = e.target.closest( '.vamtam-project' );
		var open    = document.querySelectorAll( '.vamtam-project.state-open' );

		for ( var i = 0; i < open.length; i++ ) {
			if ( open[i] !== closest ) {
				this.doClose( open[i] );
			}
		}
	}.bind( this ) );
};

Portfolio.prototype.mouseenter = function( e ) {
	this.doOpen( e.target.closest( '.vamtam-project' ) );
};

Portfolio.prototype.mouseleave = function( e ) {
	this.doClose( e.target.closest( '.vamtam-project' ) );
};

Portfolio.prototype.touchstart = function( e ) {
	var item = e.target.closest( '.vamtam-project' );

	if ( item.classList.contains( 'state-closed' ) && ! v.MEDIA.layout[ 'layout-below-max' ] ) {
		item.vamtamMaybeOpen = true;
	}
};

Portfolio.prototype.touchend = function( e ) {
	var item = e.target.closest( '.vamtam-project' );

	if ( item.vamtamMaybeOpen ) {
		item.vamtamMaybeOpen = false;

		this.doOpen( item );
		e.preventDefault();
	}
};

Portfolio.prototype.touchmove = function( e ) {
	e.target.closest( '.vamtam-project' ).vamtamMaybeOpen = false;
};

Portfolio.prototype.doOpen = function( el ) {
	if ( ! el.classList.contains( 'state-open' ) ) {
		requestAnimationFrame( function() {
			el.classList.add( 'state-open' );
			el.classList.remove( 'state-closed' );
		} );
	}
};

Portfolio.prototype.doClose = function( el ) {
	if ( ! el.classList.contains( 'state-closed' ) ) {
		requestAnimationFrame( function() {
			el.classList.add( 'state-closed' );
			el.classList.remove( 'state-open' );
		} );
	}
};

new Portfolio();

} )( jQuery, jQuery.WPV );
(function($, undefined) {
	"use strict";

	$(function() {
		var wrap = $('#header-slider-container.layerslider').find('.layerslider-fixed-wrapper'),
			first = wrap.find('>div:first');

		if(!first.length) return;

		var timeout = false,
			wait = 0,
			remove_height = function() {
				if(first.height() > 0 || wait++ > 5) {
					wrap.height('auto');
					return;
				}

				timeout = setTimeout(remove_height, 500);
			};

		timeout = setTimeout(remove_height, 0);
	});
})(jQuery);
(function($, undefined) {
	"use strict";

	$(function() {
		var settings = {};

		var mediaElement = function( context ) {
			if ( typeof window._wpmejsSettings !== 'undefined' ) {
				settings = $.extend( true, {}, window._wpmejsSettings );
			}

			settings.classPrefix = 'mejs-';
			settings.success = settings.success || function( mejs ) {
				var autoplay, loop;

				if ( mejs.rendererName && -1 !== mejs.rendererName.indexOf( 'flash' ) ) {
					autoplay = mejs.attributes.autoplay && 'false' !== mejs.attributes.autoplay;
					loop = mejs.attributes.loop && 'false' !== mejs.attributes.loop;

					if ( autoplay ) {
						mejs.addEventListener( 'canplay', function() {
							mejs.play();
						}, false );
					}

					if ( loop ) {
						mejs.addEventListener( 'ended', function() {
							mejs.play();
						}, false );
					}
				}
			};

			if ( 'mediaelementplayer' in $.fn ) {
				// Only initialize new media elements.
				$( '.wp-audio-shortcode, .wp-video-shortcode', context )
					.not( '.mejs-container' )
					.filter(function () {
						return ! $( this ).parent().hasClass( 'mejs-mediaelement' );
					})
					.mediaelementplayer( settings );
			}
		};

		// infinite scrolling
		if($('body').is('.pagination-infinite-scrolling')) {
			var last_auto_load = 0;
			$(window).bind('resize scroll', function(e) {
				var button = $('.lm-btn'),
					now_time = e.timeStamp || (new Date()).getTime();

				if(now_time - last_auto_load > 500 && parseFloat(button.css('opacity'), 10) === 1 && $(window).scrollTop() + $(window).height() >= button.offset().top) {
					last_auto_load = now_time;
					button.click();
				}
			});
		}

		$("body").on("click.pagination", ".load-more", function( e ) {
			e.preventDefault();
			e.stopPropagation(); // customizer support

			var self = $(this);
			var list = self.prev();
			var link = self.find( 'a' );

			if ( self.hasClass( 'loading' ) ) {
				return false;
			}

			self.addClass( 'loading' ).find( '> *' ).animate({opacity: 0});

			$.post( VAMTAM_FRONT.ajaxurl, {
				action: 'vamtam-load-more',
				query: link.data( 'query' ),
				other_vars: link.data( 'other-vars' )
			}, function( result ) {
				var content = $( result.content );

				mediaElement( content );

				var visible = list.find( '.cbp-item:not( .cbp-item-off )' ).length;

				list.cubeportfolio( 'appendItems', content, function() {
					if ( visible === list.find( '.cbp-item:not( .cbp-item-off )' ).length ) {
						var warning = $( '<p />' ).addClass( 'vamtam-load-more-warning' ).text( list.data( 'hidden-by-filters' ) );

						warning.insertAfter( self );

						$( 'body' ).one( 'click', function() {
							warning.remove();
						} );
					}

					self.replaceWith( result.button );

					self.removeClass( 'loading' ).find( '> *' ).animate({opacity: 1});

					$( window ).triggerHandler( 'resize.vamtam-video' );
				} );
			});
		} );
	});
})(jQuery);