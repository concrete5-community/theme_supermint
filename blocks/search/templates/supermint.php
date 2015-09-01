<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<?php if (isset($error)) { ?>
	<?php echo $error?><br/><br/>
<?php } ?>

<form action="<?php echo $view->url( $resultTargetURL )?>" method="get" class="ccm-search-block-form">

	<?php if( strlen($title)>0){ ?><h5><?php echo h($title)?></h5><?php } ?>
	<?php if(strlen($query)==0){ ?>
	<input name="search_paths[]" type="hidden" value="<?php echo htmlentities($baseSearchPath, ENT_COMPAT, APP_CHARSET) ?>" />
	<?php } else if (is_array($_REQUEST['search_paths'])) {
		foreach($_REQUEST['search_paths'] as $search_path){ ?>
			<input name="search_paths[]" type="hidden" value="<?php echo htmlentities($search_path, ENT_COMPAT, APP_CHARSET) ?>" />
	<?php  }
	} ?>

	<input name="query" type="text" value="<?php echo htmlentities($query, ENT_COMPAT, APP_CHARSET)?>" class="ccm-search-block-text" style="width:100%" />
</form>
