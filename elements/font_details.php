<?php defined('C5_EXECUTE') or die("Access Denied.");

if(!is_array($variants) || !is_array($subsets)) die(t('A error a occured to retrieve font infos'));
// Les noms des inputs
if (!$subsetName || !$variantName) 	die(t('A intern error are occured'));
?>

<div class="font_details_inner" id="_">
	<!-- <h3><?php echo t('Details for ') . $font ?></h3> -->
	<table style="width:100%">
		<tr>
			<td class="td">
				<!-- The variant -->

				<strong class="title"><?php echo t('Variants') ?></strong>
				<select name="<?php echo $variantName ?>[]" id="<?php echo $variantName ?>" <?php if ($variantType == 'multiple') :?> multiple class="variant_selector" <?php endif ?>>
				<?php foreach ($variants as $key => $variant) : 
					$selected = in_array($variant, $selected_variants) ? 'selected' : '';
					?>
					<option value="<?php echo $variant ?>" <?php echo $selected ?>><?php echo $variant ?></option>
				<?php endforeach ?>				
				</select>
				<div></div>
				
				<!-- The variant Selected -->
				
				<div class="variant_selected_wrapper" <?php if ($variantType  == 'multiple' && count($variants) > 1  && count($selected_variants) > 1) : ?>style="display:block"<?php endif ?>>
					<strong class="title"><?php echo t('Variant default ') ?></strong>
					<select name="<?php echo $variantName ?>_selected" id="<?php echo $variantName ?>_selected" >
					<?php foreach ($selected_variants as $key => $variant) : 
						$selected = $variant == $default_variant ? 'selected' : '';
						?>
						<option value="<?php echo $variant ?>" <?php echo $selected ?>><?php echo $variant ?></option>
					<?php endforeach ?>							
					</select>
				</div>	
							
				
				<strong class="title"><?php echo t('subsets') ?></strong>
				<select name="<?php echo $subsetName ?>[]" id="" <?php if ($variantType == 'multiple') :?> multiple class="variant_selector" <?php endif ?>>
				<?php foreach ($subsets as $key => $subset) : 
					$selected = in_array($subset, $selected_subsets) ? 'selected' : ''; // trouver un truc pour selectionner d'office le premier
					?>
					<option value="<?php echo $subset ?>" <?php echo $selected ?>><?php echo $subset ?></option>
				<?php endforeach ?>
				</select>
			</td>
			<td class="td">
				<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=<?php echo str_replace(' ', '+', $font) ?>" type="text/css" />
				<div id="__" contenteditable="true">
					<h3 style="font-family:'<?php echo str_replace('+', ' ', $font) ?>'">Grumpy wizards make toxic brew for the evil Queen and Jack.</h3>
				</div>
			</td>
		</tr>
		
	</table>
</div>

<style>
	#ccm-dashboard-page td.td {
		width:33%;
		padding: 10px;
		vertical-align: top;
		background-color: transparent;
	}
	td.td label {
		display: inline-block;
		margin-right : 20px;
		text-align: center;
	}
	.ccm-ui td.td input {
		margin: 0 auto
	}
</style>