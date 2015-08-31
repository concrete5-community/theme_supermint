<?php  
namespace Concrete\Package\ThemeSupermint\Src\Models;

defined('C5_EXECUTE') or die(_("Access Denied."));

use \Concrete\Core\Legacy\Model;
use Loader;
use Page;

class SupermintFont extends Model {

	// Ce helper est censé servir coté page, 
	// Il faudrait lui envoyer un pID si on veut l'utiliser coté dashboard

	var $weight = array('regular');
	var $weightconversion = array('regular' => 'normal');
	var $style = array('italic');
	var $pregstyle = '/(?:italic|regular|\d+)/';
	var $css = array();

	function __construct ($tag) {

		$this->tag = $tag;
		// On ajouytre a cet objet le nom des ses valeur en DB
		$this->setInputName();
		// On lui ajoute ses valeurs prises de la DB
		$this->setFontInfo();

	}
	function setInputName () {
		$this->fontName = $this->getFontName();
		$this->subsetName = $this->getSubsetName();
		$this->variantName = $this->getVariantName();
		$this->defaultVariantName = $this->getDefaultVariantName();
		$this->sizeName = $this->getSizeName();
		$this->uppercaseName = $this->getUppercaseName();
	}

	function setFontInfo () {

		if ($_GET['pID']) $o = ThemeSupermintOptions::get_options_from_preset_ID($_GET['pID']);
		else $o = \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions::get();
		// Le nom avec le "+"
		$this->font = $o->{$this->fontName};
		// Le nom sans le "+"
		$this->cleanfont =str_replace('+', ' ', $this->font);
		// Le tableau des subset choisis
		$this->subset = explode(',' ,  $o->{$this->subsetName});
		// Le tableau des variants choisis
		$this->variant = explode(',', $o->{$this->variantName});
		// Le varient utilisé par defaut
		$this->defaultvariant = $o->{$this->defaultVariantName};
		// SI cette police doit s'afficher en uppercase
		$this->upp = $o->{$this->uppercaseName .'_fonts'}; // !!!! A verifier
		// la taille minimale acceptées des fontes
		$size_minimum = $o->size_minimum;
		// Sa taille en regular
		$this->normalsize = $o->{$this->sizeName};
		// Sa taile en Wide
		$this->widesize = $this->calculateSizeRatio($this->normalsize, $o->wide_ratio, $size_minimum, '*');
		// Sa taile en 724
		$this->tabletsize = $this->calculateSizeRatio($this->normalsize,  $o->w724_ratio, $size_minimum, '/'); 
		// Sa taille en width 100%
		$this->fullsize = $this->calculateSizeRatio($this->normalsize,  $o->full_ratio, $size_minimum, '/'); 
		
	}

	function getFontName () {
		return $this->tag . '_font';
	}
	function getSubsetName () {
		return  $this->tag . '_subset';
	}
	function getVariantName () {
		return $this->tag . '_variants';
	}
	function getDefaultVariantName () {
		return $this->getVariantName() . '_selected';
	}	
	function getSizeName () {
		return $this->tag . '_size';
	}
	function getUppercaseName () {
		return $this->tag . '_upp';
	}

	function calculateSizeRatio ($normal,$ratio,$min,$op) {
		if(!$ratio) return 0; // A ameliorer
		switch ($op) {
			case '/': $s = $normal / $ratio; break;
			case '*': $s = $normal * $ratio; break;			
			default: $s = $normal * $ratio;	break;
		}
		return intval($s < $min ? $min : $s);
	}

	function getFamily () {
		return "font-family:'$this->cleanfont', sans;\n";
	}
	function getTransform () {
		return "text-transform:" . ($this->upp ? 'uppercase' : 'none') . " !important;\n";
	}

	function getStyleCss () {
		if ($this->font) :
			// Le nom de la famille
			$str = $this->getFamily();
			// Le mode uppercase ou non
			$str .= "\t" . $this->getTransform();
			
			
			if ($this->defaultvariant) :
				preg_match($this->pregstyle, $this->defaultvariant, $matches, PREG_OFFSET_CAPTURE);
				// var_dump($matches);
				$this->setFontStyle($matches);
			else :
				// On va tourner dans les différentes variantes selectionné
				// Normalement il y ne a qu'une !
				foreach ($this->variant as $variant) :
					// On decortique si jamais il y a 300italic ou juste italic ou juste regular ou 400..
					preg_match_all($this->pregstyle, $variant, $matches, PREG_OFFSET_CAPTURE);
					// On trourne dans les decortiqué genre [0] italic, [1] 300 ..

					$this->setFontStyle($matches[0]);
					
				endforeach;

			endif;

			// Maintenant on va composer 
			foreach ($this->css as $cssName => $valueArray) :
				foreach ($valueArray as $value => $empty) :
					$str .= "\tfont-$cssName : $value;\n";
				endforeach;
			endforeach;
	
			return $str;
		endif;
	}

	function setFontStyle ($matches) {
		foreach ($matches as $match) :
			// on regarde a qui appartient ce style  Si c'est 300 ou regular
			if (in_array($match[0], $this->weight)) $this->css['weight'][$this->weightconversion[$match[0]]] = '';
			if (is_numeric($match[0])) $this->css['weight'][$match[0]] = '';
			if (in_array($match[0], $this->style)) $this->css['style'][$match[0]] = '';
		endforeach;		
	}



}

