<?php
/*
Plugin Name: SOGO Author's Recent Posts
Plugin URI: http://ohav.co.il/plugins/oh-author-recent-post
Description: Display Author's recent post
Version: 1.8
Author: Sogo
Author URI: http://ohav.co.il
Author Email: info@ohav.co.il
License:

  Copyright 2011 OH Recent Entries (info@ohav.co.il)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


class OH_Author_Recent_Entries extends WP_Widget {
    private $plugin_name , $plugin_slug, $loc;
	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/
	
	/**
	 * The widget constructor. Specifies the classname and description, instantiates
	 * the widget, loads localization files, and includes necessary scripts and
	 * styles.
	 */
	function OH_Author_Recent_Entries() {

    // Define constants used throughout the plugin
    $this->init_plugin_constants();
        load_textdomain($this->loc, dirname( __FILE__  ) . '/lang/'. get_locale() .'.mo' );
		$widget_opts = array (
			'classname' => $this->plugin_slug,
			'description' => __("This is a simple plugin, that allows you to choose one of your blog's authors (or a random pick),and display its latest posts (as many posts as you'dd like).", $this->loc)
		);	
		
		$this->WP_Widget($this->plugin_slug, __($this->plugin_name, $this->loc), $widget_opts);

		
    // Load JavaScript and stylesheets
    $this->register_scripts_and_styles(); //no need for that
		
	} // end constructor

	/*--------------------------------------------------*/
	/* API Functions
	/*--------------------------------------------------*/
	
	/**
	 * Outputs the content of the widget.
	 *
	 * @args			The array of form elements
	 * @instance
	 */
	function widget($args, $instance) {

		extract($args, EXTR_SKIP);

		echo $before_widget;

        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        $text =  empty($instance['text']) ? '' : $instance['text'];
        $post_type =  empty($instance['post_type']) ? '' : $instance['post_type'];
        $author =  empty($instance['author']) ? 'rand' : $instance['author'];
        $rand =  empty($instance['rand']) ? '' : $instance['rand'];
        $link =  empty($instance['link']) ? '' : $instance['link'];
        $link_text =  empty($instance['link_text']) ? '' : $instance['link_text'];
        if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
            $number = 2;
        $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
        $show_excerpt = isset( $instance['show_excerpt'] ) ? $instance['show_excerpt'] : false;
        $limit_words = isset( $instance['limit_words'] ) ? $instance['limit_words'] : 0;

        if($author == -1){
            $user = $this->get_rand_author();
        }else{
            $user = get_user_by('id', $author);
        }



        $r = new WP_Query( apply_filters( 'widget_posts_args',
            array(
                'post_type'=> $post_type,
                'posts_per_page' => $number,
                'author' => $user->ID,
                'no_found_rows' => true,
                'post_status' => 'publish',
                'ignore_sticky_posts' => true )
        ) );

        include(dirname(__FILE__) . '/views/widget.php');



		
		echo $after_widget;
		
	} // end widget


    private function get_rand_author(){
        $users = get_users('blog_id=1&orderby=nicename&role=author');
        if($users){
            $rand_key = array_rand($users);
            return $users[$rand_key];
        }
        return false;
    }
	/**
	 * Processes the widget's options to be saved.
	 *
	 * @new_instance	The previous instance of values before the update.
	 * @old_instance	The new instance of values to be generated via the update.
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
        $instance['title'] = strip_tags(stripslashes($new_instance['title']));
        $instance['text'] = strip_tags(stripslashes($new_instance['text']));
        $instance['post_type'] = strip_tags(stripslashes($new_instance['post_type']));
        $instance['author'] = strip_tags(stripslashes($new_instance['author']));
        $instance['rand'] = strip_tags(stripslashes($new_instance['rand']));
        $instance['show_excerpt'] = strip_tags(stripslashes($new_instance['show_excerpt']));
        $instance['limit_words'] = strip_tags(stripslashes($new_instance['limit_words']));
        $instance['link'] = strip_tags(stripslashes($new_instance['link']));
        $instance['link_text'] = strip_tags(stripslashes($new_instance['link_text']));
        $instance['show_date'] = strip_tags(stripslashes($new_instance['show_date']));
        $instance['number'] = strip_tags(stripslashes($new_instance['number']));





		return $instance;
		
	} // end widget
	
	/**
	 * Generates the administration form for the widget.
	 *
	 * @instance	The array of keys and values for the widget.
	 */
	function form($instance) {
	
		$instance = wp_parse_args(
			(array)$instance,
			array(
                'title' => '',
				'text' => '',
			    'post_type' => '',
			    'author' => '',
                'rand' => '',
                'show_excerpt' => '',
                'limit_words' => '',
                'number' => '',
                'link' => '',
                'link_text' => '',
                'show_date' => '',

			)
		);
    
    $title = strip_tags(stripslashes($instance['title']));
    $text = strip_tags(stripslashes($instance['text']));
    $post_type = strip_tags(stripslashes($instance['post_type']));
    $author = strip_tags(stripslashes($instance['author']));
    $rand = (bool)strip_tags(stripslashes($instance['rand']));
    $link = strip_tags(stripslashes($instance['link']));
    $link_text = strip_tags(stripslashes($instance['link_text']));
    $show_excerpt = ( bool )strip_tags(stripslashes($instance['show_excerpt']));
    $limit_words = strip_tags(stripslashes($instance['limit_words']));
    $show_date = ( bool )strip_tags(stripslashes($instance['show_date']));
    $number = strip_tags(stripslashes($instance['number']));


	// Display the admin form
    include(dirname(__FILE__) . '/views/admin.php');
		
	} // end form
	
	/*--------------------------------------------------*/
	/* Private Functions
	/*--------------------------------------------------*/
	
  /**
   * Initializes constants used for convenience throughout 
   * the plugin.
   */
  private function init_plugin_constants() {
      $this->loc =  'oh' ;
      $this->plugin_name =  'OH Author Recent Post';
      $t = __('OH Author Recent Post', $this->loc ); // we do that so the poedit will scan this
      $this->plugin_slug = 'oh_author_recent_post';
    
  
 
  
  } // end init_plugin_constants
  
	/**
	 * Registers and enqueues stylesheets for the administration panel and the
	 * public facing site.
	 */
	private function register_scripts_and_styles() {
		if(is_admin()) {
			$this->load_file($this->plugin_name, 'css/admin.css');
		}

	} // end register_scripts_and_styles

	/**
	 * Helper function for registering and enqueueing scripts and styles.
	 *
	 * @name	The 	ID to register with WordPress
	 * @file_path		The path to the actual file
	 * @is_script		Optional argument for if the incoming file_path is a JavaScript source file.
	 */
	private function load_file($name, $file_path, $is_script = false) {
        $url = plugins_url($file_path , __FILE__);
        $file = dirname( __FILE__ ) . '/'. $file_path;
        if(file_exists($file)) {
            if($is_script) {
                wp_register_script($name, $url);
                wp_enqueue_script($name);
            } else {
                wp_register_style($name, $url);
                wp_enqueue_style($name);
            } // end if
        } // end if
    
	} // end load_file
	
} // end class
add_action('widgets_init', create_function('', 'register_widget("OH_Author_Recent_Entries");'));
?>