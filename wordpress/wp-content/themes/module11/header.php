<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="module11-shell">
    <header class="module11-site-header">
        <a class="module11-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <h1><?php bloginfo( 'name' ); ?></h1>
            <p class="module11-tagline"><?php bloginfo( 'description' ); ?></p>
        </a>
    </header>
    <nav class="module11-nav" aria-label="Primary navigation">
        <?php
        wp_nav_menu(
            array(
                'theme_location' => 'primary',
                'fallback_cb'    => function () {
                    echo '<ul><li><a href="' . esc_url( home_url( '/' ) ) . '">Trang chủ</a></li></ul>';
                },
            )
        );
        ?>
    </nav>
