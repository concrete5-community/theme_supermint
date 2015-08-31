<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$c = Page::getCurrentPage();

if ($c->getAttribute('page_background') || $c->getAttribute('page_backgrounds')) : 
  $bg = $c->getAttribute('page_background');
  $bgs = $c->getAttribute('page_backgrounds');
  if ($bg) $bgurls[] = $bg->getRelativePath();
  if ($bgs) :
    $fs = \Concrete\Core\File\Set\Set::getByID($bgs);
    $fl = new \Concrete\Core\File\FileList();
    $fl->filterBySet($fs);
    $fl->sortByFileSetDisplayOrder();
    $files = $fl->get();
    foreach ($files as $key => $file) $bgurls[] = $file->getRelativePath();
  endif;

if (count($bgurls)) : ?>
<script>
  $(function() {
        $.backstretch(<?php echo str_replace('\\/', '/', Loader::helper('json')->encode($bgurls))  ?>,  {speed: 750});
      });
</script>
<?php endif?>
<?php else : ?>
  <!-- No bakstrech attribute -->
<?php endif?>