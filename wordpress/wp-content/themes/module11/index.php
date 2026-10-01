<?php get_header(); ?>

<main class="module11-main">
    <aside class="module11-panel module11-archive">
        <h2><?php esc_html_e( 'Archives', 'module11' ); ?></h2>
        <div class="module11-panel-body">
            <?php if ( wp_count_posts( 'post' )->publish > 0 ) : ?>
                <ul><?php wp_get_archives( array( 'type' => 'monthly', 'show_post_count' => true ) ); ?></ul>
            <?php else : ?>
                <p class="module11-empty"><?php esc_html_e( 'Chưa có bài viết.', 'module11' ); ?></p>
            <?php endif; ?>
        </div>
    </aside>

    <section class="module11-content" aria-labelledby="module11-content-title">
        <h2 id="module11-content-title" class="module11-content-title"><?php esc_html_e( 'Xem nhiều', 'module11' ); ?></h2>
        <?php
        $module11_posts = new WP_Query(
            array(
                'post_type'           => 'post',
                'post_status'         => 'publish',
                'posts_per_page'      => 8,
                'ignore_sticky_posts' => true,
            )
        );
        ?>
        <?php if ( $module11_posts->have_posts() ) : ?>
            <div class="module11-posts">
                <?php $module11_number = 1; ?>
                <?php while ( $module11_posts->have_posts() ) : $module11_posts->the_post(); ?>
                    <article class="module11-post">
                        <h3>
                            <span><?php echo esc_html( $module11_number ); ?>. </span>
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <div class="module11-post-meta"><?php echo esc_html( get_the_date() ); ?></div>
                        <div class="module11-post-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></div>
                    </article>
                    <?php $module11_number++; ?>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <p class="module11-empty"><?php esc_html_e( 'Chưa có bài viết để hiển thị.', 'module11' ); ?></p>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </section>

    <aside class="module11-panel module11-comments">
        <h2><?php esc_html_e( 'Comments', 'module11' ); ?></h2>
        <div class="module11-panel-body">
            <?php
            $module11_comments = get_comments(
                array(
                    'number'  => 6,
                    'status'  => 'approve',
                    'post_status' => 'publish',
                )
            );
            ?>
            <?php if ( $module11_comments ) : ?>
                <ul>
                    <?php foreach ( $module11_comments as $module11_comment ) : ?>
                        <li>
                            <span class="module11-comment-author"><?php echo esc_html( $module11_comment->comment_author ); ?></span>
                            <?php esc_html_e( ' trên ', 'module11' ); ?>
                            <a href="<?php echo esc_url( get_comment_link( $module11_comment ) ); ?>"><?php echo esc_html( get_the_title( $module11_comment->comment_post_ID ) ); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p class="module11-empty"><?php esc_html_e( 'Chưa có bình luận.', 'module11' ); ?></p>
            <?php endif; ?>
        </div>
    </aside>
</main>

<?php get_footer(); ?>
