<?php
function crtdiu_comment( $comment, $args, $depth ) {
    if ( 'div' === $args['style'] ) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }

    $classes = ' ' . comment_class( empty( $args['has_children'] ) ? 'comments__children' : 'comments__parent', null, null, false );
    ?>

    <<?php echo $tag, $classes; ?> id="comment-<?php comment_ID() ?>">
    <?php if ( 'div' != $args['style'] ) { ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comments__body"><?php
    } ?>

    <div class="comments__avatar vcard">

        <?php
        if ( $args['avatar_size'] != 0 ) {
            echo get_avatar( $comment, $args['avatar_size'],null,null,['class'=> 'comments__avatar-img'] );
        }
        ?>
    </div>
    <div class="comments__data">
        <div class="comments__info">
            <span class="comments__author"><?= get_comment_author_link()?></span>
            <div class="meta comments__meta">
                <span class="meta__field comments__meta-date"><?= get_comment_date(). ' в '. get_comment_time()?></span>
            </div>
        </div>
        <div class="comments__content">
            <?php comment_text(); ?>
        </div>
    </div>

    <?php if ( 'div' != $args['style'] ) { ?>
        </div>
    <?php }
}