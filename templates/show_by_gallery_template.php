    <div id="gallery-contaimer">
      <figure class="wp-block-gallery columns-3 is-cropped">
        <ul class="blocks-gallery-grid">
            <?php
            foreach ($results_gallery as $key_gallery) {
                echo '<li class="blocks-gallery-item"><figure>';
                echo '<a href="'.$key_gallery->guid.'" target="blank"><img src="'.$key_gallery->image_url.'" alt data-id="'.$key_gallery->gallery_post_id.'" data-link="http://localhost/maps/?attachment_id='.$key_gallery->gallery_post_id.'" ></a>';
                echo '</figure>';
            }
            ?>
        </ul>
      </figure>
    </div>