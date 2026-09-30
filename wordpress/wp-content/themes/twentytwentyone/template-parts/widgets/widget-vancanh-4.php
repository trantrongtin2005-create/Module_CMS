<?php
/**
 * Widget ASEAN Cup Grid Component (Widget 3 - Văn Cảnh)
 * Displays ASEAN Cup banner layout with 1 featured post and 4 grid posts.
 */

// Query latest 5 posts for ASEAN Cup section
$vancanh_query = new WP_Query( array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 5,
    'orderby'        => 'date',
    'order'          => 'DESC',
) );

$vancanh_posts = $vancanh_query->get_posts();
wp_reset_postdata();

// Nav categories for ASEAN Cup header
$asean_categories = array(
    array( 'name' => 'Tin tức', 'link' => '#' ),
    array( 'name' => 'Lịch thi đấu', 'link' => '#' ),
    array( 'name' => 'Bảng xếp hạng', 'link' => '#' ),
);

// Fallback items matching ASEAN Cup grid layout
$fallback_grid_posts = array(
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

$featured_item = null;
$grid_items = array();

if ( ! empty( $vancanh_posts ) ) {
    $first_p = $vancanh_posts[0];
    $feat_img = get_the_post_thumbnail_url( $first_p->ID, 'large' );
    $featured_item = array(
        'title'    => get_the_title( $first_p->ID ),
        'excerpt'  => has_excerpt( $first_p->ID ) ? get_the_excerpt( $first_p->ID ) : wp_trim_words( strip_tags( $first_p->post_content ), 20, '...' ),
        'comments' => get_comments_number( $first_p->ID ),
        'image'    => $feat_img ? $feat_img : $fallback_grid_posts[0]['image'],
        'link'     => get_permalink( $first_p->ID ),
    );

    for ( $i = 1; $i < 5; $i++ ) {
        if ( isset( $vancanh_posts[$i] ) ) {
            $p = $vancanh_posts[$i];
            $img = get_the_post_thumbnail_url( $p->ID, 'medium' );
            $grid_items[] = array(
                'title'    => get_the_title( $p->ID ),
                'comments' => get_comments_number( $p->ID ),
                'image'    => $img ? $img : $fallback_grid_posts[$i]['image'],
                'has_camera' => ($i === 2),
                'link'     => get_permalink( $p->ID ),
            );
        } else {
            $grid_items[] = $fallback_grid_posts[$i];
        }
    }
} else {
    $featured_item = $fallback_grid_posts[0];
    $grid_items = array_slice( $fallback_grid_posts, 1 );
}
?>

<div class="widget-vancanh-4">
    <div class="vancanh-grid-container">
        <!-- Top Gradient Ribbon -->
        <div class="vancanh-top-bar"></div>

        <!-- Header -->
        <div class="vancanh-header">
            <div class="vancanh-logo">
                <svg class="vancanh-cup-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path>
                    <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path>
                    <path d="M4 22h16"></path>
                    <path d="M10 14.66V17c0 .55-.45 1-1 1H7v2h10v-2h-2c-.55 0-1-.45-1-1v-2.34"></path>
                    <path d="M18 4H6v7a6 6 0 0 0 12 0V4z"></path>
                </svg>
                <div class="vancanh-brand-text">
                    <span class="brand-title">ASEAN CUP</span>
                    <span class="brand-year">2026</span>
                </div>
            </div>
            <nav class="vancanh-nav">
                <?php foreach ( $asean_categories as $index => $cat_item ) : ?>
                    <a href="<?php echo esc_url( $cat_item['link'] ); ?>" class="nav-item <?php echo $index === 0 ? 'active' : ''; ?>">
                        <?php echo esc_html( $cat_item['name'] ); ?>
                    </a>
                <?php endforeach; ?>
            </nav>
        </div>

        <!-- Content Area -->
        <div class="vancanh-content">
            <!-- Featured Article -->
            <div class="vancanh-featured">
                <div class="vancanh-featured-img-wrap">
                    <a href="<?php echo esc_url( $featured_item['link'] ); ?>">
                        <img src="<?php echo esc_url( $featured_item['image'] ); ?>" alt="<?php echo esc_attr( $featured_item['title'] ); ?>" loading="lazy" />
                    </a>
                </div>
                <div class="vancanh-featured-info">
                    <h3 class="vancanh-featured-title">
                        <a href="<?php echo esc_url( $featured_item['link'] ); ?>">
                            <?php echo esc_html( $featured_item['title'] ); ?>
                        </a>
                    </h3>
                    <?php if ( ! empty( $featured_item['excerpt'] ) ) : ?>
                        <p class="vancanh-featured-excerpt">
                            <?php echo esc_html( $featured_item['excerpt'] ); ?>
                        </p>
                    <?php endif; ?>
                    <div class="vancanh-comment-count">
                        <svg class="comment-icon" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14l4 4V4c0-1.1-.9-2-2-2z"/>
                        </svg>
                        <span><?php echo esc_html( $featured_item['comments'] ); ?></span>
                    </div>
                </div>
            </div>

            <!-- 4 Grid Sub-articles -->
            <div class="vancanh-grid">
                <?php foreach ( $grid_items as $item ) : ?>
                    <article class="vancanh-grid-item">
                        <div class="vancanh-thumb-wrap">
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
                        <h4 class="vancanh-item-title">
                            <a href="<?php echo esc_url( $item['link'] ); ?>">
                                <?php echo esc_html( $item['title'] ); ?>
                            </a>
                        </h4>
                        <div class="vancanh-comment-count">
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
