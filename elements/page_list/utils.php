<?php defined('C5_EXECUTE') or die('Access Denied.');
$rssUrl = $controller->showRss ? $controller->getRssUrl($b) : '';
if (count($pages) == 0): ?>
    <div class="ccm-block-page-list-no-pages"><?php  echo $controller->noResultsMessage?></div>
<?php  endif;?>

<?php  if ($controller->showRss): ?>
<div class="ccm-block-page-list-rss-icon">
  <a href="<?php  echo $rssUrl ?>" target="_blank"><img src="<?php  echo $controller->rssIconSrc ?>" width="14" height="14" alt="<?php  echo t('RSS Icon') ?>" title="<?php  echo t('RSS Feed') ?>" /></a>
</div>
<link href="<?php  echo BASE_URL.$rssUrl ?>" rel="alternate" type="application/rss+xml" title="<?php  echo $controller->rssTitle ?>" />
<?php  endif ?>
<?php  if ($pagination): ?>
    <?php  echo $pagination;?>
<?php  endif ?>
