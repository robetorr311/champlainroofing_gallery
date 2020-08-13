<div class="wrap">
  <h1>Add Category Locations to Gallery</h1>
    <form id="addlocationform">
      <table class="form-table">
        <tbody>
          <tr>
            <th>Add Location:</th><td><div class="control"><input type="text" id="c_location" name="c_location"></div></td>
          </tr>
          <tr>
            <td colspan="2">
                <button type="submit" class="button button-primary">Submit</button>
            </td>
          </tr>          
        </tbody>
      </table>
    </form>
<div class="post-inner thin">
  <div class="entry-content">
    <table id="table_images">
      <thead>
          <tr>
            <th>Title</th> 
            <th>Post Name</th> 
            <th>Image</th> 
            <th>Location</th> 
            <th>Options</th>
          </tr>
      </thead>
      <tbody>
      <?php
      foreach ($results_locations as $key_location) {
      ?>  
        <tr>
          <td> <?php echo $key_location->title; ?> </td>  
          <td> <?php echo $key_location->post_name; ?> </td> 
          <td> <img src="<?php echo $key_location->image_url; ?>" width="200px"></td> 
          <td> <?php echo get_category_name($key_location->category); ?> </td> 
          <td>
            <button type="button" class="button button-primary" onclick="deleteimage('<?php echo $key_location->id; ?>')">Delete</button>
          </td>
      </tr>
      <?php
      }
      ?>
      </tbody>
      <tfoot>
          <tr>
            <th>Name</th> 
            <th>Type</th> 
            <th>Address</th> 
            <th>Description</th> 
            <th>Options</th>
          </tr>
      </tfoot>  
    </table>  
  </div>
</div>     
</div>

<script type="text/javascript">
var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
jQuery(document).ready(function($){
  jQuery("#table_images").dataTable({
    "oPaginate": true,
    "bLengthChange": true,
    "bFilter": true,
    "bSort": true,
    "bInfo": true,
    "bAutoWidth": false,
    "lengthMenu":[[10,25,50,100,200,-1],[10,25,50,100,200,"All"]]    
  });     
  jQuery("#addlocationform").validate({
    ignore: [],
    rules: {
      c_location: "required",
    },
    messages: {
      c_location: "Please provide an location",
    },
    errorClass: "error_validate",
    inputContainer: "control",
    submitHandler: function(response){
      var c_location=jQuery("#c_location").val();
      var data= {
        action:'save_cat',
        category: c_location,
      };
      jQuery.post(ajaxurl, data, function(response) {
        alert('Success!!');
        location.reload();
      });            
    }
  });  
}); 
function deleteimage(id){
    if (confirm("Are you sure?")) {
      var data= {
        action:'delete_page',
        id: id,
      };
      jQuery.post(ajaxurl, data, function(response) {
        alert('Success!!');
        location.reload();
      });
    }  
}
</script>