<?php
/**
 * Widget Test 4 Component
 * Displays above footer on Homepage, List page, and Detail page.
 */

// Query latest 5 posts
$widget_4_query = new WP_Query( array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 5,
    'orderby'        => 'date',
    'order'          => 'DESC',
) );

$widget_4_posts = $widget_4_query->get_posts();
wp_reset_postdata();

// Fetch WordPress Categories for the Header Nav
$widget_4_categories = get_categories( array(
    'number'     => 5,
    'hide_empty' => false,
    'orderby'    => 'count',
    'order'      => 'DESC',
) );

$nav_categories = array();
if ( ! empty( $widget_4_categories ) && ! is_wp_error( $widget_4_categories ) ) {
    foreach ( $widget_4_categories as $cat ) {
        // Exclude 'Uncategorized' / 'chua-phan-loai' if we have other categories
        if ( count( $widget_4_categories ) > 3 && ( $cat->slug === 'uncategorized' || $cat->slug === 'chua-phan-loai' ) ) {
            continue;
        }
        $nav_categories[] = array(
            'id'   => $cat->term_id,
            'name' => $cat->name,
            'link' => get_category_link( $cat->term_id ),
        );
        if ( count( $nav_categories ) >= 3 ) {
            break;
        }
    }
}

// Fallback categories if fewer than 3 found in DB
$fallback_nav_categories = array(
    array( 'name' => 'Tin tức', 'link' => '#' ),
    array( 'name' => 'Lịch thi đấu', 'link' => '#' ),
    array( 'name' => 'Bảng xếp hạng', 'link' => '#' ),
);

if ( count( $nav_categories ) < 3 ) {
    for ( $i = count( $nav_categories ); $i < 3; $i++ ) {
        $nav_categories[] = $fallback_nav_categories[$i];
    }
}

// Sample fallback posts matching screenshot design if DB posts are empty or insufficient
$fallback_posts = array(
    array(
        'title'   => 'Đăng Khoa nằm trong top 5 cầu thủ trẻ đáng xem tại FIFA ASEAN Cup 2026',
        'excerpt' => 'Tiền đạo cánh Ngô Đăng Khoa là một trong 5 cầu thủ trẻ được LĐBĐ thế giới lựa chọn...',
        'comments'=> 33,
        'image'   => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?auto=format&fit=crop&w=800&q=80',
        'link'    => '#',
    ),
    array(
        'title'   => 'Hậu vệ trụ cột của Thái Lan bật khóc vì lỡ FIFA ASEAN Cup',
        'comments'=> 46,
        'image'   => 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?auto=format&fit=crop&w=500&q=80',
        'has_camera' => false,
        'link'    => '#',
    ),
    array(
        'title'   => 'Việt Nam đến Indonesia, bắt đầu FIFA ASEAN Cup',
        'comments'=> 65,
        'image'   => 'https://images.unsplash.com/photo-1522778119026-d647f0596c20?auto=format&fit=crop&w=500&q=80',
        'has_camera' => true,
        'link'    => '#',
    ),
    array(
        'title'   => 'Quang Hải lỡ FIFA ASEAN Cup 2026',
        'comments'=> 182,
        'image'   => 'https://images.unsplash.com/photo-1517466787929-bc90951d0974?auto=format&fit=crop&w=500&q=80',
        'has_camera' => false,
        'link'    => '#',
    ),
    array(
        'title'   => 'Philippines gọi 11 cầu thủ từ Âu Mỹ để đấu Việt Nam',
        'comments'=> 79,
        'image'   => 'https://images.unsplash.com/photo-1560272564-c83b66b1ad12?auto=format&fit=crop&w=500&q=80',
        'has_camera' => false,
        'link'    => '#',
    ),
);

// Map database posts or fallback items
$featured_item = null;
$grid_items = array();

if ( ! empty( $widget_4_posts ) ) {
    $first_p = $widget_4_posts[0];
    $feat_img = get_the_post_thumbnail_url( $first_p->ID, 'large' );
    $featured_item = array(
        'title'    => get_the_title( $first_p->ID ),
        'excerpt'  => has_excerpt( $first_p->ID ) ? get_the_excerpt( $first_p->ID ) : wp_trim_words( strip_tags( $first_p->post_content ), 20, '...' ),
        'comments' => get_comments_number( $first_p->ID ),
        'image'    => $feat_img ? $feat_img : $fallback_posts[0]['image'],
        'link'     => get_permalink( $first_p->ID ),
    );

    for ( $i = 1; $i < 5; $i++ ) {
        if ( isset( $widget_4_posts[$i] ) ) {
            $p = $widget_4_posts[$i];
            $img = get_the_post_thumbnail_url( $p->ID, 'medium' );
            $grid_items[] = array(
                'title'    => get_the_title( $p->ID ),
                'comments' => get_comments_number( $p->ID ),
                'image'    => $img ? $img : $fallback_posts[$i]['image'],
                'has_camera' => ($i === 2),
                'link'     => get_permalink( $p->ID ),
            );
        } else {
            // Fill with fallback item if fewer than 5 posts
            $grid_items[] = $fallback_posts[$i];
        }
    }
} else {
    $featured_item = $fallback_posts[0];
    $grid_items = array_slice( $fallback_posts, 1 );
}
?>

<div class="widget-member-4">
<div id="member_4_widget_content" class="widget-test-4-container">
    <!-- Top Decorative Line -->
    <div class="widget-test-4-top-bar"></div>

    <!-- Header Navigation -->
    <div class="widget-test-4-header">
        <div class="widget-test-4-logo">
            <svg class="widget-test-4-cup-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path>
                <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path>
                <path d="M4 22h16"></path>
                <path d="M10 14.66V17c0 .55-.45 1-1 1H7v2h10v-2h-2c-.55 0-1-.45-1-1v-2.34"></path>
                <path d="M18 4H6v7a6 6 0 0 0 12 0V4z"></path>
            </svg>
            <div class="widget-test-4-brand-text">
                <span class="brand-title">ASEAN CUP</span>
                <span class="brand-year">2026</span>
            </div>
        </div>
        <nav class="widget-test-4-nav">
            <?php foreach ( $nav_categories as $index => $cat_item ) : ?>
                <?php
                $is_active = ( isset( $cat_item['id'] ) && is_category( $cat_item['id'] ) ) || ( $index === 0 && ! is_category() );
                ?>
                <a href="<?php echo esc_url( $cat_item['link'] ); ?>" class="nav-item <?php echo $is_active ? 'active' : ''; ?>">
                    <?php echo esc_html( $cat_item['name'] ); ?>
                </a>
            <?php endforeach; ?>
        </nav>
    </div>

    <!-- Main Widget Content -->
    <div class="widget-test-4-content">
        <!-- Featured Post Section -->
        <div class="widget-test-4-featured">
            <div class="widget-test-4-featured-img-wrap">
                <a href="<?php echo esc_url( $featured_item['link'] ); ?>">
                    <img src="<?php echo esc_url( $featured_item['image'] ); ?>" alt="<?php echo esc_attr( $featured_item['title'] ); ?>" loading="lazy" />
                </a>
            </div>
            <div class="widget-test-4-featured-info">
                <h3 class="widget-test-4-featured-title">
                    <a href="<?php echo esc_url( $featured_item['link'] ); ?>">
                        <?php echo esc_html( $featured_item['title'] ); ?>
                    </a>
                </h3>
                <?php if ( ! empty( $featured_item['excerpt'] ) ) : ?>
                    <p class="widget-test-4-featured-excerpt">
                        <?php echo esc_html( $featured_item['excerpt'] ); ?>
                    </p>
                <?php endif; ?>
                <div class="widget-test-4-comment-count">
                    <svg class="comment-icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14l4 4V4c0-1.1-.9-2-2-2z"/>
                    </svg>
                    <span><?php echo esc_html( $featured_item['comments'] ); ?></span>
                </div>
            </div>
        </div>

        <!-- 4 Sub-posts Grid -->
        <div class="widget-test-4-grid">
            <?php foreach ( $grid_items as $item ) : ?>
                <article class="widget-test-4-grid-item">
                    <div class="widget-test-4-thumb-wrap">
                        <a href="<?php echo esc_url( $item['link'] ); ?>">
                            <img src="<?php echo esc_url( $item['image'] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>" loading="lazy" />
                        </a>
                        <?php if ( ! empty( $item['has_camera'] ) ) : ?>
                            <div class="camera-badge" title="Bài viết có hình ảnh">
                                <svg viewBox="0 0 24 24" fill="currentColor" width="14" height="14">
                                    <path d="M9 2L7.17 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2h-3.17L15 2H9zm3 15c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </div>
                        <?php endif; ?>
                    </div>
                    <h4 class="widget-test-4-item-title">
                        <a href="<?php echo esc_url( $item['link'] ); ?>">
                            <?php echo esc_html( $item['title'] ); ?>
                        </a>
                    </h4>
                    <div class="widget-test-4-comment-count">
                        <svg class="comment-icon" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14l4 4V4c0-1.1-.9-2-2-2z"/>
                        </svg>
                        <span><?php echo esc_html( $item['comments'] ); ?></span>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</div>
