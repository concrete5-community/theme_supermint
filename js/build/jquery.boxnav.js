

 (function($) {
	var defaults = {

		autoClose: true,
		slideSpeed : 300,
		openSpeed : 300,
		closeSpeed : 300,
		mouseLeaveActionDelay : 1000,
		panesSelector : '.nav-panes',
		globalWrapperSelector : '',
		activeClass :'active',
		mobileClass : 'mobile',
		slideMargin:0,
		takeCareOfColumns : true, // Permeet de gerrer les colonnes en CSS si false
		columnsNumber : 4,
		columnsMargin : 2, // Valeur en %
		mobileWidthDetectionThreshold : 767,
		closeButtonPageslide : '<a href="#" class="close">X</a>',
		mode : "regular", // ou 'mobile',
		eventName : 'mouseenter', // Ceci ne marche pas car en hover, on quitte d'office la barre demu pour aller en dessous...
		openOnLoad : true,
		doubleCLickAction : 'url' // 'url' pour aller sur le lien ou 'close' pour fermer le menu
	}

	$.fn.boxNav = function(panesWrapperSelector, options){
		if(this.length == 0 || !panesWrapperSelector) return this;

		// support mutltiple elements
		if(this.length > 1){
			this.each(function(){$(this).boxNav(panesWrapperSelector, options)});

			return this;
		}

		// create a namespace to be used throughout the plugin
		var nav = {};
		// creer les objets
		nav.panes = {};
		nav.active = {};
		nav.active.onload = {};
		nav.active.onload.pane = {};
		// une reference au premier niveau de navigation
		var el = this;

		var windowWidth = $(window).width();
		var windowHeight = $(window).height();

		var init = function(){
			// mélanger les options
			nav.settings = $.extend({}, defaults, options);
			// le wrapper de panneaux
			nav.panes.wrapper = $(panesWrapperSelector);
			// le div très large qui contient tous les panneaux
			nav.panes.slide = nav.panes.wrapper.children(nav.settings.panesSelector);
			// les panneaux séparéments
			nav.panes.el = nav.panes.slide.children();
			// Le bouton pour femrer le pageslide
			// A changer pour ne plus être dépendant du .empty_pane
			$(nav.settings.closeButtonPageslide).appendTo($(nav.panes.el).not('.empty_pane')).on('click',function(e){$.boxNav.close(); e.preventDefault()} );
			// Les element actuelemnt selectionnés.
			// A améliorer pour détecter ici qui est actif et a quel niveau
			nav.active.onload.li = el.children('li.' + nav.settings.activeClass);

			// !! nav.active.onload.level =
			// l'index du menu de premier niveau selectionne
			nav.active.onload.index = nav.active.onload.li.index(); // ?est ce que ça marche ?
			// le niveau de la page active , sur base 0
			nav.active.onload.level = nav.panes.slide.find('a.' + nav.settings.activeClass).size();
			// Le panneau correspondant au menu selectionné
			nav.active.onload.pane = nav.panes.slide.children().eq(nav.active.onload.index);
			// Si le panneau actif est vide
			nav.active.onload.pane.isEmpty = nav.active.onload.pane.children().size() ? false : true;
			// le supposé viewport
			nav.viewport = nav.panes.wrapper;// nav.panes.parent(); // Il faudra 'wrapper' les panes avant ?'
			// Sil emenu est ouvert
			nav.opened = false;
			// Pas d'animation en court
			nav.working = false;
			// Une reference modifiable au mode demandé
			nav.mode = nav.settings.mode;

			// Si on est sur une page sans sous menu, ... ? Ancienne fonction
			if ( nav.active.onload.pane.isEmpty  || nav.active.onload.index == 0 ) { // A tester
				nav.settings.autoClose = true;
			}

			// On regle la navigation active sur celle definie par le onload
			setActiveNav(nav.active.onload.li);

			// On determine si il y a lieu de switcher en mode 'mobile'
			toggleMobile ();
			// adapter les largeur de panneaux
			updatePanesWidth ();
			// crer la largeur des menus
			setColumnsWidth ();
			// placer les paneaux à leur bonne place, sans délais
			placePanes () ;
			// on verifie la hauteur, et on garde fermé si on est en mobile, si un data attribute est reglé ou si c'est demandé en settings
			el.updateViewportHeight( nav.mode == 'mobile' || nav.active.onload.pane.data('closed') == 'onload' || !nav.settings.openOnLoad);
			// definir les evenements
			initEvent ();

		}

		var show = function (el) {
			$(el).css({border:'2px solid red',
						'min-height' : "50px"
						});
		}

		var initEvent = function () {
			// On supprime tout evenement sur les a (quand on passe au mode mobile, on force le click)
			// On initie l'evenement demandé sur le premier niveau
			// On force le click pour les mobiles
			el.find('a').off().on(nav.mode == 'mobile' ? 'click' : nav.settings.eventName,onNavAction);
			// la gestion du window resize
			$(window).on('resize', resizeWindow);
			// On ajoute la fermeture automatique du menu uniquement si le menu entier est
			// wrappé dans un div
			if (nav.settings.globalWrapperSelector)
				$(nav.settings.globalWrapperSelector).on('mouseleave',onCursorLeaveNav);
		}

		var onNavAction = function (e) {
			// On retient l'actif actuel pour les comparaison
			var oldActiveIndex = nav.active.index;
			// On envoi le li qui vient d'être activé
			setActiveNav ($(e.currentTarget).parent('li'));

			// Si le panneau ne contient pas d'enfant On laisse le lien actif
			if (!nav.active.pane.children().size())	return true;

			if (nav.settings.doubleCLickAction == 'toggle') {
				// l'index demandé est comparé avec l'index actif
				// on ferme si il est ouvert, on ouvre si il est fermé.
				// Que si on est pas en mode mouseenter, sionon ça crée des comportement désagréables
			    if (nav.active.index == oldActiveIndex && nav.settings.eventName != 'mouseenter') el.toggleNav();
			    // On performe les actions necessaire pour le rendre visuelement actif
			    else makeActive ();
			}
			// le deuxieme click nous envoie vers l'url
			if (nav.settings.doubleCLickAction == 'url') {
				if (nav.active.index == oldActiveIndex && nav.settings.eventName != 'mouseenter') return true;
			    else makeActive ();
			}

			// On anule le comprtement normal du lien
			e.preventDefault();
		}

		/**
		 * Met a jour l'objet nav (menu + panneaux) grâce à un element li
		 *
		 * @param li (html element ou jQuery element)
		 *  - le li qui doit être activé
		 */
		var setActiveNav = function (li) {
			// l'element nav.li
			nav.active.li = $(li);
			// On met a jour l'index
			nav.active.index = nav.active.li.index();
			// On prend celui concerné par l'index
			nav.active.pane = nav.panes.el.eq(nav.active.index);
			// On lui donne un ID
			nav.active.pane.attr('id', 'pane_' + nav.active.index );
			// On defini si il est vide (utile pour régler la hauteur)
			nav.active.pane.isEmpty = nav.active.pane.children().size() ? false : true;
		}

		/**
		 * Fonction compilant les action necessaire pour rendre un menu actif.
		 *
		 * @param li (html element or jQuery element)
		 *  - le li qui doit être activé (optionel si déjà ajuster avant l'appel de cette fonction)
		 */
		var makeActive = function (li) {
			if (li) setActiveNav (li);
			toggleSelected ();
			slidePanes ();
				// on verifie la hauteur (avnt placé a la fin de slidePane)
			el.updateViewportHeight();
		}

		var isEmpty = function (el) {
			return el.children().size() ? true : false
		}

		/**
		 * fait glisser les pannaux à la place defini par la variable nav.active
		 *
		 * @param i (int)
		 *  - l'index de l'element menu selectionner (optionel et utilisé que pour les fonctions publiques)
		 */
		var slidePanes = function (i) {
			// l'index n'est pas en argument, on prend l'index actif de cet objet
			i = i ? i : nav.active.index;

			// Si on est en version mobile, on ouvre le page slide avec le menu dedans
			if(typeof($.pageslide) == 'function' && nav.mode == 'mobile') {

				return;
			}

			// On anime
			nav.panes.slide.stop(true).animate({
				left : - i * ( getViewportWidth() + nav.settings.slideMargin )
			},nav.settings.slideSpeed, function () {
				// Animation finie
			});

		}

		/**
		 * Place les pannaux à la bonen place (utilisé qu'une fois au chargement)
		 */
		 var placePanes = function () {
			// Si on doit le placer sans attendre
			// donc ds le futur, lors d'utilisation d'animation CSS, il faudra mettre le délai à 0
		    nav.panes.slide.css({
		    	left: - nav.active.onload.index * ( getViewportWidth() + nav.settings.slideMargin ) + 'px'
			});
		}

		/**
		 * Defini la largeur des colonnes
		 */
		var setColumnsWidth = function () {
			// Si l'utilisateur ne veut pas qu'on touche à ses colonnes
			if (!nav.settings.takeCareOfColumns) return;
			// Si le mode est 'mobile' la largeur sera tjrs de 100%
			if (nav.mode == 'mobile') {
				// la largeur des marges
				columnsMargin = 0;
				// la largeur des colonnes
				columnsWidth = 100;
			} else {
				// la largeur des marges
//				columnsMargin = 100 / ((nav.settings.columnsNumber - 1) * nav.settings.columnsMargin);
				columnsMargin = nav.settings.columnsMargin;
				// la largeur des colonnes
				columnsWidth = 100 / nav.settings.columnsNumber;
			}
			// On applique les CSS
			nav.panes.el.children('ul.columned').children('li').css({
				width : columnsWidth - columnsMargin + '%',
				'margin-right' : columnsMargin + '%'
			});
		}

		/**
		 * Quand le curseur quitte les pannaux
		 *
		 * @param e (evenement)
		 *  - l'objet evenement de jQuery
		 */
		var onCursorLeaveNav = function (e) {
			// Si le panneau est fermé ou le mode mobile, on ignore
			if(!nav.opened || nav.mode == 'mobile') return;
			setTimeout(
				function(){
					makeActive(nav.active.onload.li);
				}
				,nav.settings.mouseLeaveActionDelay
			);
		}

		/**
		 * Retourne la largeur du viewport des panneaux
		 */
		var getViewportWidth = function () {
			return nav.viewport.width();
		}

		/**
		 * Met à jour les classes css du li de premier niveau
		 *
		 * @param el (jQuery DOM element)
		 *  - un objet jQuery representant le li à activer
		 */
		var toggleSelected = function (li) {
			// Si pas d'argument, on prend l'element actif
			_li = li ? li : nav.active.li;
			// On recherche les element avec class active
			el.find('.' + nav.settings.activeClass).removeClass(nav.settings.activeClass);
			// On ajoute la class que sur le li

			_li.addClass(nav.settings.activeClass);
		}

		var updatePanesWidth = function () {

			//$('body').css('width', $('body').width() + 'px');
			// Les panneaux héritent de la largeur du viewport en mode normal et 100% en mode mobile
			var paneWidth = nav.mode == 'mobile' ? '100%' : getViewportWidth();
			nav.panes.el.css({
				width : paneWidth,
				'margin-right' : nav.settings.slideMargin
			});
		}

		/**
		 * La fonction apoellée lorsque la taille de la fenetre est modifiée
		 */
		var resizeWindow = function(e){
			// get the new window dimens (again, thank you IE)
			var windowWidthNew = $(window).width();
			var windowHeightNew = $(window).height();
			// make sure that it is a true window resize
			// *we must check this because our dinosaur friend IE fires a window resize event when certain DOM elements
			// are resized. Can you just die already?*
			if(windowWidth != windowWidthNew || windowHeight != windowHeightNew){
				// set the new window dimens
				windowWidth = windowWidthNew;
				windowHeight = windowHeightNew;
				// update all dynamic elements

				el.redrawNav(windowWidthNew,windowWidthNew);
			}
		}

		/**
		 * Opère des changement de classe si les dimmensions le demandent
		 */
		var toggleMobile = function(){
			// Si le viewport est plus petit que le seuil 'mobile' defini ds les options

			if (getViewportWidth() < nav.settings.mobileWidthDetectionThreshold) {
				// On ajoute la classe mobile aux tabs et au wrapper
				el.add(nav.panes.wrapper).addClass(nav.settings.mobileClass);
				// On force le mode en 'mobile'
				nav.mode = 'mobile';
			} else {
				// On retire la classe si elle existe ET si le mode demandé est 'regular' (sinon on laisse en mobile)
				if (el.is('.' + nav.settings.mobileClass) && nav.settings.mode != 'mobile') el.add(nav.panes.wrapper).removeClass(nav.settings.mobileClass);
				// On remeet le mode comme demandé dans les settings
				//if (nav.mode == 'mobile')
				nav.mode = nav.settings.mode;
			}
		}

		// ------------------------------- //
		// ----- Objet publique ------ //
		// ------------------------------- //

		$.boxNav = {};

		$.boxNav.close = function () {
			el.closeViewport();
			makeActive(nav.active.onload.li);
		}

		// ------------------------------- //
		// ----- Methodes publiques ------ //
		// ------------------------------- //


		el.goToPane = function (index) {
			// On prend le li concerné par l'index
			var li = el.children().eq(index);
			// Si l'element est valide, on performe.
			if (li.size()) makeActive(li);
		}

		/**
		 * Ferme le viewport si ouver et inversement
		 */
		 el.toggleNav = function () {
			if (nav.opened) {
				el.closeViewport(true);
			} else {
				el.updateViewportHeight();
			}
		 }


		/**
		 * Ferme le viewport
		 * @param forceClose (bool)
		 *  - Sert
		 */
		el.closeViewport = function (forceClose) {
			if (!nav.opened || nav.working) return;
			nav.working = true;

			// Deux action different si le mode est mobile ou pas
		 	if (nav.mode == 'mobile') {
		 		//nav.active.pane.find('a.close').remove();
		 		$.pageslide.close();
		 		nav.opened = false;
		 		nav.working = false;
		 	} else {
				nav.viewport.stop(true).animate({height:0},nav.settings.closeSpeed,function(){
					nav.working = false;
					nav.opened = false;
				});
			}
		}

		/**
		 * La methode publque de updateViewportHeight, plus lisible
		 */
		el.openViewport = function () {
			el.updateViewportHeight()
		}

		/**
		 * Met à jour la hauteur du viewport avec l'object nav.active
		 * @param forceClose (bool)
		 *  - Sert a garder la navigation ferlé au chargement, sur mobiles
		 */
		el.updateViewportHeight = function (forceClose) {
			if (nav.working) return;
			nav.working = true;

		 	if (nav.mode == 'mobile' && !forceClose) {
		 		// Si le pageslide est ouvert, on le ferme
		 		// ça arrive  quand cette fonction est appellé via le onmouseleave
		 		// Mais c'est pas viable car la souris DOIT quitter le #top pour aller sur le pageslide !!
		 		//if(nav.opened) {nav.working = false; el.closeViewport(); return}
				$.pageslide({ href: '#' + nav.active.pane.attr('id'), modal:true});
				nav.opened = true;
		 		nav.working = false;
		 	} else {
				// Si le panneaux est vide (ou ne contient que &nbsp;) on le regle à zéro d'office
				// Sinon, on calcule la hauteur, marge comprises
				var paneHeight = nav.active.pane.isEmpty || forceClose ? 0 : nav.active.pane.outerHeight(false)
				// On applique la valeur
				nav.viewport.stop(true).animate({height:paneHeight},nav.settings.openSpeed,function(){
					nav.working = false;
					// LA valeur du panneau ouvert dépend de la hauteur du penneau
					nav.opened = paneHeight ? true : false;
				});
			}
		}

		/**
		 * Met à jour tous les element dynamique de la navigation
		 */
		el.redrawNav = function(){
			// On determine si il y a lieu de switcher en mode 'mobile'
			toggleMobile ();
			// On regarde si il faut mettre des colonnes ou pas
			setColumnsWidth();
			// On adapte la largeur des pannaux
			updatePanesWidth();
			// On adapte le hauteur du panneaux actif
			// On le garde fermé ?
			el.updateViewportHeight(true);
			// on replace les panneaux à la bonne place
			slidePanes();
			// Si le pageslide est visible, on cache
			if($('#pageslide').is(':visible')) $.pageslide.close();
			// On redetermine les Event sur le menu
			initEvent();
		}

		init();

		return this;
	}



 })(jQuery);






























 (function() {
  var formats, getOrderedMatches, hasMatches, isIE, isSafari, log, makeArray, safariSupport, stringToArgs, _log;
  if (!(window.console && window.console.log)) {
    return;
  }
  log = function() {
    var args;
    args = [];
    makeArray(arguments).forEach(function(arg) {
      if (typeof arg === 'string') {
        return args = args.concat(stringToArgs(arg));
      } else {
        return args.push(arg);
      }
    });
    return _log.apply(window, args);
  };
  _log = function() {
    return console.log.apply(console, makeArray(arguments));
  };
  makeArray = function(arrayLikeThing) {
    return Array.prototype.slice.call(arrayLikeThing);
  };
  formats = [
    {
      regex: /\*([^\*)]+)\*/,
      replacer: function(m, p1) {
        return "%c" + p1 + "%c";
      },
      styles: function() {
        return ['font-style: italic', ''];
      }
    }, {
      regex: /\_([^\_)]+)\_/,
      replacer: function(m, p1) {
        return "%c" + p1 + "%c";
      },
      styles: function() {
        return ['font-weight: bold', ''];
      }
    }, {
      regex: /\`([^\`)]+)\`/,
      replacer: function(m, p1) {
        return "%c" + p1 + "%c";
      },
      styles: function() {
        return ['background: rgb(255, 255, 219); padding: 1px 5px; border: 1px solid rgba(0, 0, 0, 0.1)', ''];
      }
    }, {
      regex: /\[c\=\"([^\")]+)\"\]([^\[)]+)\[c\]/,
      replacer: function(m, p1, p2) {
        return "%c" + p2 + "%c";
      },
      styles: function(match) {
        return [match[1], ''];
      }
    }
  ];
  hasMatches = function(str) {
    var _hasMatches;
    _hasMatches = false;
    formats.forEach(function(format) {
      if (format.regex.test(str)) {
        return _hasMatches = true;
      }
    });
    return _hasMatches;
  };
  getOrderedMatches = function(str) {
    var matches;
    matches = [];
    formats.forEach(function(format) {
      var match;
      match = str.match(format.regex);
      if (match) {
        return matches.push({
          format: format,
          match: match
        });
      }
    });
    return matches.sort(function(a, b) {
      return a.match.index - b.match.index;
    });
  };
  stringToArgs = function(str) {
    var firstMatch, matches, styles;
    styles = [];
    while (hasMatches(str)) {
      matches = getOrderedMatches(str);
      firstMatch = matches[0];
      str = str.replace(firstMatch.format.regex, firstMatch.format.replacer);
      styles = styles.concat(firstMatch.format.styles(firstMatch.match));
    }
    return [str].concat(styles);
  };
  isSafari = function() {
    return /Safari/.test(navigator.userAgent) && /Apple Computer/.test(navigator.vendor);
  };
  isIE = function() {
    return /MSIE/.test(navigator.userAgent);
  };
  safariSupport = function() {
    var m;
    m = navigator.userAgent.match(/AppleWebKit\/(\d+)\.(\d+)(\.|\+|\s)/);
    if (!m) {
      return false;
    }
    return 537.38 >= parseInt(m[1], 10) + (parseInt(m[2], 10) / 100);
  };
  if ((isSafari() && !safariSupport()) || isIE()) {
    window.log = _log;
  } else {
    window.log = log;
  }
  window.log.l = _log;
}).call(this);
