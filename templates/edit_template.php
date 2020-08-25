  <h1>EDIT CONTENT GALLERY</h1>
    <form id="editform1" method="POST">
      <table class="form-table">
        <tbody>
          <tr>
            <th>Title of page:</th>
          </tr>
          <tr>            
            <td><div class="control"><input type="text" id="title" name="title" value="<?php echo $title; ?>"></div></td>
          </tr>
          <tr>
            <th>Location:</th>
          </tr>
          <tr>            
            <td>
              <div class="control">
              <select id="category" name="category">
                <option selected value="<? echo $category; ?>"><?php echo $category_name; ?></option>
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
            <td><div class="control"><textarea id="content" name="content" ><?php echo $content; ?></textarea></div></td>
          </tr>
          <tr>
            <td colspan="2">
              <div class="control">  
                <input id="image_url" type="text" name="image_url" value="<?php echo $image_url; ?>"/>
                <input id="content_image_id" type="hidden" name="content_image_id" value="<?php echo $content_id; ?>"/>
                <input id="image_id" type="hidden" name="image_id" value="<?php echo $gallery_post_id; ?>"/>
                <input id="image_filename" type="hidden" name="image_filename" value="<?php echo $filename; ?>"/>
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
  jQuery("#editform1").validate({
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
      var id=jQuery("#content_image_id").val();
      var category=jQuery("#category").val();
      var image_url=jQuery("#image_url").val();
      var image_id=jQuery("#image_id").val();
      var image_filename=jQuery("#image_filename").val();
      var data= {
        action:'update_page',
        id: id,
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
});    
</script>