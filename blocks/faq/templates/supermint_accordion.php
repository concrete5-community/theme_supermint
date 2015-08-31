<?php  defined('C5_EXECUTE') or die("Access Denied.");?>

    <?php  if(count($rows) > 0) { ?>
     <div class="sm-accordion">
          <dl>
        <?php  foreach($rows as $row) : ?>
         <dt class="title <?php echo $key === 0 ? 'active' : '' ?>">
                <a href=""><i class="fa fa-chevron-circle-right"></i>  <?php  echo $row['title'] ?></a>
            </dt>       
            <dd class="content <?php echo $key === 0 ? 'active' : '' ?>" <?php echo $key === 0 ? '' : 'style="display:none"' ?>>
                <div class='content-inner'><?php  echo nl2p($row['description']) ?></div>
            </dd> 
        <?php  endforeach ?>
        </dl>
    <?php  } else { ?>
    <div class="ccm-faq-block-links">
        <p><?php  echo t('No Faq Entries Entered.'); ?></p>
    </div>
    <?php  } ?>
</div>

<?php  
function nl2p($string)
{
    $paragraphs = '';

    foreach (explode("\n", $string) as $line) {
        if (trim($line)) {
            $paragraphs .= '<p>' . $line . '</p>';
        }
    }

    return $paragraphs;
} ?>

