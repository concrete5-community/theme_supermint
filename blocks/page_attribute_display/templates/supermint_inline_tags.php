<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));
echo $controller->getOpenTag();
echo "<span class=\"ccm-block-page-attribute-display-title\">".$controller->getTitle()."</span>";
echo str_replace(array("\r", "\n"), '  |  ', $controller->getContent());
echo $controller->getCloseTag();
