<?php defined('C5_EXECUTE') or die("Access Denied.");
if (count($tagsObject->tags) && (in_array('tag-sorting',$styleObject->classesArray) || in_array('keyword-sorting',$styleObject->classesArray)) ) :
	// All is in echo to preserve the no-spce for display:inline-block
	echo '<ul class="filter-set zero hlist clearfix" data-filter="filter" id="filter-set-' . $bID . '">';
	if (in_array('tag-sorting',$styleObject->classesArray)) :
	  echo '<li><a href="#show-all" data-option-value="*" class="button-flat button-primary">' . t('show all') .'</a></li>';
	  foreach ($tagsObject->tags as $handle => $tag):
	  echo '<li><a class="button-flat" href="#' . $handle . '" data-filter=".' . $handle . '">' . $tag . '</a></li>';
	endforeach;
	endif;
	if (in_array('keyword-sorting',$styleObject->classesArray)):
		echo '<li class="search-filter-wrapper"><input type="text" class="search-filter" id="quicksearch-' . $bID . '" placeholder="' . t('Search on List') . '" /></li>';
	endif;
	echo '</ul>';
endif;?>
