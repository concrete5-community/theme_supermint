<?php defined('C5_EXECUTE') or die("Access Denied.");

$number_of_areas = $c->getAttribute($attribute_handle);
// Si l'attribut est un 'select' :
if (is_object($number_of_areas) && is_object($current = $number_of_areas->current())) $number_of_areas = $current->getSelectAttributeOptionValue();
// Si l'attribut n'a pas été séléctionné, il est égal à 1
$number_of_areas = ($number_of_areas == 0) ? 1 : $number_of_areas;

if ($number_of_areas > 0 ) {
    for ($i=0; $i <= $number_of_areas; $i++) {
        // Ce qui va suivre le nom de l'area (area, area-1, area-2, ...)
        $id = $i > 0 ?  $area_name . ' - ' . $i : $area_name;
	    $area = new Area($id);
	    if (isset($AreaGridMaximumColumns))
	    	$area->setAreaGridMaximumColumns($AreaGridMaximumColumns);
	    elseif (!isset($enableGridContainer))
	    	$area->enableGridContainer();
	    $area->display($c);
    }
}
?>
