/* Themify Theme Scripts - http://themify.me/ */

// Declar object literals and variables
var FixedHeader = {}, LayoutAndFilter = {}, themifyScript, ThemifySlider, ThemifyGallery, ThemifyMediaElement, qp_max_pages;

// throttledresize
!function($){var e=$.event,t,n={_:0},r=0,s,i;t=e.special.throttledresize={setup:function(){$(this).on("resize",t.handler)},teardown:function(){$(this).off("resize",t.handler)},handler:function(h,o){var a=this,l=arguments;s=!0,i||(setInterval(function(){r++,(r>t.threshold&&s||o)&&(h.type="throttledresize",e.dispatch.apply(a,l),s=!1,r=0),r>9&&($(n).stop(),i=!1,r=0)},30),i=!0)},threshold:0}}(jQuery);

(function($){

// Fixed Header /////////////////////////
FixedHeader = {
	headerHeight: 0,
	hasHeaderSlider: false,
	headerSlider: false,
	init: function() {
		if( '' !== themifyScript.fixedHeader ) {
			this.headerHeight = $('#headerwrap').outerHeight(true);
			this.activate();
			$(window).on('scroll touchstart.touchScroll touchmove.touchScroll', this.activate);
		}
		$('#pagewrap').css('paddingTop', Math.floor( this.headerHeight ));
		$(window).on( 'throttledresize', function() {
			$('#pagewrap').css('paddingTop', Math.floor( $('#headerwrap').outerHeight(true) ));
		});
		if( $( '#gallery-controller' ).length > 0 ) {
			this.hasHeaderSlider = true;
		}
	},
	activate: function() {
		var $window = $(window),
			scrollTop = $window.scrollTop(),
			$headerWrap = $('#headerwrap'),
			hwHeight = $headerWrap.height();
		$('#pagewrap').css('paddingTop', Math.floor( this.headerHeight ));
		if( scrollTop >= FixedHeader.headerHeight ) {
			if ( ! $headerWrap.hasClass( 'fixed-header' ) ) {
				FixedHeader.scrollEnabled();
			}
		} else {
			if ( $headerWrap.hasClass( 'fixed-header' ) ) {
				FixedHeader.scrollDisabled();
			}
		}
	},
	scrollDisabled: function() {
		$('#pagewrap').css('paddingTop', Math.floor( this.headerHeight ));
		$('#headerwrap').removeClass('fixed-header');
		$('#header').removeClass('header-on-scroll');
		$('body').removeClass('fixed-header-on');
		if ( FixedHeader.hasHeaderSlider ) {
			$('#headerwrap').data('backstretch').resize();
			$('#gallery-controller .slides').trigger( 'next' );
		}
	},
	scrollEnabled: function() {
		$('#headerwrap').addClass('fixed-header');
		$('#header').addClass('header-on-scroll');
		$('body').addClass('fixed-header-on');
		if ( FixedHeader.hasHeaderSlider ) {
			$('#headerwrap').data('backstretch').resize();
			$('#gallery-controller .slides').trigger( 'next' );
		}
	}
};
FixedHeader.init();

// Initialize carousels //////////////////////////////
ThemifySlider = {
	recalcHeight: function(items, $obj) {
		var heights = [], height;
		$.each( items, function() {
			heights.push( $(this).outerHeight(true) );
		});
		height = Math.max.apply( Math, heights );
		$obj.closest('.carousel-wrap').find( '.caroufredsel_wrapper, .slideshow' ).each(function(){
			$(this).outerHeight( height );
		});
	},
	didResize: false,

	createCarousel: function(obj) {
		var self = this;
		obj.each(function() {
			var $this = $(this);
			$this.carouFredSel({
				responsive: true,
				prev: '#' + $this.data('id') + ' .carousel-prev',
				next: '#' + $this.data('id') + ' .carousel-next',
				pagination: {
					container: '#' + $this.data('id') + ' .carousel-pager'
				},
				circular: true,
				infinite: true,
				swipe: true,
				scroll: {
					items: $this.data('scroll'),
					fx: 'scroll',
					duration: parseInt($this.data('speed'))
				},
				auto: {
					play: ('off' !== $this.data('autoplay')),
					timeoutDuration: 'off' !== $this.data('autoplay') ? parseInt($this.data('autoplay')) : 0
				},
				items: {
					visible: {
						min: 1,
						max: $this.data('visible') ? parseInt($this.data('visible')) : 1
					},
					width: 222
				},
				onCreate: function( items ) {
					var $slideWrap = $this.closest( '.slideshow-wrap' );
					$slideWrap.css({
						'visibility': 'visible',
						'height': 'auto'
					});
					
					
					$(window).on( 'throttledresize', function() {
						self.recalcHeight(items.items, $this);	
					});
					$(window).resize();

					setTimeout( function(){
						$slideWrap.find( '.carousel-nav-wrap' ).css( 'width', ( parseInt( $slideWrap.find( '.carousel-pager' ).find( 'a' ).length ) * 18 ) + 'px' );
					}, 200 );
				}
			});
		});
	}
};

// Test if touch event exists //////////////////////////////
function is_touch_device() {
	return 'true' === themifyScript.isTouch;
}

// Scroll to Element //////////////////////////////
function themeScrollTo(offset) {
	$('body,html').animate({ scrollTop: offset }, 800);
}

// Infinite Scroll ///////////////////////////////
function doInfinite( $container, selector ) {

	if ( 'undefined' !== typeof $.fn.infinitescroll ) {

		// Get max pages for regular category pages and home
		var scrollMaxPages = parseInt(themifyScript.maxPages);

		// Get max pages for Query Category pages
		if ( typeof qp_max_pages !== 'undefined') {
			scrollMaxPages = qp_max_pages;
		}

		// infinite scroll
		$container.infinitescroll({
			navSelector  : '#load-more a:last', 		// selector for the paged navigation
			nextSelector : '#load-more a:last', 		// selector for the NEXT link (to page 2)
			itemSelector : selector, 	// selector for all items you'll retrieve
			loadingText  : '',
			donetext     : '',
			loading 	 : { img: themifyScript.loadingImg },
			maxPage      : scrollMaxPages,
			behavior	 : 'auto' !== themifyScript.autoInfinite? 'twitter' : '',
			pathParse 	 : function (path, nextPage) {
				return path.match(/^(.*?)\b2\b(?!.*\b2\b)(.*?$)/).slice(1);
			},
			bufferPx: 50,
			pixelsFromNavToBottom: $('#footerwrap').height()
		}, function(newElements) {
			// call Isotope for new elements
			var $newElems = $(newElements);

			// Mark new items: remove newItems from already loaded items and add it to loaded items
			$('.post.newItems').removeClass('newItems');
			$newElems.addClass('newItems');

			if ( 'reset' === themifyScript.resetFilterOnLoad ) {
				// Make filtered elements visible again
				LayoutAndFilter.reset();
			}

			$newElems.hide().imagesLoaded(function(){

				$newElems.fadeIn();

				$('.wp-audio-shortcode, .wp-video-shortcode').not('div').each(function() {
					var $self = $(this);
					if ( $self.closest('.mejs-audio').length === 0 ) {
						ThemifyMediaElement.init($self);
					}
				});

				// Apply lightbox/fullscreen gallery to new items
				if(typeof ThemifyGallery !== 'undefined'){ ThemifyGallery.init({'context': $(themifyScript.lightboxContext)}); }

				if ( 'object' === typeof $container.data('isotope') ) {
					$container.isotope('appended', $newElems );
				}

				if ( LayoutAndFilter.filterActive ) {
					// If new elements with new categories were added enable them in filter bar
					LayoutAndFilter.enableFilters();

					if ( 'scroll' === themifyScript.scrollToNewOnLoad ) {
						LayoutAndFilter.restore();
					}
				}

				$('#infscr-loading').fadeOut('normal');
				if( 1 === scrollMaxPages ){
					$('#load-more, #infscr-loading').remove();
				}

				/**
			     * Fires event after the elements and its images are loaded.
			     *
			     * @event infiniteloaded.themify
			     * @param {object} $newElems The elements that were loaded.
			     */
				$('body').trigger( 'infiniteloaded.themify', [$newElems] );

				$(window).trigger( 'resize' );
			});

			scrollMaxPages = scrollMaxPages - 1;
			if( 1 < scrollMaxPages && 'auto' !== themifyScript.autoInfinite) {
				$('.load-more-button').show();
			}
		});

		// disable auto infinite scroll based on user selection
		if( 'auto' === themifyScript.autoInfinite ){
			$('#load-more, #load-more a').hide();
		}
	}
}

// Entry Filter /////////////////////////
LayoutAndFilter = {
	filterActive: false,
	init: function() {
		themifyScript.disableMasonry = $('body').hasClass('masonry-enabled') ? '' : 'disable-masonry';
		if ( 'disable-masonry' !== themifyScript.disableMasonry ) {
			$('.post-filter + .portfolio.list-post,.loops-wrapper.grid4,.loops-wrapper.grid3,.loops-wrapper.grid2,.loops-wrapper.portfolio.grid4,.loops-wrapper.portfolio.grid3,.loops-wrapper.portfolio.grid2').prepend('<div class="grid-sizer">').prepend('<div class="gutter-sizer">');
			this.enableFilters();
			this.filter();
			this.filterActive = true;
		}
	},
	enableFilters: function() {
		var $filter = $('.post-filter');
		if ( $filter.find('a').length > 0 && 'undefined' !== typeof $.fn.isotope ) {
			$filter.find('li').each(function(){
				var $li = $(this),
					$entries = $li.parent().next(),
					cat = $li.attr('class').replace(/(current-cat)|(cat-item)|(-)|(active)/g, '').replace(' ', '');
				if ( $entries.find('.portfolio-post.cat-' + cat).length <= 0 ) {
					$li.hide();
				} else {
					$li.show();
				}
			});
		}
	},
	filter: function() {
		var $filter = $('.post-filter');
		if ( $filter.find('a').length > 0 && 'undefined' !== typeof $.fn.isotope ) {
			$filter.addClass('filter-visible').on('click', 'a', function( e ) {
				e.preventDefault();
				var $li = $(this).parent(),
					$entries = $li.parent().next();
				if ( $li.hasClass('active') ) {
					$li.removeClass('active');
					$entries.isotope({
						masonry: {
							columnWidth: '.grid-sizer',
							gutter: '.gutter-sizer'
						},
						filter: '.portfolio-post'
					});
				} else {
					$li.siblings('.active').removeClass('active');
					$li.addClass('active');
					$entries.isotope({
						filter: '.cat-' + $li.attr('class').replace(/(current-cat)|(cat-item)|(-)|(active)/g, '').replace(' ', '')
					});
				}
			});
		}
	},
	scrolling: false,
	reset: function() {
		$('.post-filter').find('li.active').find('a').addClass('previous-active').trigger('click');
		this.scrolling = true;
	},
	restore: function() {
		//$('.previous-active').removeClass('previous-active').trigger('click');
		var $first = $('.newItems').first(),
			self = this,
			to = $first.offset().top - ( $first.outerHeight(true)/2 ),
			speed = 800;

		if ( to >= 800 ) {
			speed = 800 + Math.abs( ( to/1000 ) * 100 );
		}
		$('html,body').stop().animate({
			scrollTop: to
		}, speed, function() {
			self.scrolling = false;
		});
	},
	layout: function() {
		if ( 'disable-masonry' !== themifyScript.disableMasonry ) {
			$('.post-filter + .portfolio.list-post,.loops-wrapper.portfolio.grid4,.loops-wrapper.portfolio.grid3,.loops-wrapper.portfolio.grid2,.loops-wrapper.portfolio-taxonomy').isotope({
				masonry: {
					columnWidth: '.grid-sizer',
					gutter: '.gutter-sizer'
				},
				itemSelector : '.portfolio-post'
			}).addClass('masonry-done');

			

			$('.loops-wrapper.grid4,.loops-wrapper.grid3,.loops-wrapper.grid2').not('.portfolio-taxonomy,.portfolio')
				.isotope({
					masonry: {
						columnWidth: '.grid-sizer',
						gutter: '.gutter-sizer'
					},
					itemSelector: '.loops-wrapper > article'
				})
				.addClass('masonry-done')
				.isotope( 'once', 'layoutComplete', function() {
					$(window).trigger('resize');
				});

			$('.woocommerce.archive').find('#content').find('ul.products').isotope({
				layoutMode: 'packery',
				itemSelector : '.type-product'
			}).addClass('masonry-done');
		}
		var $gallery = $('.gallery-wrapper.packery-gallery');
		if ( $gallery.length > 0 ) {
			$gallery.isotope({
				layoutMode: 'packery',
				itemSelector: '.item'
			});
		}
	},
	reLayout: function() {
		$('.loops-wrapper').each(function(){
			var $loopsWrapper = $(this);
			if ( 'object' === typeof $loopsWrapper.data('isotope') ) {
				$loopsWrapper.isotope('layout');
			}
		});
		var $gallery = $('.gallery-wrapper.packery-gallery');
		if ( $gallery.length > 0 && 'object' === typeof $gallery.data('isotope') ) {
			$gallery.isotope('layout');
		}
	}
};

// DOCUMENT READY
$(document).ready(function() {

	var $body = $('body'), $header = $('#header');

	/////////////////////////////////////////////
	// Scroll to row when a menu item is clicked.
	/////////////////////////////////////////////
	if ( 'undefined' !== typeof $.fn.themifyScrollHighlight ) {
		$body.themifyScrollHighlight();
	}

	/////////////////////////////////////////////
	// Initialize Packery Layout and Filter
	/////////////////////////////////////////////
	LayoutAndFilter.init();
	LayoutAndFilter.layout();

	/////////////////////////////////////////////
	// Initialize color animation
	/////////////////////////////////////////////
	if ( 'undefined' !== typeof $.fn.animatedBG ) {
		$('.animated-bg').animatedBG({
			colorSet: themifyScript.colorAnimationSet.split(','),
			speed: parseInt( themifyScript.colorAnimationSpeed, 10 )
		});
	}

	/////////////////////////////////////////////
	// Scroll to top
	/////////////////////////////////////////////
	$('.back-top a').on('click', function(e){
		e.preventDefault();
		themeScrollTo(0);
	});

	/////////////////////////////////////////////
	// Toggle main nav on mobile
	/////////////////////////////////////////////
	if( typeof $.fn.themifyDropdown === 'function' ) {
		$( '#main-nav' ).themifyDropdown();
	}
	if ( $body.hasClass( 'header-minbar' ) || $body.hasClass( 'header-leftpane' ) ) {
		/////////////////////////////////////////////
		// Side Menu for header-minbar and header-leftpane
		/////////////////////////////////////////////
		$('#menu-icon').themifySideMenu({
			close: '#menu-icon-close',
			side: 'left'
		});
		/////////////////////////////////////////////
		// NiceScroll only for header-minbar and header-leftpane
		/////////////////////////////////////////////
		if ( 'undefined' !== typeof $.fn.niceScroll ) {
			var $niceScrollTarget = $header;
			if ( $body.hasClass( 'header-minbar' ) ) {
				$niceScrollTarget = $('#mobile-menu');
			}
			$niceScrollTarget.niceScroll();
			$body.on( 'sidemenushow.themify', function(){
				setTimeout(function(){
					$niceScrollTarget.getNiceScroll().resize();
				}, 200);
			} );
		}
	} else {
		/////////////////////////////////////////////
		// Side Menu for all other header designs
		/////////////////////////////////////////////
		$('#menu-icon').themifySideMenu({
			close: '#menu-icon-close'
		});
	}

	/////////////////////////////////////////////
	// Add class "first" to first elements
	/////////////////////////////////////////////
	$('.highlight-post:odd').addClass('odd');

	/////////////////////////////////////////////
	// Lightbox / Fullscreen initialization
	/////////////////////////////////////////////
	if(typeof ThemifyGallery !== 'undefined') {
		ThemifyGallery.init({'context': $(themifyScript.lightboxContext)});
	}

	// NiceScroll Initialized Default
	var viewport = $(window).width();
	if (viewport > 1000) {
		jQuery(".header-horizontal .header-widget, .header-top-bar .header-widget, .boxed-compact .header-widget").niceScroll();
	}
	
	var $headerWidgets = $('.header-horizontal, .header-top-bar, .boxed-compact').find('.header-widget');
	if ( $headerWidgets.length > 0 ) {
		// Header Horizontal, Header Topbar, Boxed Compact Add pull down wrapper
		$( '.header-horizontal #header, .header-top-bar #header, .boxed-compact #header' ).append( $( '<a href="#" class="pull-down">' ) );
		
		// Pull Down onclick Header Horizontal, Header Topbar, Boxed Compact Only
		$('.pull-down').on('click', function(e){
			$headerWidgets.getNiceScroll().resize();
			$('#header').toggleClass('pull-down-close'); 
			$headerWidgets.slideToggle( 'fast', function() {
				$('#pagewrap').css('paddingTop', $('#headerwrap').outerHeight());
			});
			e.preventDefault();
		});
	}
	
	// Reset NiceScroll Resize
	$(window).resize(function(){
		var viewport = $(window).width();
		if (viewport < 1000) {
			jQuery(".header-horizontal .header-widget, .header-top-bar .header-widget, .boxed-compact .header-widget").getNiceScroll().remove();
			jQuery(".header-horizontal .header-widget, .header-top-bar .header-widget, .boxed-compact .header-widget").attr("style","");
		}
	});

	/////////////////////////////////////////////
	// Make overlay clickable
	/////////////////////////////////////////////
	var $loopsWrapper = $('#loops-wrapper');
	if ( $loopsWrapper.hasClass( 'overlay' ) || $loopsWrapper.hasClass( 'polaroid' ) ) {
		$( 'body' ).on( 'click', '.loops-wrapper.grid4 .post-image + .post-content, .loops-wrapper.grid3 .post-image + .post-content, .loops-wrapper.grid2 .post-image + .post-content', function(){
			var $link = $( this ).find( '.post-title a' );
			if( ! $link.hasClass( 'lightbox' ) ) {
				window.location = $link.attr( 'href' );
			}
		});
	}

	/////////////////////////////////////////////
	// Carousel initialization
	/////////////////////////////////////////////
	if( typeof $.fn.carouFredSel !== 'undefined' ) {
		if ( $('.loops-wrapper.slider').length > 0 ) {
			var elID = 0;
			$('.loops-wrapper.slider').each(function(){
				elID++;
				var $self = $(this);
				
				if ( 'undefined' === typeof $self.attr( 'id' ) ) {
					// If this doesn't have an id, set dummy id
					$self.attr( 'id', 'loops-wrapper-' + elID );
				}
				var dataID = $self.attr( 'id' );

				$self.addClass( 'slideshow-wrap' );

				if ( $self.find( '.slideshow' ).length === 0 ) {
					$self.wrapInner( '<div class="slideshow" data-id="' + dataID + '" data-autoplay="off" data-speed="1000" data-effect="scroll" data-visible="3" />' );
				} else {
					$self.find( '.slideshow' ).attr( 'data-id', dataID );
				}
			});
		}
		ThemifySlider.createCarousel( $( '.slideshow' ) );
	}

});

// WINDOW LOAD
$(window).load(function() {

	var $body = $('body');

	///////////////////////////////////////////
	// Initialize infinite scroll
	///////////////////////////////////////////
	if ( $body.hasClass( 'woocommerce' ) && $body.hasClass( 'archive' ) ) {
		doInfinite( $( 'ul.products' ), '.product' );
	} else {
		doInfinite( $( '#loops-wrapper' ), '.post' );
	}

	///////////////////////////////////////////
	// Header Video
	///////////////////////////////////////////
	if ( ! is_touch_device() ) {
		if ( typeof $.BigVideo !== 'undefined' ) {
			var $videos = $('[data-fullwidthvideo]').not('.themify_builder_row'),
				fwvideos = [];
			$.each($videos, function (i, elm) {
				fwvideos[i] = new $.BigVideo({
					useFlashForFirefox: true,
					container: $(elm),
					id: i
				});
				fwvideos[i].init();
				fwvideos[i].show($(elm).data('fullwidthvideo'), {
					doLoop : true
				});
			});
		}
	}

	/////////////////////////////////////////////
	// Entry Filter Layout
	/////////////////////////////////////////////
	//$body.imagesLoaded(function(){
		//$(window).resize();
		//LayoutAndFilter.reLayout();
	//});

});
	
})(jQuery);