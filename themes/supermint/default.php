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
        <div class="<?php echo $span_sidebar ?> sidebar" id="left-sidebar">
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
        <div class="<?php echo $span_main ?> <?php echo $sidebar_offset ?>">
            <div class="page-content-style padding-<?php echo $o->content_padding ?>">
                <?php $this->inc('elements/ribbon.php') ?>
            <?php 
            $a = new Area('Main');
            $a->setAreaGridMaximumColumns(12);
            $a->display($c);
            ?>          
            </div>
        </div>     
    </div>
</main>

<?php   $this->inc('elements/bottom.php'); ?>