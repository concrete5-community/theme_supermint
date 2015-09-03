<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$o = \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions::get();

$span_sidebar = 'col-md-' . $o->sidebar_size;
$span_main = 'col-md-' . ( 12 - $o->sidebar_size - $o->sidebar_offset ) ;
$sidebar_offset = $o->sidebar_offset ? ('col-md-offset-' . $o->sidebar_offset) : '';

$this->inc('elements/header.php');
$this->inc('elements/intro.php');
?>
<main class="container main-container">
    <div class="row">
        <div class="<?php echo $span_main ?>">
            <div class="page-content-style padding-<?php echo $o->content_padding ?>">
                <?php $this->inc('elements/ribbon.php') ?>
                <?php $this->inc('elements/multiple_area.php',array('c'=>$c,'area_name'=>'Main','AreaGridMaximumColumns' => 12, 'attribute_handle'=>'number_of_main_areas'));  ?>		         
            </div>
        </div>
        <div class="<?php echo $span_sidebar ?> <?php echo $sidebar_offset ?> sidebar" id="rigth-sidebar">
            <div class="sb-header padding-<?php echo $o->sidebar_padding?>">
                <?php
                $a = new Area('Sidebar');
                $a->display($c);
                ?>

            </div>
            <div class="sb-footer">
                <?php
                $a = new Area('Sidebar Footer');
                $a->display($c);
                ?>
            </div>
        </div>
    </div>
</main>

<?php   $this->inc('elements/bottom.php'); ?>
