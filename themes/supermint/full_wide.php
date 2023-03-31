<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$this->inc('elements/header.php');
$this->inc('elements/intro.php');
/** @var \Concrete\Core\Entity\Attribute\Value\Value\SelectValue $columns */
$columns = $c->getAttribute('number_of_wide_columns');
if (is_object($columns)) {
    /** @var \Concrete\Core\Entity\Attribute\Value\Value\SelectValueOption $selectValueOption */
    if (is_object($selectValueOption = $columns->getSelectedOptions()->get(0))) {
        $columns = $selectValueOption->getSelectAttributeOptionValue();
    }
}

$columns = $columns ? $columns : 2;
$columnClass = 'col-md-' . (12 / (int)$columns);
?>

<main class="wide-container">
	<div class="row no-gap">  
	<?php for ($i=0; $i < $columns; $i++) :
		$areaName = $i > 0 ? ('Main Column ' . $i) : 'Main'; ?>
		<div class="<?php echo $columnClass ?>">
			<?php $this->inc('elements/multiple_area.php',array('c'=>$c,'area_name'=>$areaName,'attribute_handle'=>'number_of_main_areas','enableGridContainer' => 'disable'));  ?>		
		</div>
	<?php endfor ?>
	</div>
</main>	

<?php   $this->inc('elements/bottom.php'); ?>