<?php 
defined('C5_EXECUTE') or die("Access Denied.");
$nh = Loader::helper('navigation');
?>
<div class="team">
	<div class="portrait">
		<?php  if (!empty($field_6_image)): ?>
			<?php  if (!empty($field_6_image_externalLinkURL)) { ?><a href="<?php  echo $this->controller->valid_url($field_6_image_externalLinkURL); ?>" target="_blank"><?php  } ?>
			<img src="<?php  echo $field_6_image->src; ?>" width="<?php  echo $field_6_image->width; ?>" height="<?php  echo $field_6_image->height; ?>" alt="<?php  echo $field_6_image_altText; ?>" />
			<?php  if (!empty($field_6_image_externalLinkURL)) { ?></a><?php  } ?>
		<?php  endif; ?>
	</div><!-- .portrait -->

<div class="social">
	<?php  if (!empty($field_3_textbox_text)): ?>
		<a class="right" href="<?php  echo htmlentities($field_3_textbox_text, ENT_QUOTES, APP_CHARSET); ?>">
			<span class="fa-stack fa-lg">
			  <i class="fa fa-circle fa-stack-2x"></i>
			  <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
			</span>
		</a>
	<?php  endif; ?>

	<?php  if (!empty($field_4_textbox_text)): ?>
		<a class="right" href="<?php  echo htmlentities($field_4_textbox_text, ENT_QUOTES, APP_CHARSET); ?>">
			<span class="fa-stack fa-lg">
			  <i class="fa fa-circle fa-stack-2x"></i>
			  <i class="fa fa-linkedin fa-stack-1x fa-inverse"></i>
			</span>
		</a>
		
	<?php  endif; ?>

	<?php  if (!empty($field_5_textbox_text)): ?>
		<a href="<?php  echo htmlentities($field_5_textbox_text, ENT_QUOTES, APP_CHARSET); ?>" class="right">
			<span class="fa-stack fa-lg">
			  <i class="fa fa-circle fa-stack-2x"></i>
			  <i class="fa fa-twitter  fa-stack-1x fa-inverse"></i>
			</span>
		</a>
		
	<?php  endif; ?>
</div><!-- .social -->

<div class="info">
	<?php  if (!empty($field_1_textbox_text)): ?>
		<p class="name"><strong><?php  echo htmlentities($field_1_textbox_text, ENT_QUOTES, APP_CHARSET); ?></strong></p>
	<?php  endif; ?>

	<?php  if (!empty($field_2_textbox_text)): ?>
		<p class="role"><?php  echo htmlentities($field_2_textbox_text, ENT_QUOTES, APP_CHARSET); ?></p>
	<?php  endif; ?>
</div><!-- .info -->


<?php  if (!empty($field_7_link_cID)): ?>
	<?php 
	$link_url = $nh->getLinkToCollection(Page::getByID($field_7_link_cID), true);
	$link_text = empty($field_7_link_text) ? $link_url : htmlentities($field_7_link_text, ENT_QUOTES, APP_CHARSET);
	?>
	<a href="<?php  echo $link_url; ?>"><?php  echo $link_text; ?></a>
<?php  endif; ?>

<?php  if (!empty($field_8_wysiwyg_content)): ?>
	<?php  echo $field_8_wysiwyg_content; ?>
<?php  endif; ?>
</div>