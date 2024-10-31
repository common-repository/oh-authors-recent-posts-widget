<div class="wrapper">

    <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:',$this->loc); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

    <p><label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Text:',$this->loc ); ?></label>
        <textarea class="widefat" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" ><?php echo $text; ?></textarea>

    <p><label for="<?php echo $this->get_field_id( 'post_type' ); ?>"><?php _e( 'Post Type:',$this->loc ); ?></label>
        <select class="widefat" id="<?php echo $this->get_field_id( 'post_type' ); ?>" name="<?php echo $this->get_field_name( 'post_type' ); ?>" >
            <?php   $args = array(
                'public'   => true
            );

            $output = 'object'; // names or objects, note names is the default
            $post_types = get_post_types( $args, $output );

            foreach ( $post_types  as $obj ) {
                echo '<option value="'.$obj->name.'" '. selected($post_type,$obj->name, false ) .'>' . __($obj->name,$this->loc) . '</option>';
            }
            ?>
        </select> </p>
    <p>
     <label for="<?php echo $this->get_field_id( 'author' ); ?>"><?php _e( 'select author',$this->loc ); ?></label>
    <?php

        $args = array(
            'show_option_none'       => 'rand',
            'orderby'                 => 'display_name',
            'order'                   => 'ASC',
            'show'                    => 'display_name',
            'echo'                    => true,
            'selected'                => $author,
            'name'                    => $this->get_field_name( 'author' ), // string
            'who'                     => 'authors' // string

        );
        wp_dropdown_users( $args );

    ?>
    </p>

    <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
        <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

    <p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date',$this->loc ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>
    <p>
        <input class="checkbox" type="checkbox" <?php checked( $show_excerpt ); ?> id="<?php echo $this->get_field_id( 'show_excerpt',$this->loc ); ?>" name="<?php echo $this->get_field_name( 'show_excerpt' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'show_excerpt' ); ?>"><?php _e( 'Display excerpt?',$this->loc ); ?></label>
        <input size="3" class="text" type="text" value="<?php echo $limit_words; ?>"  id="<?php echo $this->get_field_id( 'limit_words',$this->loc ); ?>" name="<?php echo $this->get_field_name( 'limit_words' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'limit_words' ); ?>"><?php _e( 'Limit words',$this->loc ); ?></label>
    </p>

    <p><label for="<?php echo $this->get_field_id( 'link_text' ); ?>"><?php _e( 'Link Text:' ,$this->loc); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'link_text',$this->loc ); ?>" name="<?php echo $this->get_field_name( 'link_text' ); ?>" type="text" value="<?php echo $link_text; ?>" /></p>
          <input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo $link; ?>" /></p>


</div><!-- /wrapper -->