<?php
if ( is_home() || is_front_page() || is_archive() || is_search() || is_single() || is_page() ) {
    get_template_part( 'template-parts/widgets/widget-test-4' );
}
?>
    <footer class="module11-footer">
        <p><?php echo esc_html( get_bloginfo( 'name' ) ); ?> &copy; <?php echo esc_html( wp_date( 'Y' ) ); ?></p>
    </footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
