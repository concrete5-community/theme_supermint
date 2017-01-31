<?php
defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
$pageTheme = \Concrete\Package\ThemeSupermint\Src\Helper\ThemeObject::get($c);
extract ($pageTheme->getPageListVariables($b,$controller,$pages));
if (!$c->isEditMode()) :
  echo $wrapperOpenTag;
  foreach ($pages as $key => $page): extract($page->mclDetails);
  	echo $itemOpenTag;?>
    <figure>
      <?php if ($imageTag) : echo $imageTag; else :?><div class="placeholder"></div><?php endif ?>
    	<div class="icons">
    		<a href="#"><i class="ion-ios-email-outline"></i></a>
    		<a href="#"><i class="ion-ios-telephone-outline"></i></a>
    	</div>
    	<figcaption>
    		<?php if ($includeName): ?><h4><?php echo $title ?></h4><?php endif ?>
          <?php if ($includeDate): ?>
            <div class="meta-text">
            	<small><i class="fa fa-calendar-o"></i> <?php echo $date?></small>
            	<?php if($o->carousel_meta) : ?><small> <i class="fa fa-user"></i> <?php echo $original_author ?></small><?php endif ?>
            </div>
          <?php endif; ?>
        <?php if (count($tagsArray)): ?><p class="tags"><?php echo implode(' | ',$tagsArray) ?></p><?php endif ?>
    		<?php if ($includeDescription): ?><p><?php  echo $description ?></p><?php endif ?>
        <?php if ($useButtonForLink): ?><a <?php echo $link ?> class="button-primary button-flat button-tiny"><?php echo $buttonLinkText?></a><?php endif ?>
    	</figcaption>
    </figure>
    <?php echo $popup ?>
  <?php echo $itemCloseTag ?>
<?php  endforeach ?>
<?php echo $wrapperCloseTag ?>
<?php Loader::PackageElement("page_list/utils", 'theme_supermint', array('b'=>$b,'controller' => $controller,'pages'=>$pages,'pagination'=>$pagination))?>

<?php  endif ?>
