<?php  defined('C5_EXECUTE') or die("Access Denied.");
$dh = Core::make('helper/date'); /* @var $dh \Concrete\Core\Localization\Service\Date */
$page = Page::getCurrentPage();
$date = Core::make('helper/date')->formatDate($page->getCollectionDatePublic(), true);
$user = UserInfo::getByID($page->getCollectionUserID());
?>
<p class="page-meta">
	<small>
		<i class="fa fa-calendar"></i>&nbsp;
	    <span class="page-date">
	    <?php print $date; ?>
	    </span>

	    <?php if (is_object($user)): ?>
	    <i class="fa fa-user"></i>&nbsp;
	    <span class="page-author">
	    <?php print $user->getUserDisplayName(); ?>
	    </span>
	    <?php endif; ?>
	</small>
</p>