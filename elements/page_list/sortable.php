<?php defined('C5_EXECUTE') or die("Access Denied.");
/*
stdClass Object
(
    [pageTags] => Array
        (
            [169] => Array
                (
                    [0] => navigation
                    [1] => jquery
                    [2] => masonry
                )

        )

    [tags] => Array
        (
            [navigation] => navigation
            [jquery] => jQuery
            [masonry] => Masonry
        )

)
*/
if (count($tagsObject->tags) && $o->isotope_display_tags ) :
	// All is in echo to preserve the no-spce for display:inline-block
	echo '<ul class="filter-set zero hlist" data-filter="filter" id="filter-set-' . $bID . '">';
	  echo '<li><a href="#show-all" data-option-value="*" class="button-flat button-primary">' . t('show all') .'</a></li>';
	  foreach ($tagsObject->tags as $handle => $tag):
	  echo '<li><a class="button-flat" href="#' . $handle . '" data-filter=".' . $handle . '">' . $tag . '</a></li>';
	endforeach;
	if($o->isotope_display_search):
		echo '<li class="search-filter-wrapper"><input type="text" class="search-filter" id="quicksearch-' . $bID . '" placeholder="' . t('Search on Title') . '" /></li>';
	endif;
	echo '</ul>';
endif;?>
