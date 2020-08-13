<div class="post-inner thin">
  <div class="entry-content">
    <select name="categories" id="categories">
        <option value="">Show All Pictures</option>
        <?php
        foreach ($results_category as $key_category) {
            echo '<option value="'.$key_category->id.'">Show Pictures From '.$key_category->name.'</option>';
        }
        ?>
    </select>
  </div>
  <div class="entry-content">
    <div id="gallery-contaimer">
      <figure class="wp-block-gallery columns-3 is-cropped">
        <ul class="blocks-gallery-grid">
            <?php
            foreach ($results_gallery as $key_gallery) {
                echo '<li class="blocks-gallery-item"><figure>';
                echo '<a href="'.$key_gallery->guid.'" target="blank"><img src="'.$key_gallery->image_url.'" alt="'.$key_gallery->title.'" data-id="'.$key_gallery->gallery_post_id.'" data-link="http://localhost/maps/?attachment_id='.$key_gallery->gallery_post_id.'" ></a>';
                echo '</figure>';
            }
            ?>
        </ul>
      </figure>
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