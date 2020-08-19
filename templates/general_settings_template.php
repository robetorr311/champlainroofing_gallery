<div class="wrap">
  <h1>GENERAL SETTINGS</h1>
    <form id="form1" method="POST">
      <table class="form-table">
        <tbody>
          <tr>
            <th>Title of page:</th><td><div class="control"><input type="text" id="title" name="title"></div></td>
          </tr>
          <tr>
            <th>Location:</th>
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
            <th>Content of page:</th><td><div class="control"><textarea id="content" name="content" ></textarea></div></td>
          </tr>
          <tr>
            <td colspan="2">
              <div class="control">  
                <input id="image_url" type="text" name="image_url"/>
                <input id="image_id" type="hidden" name="image_id"/>
                <input id="image_filename" type="hidden" name="image_filename"/>
                <input id="upload-button" type="button" class="button button-primary" value="Upload and Choose an Image" />
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="2">
                <button type="submit" class="button button-primary">Submit</button>
            </td>
          </tr>          
        </tbody>
      </table>
    </form> 
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
});    
</script>