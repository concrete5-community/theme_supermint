var docWidth = document.documentElement.offsetWidth;
var mmenu = false;

// Afficher les element avec la classe .detect
detectOnView();

$(document).ready(function(){

	isDashboard = $('#ccm-dashboard-page').size();
	noScript = $('.no-script').size();
	if (isDashboard || noScript ) return;

	if (typeof(navigationOptions) == "object")
		$('.nav_tabs').boxNav('.submenu_panes',navigationOptions);

// Le breadcrumb
	$(".rcrumbs").rcrumbs();

// les sliders
	 $('.slick-wrapper').each(function(){
	 	var e = $(this);
	 	var n = '<div class="slick-arrows"></div>';

	 	var settings = e.data('slick');
		var options = {
		 	nextArrow:'<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
		 	prevArrow:'<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
            customPaging: function(slider, i) {
                return '<a href="" data-role="none">' + (i + 1) + '</a>';
            },
			  responsive: [
			    // {
			    //   breakpoint: 1024,
			    //   settings: {
			    //     slidesToShow: 3,
			    //     slidesToScroll: 3,
			    //     infinite: true,
			    //     dots: true
			    //   }
			    // },
			    {
			      breakpoint: 600,
			      settings: {
			        slidesToShow: settings.slidesToShow > 2 || settings.slidesToShow > 1 ? 2 : 1 ,
			        slidesToScroll: 2
			      }
			    },
			    {
			      breakpoint: 480,
			      settings: {
			        slidesToShow: 1,
			        slidesToScroll: 1
			      }
			    }
			  ]

		 };
		 e.slick($.extend(options,settings));
	 });

// Accordions
	initializeAccordions();

// Tabs
	initializeTabs();

// AUto hidding responsive nav bar
	$('.small-display-nav-bar-inner, .large-top-nav, .small-display-nav-bar .regular-top-nav').autoHidingNavbar();

// Mmenu
	if($("#mmenu").size()) {
		$("#mmenu").mmenu(mmenuSettings,  {
		    // configuration
		    offCanvas: {
		      pageSelector:'.ccm-page'
		      // menuWrapperSelector:'.small-display-nav-bar'
		    }
		  });
		mmenu = $("#mmenu").data( "mmenu" );
		mmenu.bind( "opened", function() {$('#hamburger-icon').addClass('active')});
		mmenu.bind( "closing", function() {$('#hamburger-icon').removeClass('active')});
		$("#mmenu .mm-search input").keyup(function(e){
		    if(e.keyCode == 13){
		        window.location.href = SEARCH_URL + '?query=' + $(this).val();
		    }
		});
	}

// Mobile behavior on lateral navigation
	intitializeLateralMobile();

// Happier text
	var nodes = $('.harmonize-width-heading li > a');
	if (nodes.size()) nodes.harmonizeText().delay(3000).css('opacity',1);


// Magnific popup
	$('.magnific-wrapper').each(function(){
		var t = $(this);
		var child = t.data('delegate') ? t.data('delegate') : 'a';
		var contentType = t.data('type') ? t.data('type') : 'image';
		t.magnificPopup({
	  		delegate: child, // child items selector, by clicking on it popup will open
	  		type: contentType,
	  		mainClass: 'mfp-effect',
	  		removalDelay: 500,
			  gallery:{
			    enabled:true
			  }
		})
	});

	$(".open-popup-link").magnificPopup({
		type:'inline',
		midClick: true, // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
	  		mainClass: 'mfp-effect',
	  		removalDelay: 500
	});

	$('.page-list-img-box-hover .inner').hover(function(){
		$(this).addClass('area-primary');
	}, function(){
		$(this).removeClass('area-primary');
	})


	 // Fixer le probleme des video sous le menu
	 if (true) { // FIX_IFRAME_ZINDEX
	    $('iframe').each(function(){
	          var url = $(this).attr("src");
	          var char = "?";
	          if (typeof url === 'string') {
		          if(url.indexOf("?") != -1){
		                  var char = "&";
		           }
		          $(this).attr("src",url+char+"wmode=transparent");
		      }
	    });
	}
});


window.onload = function() {$('body').addClass('loaded')};

// -- Media Queries -- \\

enquire.register("screen and (max-width: 979px)", {

    match : function() {
			$('.top-nav-lateral').addClass('masked');
			// On desactive les dropdown
			$('.large-top-nav li.has-submenu').removeClass('mgm-drop');
		},
    unmatch : function() {
			$('.top-nav-lateral').removeClass('masked');
			$('.large-top-nav li.has-submenu').addClass('mgm-drop');
		}

});

// -- Lateral responsive behavior -- \\
function intitializeLateralMobile () {
	$('.top-nav-lateral .mobile-handle').on('click',function(e){
		$(this).parent().toggleClass('masked');
	})
}


function is_int(value){
  if((parseFloat(value) == parseInt(value)) && !isNaN(value)){
      return true;
  } else {
      return false;
  }
}

function initializeAccordions () {
    $('.sm-accordion').each(function(){
        var titles = $(this).find('.title');

        titles.not('.active').each(function(){$(this).next('.content').hide()});

        titles.click(function(e){
            e.preventDefault();
            var title = $(this);
            var active = title.is('.active') ? true : false;

            var accordion = title.parent().parent();
            accordion.find('.title.active').removeClass('active');
            accordion.find('.content.active').slideUp().removeClass('active');

            if (active) return;

            title.addClass('active');
            title.next(".content").slideDown().addClass('active');
        });
    });
}

function initializeTabs () {
    $(".tabs-menu a").click(function(event) {
        event.preventDefault();
        $(this).parent().addClass("current");
        $(this).parent().siblings().removeClass("current");
        var tab = $(this).attr("href");
        $(".tab-content", $(this).parent().parent().parent() ).not(tab).css("display", "none");
        $(tab).fadeIn();
    });
}

// -- Ajoute la classe 'view' sur les element '.detect' une fois qu'il arrive dans le viewport -- \\

function detectOnView () {
	var wow = new WOW(
	  {
	    boxClass:     'wow',      // animated element css class (default is wow)
	    animateClass: 'animated', // animation css class (default is animated)
	    offset:       0,          // distance to the element when triggering the animation (default is 0)
	    mobile:       false,       // trigger animations on mobile devices (default is true)
	    live:         true,       // act on asynchronously loaded content (default is true)
	    callback:     function(box) {
	      // the callback is fired every time an animation is started
	      // the argument that is passed in is the DOM node being animated
	    }
	  }
	);
	wow.init();
}

// -- Responsive navigation -- \\

(function() {
    var container = $( 'div.ccm-page' ),
        triggerBttn = $('#hamburger-icon'),
        overlay = $( '.overlay' ),
        closeBttn = $( 'button.overlay-close' );
    function toggleOverlay() {

			// Mmenu mode
			// Si le mmenu a été inité, on aporte les changement sur lui
			if (typeof mmenu == 'object') {
				if($("#mmenu").is(".mm-opened")) {
					mmenu.close();
					// triggerBttn.removeClass('active');
				} else {
					mmenu.open();
					// triggerBttn.addClass('active');
				}

				// Full screen mode

			} else {
				if( overlay.is('.open' ) ) {
            overlay.removeClass('open' );
            container.removeClass('overlay-open' );
            triggerBttn.removeClass('active');
        }
        else {
            overlay.addClass('open' );
            container.addClass('overlay-open' );
            triggerBttn.addClass('active');
        }
			}
    }
    triggerBttn.on( 'click', toggleOverlay );
})();


/*
	By Osvaldas Valutis, www.osvaldas.info
	Available for use under the MIT License
*/
;(function( $, window, document, undefined )
{
	$.fn.doubleTapToGo = function( params )
	{
		if( !( 'ontouchstart' in window ) &&
			!navigator.msMaxTouchPoints &&
			!navigator.userAgent.toLowerCase().match( /windows phone os 7/i ) ) return false;

		this.each( function()
		{
			var curItem = false;

			$( this ).on( 'click', function( e )
			{
				var item = $( this );
				if( item[ 0 ] != curItem[ 0 ] )
				{
					e.preventDefault();
					curItem = item;
				}
			});

			$( document ).on( 'click touchstart MSPointerDown', function( e )
			{
				var resetItem = true,
					parents	  = $( e.target ).parents();

				for( var i = 0; i < parents.length; i++ )
					if( parents[ i ] == curItem[ 0 ] )
						resetItem = false;

				if( resetItem )
					curItem = false;
			});
		});
		return this;
	};
})( jQuery, window, document );

(function(){var e,t,n,r,i,s,o,u,a,f;if(!(window.console&&window.console.log)){return}s=function(){var e;e=[];o(arguments).forEach(function(t){if(typeof t==="string"){return e=e.concat(a(t))}else{return e.push(t)}});return f.apply(window,e)};f=function(){return console.log.apply(console,o(arguments))};o=function(e){return Array.prototype.slice.call(e)};e=[{regex:/\*([^\*)]+)\*/,replacer:function(e,t){return"%c"+t+"%c"},styles:function(){return["font-style: italic",""]}},{regex:/\_([^\_)]+)\_/,replacer:function(e,t){return"%c"+t+"%c"},styles:function(){return["font-weight: bold",""]}},{regex:/\`([^\`)]+)\`/,replacer:function(e,t){return"%c"+t+"%c"},styles:function(){return["background: rgb(255, 255, 219); padding: 1px 5px; border: 1px solid rgba(0, 0, 0, 0.1)",""]}},{regex:/\[c\=\"([^\")]+)\"\]([^\[)]+)\[c\]/,replacer:function(e,t,n){return"%c"+n+"%c"},styles:function(e){return[e[1],""]}}];n=function(t){var n;n=false;e.forEach(function(e){if(e.regex.test(t)){return n=true}});return n};t=function(t){var n;n=[];e.forEach(function(e){var r;r=t.match(e.regex);if(r){return n.push({format:e,match:r})}});return n.sort(function(e,t){return e.match.index-t.match.index})};a=function(e){var r,i,s;s=[];while(n(e)){i=t(e);r=i[0];e=e.replace(r.format.regex,r.format.replacer);s=s.concat(r.format.styles(r.match))}return[e].concat(s)};i=function(){return/Safari/.test(navigator.userAgent)&&/Apple Computer/.test(navigator.vendor)};r=function(){return/MSIE/.test(navigator.userAgent)};u=function(){var e;e=navigator.userAgent.match(/AppleWebKit\/(\d+)\.(\d+)(\.|\+|\s)/);if(!e){return false}return 537.38>=parseInt(e[1],10)+parseInt(e[2],10)/100};if(i()&&!u()||r()){window.log=f}else{window.log=s}window.log.l=f}).call(this)
