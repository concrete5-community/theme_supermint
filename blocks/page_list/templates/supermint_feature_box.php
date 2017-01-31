<?php
defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
$pageTheme = \Concrete\Package\ThemeSupermint\Src\Helper\ThemeObject::get($c);
extract ($pageTheme->getPageListVariables($b,$controller,$pages));
if (!$c->isEditMode()) :
  echo $wrapperOpenTag;
  foreach ($pages as $key => $page): extract($page->mclDetails);
  	echo $itemOpenTag;?>
    <table class="feature-box">
			<tr>
				<td class="i-icon">
					<?php echo $icon?>
				</td>
				<td <?php if (!$useButtonForLink) : ?>colspan="2"<?php endif ?>>
					<?php if ($title) : ?><h3><?php echo $title?></h3><?php endif ?>
					<?php if ($includeDescription) : ?><p><?php echo h($paragraph) ?></p><?php endif ?>
				</td>
				<?php if ($useButtonForLink) : ?>
				<td style="text-align:right">
					<a href="<?php echo $url ?>" class="button button-flat-primary" target="<?php echo $target ?>"><?php echo $o->feature_link_text ?></a>
					<?php echo $popup ?>
				</td>
				<?php endif ?>
			</tr>
      </table>
		<?php echo $itemCloseTag ?>
	<?php  endforeach ?>
	<?php echo $wrapperCloseTag ?>
	<?php Loader::PackageElement("page_list/utils", 'theme_supermint', array('b'=>$b,'controller' => $controller,'pages'=>$pages,'pagination'=>$pagination))?>

<?php  endif ?>
