<?php

class CRTDIU_Widget_Kuzbass extends WP_Widget {

    public function __construct() {
        $widget_ops = array(
            'classname' => 'crtdiu_widget_kuzbass',
            'description' => 'Заявка на запись в объединение'
        );
        parent::__construct( 'crtdiu_kuzbass', 'ЦРТДиЮ 300 лет Кузбассу', $widget_ops );
    }

    public function widget( $args, $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';

        $title = apply_filters( 'widget_title', $title);

        echo $args['before_widget'];
//        if ( $title ) {
//            echo $args['before_title'] . $title . $args['after_title'];
//        }
        echo '<c-timer template-directory="'.get_template_directory_uri().'" timer-title="'.$title.'"></c-timer>';

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
        ));
        list('title' => $title) = $instance;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('Заголовок виджета'); ?>">
                <?php _e('Title:'); ?>
                <input class="widefat"
                       id="<?php echo $this->get_field_id('title'); ?>"
                       name="<?php echo $this->get_field_name('title'); ?>"
                       type="text"
                       value="<?php echo esc_attr($title); ?>" />
            </label>
        </p>
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
            'title' => '',
        ));
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        return $instance;
    }

}
