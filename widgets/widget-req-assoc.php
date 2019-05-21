<?php

class CRTDIU_Widget_Req_Assoc extends WP_Widget {

    public function __construct() {
        $widget_ops = array(
            'classname' => 'crtdiu_widget_req_assoc',
            'description' => 'Заявка на запись в объединение'
        );
        parent::__construct( 'crtdiu_req_assoc', 'ЦРТДиЮ Заявка на запись в объединение', $widget_ops );
    }

    public function widget( $args, $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';

        $title = apply_filters( 'widget_title', $title);

        echo $args['before_widget'];
        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        list('icon' => $icon, 'name' => $name, 'desc' => $desc) = $instance;

        echo '<c-assoc-rec-widget link-icon="'.$icon.'" link-name="'.$name.'" link-desc="'.$desc.'"></c-assoc-rec-widget>';

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
            'icon' => '',
            'name' => '',
            'desc' => '',
        ));
        list('title' => $title, 'name' => $name, 'desc' => $desc, 'icon' => $icon) = $instance;
        ?>
        <p><label for="<?php echo $this->get_field_id('Заголовок виджета'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('name'); ?>"><?php _e('Заголовок кнопки: (обязательно)'); ?> <input class="widefat" id="<?php echo $this->get_field_id('name'); ?>" name="<?php echo $this->get_field_name('name'); ?>" type="text" value="<?php echo esc_attr($name); ?>" required /></label></p>
        <p><label for="<?php echo $this->get_field_id('desc'); ?>"><?php _e('Описание: (обязательно)'); ?> <input class="widefat" id="<?php echo $this->get_field_id('desc'); ?>" name="<?php echo $this->get_field_name('desc'); ?>" type="text" value="<?php echo esc_attr($desc); ?>" required /></label></p>
        <p><label for="<?php echo $this->get_field_id('icon'); ?>"><?php _e('Иконка:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('icon'); ?>" name="<?php echo $this->get_field_name('icon'); ?>" type="text" value="<?php echo esc_attr($icon); ?>" required /></label></p>
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
            'icon' => '',
            'name' => '',
            'desc' => '',
        ));
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['icon'] = sanitize_text_field( $new_instance['icon'] );
        $instance['name'] = sanitize_text_field( $new_instance['name'] );
        $instance['desc'] = sanitize_text_field( $new_instance['desc'] );
        return $instance;
    }

}
