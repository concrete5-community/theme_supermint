<?php  
defined('C5_EXECUTE') or die("Access Denied.");

class TeamBlockController extends BlockController {
	
	protected $btName = 'Team';
	protected $btDescription = 'Add a person to create a team page';
	protected $btTable = 'btTeam';
	protected $btInterfaceWidth = "700";
	protected $btInterfaceHeight = "450";
	
	protected $btCacheBlockRecord = true;
	protected $btCacheBlockOutput = true;
	protected $btCacheBlockOutputOnPost = true;
	protected $btCacheBlockOutputForRegisteredUsers = true;
	protected $btCacheBlockOutputLifetime = 300;
	
	public function getSearchableContent() {
		$content = array();
		$content[] = $this->field_1_textbox_text;
		$content[] = $this->field_2_textbox_text;
		$content[] = $this->field_3_textbox_text;
		$content[] = $this->field_4_textbox_text;
		$content[] = $this->field_5_textbox_text;
		$content[] = $this->field_8_wysiwyg_content;
		return implode(' - ', $content);
	}

	public function view() {
		$this->set('field_6_image', $this->get_image_object($this->field_6_image_fID, 300, 300, true));
		$this->set('field_8_wysiwyg_content', $this->translateFrom($this->field_8_wysiwyg_content));
	}


	public function edit() {
		$this->set('field_6_image', (empty($this->field_6_image_fID) ? null : File::getByID($this->field_6_image_fID)));
		$this->set('field_8_wysiwyg_content', $this->translateFromEditMode($this->field_8_wysiwyg_content));
	}

	public function save($args) {
		$args['field_6_image_fID'] = empty($args['field_6_image_fID']) ? 0 : $args['field_6_image_fID'];
		$args['field_7_link_cID'] = empty($args['field_7_link_cID']) ? 0 : $args['field_7_link_cID'];
		$args['field_8_wysiwyg_content'] = $this->translateTo($args['field_8_wysiwyg_content']);
		parent::save($args);
	}

	//Helper function for image fields
	private function get_image_object($fID, $width = 0, $height = 0, $crop = false) {
		if (empty($fID)) {
			$image = null;
		} else if (empty($width) && empty($height)) {
			//Show image at full size (do not generate a thumbnail)
			$file = File::getByID($fID);
			$size = @getimagesize($file->getPath());
			$image = new stdClass;
			$image->src = $file->getRelativePath();
			$image->width = $size[0];
			$image->height = $size[1];
		} else {
			//Generate a thumbnail
			$width = empty($width) ? 9999 : $width;
			$height = empty($height) ? 9999 : $height;
			$file = File::getByID($fID);
			$ih = Loader::helper('image');
			$image = $ih->getThumbnail($file, $width, $height, $crop);
		}
	
		return $image;
	}
	
	//Helper function for external URLs
	public function valid_url($url) {
		if ((strpos($url, 'http') === 0) || (strpos($url, 'mailto') === 0)) {
			return $url;
		} else if (strpos($url, '@') !== false) {
			return 'mailto:' . $url;
		} else if (strpos($url, '/') === 0) {
			return View::url($url); //site path (not an external url)
		} else {
			return 'http://' . $url;
		}
	}
	
//WYSIWYG HELPER FUNCTIONS (COPIED FROM "CONTENT" BLOCK):
	function br2nl($str) {
		$str = str_replace("\r\n", "\n", $str);
		$str = str_replace("<br />\n", "\n", $str);
		return $str;
	}
	
	function translateFromEditMode($text) {
		// old stuff. Can remove in a later version.
		$text = str_replace('href="{[CCM:BASE_URL]}', 'href="' . BASE_URL . DIR_REL, $text);
		$text = str_replace('src="{[CCM:REL_DIR_FILES_UPLOADED]}', 'src="' . BASE_URL . REL_DIR_FILES_UPLOADED, $text);

		// we have the second one below with the backslash due to a screwup in the
		// 5.1 release. Can remove in a later version.

		$text = preg_replace(
			array(
				'/{\[CCM:BASE_URL\]}/i',
				'/{CCM:BASE_URL}/i'),
			array(
				BASE_URL . DIR_REL,
				BASE_URL . DIR_REL)
			, $text);
			
		// now we add in support for the links
		
		$text = preg_replace(
			'/{CCM:CID_([0-9]+)}/i',
			BASE_URL . DIR_REL . '/' . DISPATCHER_FILENAME . '?cID=\\1',
			$text);

		// now we add in support for the files
		
		$text = preg_replace_callback(
			'/{CCM:FID_([0-9]+)}/i',
			array('TeamBlockController', 'replaceFileIDInEditMode'),
			$text);
		

		return $text;
	}
	
	function translateFrom($text) {
		// old stuff. Can remove in a later version.
		$text = str_replace('href="{[CCM:BASE_URL]}', 'href="' . BASE_URL . DIR_REL, $text);
		$text = str_replace('src="{[CCM:REL_DIR_FILES_UPLOADED]}', 'src="' . BASE_URL . REL_DIR_FILES_UPLOADED, $text);

		// we have the second one below with the backslash due to a screwup in the
		// 5.1 release. Can remove in a later version.

		$text = preg_replace(
			array(
				'/{\[CCM:BASE_URL\]}/i',
				'/{CCM:BASE_URL}/i'),
			array(
				BASE_URL . DIR_REL,
				BASE_URL . DIR_REL)
			, $text);
			
		// now we add in support for the links
		
		$text = preg_replace_callback(
			'/{CCM:CID_([0-9]+)}/i',
			array('TeamBlockController', 'replaceCollectionID'),
			$text);

		$text = preg_replace_callback(
			'/<img [^>]*src\s*=\s*"{CCM:FID_([0-9]+)}"[^>]*>/i',
			array('TeamBlockController', 'replaceImageID'),
			$text);

		// now we add in support for the files that we view inline			
		$text = preg_replace_callback(
			'/{CCM:FID_([0-9]+)}/i',
			array('TeamBlockController', 'replaceFileID'),
			$text);

		// now files we download
		
		$text = preg_replace_callback(
			'/{CCM:FID_DL_([0-9]+)}/i',
			array('TeamBlockController', 'replaceDownloadFileID'),
			$text);
		
		return $text;
	}
	
	private function replaceFileID($match) {
		$fID = $match[1];
		if ($fID > 0) {
			$path = File::getRelativePathFromID($fID);
			return $path;
		}
	}
	
	private function replaceImageID($match) {
		$fID = $match[1];
		if ($fID > 0) {
			preg_match('/width\s*="([0-9]+)"/',$match[0],$matchWidth);
			preg_match('/height\s*="([0-9]+)"/',$match[0],$matchHeight);
			$file = File::getByID($fID);
			if (is_object($file) && (!$file->isError())) {
				$imgHelper = Loader::helper('image');
				$maxWidth = ($matchWidth[1]) ? $matchWidth[1] : $file->getAttribute('width');
				$maxHeight = ($matchHeight[1]) ? $matchHeight[1] : $file->getAttribute('height');
				if ($file->getAttribute('width') > $maxWidth || $file->getAttribute('height') > $maxHeight) {
					$thumb = $imgHelper->getThumbnail($file, $maxWidth, $maxHeight);
					return preg_replace('/{CCM:FID_([0-9]+)}/i', $thumb->src, $match[0]);
				}
			}
			return $match[0];
		}
	}

	private function replaceDownloadFileID($match) {
		$fID = $match[1];
		if ($fID > 0) {
			$c = Page::getCurrentPage();
			return View::url('/download_file', 'view', $fID, $c->getCollectionID());
		}
	}

	private function replaceFileIDInEditMode($match) {
		$fID = $match[1];
		return View::url('/download_file', 'view_inline', $fID);
	}
	
	private function replaceCollectionID($match) {
		$cID = $match[1];
		if ($cID > 0) {
			$c = Page::getByID($cID, 'APPROVED');
			return Loader::helper("navigation")->getLinkToCollection($c);
		}
	}
	
	function translateTo($text) {
		// keep links valid
		$url1 = str_replace('/', '\/', BASE_URL . DIR_REL . '/' . DISPATCHER_FILENAME);
		$url2 = str_replace('/', '\/', BASE_URL . DIR_REL);
		$url3 = View::url('/download_file', 'view_inline');
		$url3 = str_replace('/', '\/', $url3);
		$url3 = str_replace('-', '\-', $url3);
		$url4 = View::url('/download_file', 'view');
		$url4 = str_replace('/', '\/', $url4);
		$url4 = str_replace('-', '\-', $url4);
		$text = preg_replace(
			array(
				'/' . $url1 . '\?cID=([0-9]+)/i', 
				'/' . $url3 . '([0-9]+)\//i', 
				'/' . $url4 . '([0-9]+)\//i', 
				'/' . $url2 . '/i'),
			array(
				'{CCM:CID_\\1}',
				'{CCM:FID_\\1}',
				'{CCM:FID_DL_\\1}',
				'{CCM:BASE_URL}')
			, $text);
		return $text;
	}

}
