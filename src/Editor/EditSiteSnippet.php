<?php 
namespace Concrete\Package\ThemeSupermint\Src\Editor;
use Loader;
use User;
use URL;
use Config;

class EditSiteSnippet extends \Concrete\Core\Editor\Snippet {

	public function replace() {

		$u = new User();
		if ($u->isRegistered()) { 
			
			$html = '';

			if (Config::get("ENABLE_USER_PROFILES")) {
				$userName = '<a href="' . URL::to('/profile') . '">' . $u->getUserName() . '</a>';
			} else {
				$userName = $u->getUserName();
			}
			
			$html = '<small class="sign-in light">&nbsp' . t('Currently logged in as <b>%s</b>.', $userName) . '&nbsp;<a href="' . URL::to('/login', 'logout') . '">'.  t('Sign Out') . '</a></small>';
		} else { 
			$html = '<small class="sign-in light"><a href="' . URL::to('/login') . '">&nbsp;' . t('Sign In to Edit this Site') . '</a></small>';
		}

		return $html;
	}
}
