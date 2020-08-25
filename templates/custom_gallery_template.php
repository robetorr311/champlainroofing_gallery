<style type="text/css">
  .toplinks {
  width: 100%;
  background-color: #ffffff;
  overflow: auto;
}

.toplinks a {
  float: left;
  padding: 12px;
  background-color: #ffffff;
  font-family: Poppins, Helvetica, Arial, sans-serif;
  font-weight: 500;
  text-decoration:none;
  font-size:16px; 
  color:#1b2465; 
  text-align: center;
}

.toplinks a:hover {
  background-color: #ffffff;
  font-family: Poppins, Helvetica, Arial, sans-serif;
  font-weight: 500;
  text-decoration:none;
  font-size:16px; 
  color:#1b2465;  
}

.toplinks a.active {
  background-color: #ffffff;
  font-family: Poppins, Helvetica, Arial, sans-serif;
  font-weight: 500;
  text-decoration:none;
  font-size:16px; 
  color:#1b2465;
  padding-bottom: 0px;
  padding-top: 0px; 
}
.image_fixed{
  max-width:450px;
}
@media screen and (max-width: 500px) {
  .toplinks a {
    float: none;
    display: block;
    width: 100%;
    text-align: left;
    background-color: #ffffff;
    font-family: Poppins, Helvetica, Arial, sans-serif;
    font-weight: 500;
    text-decoration:none;
    font-size:16px; 
    color:#1b2465;     
  }
}

</style>
<div class="post-inner thin">
  <div class="row">
  <div class="container">
  <div class="toplinks">
        <?php
        $k=0;
        $i=5;
        foreach ($results_category as $key_category) {
          $k++;
          echo '<a href="'.get_site_url().'?page_id=5671&category='.$key_category->id.'" target="blank" style="font-family: Poppins, Helvetica, Arial, sans-serif; font-weight: 500; text-decoration:none; font-size:16px; color:#1b2465;">'.$key_category->name.'</a>';
          if ($k==$i){
            $i=$i+5;
            echo '</div><div class="toplinks">';
          }
        }
        echo '<a href="'.get_site_url().'?page_id=5671" target="blank" style="font-family: Poppins, Helvetica, Arial, sans-serif; font-weight: 500; text-decoration:none; font-size:16px; color:#1b2465;">Show All Pictures</a>';
        ?>
    </div>
  </div>
  </div>
  <div class="row">
  <div class="container"> 
  <div class="entry-content">
    <div id="gallery-contaimer">
      <figure class="wp-block-gallery columns-3 is-cropped">
        <?php
          if(count($results_gallery)>0){
            echo '<ul class="blocks-gallery-grid">';  
            foreach ($results_gallery as $key_gallery) {
                echo '<li class="blocks-gallery-item"><figure class="image_fixed">';
                echo '<a href="'.$key_gallery->guid.'" target="blank"><img src="'.$key_gallery->image_url.'" alt="'.$key_gallery->title.'" title="'.$key_gallery->title.'" data-id="'.$key_gallery->gallery_post_id.'" data-link="http://localhost/maps/?attachment_id='.$key_gallery->gallery_post_id.'" ></a>';
                echo '</figure>';
            }
            echo '</ul>';  
          }
          else {
            echo "<h2>No images loaded for this location</h2>";
          }
        ?>
      </figure>
    </div>
  </div>
    </div>
  </div>
</div>
<script type="text/javascript">
var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
jQuery(document).ready(function($){
  $(".page-title-bar-inner").css('display', 'none');
  $("#categories").change(function () {
    var selected=$("#categories").val();
    var data={
      action:"show_by",
      category:selected
    }
    jQuery.post(ajaxurl, data, function(response) {
      $("#gallery-contaimer").html((response));
    });
  });
});  
</script>