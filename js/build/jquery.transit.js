/*
.-. .-. .-. . . .-. .-. .-.     . .-.
 |  |(  |-| |\| `-.  |   |      | `-.
 '  ' ' ` ' ' ` `-' `-'  '  . `-' `-'
 Copyright 2015 My Concrete Lab
 Version 0.1
*/

// this is only for IE8
if (!Object.create) {
    Object.create = function(proto, props) {
        if (typeof props !== "undefined") {
            throw "The multiple-argument version of Object.create is not provided by this browser and cannot be shimmed.";
        }
        function ctor() { }
        ctor.prototype = proto;
        return new ctor();
    };
}

var Transit = {
	options: {
	navSelector: false,
	dots : true,
	dotsSelector : '.dots'
	},

	init: function(options, elem) {
		// Save the element reference, both as a jQuery
		// reference and a normal reference

		this.elem  = elem;
		this.$elem = $(elem);

		// Mix in the passed in options with the default options
		this.options = $.extend({},this.options,options);
		this.options = $.extend({},this.options,this.getDataOptions());

		this.itemsWrapper = this.$elem.find( 'ul.itemwrap' );
		this.items = this.itemsWrapper.children();
		this.currentSlide = 0;
		this.itemsCount = this.items.length;
		this.nav = this.options.navSelector ? $(this.options.navSelector) : this.$elem.find( 'nav' );
		this.navNext = this.nav.find( '.next' );
		this.navPrev = this.nav.find( '.prev' );
		this.dots = this.options.dots ? this.getDots() : false;
		this.isAnimating = false;
		this.cntAnims = 0;
		this.newClasses = '';
		this.oldClasses = '';

		// Events

		//if (this.options.dots && this.dots.size()) this.initDotsEvent();
		this.navNext.on( 'click', $.proxy(this.navigate,this, 'next'));
		this.navPrev.on( 'click', $.proxy(this.navigate,this, 'prev'));

		// Check Support for old browsers
		this.support = { animations : Modernizr.csstransitions };
		// console.log(Modernizr);
		this.animEndEventNames = {
			'WebkitAnimation' : 'webkitAnimationEnd',
			'OAnimation' : 'oAnimationEnd',
			'msAnimation' : 'MSAnimationEnd',
			'animation' : 'animationend'
		};
		// animation end event name
		this.animEndEventName = this.animEndEventNames[ Modernizr.prefixed( 'animation' ) ];
		// Build the dom initial structure
		this._build();

		// return this so we can chain/use the bridge with less codthis.
		return this;
	},

	_build: function(){
		this.showNav();
		this.setSliderHeight($(this.items[ this.currentSlide ]));
    $(window).on('resize',$.proxy(this.setSliderHeight,this,$(this.items[ this.currentSlide ])));
	},
	getDots : function () {
		if (this.options.dotsSelector)
			return $(this.options.dotsSelector, this.$elem).children();
	},
	initDotsEvent : function () {
		// TODO
	},
	getDataOptions : function () {
		var a = {};
		[].forEach.call(this.elem.attributes, function(attr) {
		    if (/^data-/.test(attr.name)) {
		        var camelCaseName = attr.name.substr(5).replace(/-(.)/g, function ($0, $1) {
		            return $1.toUpperCase();
		        });
		        a[camelCaseName] = attr.value;
		    }
		});
		return a;
	},

	hideNav : function () {
		this.nav.hide();
	},

	showNav : function () {
		this.nav.show();
	},
	setSliderHeight : function (elem) {
		this.itemsWrapper.add(elem).height(elem.find('img').height());
	},
	navigate : function ( dir,e ) {
		e.preventDefault();

		if( this.isAnimating ) return false;
		this.isAnimating = true;

		this.currentSlideItem = $(this.items[ this.currentSlide ]);

		if( dir === 'next' ) {
			this.currentSlide = this.currentSlide < this.itemsCount - 1 ? this.currentSlide + 1 : 0;
		}
		else if( dir === 'prev' ) {
			this.currentSlide = this.currentSlide > 0 ? this.currentSlide - 1 : this.itemsCount - 1;
		}
		else if (dir === parseInt(dir, 10)) {
			this.currentSlide = dir;
		}



		this.nextItem = $(this.items[ this.currentSlide ]);

		this.setSliderHeight(this.nextItem);

		if( this.support.animations ) {
			this.currentSlideItem.on( this.animEndEventName, $.proxy(this.onEndAnimationCurrentItem, this ,this.currentSlideItem, dir));
			this.nextItem.on( this.animEndEventName, $.proxy(this.onEndAnimationNextItem, this ,this.nextItem, dir));
		}
		else {
			// A aeliorer pour ie8
			//this.onEndAnimationCurrentItem();
			//this.onEndAnimationNextItem();
		}

		this.currentSlideItem.addClass( dir === 'next' ? 'navOutNext' : 'navOutPrev' );
		this.nextItem.addClass(  dir === 'next' ? 'navInNext' : 'navInPrev' );
	},
	onEndAnimationCurrentItem : function(el, dir) {
		el.off( this.animEndEventName ).removeClass( 'current' ).removeClass( dir === 'next' ? 'navOutNext' : 'navOutPrev' );
		++this.cntAnims;
		if( this.cntAnims === 2 ) {
			this.isAnimating = false;
			this.cntAnims = 0;
		}
	},

	onEndAnimationNextItem : function(el, dir) {
		el.off( this.animEndEventName).addClass( 'current' ).removeClass( dir === 'next' ? 'navInNext' : 'navInPrev' );
		++this.cntAnims;
		if( this.cntAnims === 2 ) {
			this.isAnimating = false;
			this.cntAnims = 0;
		}
	}

};

// Make sure Object.create is available in the browser (for our prototypal inheritance)
// Courtesy of Papa Crockford
// Note this is not entirely equal to native Object.create, but compatible with our use-case
// if (typeof Object.create !== 'function') {
//     Object.create : function (o) {
//         function F() {} // optionally move this outside the declaration and into a closure if you need more speed.
//         F.prototype = o;
//         return new F();
//     };
// }

$(document).ready(function(){
  // Start a plugin

  $.fn.transit = function(options) {
    // Don't act on absent elements -via Paul Irish's advice
    if ( this.length && Modernizr.csstransitions) {
      return this.each(function(){
        // Create a new transit object via the Prototypal Object.create
        var myTransit = Object.create(Transit);


        // Run the initialization function of the transit
        myTransit.init(options, this); // `this` refers to the element

        // Save the instance of the transit object in the element's data store
        $.data(this, 'transit', myTransit);
      });
    }
  };
  if ($('#ccm-dashboard-page').size() || $('.no-script').size() ) return;

  $('#container').imagesLoaded( function() {
    $(".transit").transit();
  });

});



function l(e) {
	console.log(e)
}
