<?php  defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
$pageTheme = \Concrete\Package\ThemeSupermint\Src\Helper\ThemeObject::get($c);
?>
    <?php  if(count($rows) > 0) { ?>
     <div class="sm-accordion">
          <dl>
        <?php  foreach($rows as $row) : ?>
         <dt class="title <?php echo $key === 0 ? 'active' : '' ?>">
                <a href=""><i class="fa fa-chevron-circle-right"></i>  <?php  echo $row['title'] ?></a>
            </dt>
            <dd class="content <?php echo $key === 0 ? 'active' : '' ?>" <?php echo $key === 0 ? '' : 'style="display:none"' ?>>
                <div class='content-inner'><?php  echo $pageTheme->nl2p($row['description']) ?></div>
            </dd>
        <?php  endforeach ?>
        </dl>
    <?php  } else { ?>
    <div class="ccm-faq-block-links">
        <p><?php  echo t('No Faq Entries Entered.'); ?></p>
    </div>
    <?php  } ?>
</div>
