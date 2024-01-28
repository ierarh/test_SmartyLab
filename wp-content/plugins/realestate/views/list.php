<?php
/**
 * @var $results array
 */

use RealEstate\Components\Registered;

?>
<?php foreach ($results as $key => $items) : ?>
    <ul data-re-list-page="<?php echo $key + 1; ?>"
        class="re_page<?php echo ($key == 0) ? ' active' : ''; ?>"
    >
        <?php foreach ($items as $item) : ?>
            <li>
                <span class="re_district">
                    <?php $districts = wp_get_post_terms($item->ID, Registered::$taxonomy_id, ['fields' => 'names']);
                    if (count($districts)):
                        echo $districts[0];
                    endif;
                    ?>
                </span>
                <span class="re_name">
                <a href="<?php the_permalink($item->ID); ?>">
                    <?php esc_html_e($item->name, 'realestate'); ?>
                </a>
            </span>
                <span class="re_coordinate"><?php esc_html_e($item->coordinate, 'realestate'); ?></span>
                <span class="re_floor"><?php esc_html_e($item->floor + 1, 'realestate'); ?></span>
                <span class="re_type"><?php esc_html_e($item->type, 'realestate'); ?></span>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endforeach; ?>
<?php if (count($results) > 1): ?>
    <div class="re_pagination">
        <?php foreach ($results as $key => $items) : ?>
            <a href="#" data-re-paging="<?php echo $key + 1; ?>"
               class="re_pagination<?php echo ($key == 0) ? ' active' : ''; ?>">
                <?php echo $key + 1; ?>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif;
