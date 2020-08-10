<?php
  /*
    Plugin Name: champlainroofing_custom_gallery
    Plugin URI: https://champlainroofing.com/
    Description: Custom plugin for champlainroofing site
    Version: 1
    Author: Robert Torres
    Author URI: https://robetorr.net
  */
  function champlainroofing_custom_gallery_install(){
    global $wpdb;
    $content_image = $wpdb->prefix . "content_image";
    $sql1 = "CREATE TABLE $content_image( id int(11) NOT NULL, content text NOT NULL, title text NOT NULL, category int(11) NOT NULL, gallery_post_id int(11) NOT NULL, image_url text NOT NULL, filename text NOT NULL, post_id int(11), post_name text, guid text) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $sql2= "ALTER TABLE $table_owner ADD PRIMARY KEY(id);";
    $sql3="ALTER TABLE $table_owner MODIFY id INT(11) NOT NULL AUTO_INCREMENT;";
    $wpdb->query($sql1);
    $wpdb->query($sql2);
    $wpdb->query($sql3);
  }
  function champlainroofing_custom_gallery_uninstall(){
    global $wpdb;
    $content_image = $wpdb->prefix . "content_image";
    $sql1 = "DROP TABLE $content_image;";
    $wpdb->query($sql1);
  }
  function champlainroofing_custom_gallery_general_settings(){
    global $wpdb;
    $table_category= $wpdb->prefix . "terms";
    $results_category = $wpdb->get_results("SELECT * FROM $table_category;");
    include("templates/general_settings_template.php");
  }
  /**********************************************************************
  Ajax functions section
  ***********************************************************************/
  function show_by(){
    global $wpdb;
    $user_id = wp_get_current_user()->ID;
    $category = $_POST['category'];
    $content_image = $wpdb->prefix . "content_image";
    if(empty($category)){
      $results_gallery = $wpdb->get_results("SELECT * FROM $content_image;");

    }
    else{
      $results_gallery = $wpdb->get_results("SELECT * FROM $content_image where category=$category;");
    }
 	include("templates/show_by_gallery_template.php");
    wp_die();
  }
  function save_page(){
    global $wpdb;
    $user_id = wp_get_current_user()->ID;
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $image_url = $_POST['image_url'];
    $image_id = $_POST['image_id'];
    $image_filename = $_POST['image_filename'];
    $content_image = $wpdb->prefix . "content_image";
    $data_content= array(    
      'title' => $title,
      'content' => $content,
      'category' => $category,
      'image_url' => $image_url,
      'gallery_post_id' => $image_id,
      'filename' => $image_filename);
    $contents='<img src="'.$image_url.'" />';
    $format_content = array('%s','%s','%d','%s','%d','%s');
    $wpdb->insert($content_image,$data_content,$format_content);
    $my_id = $wpdb->insert_id;
    if($my_id>0){
      $my_post = array(
        'post_author'           => $user_id,
        'post_content'          => $contents.$content,
        'post_title'            => $title,
        'post_status'           => 'publish',
        'post_type'             => 'page',
        'post_parent'           => 0,
        'menu_order'            => 0,
        'import_id'             => 0,
      );
      $post_id = wp_insert_post( $my_post );
      if ( ! is_wp_error( $post_id ) ) {
        $table_post= $wpdb->prefix . "posts";
        $results_posts = $wpdb->get_results("SELECT * FROM $table_post WHERE ID=$post_id;");
        foreach ($results_posts as $key_post) {
          $post_name= $key_post->post_name;
          $guid= $key_post->guid;
      	$sql="UPDATE $content_image SET post_id=$post_id, post_name='$post_name', guid='$guid' WHERE id=$my_id;";
        $wpdb->query($sql);          
        }
      }
      echo $my_id;
    } 	
    wp_die();
  }
  function custom_gallery(){
    global $wpdb;
    $table_category= $wpdb->prefix . "terms";
    $results_category = $wpdb->get_results("SELECT * FROM $table_category;");
    $content_image = $wpdb->prefix . "content_image";
    $results_gallery = $wpdb->get_results("SELECT * FROM $content_image;");
    include("templates/custom_gallery_template.php");
  }
  /**********************************************************************
  End section
  ***********************************************************************/  
  /**********************************************************************
  Functions for Add Action Section 
  **********************************************************************/
  function validates_load_scripts() {
    wp_enqueue_script( "jquery-validate", plugin_dir_url( __FILE__ ) . 'templates/assets/js/jquery.validate.js', array( 'jquery' ) );
  }  
  function ckeditor_load_scripts(){
  	wp_enqueue_script( "ckeditor", plugin_dir_url( __FILE__ ) . '/templates/assets/ckeditor/ckeditor.js', array( 'jquery' ) );  
  }
  function champlainroofing_custom_gallery_add_menu(){   
    if (function_exists('add_options_page')) {
      add_options_page('Champlainroofing Custom Gallery - General Settings', 'Champlainroofing Custom Gallery general settings', 8, basename(__FILE__), 'champlainroofing_custom_gallery_general_settings');
    }
  }
  function dcms_insert_script_upload(){
    wp_enqueue_media();
    wp_register_script('my_upload', plugin_dir_url( __FILE__ ).'/templates/assets/js/uploader.js', array('jquery'), '1', true );
    wp_enqueue_script('my_upload');
  }

  /**********************************************************************
  End section
  ***********************************************************************/ 
  /**********************************************************************
  Short code Section
  **********************************************************************/
  add_shortcode( 'cr_gallery', 'show_gallery_shortcode' );
  function show_gallery_shortcode() {
    ob_start();
    custom_gallery();
    return ob_get_clean();
  }  
  /**********************************************************************
  End section
  ***********************************************************************/    
  /*************************************************************************
  add_action Section 
  **************************************************************************/
  add_action("admin_enqueue_scripts", "dcms_insert_script_upload");
  add_action( 'admin_head', 'ckeditor_load_scripts');
  add_action('admin_head', 'validates_load_scripts');
  if (function_exists('add_action')) {
    add_action('admin_menu', 'champlainroofing_custom_gallery_add_menu');
  }
  add_action('wp_ajax_save_page', 'save_page');
  add_action( 'wp_ajax_nopriv_save_page', 'save_page' );
  add_action('wp_ajax_show_by', 'show_by');
  add_action( 'wp_ajax_nopriv_show_by', 'show_by' );
  add_action('activate_champlainroofing_custom_gallery/champlainroofing_custom_gallery.php','champlainroofing_custom_gallery_install');
  add_action('deactivate_champlainroofing_custom_gallery/champlainroofing_custom_gallery.php', 'champlainroofing_custom_gallery_uninstall');