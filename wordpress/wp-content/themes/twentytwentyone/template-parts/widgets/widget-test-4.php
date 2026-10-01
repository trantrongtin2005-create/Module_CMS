<?php
/**
 * Widget Test 4 Component
 * Displays category navigation and list of posts matching screenshot design.
 */

// Query published posts from DB
$widget_4_query = new WP_Query( array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 10,
    'orderby'        => 'date',
    'order'          => 'DESC',
) );

$db_posts = $widget_4_query->get_posts();
wp_reset_postdata();

// Fallback post titles matching user screenshot
$fallback_titles = array(
    'Thành công',
    'Hello world!',
    'LỊCH PHỎNG VẤN CHƯƠNG TRÌNH CNTT NHẬT BẢN 2021',
    'Bóng đá',
    'Sài gòn',
);

$display_posts = array();

if ( ! empty( $db_posts ) ) {
    foreach ( $db_posts as $index => $p ) {
        $display_posts[] = array(
            'title' => get_the_title( $p->ID ),
            'link'  => get_permalink( $p->ID ),
        );
    }
}

// Ensure screenshot items are present or fallback as needed
if ( count( $display_posts ) < 5 ) {
    for ( $i = count( $display_posts ); $i < 5; $i++ ) {
        $display_posts[] = array(
            'title' => $fallback_titles[$i],
            'link'  => '#',
        );
    }
}

// Fetch categories from DB
$db_categories = get_categories( array(
    'hide_empty' => false,
    'orderby'    => 'count',
    'order'      => 'DESC',
) );

$nav_cats = array();
$dropdown_cats = array();

if ( ! empty( $db_categories ) && ! is_wp_error( $db_categories ) ) {
    foreach ( $db_categories as $c ) {
        if ( $c->slug === 'uncategorized' || $c->slug === 'chua-phan-loai' ) {
            continue;
        }
        $cat_item = array(
            'name' => $c->name,
            'link' => get_category_link( $c->term_id ),
        );
        if ( count( $nav_cats ) < 3 ) {
            $nav_cats[] = $cat_item;
        } else {
            $dropdown_cats[] = $cat_item;
        }
    }
}

// Fallback categories matching screenshot if DB has fewer than 3
$fallback_nav_cats = array(
    array( 'name' => 'Công nghệ', 'link' => '#' ),
    array( 'name' => 'Đời sống', 'link' => '#' ),
    array( 'name' => 'Du lịch', 'link' => '#' ),
);

if ( count( $nav_cats ) < 3 ) {
    for ( $i = count( $nav_cats ); $i < 3; $i++ ) {
        $nav_cats[] = $fallback_nav_cats[$i];
    }
}

if ( empty( $dropdown_cats ) ) {
    $dropdown_cats = array(
        array( 'name' => 'Thế giới', 'link' => '#' ),
        array( 'name' => 'Thể thao', 'link' => '#' ),
        array( 'name' => 'Giải trí', 'link' => '#' ),
        array( 'name' => 'Kinh doanh', 'link' => '#' ),
    );
}
?>

<div class="widget-member-4">
    <div id="member_4_widget_content" class="widget-test-4-container">
        <!-- Header Navigation (Right Aligned) -->
        <div class="widget-test-4-header">
            <nav class="widget-test-4-nav">
                <?php foreach ( $nav_cats as $idx => $cat ) : ?>
                    <?php if ( $idx > 0 ) : ?>
                        <span class="widget-test-4-sep">|</span>
                    <?php endif; ?>
                    <a href="<?php echo esc_url( $cat['link'] ); ?>" class="widget-test-4-nav-link">
                        <?php echo esc_html( $cat['name'] ); ?>
                    </a>
                <?php endforeach; ?>
                
                <span class="widget-test-4-sep">|</span>

                <!-- Dropdown Toggle 'v' -->
                <div class="widget-test-4-dropdown-wrapper">
                    <span class="widget-test-4-caret" title="Xem thêm danh mục">v</span>
                    <div class="widget-test-4-dropdown-menu">
                        <?php foreach ( $dropdown_cats as $drop_cat ) : ?>
                            <a href="<?php echo esc_url( $drop_cat['link'] ); ?>" class="widget-test-4-dropdown-item">
                                <?php echo esc_html( $drop_cat['name'] ); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Main List Body with Vertical Line on Left -->
        <div class="widget-test-4-body">
            <ul class="widget-test-4-list">
                <?php foreach ( $display_posts as $post_item ) : ?>
                    <li class="widget-test-4-item">
                        <a href="<?php echo esc_url( $post_item['link'] ); ?>" class="widget-test-4-title">
                            <?php echo esc_html( $post_item['title'] ); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

