<?php defined('C5_EXECUTE') or die("Access Denied.");
/*
stdClass Object
(
    [fileTags] => Array
        (
            [169] => Array
                (
                    [value] => Masonry
                    [handle] => masonry
                )

        )

    [tags] => Array
        (
            [navigation] => navigation
            [jquery] => jQuery
            [masonry] => Masonry
        )

)
*/?>
<!-- <pre><?php print_r($tagsObject)?></pre> -->
<?php
	if (count($tagsObject->tags) && true ) : ?>
		<ul class="filter-set" data-filter="filter" id="filter-set-<?php echo $bID?>">
		  <li><a href="#show-all" data-option-value="*" class="selected rounded"><?php echo t('show all')?></a></li>
		  <?php foreach ($tagsObject->tags as $handle => $tag): ?>
		  <li><a class="" href="#<?php echo $handle?>" data-filter=".<?php echo $handle ?>"><?php echo $tag?></a></li>
		  <?php endforeach ?>
		</ul>
	<?php endif ?>
