<style type="text/css">
#main_wrapper{
  display:grid;
  grid-template-columns: repeat(auto-fill, minmax(350px, 1fr) );
  grid-gap: 3%;
  background:#ccc;
  padding:10px;
  border:#000 thin solid;
}
.inner_wrapper{
  display:grid;
  border:#000 thin solid;
  padding:10px;
  min-height:100px;
  text-align:center;
  font-weight:bold;
  font-size:30px;
  font-family: 'Open Sans';
}
@media screen and (min-width:700px){
  .inner_wrapper{
    grid-template-columns: 2fr 1fr;    
  }  
  #main_wrapper{
    grid-template-columns: 1fr 3fr;
  }
}
.inner_wrapper.one_col{
    grid-template-columns: 1fr;
  }
.main_col_left{
  background:#ffffff;
  font-size: 12px;
}
.main_col_right{
  background:#ffffff;
  font-size: 12px;
}
.right_container{
  border: solid 1px #cccccc;
}
.left_container{
  border: solid 1px #cccccc;
}   
</style>
<div class="wrap">
<div class="main_column">
  <div id="div_1" class="inner_wrapper">
  <div class="main_col_left">     
  <div id="gnsttcont" class="left_container"> 
    <h1>GENERAL SETTINGS</h1>
    <form id="form1" method="POST">
      <table class="form-table">
        <tbody>
          <tr>
            <th>Title of page:</th>
          </tr>
          <tr>  
            <td><div class="control"><input type="text" id="title" name="title"></div></td>
          </tr>
          <tr>
            <th>Location:</th>
          </tr>
          <tr>             
            <td>
              <div class="control">
              <select id="category" name="category">
                <option value="">Choose Location</option>
                <?php
                  foreach ($results_category as $key_category) {
                    echo "<option value='".$key_category->id."'>".$key_category->name."</option>";
                  }
                ?>
              </select>
              </div>
            </td>
          </tr>
          <tr>
            <th>Content of page:</th>
          </tr>
          <tr> 
            <td><div class="control"><textarea id="content" name="content" ></textarea></div></td>
          </tr>
          <tr>
            <td colspan="2">
              <div class="control">  
                <input id="image_url" type="text" name="image_url"/>
                <input id="content_image_id" type="hidden" name="content_image_id"/>
                <input id="image_id" type="hidden" name="image_id"/>
                <input id="image_filename" type="hidden" name="image_filename"/>
                <input id="upload-button" type="button" class="button button-primary" value="Upload and Choose an Image" />
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="2">
                <button type="submit" id="save_gallery" class="button button-primary">Submit</button>
            </td>
          </tr>          
        </tbody>
      </table>
    </form>
    </div> 
  </div>


  <div class="main_col_right">
  <div class="right_container">  
  <h1>ADD CATEGORY LOCATIONS TO GALLERY</h1>
    <form id="addlocationform">
      <table class="form-table">
        <tbody>
          <tr>
            <th>Add Location:</th><td><div class="control"><input type="text" id="c_location" name="c_location"><input type="hidden" id="id_location" name="id_location"></div></td>
          </tr>
          <tr>
            <td colspan="2">
                <button type="submit" id="submt" class="button button-primary">Submit</button>
                <button type="button" id="updt" class="button button-primary" onclick="updatecategory()">Update</button>
            </td>
          </tr>          
        </tbody>
      </table>
    </form>
  </div>
<div class="right_container">
  <div class="entry-content">
    <h1>LOCATIONS LOADED</h1>
    <table id="table_location">
      <thead>
          <tr>
            <th>Name</th> 
            <th>Options</th>
          </tr>
      </thead>
      <tbody>
      <?php
      foreach ($results_categories as $key_cat) {
      ?>  
        <tr>
          <td> <?php echo $key_cat->name; ?> </td>  
          <td>
            <button type="button" class="button button-primary" onclick="deletecategory('<?php echo $key_cat->id; ?>')">Delete</button><button type="button" class="button button-primary" onclick="editcategory('<?php echo $key_cat->id; ?>')">Edit</button>
          </td>
      </tr>
      <?php
      }
      ?>
      </tbody>
      <tfoot>
          <tr>
          <tr>
            <th>Name</th> 
            <th>Options</th>
          </tr>
          </tr>
      </tfoot>  
    </table>  
  </div>
</div>    
<div class="right_container">
  <div class="entry-content">
    <h1>IMAGES LOADED TO GALLERY</h1>
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
            <button type="button" class="button button-primary" onclick="deleteimage('<?php echo $key_location->id; ?>')">Delete</button><button type="button" class="button button-primary" onclick="editimage('<?php echo $key_location->id; ?>')">Edit</button>
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
</div>
</div>
</div>
<script type="text/javascript">
var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
jQuery(document).ready(function($){
  CKEDITOR.replace( 'content', { toolbarGroups : [
            { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
            { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
            { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
            { name: 'forms', groups: [ 'forms' ] },
            { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
            { name: 'paragraph', groups: [ 'indent', 'list', 'blocks', 'align', 'bidi', 'paragraph' ] },
            { name: 'links', groups: [ 'links' ] },
            { name: 'styles', groups: [ 'styles' ] },
            { name: 'colors', groups: [ 'colors' ] },
            { name: 'insert', groups: [ 'insert' ] },
            { name: 'tools', groups: [ 'tools' ] },
            { name: 'others', groups: [ 'others' ] },
            { name: 'about', groups: [ 'about' ] }
          ],      
          removeButtons : 'Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Link,Unlink,Anchor,Maximize,ShowBlocks,About,Image,Flash,Table,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Source,Save,NewPage,Preview,Print,Templates'
  });
  jQuery("#form1").validate({
    ignore: [],
    rules: {
      title: "required",
      content:{ required: function(textarea) {
          CKEDITOR.instances[textarea.id].updateElement();
          var editcontent = textarea.value.replace(/<[^>]*>/gi,'');
          return editcontent.length===0;
        },
      },
      category:"required",
      image_url:"required",
    },
    messages: {
      title: "Please provide a title",
      content: "Please enter content",
      category: "Please choose category",
      image_url: "Please choose image",
    },
    errorClass: "error_validate",
    inputContainer: "control",
    submitHandler: function(response){
      var title=jQuery("#title").val();
      var content=jQuery("#content").val();
      var category=jQuery("#category").val();
      var image_url=jQuery("#image_url").val();
      var image_id=jQuery("#image_id").val();
      var image_filename=jQuery("#image_filename").val();
      var data= {
        action:'save_page',
        title: title,
        content: content,
        category: category,
        image_url: image_url,
        image_id: image_id,
        image_filename: image_filename
      };
      jQuery.post(ajaxurl, data, function(response) {
        alert('Success!!');
        location.reload();
      });            
    }
  });
  jQuery("#submt").show();
  jQuery("#updt").hide();
  jQuery("#table_location").dataTable({
    "oPaginate": true,
    "bLengthChange": true,
    "bFilter": true,
    "bSort": true,
    "bInfo": true,
    "bAutoWidth": false,
    "lengthMenu":[[5,10,25,50,100,200,-1],[5,10,25,50,100,200,"All"]]    
  });
  jQuery("#table_images").dataTable({
    "oPaginate": true,
    "bLengthChange": true,
    "bFilter": true,
    "bSort": true,
    "bInfo": true,
    "bAutoWidth": false,
    "lengthMenu":[[5,10,25,50,100,200,-1],[5,10,25,50,100,200,"All"]]    
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
function editcategory(id){
      var data= {
        action:'edit_category',
        id: id,
      };
      jQuery.post(ajaxurl, data, function(response) {
        var res = response.split("|");
        jQuery("#id_location").val(res[0]);
        jQuery("#c_location").val(res[1]);
        jQuery("#submt").hide();
        jQuery("#updt").show();
      });
}
function deletecategory(id){
      var data= {
        action:'delete_category',
        id: id,
      };
      jQuery.post(ajaxurl, data, function(response) {
        alert('Success');
        location.reload();
      });
}
function updatecategory(){
      id=jQuery("#id_location").val();
      c_location=jQuery("#c_location").val();
      var data= {
        action:'update_category',
        id: id,
        category: c_location,
      };
      jQuery.post(ajaxurl, data, function(response) {
        alert('Success');
        location.reload();
      });
}
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
function editimage(id){
    var data= {
        action:'edit_page',
        id: id,
      };
      jQuery.post(ajaxurl, data, function(response) {
        jQuery("#gnsttcont").html(response);
        jQuery('html, body').animate({scrollTop: 0}, 0);
      });
}  
</script>