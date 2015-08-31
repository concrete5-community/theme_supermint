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

    <?php if($buttonText) { ?>
	<input name="submit" type="submit" value="<?php echo h($buttonText)?>" class="btn btn-default ccm-search-block-submit" />
    <?php } ?>

<?php 
$tt = Loader::helper('text');
if ($do_search) {
	if(count($results)==0){ ?>
		<h4 style="margin-top:32px"><?php echo t('There were no results found. Please try another keyword or phrase.')?></h4>	
	<?php }else{ ?>
		<div id="searchResults">
		<?php foreach($results as $r) { 
			$currentPageBody = $this->controller->highlightedExtendedMarkup($r->getPageIndexContent(), $query);?>
			<div class="searchResult">
				<h5><a href="<?php echo $r->getCollectionLink()?>"><?php echo $r->getCollectionName()?></a></h5>
				<p>
					<?php if ($r->getCollectionDescription()) { ?>
						<?php  echo $this->controller->highlightedMarkup($tt->shortText($r->getCollectionDescription()),$query)?><br/>
					<?php } ?>
					<?php echo $currentPageBody; ?>
					<a href="<?php  echo $r->getCollectionLink(); ?>" class="pageLink"><?php  echo $this->controller->highlightedMarkup($r->getCollectionLink(),$query)?></a>
				</p>
			</div>
		<?php 	}//foreach search result ?>
		</div>
		
		<?php
		
		
        //$pagination = $searchList->getPagination();
        $pages = $pagination->getCurrentPageResults();

        if ($pagination->getTotalPages() > 1 && $pagination->haveToPaginate()) {
            $showPagination = true;
            echo $pagination->renderDefaultView();
        }		
	} //results found
} 
?>

</form>