<?php defined('C5_EXECUTE') or die(_("Access Denied.")) ?>

<div class="ccm-ui">
<table style="width:100%" class="tbl">
	<tbody>
	<tr>
		<td><strong><?php echo t('Value')?></strong></td>
	    <td><?php echo t('The value (must be a number)')?></td>
	    <td>
	    	<div class="jrange" data-id="value" data-min="0" data-max="100" data-value="<?php echo $options->value ?>" data-step="1"></div>
	    	<input type="text" id="value" name="value" readonly value="<?php echo $options->value ?>"> %
	    </td>
	</tr>
	<tr>
		<td><strong><?php echo t('Content')?></strong></td>
	    <td><?php echo t('The content text')?></td>
	    <td><input type="text" maxlength="250" name="content" value="<?php echo $options->content ?>"></td>
	</tr>
	<tr>
		<td><strong><?php echo t('Content Font size')?></strong></td>
	    <td><?php echo t('The font size for content text')?></td>
	    <td>
	    	<div class="jrange" data-id="fontSize" data-min="12" data-max="80" data-value="<?php echo $options->fontSize ?>" data-step="1"></div>
	    	<input type="text" id="fontSize" name="fontSize" readonly value="<?php echo $options->fontSize ?>"> px
	    </td>
	</tr>
	<tr>
		<td><strong><?php echo t('Content Color')?></strong></td>
	    <td><?php echo t('The color of the content Text')?></td>
		<td><input type="text" class="spectrum" name="textColor" value="<?php echo  $options->textColor ?>" /></td>
   	</tr>
	<tr>
		<td style="width:20%"><strong><?php echo t('Bar Color')?></strong></td>
		<td style="width:30%"><?php echo t('The color of the circular bar.')?></td>
		<td style="width:50%"><input type="text" class="spectrum" name="barColor" value="<?php echo $options->barColor ?>" /></td>

	</tr>
	<tr>
		<td><strong><?php echo t('Display Track')?></strong></td>
	    <td><?php echo t('')?></td>
		<td>
			<input type="radio" name="track" value="1" <?php echo $options->track == 1 ? 'checked' : '' ?>><?php echo t('Yes') ?>
			&nbsp;&nbsp;
			<input type="radio" name="track" value="0" <?php echo $options->track == 0 ? 'checked' : '' ?>><?php echo t('No') ?>
		</td>
	</tr>
	<tr>
		<td><strong><?php echo t('Track Color')?></strong></td>
	    <td><?php echo t('The color of the track for the bar')?></td>
		<td><input type="text" class="spectrum" name="trackColor" value="<?php echo  $options->trackColor ?>" /></td>
   	</tr>
	<tr>
		<td><strong><?php echo t('Display Scale')?></strong></td>
	    <td><?php echo t('')?></td>
		<td>
			<input type="radio" name="scale" value="1" <?php echo $options->scale == 1 ? 'checked' : '' ?>><?php echo t('Yes') ?>
			&nbsp;&nbsp;
			<input type="radio" name="scale" value="0" <?php echo $options->scale == 0 ? 'checked' : '' ?>><?php echo t('No') ?>
		</td>
	</tr>
	<tr>
		<td><strong><?php echo t('Scale Color')?></strong></td>
	    <td><?php echo t('The color of the scale lines')?></td>
	    <td><input type="text" class="spectrum" name="scaleColor" value="<?php echo  $options->scaleColor ?>" /></td>
	    </tr>
	<tr>
		<td><strong><?php echo t('lineCap')?></strong></td>
	    <td><?php echo t('Defines how the ending of the bar line looks like')?></td>
	    <td>
		    <select name="lineCap" id="lineCap">
		    	<option value="butt" <?php echo $options->lineCap == 'butt' ? 'selected' : '' ?>><?php echo t('Normal') ?></option>
		    	<option value="round" <?php echo $options->lineCap == 'round' ? 'selected' : '' ?>><?php echo t('Round') ?></option>
		    	<option value="square" <?php echo $options->lineCap == 'square' ? 'selected' : '' ?>><?php echo t('square') ?></option>
		    </select>
		 </td>
	    </tr>
	<tr>
		<td><strong><?php echo t('Line Width')?></strong></td>
	    <td><?php echo t('Width of the bar line in px.')?></td>
	    <td>
	    	<div class="jrange" data-id="lineWidth" data-min="1" data-max="40" data-value="<?php echo $options->lineWidth ?>" data-step="1"></div>
	    	<input type="text" id="lineWidth" name="lineWidth" readonly value="<?php echo $options->lineWidth ?>"> px
	    </td>
	    </tr>
	<tr>
		<td><strong><?php echo t('size')?></strong></td>
	    <td><?php echo t('Size of the pie chart in px. It will always be a square.')?></td>
	    <td>
	    	<div class="jrange" data-id="size" data-min="20" data-max="800" data-value="<?php echo $options->size ?>" data-step="1"></div>
	    	<input type="text" id="size" name="size" readonly value="<?php echo $options->size ?>"> px
	    </td>
	    </tr>
	<tr>
		<td><strong><?php echo t('rotate')?></strong></td>
	    <td><?php echo t('Rotation of the complete chart in degrees.')?></td>
	    <td>
	    	<div class="jrange" data-id="rotate" data-min="0" data-max="360" data-value="<?php echo $options->rotate ?>" data-step="1"></div>
	    	<input type="text" id="rotate" name="rotate" readonly value="<?php echo $options->rotate ?>">
	    </td>
	    </tr>
	<tr>
		<td><strong><?php echo t('animate')?></strong></td>
	    <td><?php echo t('Time in milliseconds for a eased animation of the bar growing, or 0 to deactivate.')?></td>
	    <td>
	    	<div class="jrange" data-id="animate" data-min="0" data-max="5000" data-value="<?php echo $options->animate ?>" data-step="50"></div>
	    	<input type="text" id="animate" name="animate" readonly value="<?php echo $options->animate ?>">
	    </td>
	    </tr>
	<tr>
	</tbody>
</table>
</div>
<script>

	$(document).ready(function(){

		$(".jrange").each(function(){
			var t = $(this);
			t.slider({
				min:t.data('min'),
				max:t.data('max'),
				step:t.data('step'),
				value: t.data('value'),
				slide: function(event, ui) {
					$("#" + $(this).data('id')).val(ui.value)}
				})
		});
		$('.spectrum').spectrum({
			  showInput: true,
				appendTo: '.ui-dialog'
		});

	});
</script>
<style>
	.tbl td {
		padding:20px 10px;
	}
	.tbl tr {
		border-bottom: 1px solid #ccc;
	}
	.tbl .ui-slider {
		margin: 15px 0;
		width:90%;
	}
	.tbl .ui-slider + input {
		width:80px;
	}
</style>
