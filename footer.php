    <div class="wrapper__footer">
        <footer class="footer">
            <div class="wrapper__block footer-main__wrapper">
                <div class="container">
                    <div class="block footer__main">
                        <div class="content">
                            <?php get_sidebar('footer')?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrapper__block footer-bottom__wrapper">
                <div class="container">
                    <div class="block footer__bottom">
                        <?php echo get_theme_mod('footer_my_desc')?>
<!--                        --><?//= get_bloginfo('name') .' '. get_bloginfo('description'). ' © '. date('Y')?>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    </div>
</main>
<?php wp_footer(); ?>
</body>
</html>
