<?php 
namespace Concrete\Package\ThemeSupermint\Src\Editor;
use Loader;
use User;
use URL;
use Config;

class CopyrightSnippet extends \Concrete\Core\Editor\Snippet {
	public function replace() {
		return '<small class="light">&copy;&nbsp;' . date('Y') . '&nbsp;<a href="' . DIR_REL .'/">' . Config::get('concrete.site') . '</a>&nbsp;</small>';
	}
}
