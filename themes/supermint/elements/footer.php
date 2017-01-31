<?php   defined('C5_EXECUTE') or die(_("Access Denied."));
$pageTheme =  \Concrete\Package\ThemeSupermint\Src\Helper\ThemeObject::get($c);
$o = \Concrete\Package\ThemeSupermint\Src\Models\ThemeSupermintOptions::get();
if($o->display_footer) :
$footer = $pageTheme->get_footer_geometry($o->display_footer_column);
?>
<footer class="main-footer">
<div class="container">
      <div class="row">
      	<div class="space-s"></div>
		<?php  foreach ($footer as $area) : ?>
		<div class="<?php echo $area['class'] ?>" id='<?php echo $area['name']?>'>
			<?php
			if($o->footer_global) :
				$f = new GlobalArea($area['name']);
				$f->display();
			else :
				$f = new Area($area['name']);
				$f->display($c);
			endif;
			?>
		</div>
		<?php  endforeach ?>
		<div class="space-s"></div>
      </div>
      <hr>
      <hr class="space-s">
      <div class="row credits">
      	<div class="col-md-8">
      		<p id="footer-note" class="small">
      			<span>&copy;&nbsp;<?php echo date('Y')?>&nbsp;<a href="<?php echo DIR_REL?>/"><?php echo Config::get('concrete.site')?></a>&nbsp;</span>
				<?php echo $o->footer_credit ?>
				<?php
        if (!$o->disable_footer_login) :
				$u = new User();
				if ($u->isRegistered()) { ?>
					<?php
					if (Config::get("ENABLE_USER_PROFILES")) {
						$userName = '<a href="' . $this->url('/profile') . '">' . $u->getUserName() . '</a>';
					} else {
						$userName = $u->getUserName();
					}
					?>
					<span class="sign-in">&nbsp;<?php echo t('Currently logged in as <b>%s</b>.', $userName)?> <a href="<?php  echo $view->url('/login', 'logout', Loader::helper('validation/token')->generate('logout'))?>"><?php  echo t('Sign Out')?></a></span>
				<?php  } else { ?>
					<span class="sign-in"><a href="<?php echo $this->url('/login')?>">&nbsp;<?php echo t('Sign In to Edit this Site')?></a></span>
				<?php  } ?>
      <?php endif ?>
      		</p>
      		<div class="space-s"></div>
      	</div>
      </div>
  </div>
</footer>

<?php endif ?>
</div>


<?php   $this->inc('elements/backstretch.php') ?>
<?php   Loader::element('footer_required'); ?>

<script type="text/javascript">
	<?php if ($o->navigation_style == 'slide') : ?>
	// Si navigationOption n'est pas défini, on n'initira pas le box.nav
	var navigationOptions = {
		columnsNumber : <?php echo $o->nav_columns ?>,
		columnsMargin : <?php echo $o->nav_columns_margin ?>,
		slideSpeed : <?php echo $o->nav_slide_speed ?>,
		openSpeed : <?php echo $o->nav_open_speed ?>,
		closeSpeed : <?php echo $o->nav_close_speed ?>,
		mouseLeaveActionDelay : <?php echo $o->nav_mouseleave_delay ?>,
		mode : '<?php echo $o->force_mobile_nav ? 'mobile' : 'regular' ?>',
		globalWrapperSelector:'#header-nav',
		openOnLoad : <?php echo $o->nav_open_on_load ? 'true' : 'false' ?>, // A regler depuis l'admin
		eventName : '<?php echo $o->nav_event ?>',
		doubleCLickAction : '<?php echo $o->nav_dbl_click_event ?>'
	}
	<?php endif ?>
  var mmenuSettings = {
    // options
    <?php if($o->display_searchbox && false) :	$searchPage = Page::getByID($o->display_searchbox);	if (is_object($searchPage)) : $searchURL = URL::to($searchPage); ?>
    searchfield:{
        add: true,
        search: false
    },
    <?php endif; endif ?>
     extensions: <?php echo '["theme-' . ($o->mmenu_theme ? $o->mmenu_theme : 'light') .'"';
                 echo $o->mmenu_shadow ? ',"pageshadow"' : '';
                 echo $o->mmenu_iconbar ? ',"iconbar"' : '';
                 echo '],'
                 ?>
     offCanvas: {
               position:"<?php echo $o->mmenu_position ? $o->mmenu_position : 'left'?>"
              //  zposition : "front"
            }
  <?php echo ($o->mmenu_position == 'bottom' OR $o->mmenu_position == 'top') ? ',autoHeight: true' : ''?>
  };

	var THEME_PATH = '<?php  echo $this->getThemePath()?>';
	var FONT_DETAILS_TOOLS_URL = "<?php echo URL::to('/ThemeSupermint/tools/font_details'); ?>";
	var FIX_IFRAME_ZINDEX = <?php echo $o->fix_iframe_zindex ? 'true' : 'false' ?>;
  <?php if ($searchURL) : ?>
  var SEARCH_URL = "<?php echo $searchURL?>";
  <?php endif ?>
  var HIDDE_DROPDOWN_SMALL_SCREEN = <?php echo $o->hidde_dropdown_small_screen ? 'true' : 'false' ?>;
</script>

</body>
</html>
