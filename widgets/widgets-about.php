<?php

class About_Widget extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        $widget_ops = array(
            'classname' => 'about_widget',
            'description' => 'My Widget is awesome',
        );
        parent::__construct( 'about_widget', 'My Widget', $widget_ops );
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        // outputs the content of the widget
        echo $args['before_widget'];
        if(!empty($instance['title'])){
            echo $args['before_title'] . apply_filters('widget_title',$instance['title']) . $args['after_title'];
        }
        echo $args['after_widget'];
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form( $instance ) {
        // outputs the options form on admin
        $title = !empty($instance['title']) ? $instance['title'] : 'New title';
        ?>
        <p>
            <label for="<?= esc_attr($this->get_field_id('title'));?>">
                Title
            </label>
            <input class="widefat" id="<?= esc_attr($this->get_field_id('title'))?>" name="<?= esc_attr($this->get_field_name('title'))?>" type="text" value="<?= esc_attr($title)?>">
        </p>
        <?php
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     *
     * @return array
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';

        return $instance;
    }
}