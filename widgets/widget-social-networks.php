<?php

class CRTDIU_Widget_Social_Networks extends WP_Widget {

    public function __construct() {
        $widget_ops = array(
            'classname' => 'crtdiu_widget_social_networks',
            'description' => 'Ссылки на социальные сети'
        );
        parent::__construct( 'crtdiu_social_networks', 'ЦРТДиЮ Социальные сети', $widget_ops );
    }

    public function widget( $args, $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';

        $title = apply_filters( 'widget_title', $title);

        echo $args['before_widget'];
        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        list('vk' => $vk, 'ok' => $ok,'inst' => $inst) = $instance;

        $content = '<ul class="widget__social-networks widget-social-networks menu menu--main menu--vertical">';
        if(!empty($vk)){
            $content .= '<li class="widget-social-networks__li menu-node"><a class="widget-social-networks__href widget-social-networks__href--vk" href="'.$vk.'">ВКонтакте<i class="widget-social-networks__icon fab fa-vk"></i></a></li>';
        }
        if(!empty($ok)){
            $content .= '<li class="widget-social-networks__li menu-node"><a class="widget-social-networks__href widget-social-networks__href--ok" href="'.$ok.'">Одноклассники<i class="widget-social-networks__icon fab fa-odnoklassniki"></i></a></li>';
        }
        if(!empty($inst)){
            $content .= '<li class="widget-social-networks__li menu-node"><a class="widget-social-networks__href widget-social-networks__href--inst" href="'.$inst.'">Инстаграмм<i class="widget-social-networks__icon fab fa-instagram"></i></a></li>';
        }
        $content.='</ul>';

        echo $content;

        echo $args['after_widget'];
    }

    /**
     * Outputs the settings form for the Search widget.
     *
     * @since 2.8.0
     *
     * @param array $instance Current settings.
     */
    public function form( $instance ) {
        $instance = wp_parse_args((array) $instance, array(
            'title' => '',
            'vk' => '',
            'ok' => '',
            'inst' => '',
        ));
        list('title' => $title, 'vk' => $vk, 'ok' => $ok, 'inst' => $inst) = $instance;
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('vk'); ?>"><?php _e('Вконакте:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('vk'); ?>" name="<?php echo $this->get_field_name('vk'); ?>" type="url" value="<?php echo esc_attr($vk); ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('ok'); ?>"><?php _e('Одноклассники:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('ok'); ?>" name="<?php echo $this->get_field_name('ok'); ?>" type="url" value="<?php echo esc_attr($ok); ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('inst'); ?>"><?php _e('Инстраграмм:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('inst'); ?>" name="<?php echo $this->get_field_name('inst'); ?>" type="url" value="<?php echo esc_attr($inst); ?>" /></label></p>
        <?php
    }

    /**
     * Handles updating settings for the current Search widget instance.
     *
     * @since 2.8.0
     *
     * @param array $new_instance New settings for this instance as input by the user via
     *                            WP_Widget::form().
     * @param array $old_instance Old settings for this instance.
     * @return array Updated settings.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $new_instance = wp_parse_args((array) $new_instance, array(
            'title' => 'Социальные сети',
            'vk' => '',
            'ok' => '',
            'inst' => '',
        ));
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['vk'] = sanitize_text_field( $new_instance['vk'] );
        $instance['ok'] = sanitize_text_field( $new_instance['ok'] );
        $instance['inst'] = sanitize_text_field( $new_instance['inst'] );
        return $instance;
    }

}
