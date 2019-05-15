<?php

if ( ! is_active_sidebar( 'footer' ) ) {
    return;
} ?>

<div class="footer-sidebar">
    <?php dynamic_sidebar('footer')?>
</div>
