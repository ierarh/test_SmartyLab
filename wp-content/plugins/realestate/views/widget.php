<div class="re_widget">
    <div class="re_filters">
        <div class="col">
            <div class="re_input">
                <label for="re_name"><?php esc_html_e('Building Name', 'realestate'); ?></label>
                <input type="text" class="re_name" id="re_name" name="building_name"/>
            </div>
            <div class="re_select">
                <label for="re_floor"><?php esc_html_e('Floor Count', 'realestate'); ?></label>
                <select class="re_select" id="re_floor" name="floor_count">
                    <option value="">-</option>
                    <?php for ($i = 1; $i <= 20; $i++) : ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </div>

        </div>
        <div class="re_radio">
            <span><?php esc_html_e('Building Type', 'realestate'); ?></span>
            <label for="re_wpanel">
                <input type="radio" class="re_type" id="re_wpanel" name="widget_type" value="panel"/>
                <?php esc_html_e('Panel', 'realestate'); ?>
            </label>
            <label for="re_wbriks">
                <input type="radio" class="re_type" id="re_wbriks" name="widget_type" value="bricks"/>
                <?php esc_html_e('Bricks', 'realestate'); ?>
            </label>
            <label for="re_wblocks">
                <input type="radio" class="re_type" id="re_wblocks" name="widget_type" value="blocks"/>
                <?php esc_html_e('Blocks', 'realestate'); ?>
            </label>
        </div>
        <div class="re_button">
            <button class="re_search"><?php esc_html_e('Search', 'realestate'); ?></button>
        </div>
    </div>
    <div class="re_search_results"></div>
</div>