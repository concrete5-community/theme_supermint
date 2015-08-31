<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); 
$o = \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions::get();
?>

<?php if(Page::getCurrentPage()->getAttribute('ribbon_text')) :?>
    <div class="sm_ribbon negative-margin-top-<?php echo $o->content_padding?>">
        <span><?php echo Page::getCurrentPage()->getAttribute('ribbon_text') ?></span>
    </div> <!-- #sm_ribbon -->
<?php endif ?>                
