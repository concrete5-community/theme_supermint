<?php defined('C5_EXECUTE') or die(_("Access Denied.")) ?>
<div class="chart chart_<?php echo $bID?>" id="chart_<?php echo $bID?>" data-percent="0" data-updateto="<?php echo $options->value ?>" style="width:<?php echo $options->size ?>px; height:<?php echo $options->size ?>px"><?php echo $options->content ?></div>
<script type="text/javascript">

$(document).ready(function() {
    if (!chart_<?php echo $bID?>) {
        var chart_<?php echo $bID?> = true;
            $('.chart_<?php echo $bID?>').easyPieChart({
                barColor : '<?php echo $options->barColor ?>',
                trackColor : <?php echo $options->track ? '"' . $options->trackColor . '"' : 'false' ?>,
                scaleColor : <?php echo $options->scale ? '"' . $options->scaleColor . '"' : 'false' ?>,
                lineCap : '<?php echo $options->lineCap ?>',
                lineWidth : <?php echo (int)$options->lineWidth ?>,
                size : <?php echo (int)$options->size ?>,
                rotate : <?php echo (int)$options->rotate ?>,
                <?php echo $options->animate ? 'animate:' . $options->animate : '' ?> 
            });
        
            $('.chart_<?php echo $bID?>').bind('enterviewport', updateChart).bind('leaveviewport', resetchart).bullseye();
    }   
});
    // Si la function n'existe pas on la crée
    if (typeof(updateChart) == 'undefined') {
        var updateChart = function  (e) {
            var t = $(this);
            t.data('easyPieChart').update(t.data('updateto'));
        }
        var resetchart = function  (e) {
            var t = $(this);
            t.data('easyPieChart').update(0);
        }
    }
</script>
<style>
    #chart_<?php echo $bID?> {
        font-size: <?php echo $options->fontSize ?>px;
        <?php echo $options->textColor ? 'color:' . $options->textColor . ';' : '' ?>
        width: <?php echo $options->size ?>px;
        margin:0 auto;
    }
</style>