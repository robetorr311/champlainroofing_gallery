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
    $category_location = $wpdb->prefix . "category_location";
    $sql1 = "CREATE TABLE $content_image( id int(11) NOT NULL, content text NOT NULL, title text NOT NULL, category int(11) NOT NULL, gallery_post_id int(11) NOT NULL, image_url text NOT NULL, filename text NOT NULL, post_id int(11), post_name text, guid text) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $sql2= "ALTER TABLE $content_image ADD PRIMARY KEY(id);";
    $sql3="ALTER TABLE $content_image MODIFY id INT(11) NOT NULL AUTO_INCREMENT;";
    $sql4 = "CREATE TABLE $category_location( id int(11) NOT NULL, name text NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $sql5= "ALTER TABLE $category_location ADD PRIMARY KEY(id);";
    $sql6="ALTER TABLE $category_location MODIFY id INT(11) NOT NULL AUTO_INCREMENT;";    
    $wpdb->query($sql1);
    $wpdb->query($sql2);
    $wpdb->query($sql3);
    $wpdb->query($sql4);
    $wpdb->query($sql5);
    $wpdb->query($sql6);
  }
  function champlainroofing_custom_gallery_uninstall(){
    global $wpdb;
    $content_image = $wpdb->prefix . "content_image";
    $sql1 = "DROP TABLE $content_image;";
    $wpdb->query($sql1);
  }
  function champlainroofing_custom_gallery_general_settings(){
    global $wpdb;
    $table_category= $wpdb->prefix . "category_location";
    $content_image = $wpdb->prefix . "content_image";
    $results_category = $wpdb->get_results("SELECT * FROM $table_category;");
    $results_categories = $wpdb->get_results("SELECT * FROM $table_category;");
    $results_locations = $wpdb->get_results("SELECT * FROM $content_image;");
    include("templates/general_settings_template.php");
    include("templates/locations_template.php");
  }
  function get_category_name($id){
    global $wpdb;
    $output="";
    $table_category= $wpdb->prefix . "category_location";
    $results_category = $wpdb->get_results("SELECT * FROM $table_category where id=$id;");
    foreach ($results_category as $key) {
      $output=$key->name;
    }
    return $output;    
  }
  /**********************************************************************
  Ajax functions section
  ***********************************************************************/
  function save_cat(){
    global $wpdb;
    $location = $_POST['category'];
    $category_location = $wpdb->prefix . "category_location";
    $data_category_location= array(    
      'name' => $location);
    $format_location = array('%s');
    $wpdb->insert($category_location,$data_category_location,$format_location);
    $my_id = $wpdb->insert_id;
    wp_die();
  }
  function delete_category(){
    global $wpdb;
    $id = $_POST['id'];
    $category_location = $wpdb->prefix . "category_location";
    $sql="DELETE from $category_location WHERE id=$id;";
    $wpdb->query($sql);
    wp_die();
  }  
  function delete_page(){
    global $wpdb;
    $id = $_POST['id'];
    $content_image = $wpdb->prefix . "content_image";
    $posts = $wpdb->prefix . "posts";
    $results_locations = $wpdb->get_results("SELECT * FROM $content_image where id=$id;");
    foreach ($results_locations as $key) {
      $post_id=$key->post_id;
      $gallery_post_id=$key->gallery_post_id;
    }
    if(!empty($post_id)){
      wp_delete_post($post_id,true);
    }
    if(!empty($gallery_post_id)){
      wp_delete_post($gallery_post_id,true);
    }
    $sql="DELETE from $content_image WHERE id=$id;";
    $wpdb->query($sql);
    wp_die();
  }
  function edit_category(){
    global $wpdb;
    $id = $_POST['id'];
    $category_location = $wpdb->prefix . "category_location";
    $results_locations = $wpdb->get_results("SELECT * FROM $category_location where id=$id;");
    foreach ($results_locations as $key) {
      $id=$key->id;
      $name=$key->name;
    }
    $output=$id.'|'.$name;
    echo $output;
    wp_die();
  }
  function edit_page(){
    global $wpdb;
    $id = $_POST['id'];
    $content_image = $wpdb->prefix . "content_image";
    $results_locations = $wpdb->get_results("SELECT * FROM $content_image where id=$id;");
    foreach ($results_locations as $key) {
      $content_id=$key->id;
      $content=$key->content;
      $title=$key->title;
      $category=$key->category;
      $gallery_post_id=$key->gallery_post_id;
      $image_url=$key->image_url;
      $filename=$key->filename;
      $post_id=$key->post_id;
      $postname=$key->postname;
      $guid=$key->guid;                        
    }
    $category_location = $wpdb->prefix . "category_location";
    $results_locations = $wpdb->get_results("SELECT * FROM $category_location where id=$category;");
    foreach ($results_locations as $key) {
      $category_name=$key->name;
    }
    $results_category = $wpdb->get_results("SELECT * FROM $category_location;");
    include("templates/edit_template.php");
    wp_die();
  }  
  function update_category(){
    global $wpdb;
    $id = $_POST['id'];
    $category=$_POST['category'];
    $category_location = $wpdb->prefix . "category_location";
    $wpdb->query("UPDATE $category_location set name='$category' where id=$id;");
    wp_die();
  }     
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
    $contents='<div class="page-main-content"><div class="vc_row vc_row-outer vc_row-fluid"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="tm-heading  center tm-animation move-up animate"><h1 class="heading" style="text-align:center; padding-bottom:10px; color: #073763;">Champlain Roofing Gallery</h1></div></div></div><div class="vc_row vc_row-outer vc_row-fluid"><div class="wpb_column vc_column_container vc_col-sm-6"><div class="vc_column-inner">';
    $contents.='<img src="'.$image_url.'" />';
    $contents.='</div></div><div class="wpb_column vc_column_container vc_col-sm-6"><div class="vc_column-inner" style="background-color:#073763; color:#ffffff;">';
    $contents.='<h5 class="heading" style="font-size:23px; background-color:#073763; color:#ffffff;">'.$title.'</h5><div class="text" style="background-color:#073763; color:#ffffff; font-size:21px;">'.$content.'</div></div></div></div></div><style type="text/css">.page-title-bar-inner{ display : none; }</style>';
    
    $format_content = array('%s','%s','%d','%s','%d','%s');
    $wpdb->insert($content_image,$data_content,$format_content);
    $my_id = $wpdb->insert_id;
    if($my_id>0){
      $my_post = array(
        'post_author'           => $user_id,
        'post_content'          => $contents,
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
  function update_page(){
    global $wpdb;
    $user_id = wp_get_current_user()->ID;
    $id=$_POST['id'];
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
    $contents='<div class="page-main-content"><div class="vc_row vc_row-outer vc_row-fluid"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="tm-heading  center tm-animation move-up animate"><h1 class="heading" style="text-align:center; padding-bottom:10px; color: #073763;">Champlain Roofing Gallery</h1></div></div></div><div class="vc_row vc_row-outer vc_row-fluid"><div class="wpb_column vc_column_container vc_col-sm-6"><div class="vc_column-inner">';
    $contents.='<img src="'.$image_url.'" />';
    $contents.='</div></div><div class="wpb_column vc_column_container vc_col-sm-6"><div class="vc_column-inner" style="background-color:#073763; color:#ffffff;">';
    $contents.='<h5 class="heading" style="font-size:23px; background-color:#073763; color:#ffffff;">'.$title.'</h5><div class="text" style="background-color:#073763; color:#ffffff; font-size:21px;">'.$content.'</div></div></div></div></div><style type="text/css">.page-title-bar-inner{ display : none; }</style>';
    $format_content = array('%s','%s','%d','%s','%d','%s');
    $where = array ('id' => $id);
    $wpdb->update( $content_image, $data_content, $where, $format_content );
    $results_posts = $wpdb->get_results("SELECT * FROM $content_image WHERE id=$id;");
    foreach ($results_posts as $key_post) {
      $post_id=$key_post->post_id;
    }
    $my_post = array(
        'ID'                    => $post_id,
        'post_author'           => $user_id,
        'post_content'          => $contents,
        'post_title'            => $title,
        'post_status'           => 'publish',
        'post_type'             => 'page',
        'post_parent'           => 0,
        'menu_order'            => 0,
        'import_id'             => 0,
      );
    wp_update_post( $my_post, true );   
    wp_die();
  }  
  function custom_gallery(){
    global $wpdb;
    $category=$_GET['category'];
    $category_location= $wpdb->prefix . "category_location";
    $results_category = $wpdb->get_results("SELECT * FROM $category_location;");
    $content_image = $wpdb->prefix . "content_image";
    if(!empty($category)){
      $sql="SELECT * FROM $content_image WHERE category=$category;";
    }
    else {
      $sql="SELECT * FROM $content_image;";
    }    
    $results_gallery = $wpdb->get_results($sql);
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
  add_action('wp_ajax_save_cat', 'save_cat');
  add_action( 'wp_ajax_nopriv_save_cat', 'save_cat' );
  add_action('wp_ajax_delete_page', 'delete_page');
  add_action( 'wp_ajax_nopriv_delete_page', 'delete_page' );
  add_action('wp_ajax_edit_category', 'edit_category');
  add_action( 'wp_ajax_nopriv_edit_category', 'edit_category' );
  add_action('wp_ajax_update_category', 'update_category');
  add_action( 'wp_ajax_nopriv_update_category', 'update_category' );
  add_action('wp_ajax_edit_page', 'edit_page');
  add_action( 'wp_ajax_nopriv_edit_page', 'edit_page' );
  add_action('wp_ajax_update_page', 'update_page');
  add_action( 'wp_ajax_nopriv_update_page', 'update_page' );  
  add_action('wp_ajax_delete_category', 'delete_category');
  add_action( 'wp_ajax_nopriv_delete_category', 'delete_category' );
  add_action('activate_champlainroofing_custom_gallery/champlainroofing_custom_gallery.php','champlainroofing_custom_gallery_install');
  add_action('deactivate_champlainroofing_custom_gallery/champlainroofing_custom_gallery.php', 'champlainroofing_custom_gallery_uninstall');