/**
 * @see http://stackoverflow.com/a/21015636/635882
 */
(function($) {
	'use strict';

	if ( 'ontouchstart' in window ) {
		var startTime = null,
			startTouch = null,
			isActive = false,
			scrolled = false;

		/* Constructor */
		window.WPVQuickTap = function(context) {
			var self = this;

			context.on("touchstart", function(evt) {
				startTime = evt.timeStamp;
				startTouch = evt.originalEvent.touches.item(0);
				isActive = true;
				scrolled = false;
			});

			context.on("touchend", function(evt) {
				// Get the distance between the initial touch and the point where the touch stopped.
				var duration = evt.timeStamp - startTime,
					movement = self.getMovement(startTouch, evt.originalEvent['changedTouches'].item(0)),
					isTap = !scrolled && movement < 5 && duration < 200;

				if (isTap) {
					$(evt.target).trigger('wpvQuickTap', evt);

					evt.preventDefault();
				}
			});

			context.on('scroll mousemove touchmove', function(evt) {
				if ((evt.type === "scroll" || evt.type === 'mousemove' || evt.type === 'touchmove') && isActive && !scrolled) {
					scrolled = true;
				}
			});
		};

		/* Calculate the movement during the touch event(s)*/
		WPVQuickTap.prototype.getMovement = function(s, e) {
			if (!s || !e) return 0;
			var dx = e.screenX - s.screenX,
				dy = e.screenY - s.screenY;
			return Math.sqrt((dx * dx) + (dy * dy));
		};
	}

})(jQuery);
/**
 * mlpushmenu.js v1.0.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Copyright 2013, Codrops
 * http://www.codrops.com
 */
( function( window, $, undefined ) {
	'use strict';

	// taken from https://github.com/inuyaksa/jquery.nicescroll/blob/master/jquery.nicescroll.js
	function hasParent( e, id ) {
		if (!e) return false;
		var el = e.target||e.srcElement||e||false;
		while (el && el.id !== id) {
			el = el.parentNode||false;
		}
		return (el!==false);
	}

	// returns the depth of the element "e" relative to element with id=id
	// for this calculation only parents with classname = waypoint are considered
	function getLevelDepth( e, id, waypoint, cnt ) {
		cnt = cnt || 0;
		if ( e.id.indexOf( id ) >= 0 ) return cnt;
		if( $(e).hasClass(waypoint) ) {
			++cnt;
		}
		return e.parentNode && getLevelDepth( e.parentNode, id, waypoint, cnt );
	}

	function mlPushMenu( el, trigger, options ) {
		/*jshint validthis:true */
		var self = this;
		this.el = el;
		this.$el = $( el );
		this.trigger = trigger;
		this.options = $.extend( this.defaults, options );
		this._init();
	}

	function translate(X) {
		return 'translate3d(' + X + ',0,0)';
	}

	mlPushMenu.prototype = {
		defaults : {
			// classname for the element (if any) that when clicked closes the current level
			backClass : 'mp-back',
			duration: .7
		},
		_init : function() {
			// if menu is open or not
			this.open = false;
			// level depth
			this.level = 0;
			// the moving wrapper
			this.wrapper = $( '#mp-pusher' );
			// the mp-level elements
			this.levels = Array.prototype.slice.call( this.el.querySelectorAll( 'div.mp-level' ) );
			this.$levels = $( this.levels );
			// save the depth of each of these mp-level elements
			var self = this;
			this.levels.forEach( function( el ) { el.setAttribute( 'data-level', getLevelDepth( el, self.el.id, 'mp-level' ) ); } );
			// the menu items
			this.menuItems = Array.prototype.slice.call( this.el.querySelectorAll( 'li' ) );
			// if type == "cover" these will serve as hooks to move back to the previous level
			this.levelBack = Array.prototype.slice.call( this.el.querySelectorAll( '.' + this.options.backClass ) );
			// event type (if mobile use touch events)
			this.eventtype = 'click';

			this._initInteractions();
		},
		_initEvents : function() {
			var self = this;

			// open (or close) the menu
			this.trigger.bind( 'touchstart.openpushmenu, click.openpushmenu', function( ev ) {
				ev.stopPropagation();
				ev.preventDefault();

				if( self.open ) {
					self._resetMenu();
				} else {
					self._openMenu();
					// the menu should close if clicking somewhere on the body (excluding clicks on the menu)
					$( window ).bind( 'touchstart.closepushmenu click.closepushmenu', function( ev ) {
						if( self.open && !hasParent( ev.target, self.el.id ) ) {
							ev.preventDefault();
							self._resetMenu();
							$( window ).unbind( 'touchstart.closepushmenu click.closepushmenu' );
						}
					} );
				}
			} );
		},
		_initInteractions: function() {
			var self = this;

			self.vamtam_yepnope=function(a,b){function c(){}function d(a){return Object(a)===a}function e(a){return"string"==typeof a}function f(){return"yn_"+q++}function g(){o&&o.parentNode||(o=b.getElementsByTagName("script")[0])}function h(a){return!a||"loaded"==a||"complete"==a||"uninitialized"==a}function i(b,c){c.call(a)}function j(a,j){var k,l,m;e(a)?k=a:d(a)&&(k=a._url||a.src,l=a.attrs,m=a.timeout),j=j||c,l=l||{};var q,r,t=b.createElement("script");m=m||n.errorTimeout,t.src=k,s&&(t.event="onclick",t.id=t.htmlFor=l.id||f());for(r in l)t.setAttribute(r,l[r]);t.onreadystatechange=t.onload=function(){if(!q&&h(t.readyState)){if(q=1,s)try{t.onclick()}catch(a){}i(k,j)}t.onload=t.onreadystatechange=t.onerror=null},t.onerror=function(){q=1,j(new Error("Script Error: "+k))},p(function(){q||(q=1,j(new Error("Timeout: "+k)),t.parentNode.removeChild(t))},m),g(),o.parentNode.insertBefore(t,o)}function k(f,h){var i,j,k={};d(f)?(i=f._url||f.href,k=f.attrs||{}):e(f)&&(i=f);var l=b.createElement("link");h=h||c,l.href=i,l.rel="stylesheet",l.media="only x",l.type="text/css",p(function(){l.media=k.media||"all"});for(j in k)l.setAttribute(j,k[j]);g(),o.parentNode.appendChild(l),p(function(){h.call(a)})}function l(a){var b=a.split("?")[0];return b.substr(b.lastIndexOf(".")+1)}function m(a,b){var c=a,d=[],e=[];for(var f in b)b.hasOwnProperty(f)&&(b[f]?d.push(encodeURIComponent(f)):e.push(encodeURIComponent(f)));return(d.length||e.length)&&(c+="?"),d.length&&(c+="yep="+d.join(",")),e.length&&(c+=(d.length?"&":"")+"nope="+e.join(",")),c}function n(a,b,c){var e;d(a)&&(e=a,a=e.src||e.href),a=n.urlFormatter(a,b),e?e._url=a:e={_url:a};var f=l(a);if("js"===f)j(e,c);else{if("css"!==f)throw new Error("Unable to determine filetype.");k(e,c)}}var o,p=a.setTimeout,q=0,r={}.toString,s=!(!b.attachEvent||a.opera&&"[object Opera]"==r.call(a.opera));return n.errorTimeout=1e4,n.injectJs=j,n.injectCss=k,n.urlFormatter=m,n}(window,document); // jshint ignore:line

			window.vamtampmgs = window.GreenSockGlobals = {};
			window._gsQueue = window._gsDefine = null;

			var scripts = [
				window.WpvPushMenu.jspath + 'gsap/Draggable.min.js',
				window.WpvPushMenu.jspath + 'gsap/ThrowPropsPlugin.min.js',
				window.WpvPushMenu.jspath + 'gsap/CSSPlugin.min.js',
				window.WpvPushMenu.jspath + 'gsap/TweenLite.min.js',
			];

			var total_ready = 0;
			var maybe_ready = function() {
				if ( ++ total_ready >= scripts.length ) {
					window.GreenSockGlobals = window._gsQueue = window._gsDefine = null;

					window.vamtampmgs_greensock_loaded = true;

					scripts_loaded();
				}
			};

			if ( scripts.length > 0 ) {
				for ( var i = 0; i < scripts.length; i++ ) {
					self.vamtam_yepnope.injectJs( scripts[i], maybe_ready );
				}
			} else {
				maybe_ready();
			}

			var scripts_loaded = function() {
				var win = $( window );

				var first_time = true;
				var logo_wrapper = $( 'header.main-header .logo-wrapper' );

				self.$el.css( {
					height: 'auto',
					bottom: 0
				} );

				var resize_callback = function() {
					if ( win.width() > window.WpvPushMenu.limit ) {
						self._resetMenu( true );
					}
				};

				var reposition_trigger = function() {
					if ( self.trigger.is( ':visible' ) && ! self.open ) {
						var wrapper_offset = self.wrapper.offset().top;

						self.$el.css( 'top', wrapper_offset );

						self.trigger.css( {
							top: logo_wrapper.offset().top + logo_wrapper.outerHeight() / 2 - wrapper_offset,
							left: '100%'
						} );

						if ( first_time ) {
							first_time = false;
							self.trigger.appendTo( self.$el )
							vamtampmgs.TweenLite.to( self.trigger, .5, { autoAlpha: 1, ease: vamtampmgs.Power4.easeOut } );
						}
					}
				}

				win.bind( 'resize touchmove', _.debounce( resize_callback, 100 ) );
				win.resize( _.debounce( reposition_trigger, 1000 ) );
				resize_callback();
				reposition_trigger();

				self._initEvents();

				self.draggable = vamtampmgs.Draggable.create( self.$el.find( '> ul > li > .mp-level' ), {
					type: "scrollTop",
					edgeResistance: 0.7,
					throwProps: true,
					dragClickables: true,
					onClick: function( e ) {
						e.preventDefault();
						e.stopPropagation();

						var el = $( e.target );

						console.log( e, e.target );

						// back button
						if ( el.hasClass( 'mp-back' ) ) {

							self.level = $(el).closest('.mp-level').data('level') - 1;
							if(self.level === 0) {
								self._resetMenu();
							} else {
								self._closeMenu();
							}

							return;
						}

						// regular menu items
						var next_level = el.find( '+ .mp-level' );
						if( next_level.length ) {
							el.closest('.mp-level').addClass('mp-level-overlay');

							// Chrome 55 click issue
							setTimeout( function() {
								self._openMenu( next_level );
							}, 100 );
						} else {
							var href = el.attr( 'href' );

							if ( href ) {
								try {
									var target = String( el.attr( 'target' ) || 'self' ).replace( /^_/, '' );
									if ( target === 'blank' || target === 'new' ) {
										window.open( href );
									} else {
										window[target].location = href;

										if ( href[0] === '#' ) {
											self._resetMenu();
										}
									}
								} catch (ex) {
									console.log( e );
									self._resetMenu();
								}
							}
						}
					}
				} );

				self.$el.find( '> ul > li > .mp-level' ).css( 'overflow-y', 'hidden' );
			};
		},
		_openMenu : function( subLevel ) {
			// increment level depth
			++this.level;

			document.getElementsByTagName("html")[0].style.overflow = 'hidden';

			if ( 'draggable' in this ) {
				this.draggable[0].scrollProxy.scrollTop( 0 );
			}

			// move the main wrapper
			var levelFactor = ( this.level - 1 ) * this.options.levelSpacing,
				translateVal = this.el.offsetWidth;


			// add class mp-pushed to main wrapper if opening the first time
			if( this.level === 1 ) {
				this.wrapper.addClass('mp-pushed');
				vamtampmgs.TweenLite.to( this.$el, this.options.duration, { x: 270, ease: vamtampmgs.Power3.easeOut } );
				this.open = true;
			} else if ( subLevel ) {
				// check that the number of show/hides corresponds with the one in _closeMenu
				subLevel.closest( 'li' ).siblings().hide();
				subLevel.prev().hide();
				this.$levels.not( subLevel ).find( '> .mp-level-header, > div > .mp-level-header' ).hide();
				subLevel.find( '> .mp-level-header, > div > .mp-level-header' ).show();
			}

			// add class mp-level-open to the opening level element
			$(subLevel || this.levels[0]).addClass('mp-level-open');
		},
		// close the menu
		_resetMenu : function(avoidresize) {
			// remove class mp-pushed from main wrapper
			this.wrapper.removeClass('mp-pushed');
			vamtampmgs.TweenLite.to( this.$el, this.options.duration, { x: 0, ease: vamtampmgs.Power2.easeOut } );
			document.getElementsByTagName("html")[0].style.overflow = '';
			this.open = false;

			// _closeMenu always closes the currently active level
			// we must run it multiple times to account for nested submenus
			// stop when the root level becomes active
			while ( this.level-- >= 0 ) {
				this._closeMenu();
			}

			this.level = 0;

			if(!avoidresize) {
				$(window).resize();

				setTimeout(function() {
					$(window).resize();
				}, 500);
			}
		},
		// removes classes mp-level-open from closing levels
		_closeMenu : function() {
			var self = this;

			this.$levels.each( function( i, level ) {
				level = $( level );

				if( level.data('level') > self.level ) {
					// deeper than target level -  hide level and show level trigger

					level.removeClass('mp-level-open mp-level-overlay');
					level.prev().show();
				} else if( Number( level.data('level') ) === self.level ) {
					// at target level - show level and level header

					level.removeClass('mp-level-overlay');

					// check that the number of show/hides corresponds with the one in _closeMenu
					self.$levels.not( level ).not( '[data-level="' + self.level + '"]' ).find( '> .mp-level-header, > div > .mp-level-header' ).hide();
					level.find( '> .mp-level-header, > div > .mp-level-header' ).show();
					level.find( 'li, li > a' ).show();
				}
			} );
		}
	};

	// add to global namespace
	window.MlPushMenu = mlPushMenu;

} )( window, jQuery );
(function($, undefined) {
	"use strict";

	var PM = {
		Models: {},
		Collections: {},
		Views: {}
	};

PM.Models.Root = Backbone.Model.extend({
	defaults: {
		title: '',
		description: '',
		type: 'root',
		children: []
	},
	initialize: function() {
		this.children = new PM.Collections.Item();
	}
});

PM.Models.Item = Backbone.Model.extend({
	defaults: {
		url: '',
		title: '',
		attr_title: '',
		description: '',
		classes: [],
		type: 'root',
		children: []
	}
});
PM.Collections.Item =  Backbone.Collection.extend({
	model: PM.Models.Item
});

PM.Collections.Root =  Backbone.Collection.extend({
	model: PM.Models.Root
});
PM.Views.Root = Backbone.View.extend({
	el: $('.main-container'),
	initialize: function() {
		this.template = $('#wpvpm-menu-root').html();
		_.bindAll(this, 'render');
		this.listenTo( this.model, 'change', this.render );
		this.render();
	},
	render: function() {
		var content = new PM.Views.Item({
			model: new PM.Models.Item(this.model.toJSON())
		}).render();

		var scroller = $('<div></div>').addClass('mp-scroller').attr('id', 'mp-scroller'),
			pusher = $('<div></div>').addClass('mp-pusher').attr('id', 'mp-pusher');

		$(this.el)
		.wrap(pusher)
		.before( _.template(this.template)({
			content: content
		}) );

		$(this.el).wrap(scroller);
	}
});

PM.Views.Item = Backbone.View.extend({
	initialize: function() {
		this.template = $('#wpvpm-menu-item').html();
		_.bindAll(this, 'render');
	},
	render: function() {
		var content = '';

		_(this.model.get('children')).each(function(child) {
			var child_view = new PM.Views.Item({
				model: new PM.Models.Item(child)
			});

			content += child_view.render();
		});

		return _.template(this.template)(
			_.extend(this.model.toJSON(), {
				content: content
			})
		);
	}
});

$(function() {
	if('WpvPushMenu' in window && WpvPushMenu.items) {
		new PM.Views.Root({
			model: new PM.Models.Root(WpvPushMenu.items)
		});

		var trigger = $( '#mp-menu-trigger' );

		if(trigger) {
			new MlPushMenu( document.getElementById( 'mp-menu' ), trigger, {} );

			if('WPVQuickTap' in window) {
				// new WPVQuickTap( $('#mp-menu .mp-back, #mp-menu .has-children, #mp-menu-trigger') );
			}
		}
	}
});

})(jQuery);