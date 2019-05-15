<?php

if ( ! is_active_sidebar( 'home' ) ) {
    return;
} ?>

<div class="main-sidebar">
    <div class="content">
        <div class="sidebar">
            <?php dynamic_sidebar('home')?>
        </div>
    </div>
</div>
