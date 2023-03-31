<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$form = core::make('helper/form');
$spPath = 'packages/theme_supermint/starting_points';
$spArray = Core::make('helper/file')->getDirectoryContents($spPath);
?>

<div class="install_wrapper">
	<input type="hidden" name="spHandle" id="starting_point_handle" value="0">
	<h3><?php  echo t('Choose the Starting Point');?></h3>
	<p><?php  echo t('A starting point is a Complete site that will be installed on your server');?></p>
	<div class="alert alert-danger" role="alert"><p><strong><?php echo ('Important :')?> </strong><?php echo t('To avoid any errors, ensure installing Starting Points on a newly created website without content.') ?></p></div>

	<div class="thumbnail-list clearfix" style="margin-top:20px;">
		<div class="col starting_point active">
			<img class="img-responsive" src="https://placeholdit.imgix.net/~text?txtsize=28&bg=dde2e7&txtclr=cccccc%26text%3Dnone&txt=No+Starting+Point&w=300&h=300"/>
			<div class="info">
				<h3>None</h3>
				<p><?php  echo t('Just install the theme');?></p>
				<div>
					<a class="btn btn-primary none spPicker" ><?php echo t('Choose') ?></a>
				</div>
			</div>
		</div>
		<?php 
		foreach ($spArray as $spHandle) :
			if(	is_dir($spPath . '/' . $spHandle . '/content_files')
				&& 	file_exists($spPath . '/' . $spHandle . '/content.xml')
				&& 	file_exists($spPath . '/' . $spHandle . '/thumbnail.png')
				&& file_exists($spPath . '/' . $spHandle . '/description.txt')
				) :
				?>
				<div class="col starting_point">
					<img class="img-responsive" src="<?php echo DIR_REL . '/' . $spPath . '/' . $spHandle . '/thumbnail.png';?>" />
					<div class="info">
						<div class="inner">
							<h3><?php  echo ucwords(str_replace('_', ' ', $spHandle));?></h3>
							<p><?php  echo Core::make('helper/file')->getContents($spPath . '/' . $spHandle . '/description.txt');?></p>
							<div class="btn-group" role="group">
							 <a class="btn spPicker btn-primary" rel="<?php echo $spHandle ?>"><?php echo t('Choose ') . ucwords(str_replace('_', ' ', $spHandle))  ?></a>
							 <a href="http://<?php echo $spHandle?>.supermint3.myconcretelab.com/" target="_blank" class="btn btn-default"><?php echo t('Live Preview') ?></a>
							</div>
						</div>
					</div>
				</div>
				<?php 
			endif;
		endforeach;
		?>
	</div>
</div>
<div class="alert alert-warning" role="alert"><p><strong><?php echo t('Note :')?> </strong><?php echo t('As all images in the demo are copyrighted, all images are replaced by placeholder in your server')?></p></div>
<style>
.install_wrapper {
	margin: 20px 0;
}
	.thumbnail-list {
		margin-top: 20px;
	}
	.starting_point {
		width: 300px;
		max-width: 310px;
		float: left;
		position: relative;
		overflow: hidden;
		transition:.2s;
	}
	.info {
		top:300px;left: 0;right: 0;bottom:0;
		position: absolute;
		text-align: center;
		transition:.2s;
		background-color: rgba(65,77,89,.8);
	}
	.info .inner {
		padding: 15px;
	}
	.info * {
		/*color: #5d6a78 !important;*/
	}
	.info h3 {
		font-weight: lighter;
		color: #fff;
		text-transform: uppercase;
		border-bottom: 1px solid #b6babe;
		padding-bottom: 10px;
		margin-bottom: 10px;
	}
	.info p {
		opacity: .8;
		color: #fff;
	}
	.info .btn-group {
		margin-top: 50px;
	}

	/* Active & hover state */

	.starting_point:hover .info {
		top:0;
	}
	.starting_point.active {
		border: 5px solid #428bca ;
	}
</style>
	<script>
	$(document).ready(function(){
		$('.spPicker').on('click',function(e){
			e.preventDefault();
			setSwapState(
				$(this).is('.none'),
				$(this).parent().parent().parent().parent(),
				$(this).attr('rel')
				);
		})

		$('input[name=pkgDoFullContentSwap]:radio').on('click', function(){
			if($(this).val() == 0) {
				$('input[name=option][value="none"]:radio').prop('checked', true);
			} else {
				$('input[name=option]:eq(1)').prop('checked', true);
			}
		});
		function setSwapState (state,elem,stHandle) {
			if(!state) {
				$('input[name=pkgDoFullContentSwap][value=1]:radio').prop('checked', false);
				$('input[name=pkgDoFullContentSwap][value=1]:radio').prop('checked', true);
			} else {
				$('input[name=pkgDoFullContentSwap][value=0]:radio').prop('checked', false);
				$('input[name=pkgDoFullContentSwap][value=0]:radio').prop('checked', true);
			}
			$("#starting_point_handle").val(stHandle);
			$('.col.active').removeClass('active');
			elem.toggleClass('active');

		}
	});
	</script>
