
<h2>Bundle Settings</h2>
<div class="postbox-container" style="width: 980px">
      <div class="metabox-holder">
        <div class="meta-box-sortables">
          <div class="postbox" id="first">
            <div class="handlediv" title="Click to toggle"><br /></div>
            <h3 class="hndle"><span><?php echo isset($pwyw_data['bundle']->title)?$pwyw_data['bundle']->title:'';?></span></h3>
            <div class="inside">
              <div class="bluerevbox">
                <h2>Total Revenue: $<?php echo isset($pwyw_data['payment_info'])?number_format($pwyw_data['payment_info']->total_payments,2):'0.00'?></h2>
                <h4>Avg. Purchase Price: $<?php echo isset($pwyw_data['payment_info'])?number_format($pwyw_data['payment_info']->avg_price,2):'0.00' ?>  |  # <?php echo isset($pwyw_data['payment_info'])?$pwyw_data['payment_info']->total_sales:'0' ?></h4>
              </div>
              <div class="statsbox">
                <div class="totalsbox">
                  <h3><span>Totals:</span></h3>
                  <ul>
                    <?php foreach($pwyw_data['categories'] as $key => $cat_obj):?>
                    <?php
                    $smalltitle = strtolower($cat_obj['info']['title']);
                    switch ($key) {
                      case 1:
                        $ctitle = 'Films';
                        break;
                      case 2:
                        $ctitle = 'Charities';
                        break;
                      case 3:
                        $ctitle = 'FilmBundle';
                        break; 
                    }
                    ?>
                    <li><?php echo $ctitle ?>: <span>$<?php echo isset($cat_obj['info']['payment'])?number_format($cat_obj['info']['payment'],2):'0.00' ?></span>
                      <?php if(isset($cat_obj['sub'])): ?>
                      <ul>
                        <?php foreach ($cat_obj['sub'] as $key_s => $sub): ?>
                          <li><?php echo $sub['info']['title'] ?>:<span>$<?php echo number_format($sub['info']['payment'],2) ?></span></li>
                        <?php endforeach;?>
                      </ul>
                      <?php endif; ?>
                    </li>
                        
                    <?php endforeach;?>
                  </ul>
                </div>
                <div class="leadersbox">
                  <h3><span>Leaders:</span></h3>
          <ul>
                      <?php
                      if(isset($pwyw_data['top'])):
                        $j = 1;
                        foreach($pwyw_data['top'] as $user):?>
                          <li><?php echo $j?>. <?php echo $user->display_name ?></li>
                      <?php $j++;
                         endforeach;
                         endif;
                         ?>
          </ul>
                </div>
              </div>

              <form method="post" action="<?php echo $pwyw_action ?>">

                <div class="bundlesettings">
                  <h3><span>Settings</span></h3>
                  <div class="bundletitleinput">
                    <h4>Bundle Title</h4>
                    <input name="title" type="text" value="<?php echo isset($pwyw_data['bundle'])?$pwyw_data['bundle']->title:'';?>" />
              </div>
              <div class="suggestedvalues">
                <h4>Suggested Values:</h4>
                <div class="indivvalues">
                  1. <input type="text" name="suggested_val_1" value="<?php echo isset($pwyw_data['bundle'])?$pwyw_data['bundle']->suggested_val_1:''?>" />
                </div>
                <div class="indivvalues">
                  2. <input type="text" name="suggested_val_2" value="<?php echo isset($pwyw_data['bundle'])?$pwyw_data['bundle']->suggested_val_2:'';?>" />
                </div>
                <div class="indivvalues">
                  3. <input type="text" name="suggested_val_3" value="<?php echo isset($pwyw_data['bundle'])?$pwyw_data['bundle']->suggested_val_3:'';?>" />
                </div>
                <div class="indivvalues">
                  4. PWYW Suggestion <input type="text" name="pwyw_val" value="<?php echo isset($pwyw_data['bundle'])?$pwyw_data['bundle']->pwyw_val:'' ?>" />
                </div>
              </div>


              <div class="bundlecategories">
                <h4>Categories <span>Starting Value</span></h4>
                <?php
                foreach ($pwyw_data['categories']  as $key => $cat):
                  $main = $cat['info'];

                  $id =  strtolower(preg_replace('/\s*/', '', $main['title']));
  
                  $id_slider = 'slider_' . $id;
                  $class_slider = $id.'_percent';
                  $ids[] = $id;

                  $ids_subs = array();
                ?>
                <div class="indivcategory" id="cat_<?php echo $key ?>">
                  <p><?php echo $main['title']?>:</p>
                  <div class="indivcategoryslider">
                    <div id="<?php echo $id_slider ?>"  class="selector linked3" value="<?php echo $main['val'];?>" ></div>
                    <input type="text" class="main_cat" name="parent_category_val[<?php echo $key ?>]" value="<?php echo $main['val'];?>" />
                  </div>
               
                <?php if(isset($cat['sub'])):
                    foreach($cat['sub'] as $key_sub=>$child): ?>
                   <input type="hidden" value="0" name="del_sub[<?php echo $key_sub ?>]" class="delete_sub"  id="del_sub_<?php echo $key_sub ?>"/>
                 <?php $child_c = $child['info'] ?>
                        <div class="indivsubcategory" id="sub_cat_<?php echo $key_sub; ?>">
                        <input class="pwyw_sub_title" type="text" name="pwyw_sub_name[<?php echo $key ?>][<?php echo $key_sub ?>]" value="<?php echo $child_c['title']?>">
                        <div class="indivsubcategoryslider">
                          <div class="selector <?php echo $id_slider?>_lib" value="<?php echo $child_c['val'];?>" ></div>
                          <input class ="pwyw_sub <?php echo $id_slider?>_inp" type="text"  name="pwyw_sub_val[<?php echo $key ?>][<?php echo $key_sub ?>]" value="<?php echo $child_c['val'];?>" />
                        </div>
                        <img class ="del_sub" alt="Delete" src="<?php echo plugins_url('/PWYW/img/images.jpg')?>" />
                         
                        </div>
     
                  <?php endforeach; ?>
                <?php endif; ?>
                <?php if($key!=3):?>
                      <div class="indivsubcategory add_sub">
                        <a href="#" class="add_sub_link">Add Sub-Category</a>
                      </div>
                  <?php endif;?>
                   </div>
                <?php endforeach;?>

              </div>
              <div class="PWYWmemberships">

                <h4>Above/Below Average Memberships:</h4>
                <div class="belowmembership">
                  <p>Below Average Memberships:</p>
                  <select name="belowaverage" >
                    <?php $sel_lev = isset($pwyw_data['bundle'])?$pwyw_data['bundle']->belowaverage: '' ?>
                    <?php foreach ($pwyw_data['levels'] as $level) : ?>
                      <option <?php if ($sel_lev  == $level->id) echo "selected='selected'";?> value="<?php echo $level->id?>"><?php echo $level->name?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="abovemembership">
                  <p>Above Average Memberships:</p>
                  <select name="aboveaverage">
                    <?php $sel_lev = isset($pwyw_data['bundle'])?$pwyw_data['bundle']->aboveaverage: '' ?>
                    <?php foreach ($pwyw_data['levels'] as $level) : ?>
                      <option <?php if ($sel_lev  == $level->id) echo "selected='selected'";?> value="<?php echo $level->id?>"><?php echo $level->name?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <input class='button-primary activatebutton' type='submit' value="<?php _e('Save Changes')?>">
              <div class="activatediv">Activated: <input name="activate" type="checkbox" value="1" <?php if (isset($pwyw_data['bundle'])&&$pwyw_data['bundle']->activated == '1') echo 'checked'?> />
                </div>
              <?php if(isset($pwyw_del)): ?>
                <span class="deletebundle">Delete</span>
              <?php endif; ?>
          </div><!-- .bundlesettings -->
<?php
echo Pwyw_View::make('films');
echo Pwyw_View::make('charities');
?>
        </form>
      </div>
    </div>
  </div>
</div>


  <script type="text/javascript">

jQuery(document).ready(function($) {
    var min=0;
    var max=100;
    
    function setSliderHandlers(slider_class,input_class,parent_class,_new){
      var default_val = 0;
      $('.'+input_class).val(0);
      

      $( "."+slider_class ).slider(
      { animate: true },
      { min: min },
      { max: max },
      {change: function(event, ui) {
          $(this).parent('div.'+parent_class).find('input.'+input_class).val($(this).slider('value'));
        }},
      {slide: function(event, ui) {
          $(this).parent('div.'+parent_class).find('input.'+input_class).val($(this).slider('value'));
        }});
      
      if(_new){
        var el = $('.'+input_class).last();
        var slider = el.parent('div.'+parent_class).find('div.'+slider_class);
        el.val(default_val);
        el.change(function(){
          slider.slider("value" , el.val());
        })
      }else{
        $('.'+input_class).each(function(){

              var slider = $(this).parent('div.'+parent_class).find('div.'+slider_class);

              if(slider.attr('value') != ''){
                $(this).val(slider.attr('value'));
                slider.slider("value",slider.attr('value'));
              }else{
                $(this).val(default_val);
              }

              $(this).change(function(){
                slider.slider("value" , $(this).val());
              })
            })
      }
      

      
      $('div.'+slider_class).linkedSliders({
        total: 100,  // The total for all the linked sliders
        policy: 'next' // Adjustment policy: 'next', 'prev', 'first', 'last', 'all'
      });
      
    }


    
    
    $(function() {
      setSliderHandlers('linked3','main_cat','indivcategoryslider',false);
      $('.pwyw_sub').each(function(){
        var parent =  $(this).parent().parent().parent('div.indivcategory');
        var class_sub = parent.find('div.linked3').attr('id')+'_lib';
        var input_class = parent.find('div.linked3').attr('id')+'_inp';
        setSliderHandlers(class_sub,input_class,'indivsubcategoryslider');
      })
      
      $('.add_sub_link').click(function(){
        
        var parent =  $(this).parent().parent('div.indivcategory');
        var class_sub = parent.find('div.linked3').attr('id')+'_lib';
        var cat_id = parent.attr('id').match(/cat_(.+)/)[1];

        var input_class = parent.find('div.linked3').attr('id')+'_inp';
        
        var sub_cat = '<div class="indivsubcategory">';
        sub_cat += '<input class="pwyw_sub_title" type="text" name="pwyw_new_sub_name['+cat_id+'][]" value="">';
        sub_cat += '<div class="indivsubcategoryslider">';
        sub_cat += '<div class="selector '+class_sub+'" value="100" ></div>';
        sub_cat += '<input type="text" class="pwyw_sub '+input_class+'" name="pwyw_new_sub_val['+cat_id+'][]" value="100" />';
        sub_cat += '</div>';
        sub_cat += '<img class ="del_sub" alt="Delete" src="<?php echo plugins_url('/PWYW/img/images.jpg')?>" />';
        sub_cat += '</div>';
        
        $(this).parent().parent('div.indivcategory').find('div.add_sub').before(sub_cat);
        $('.'+class_sub).linkedSliders('destroy');
        setSliderHandlers(class_sub,input_class,'indivsubcategoryslider',true);
        return false;
      })
      
      $('.del_sub').live('click',function(){
        if(typeof($(this).parent().attr('id'))!='undefined'){
           var id = $(this).parent().attr('id').match(/sub_cat_(\d+)/)[1];
           $('#del_sub_'+id).val(1);
        }

        var parent =  $(this).parent().parent('div.indivcategory');
        var class_sub = parent.find('div.linked3').attr('id')+'_lib';
        $(this).parent('div.indivsubcategory').remove();
        $('.'+class_sub).linkedSliders('destroy');
        $('div.'+class_sub).linkedSliders({
          total: 100,  // The total for all the linked sliders
          policy: 'next' // Adjustment policy: 'next', 'prev', 'first', 'last', 'all'
        });
        
      })
      
       <?php if(isset($pwyw_del)): ?>
         $('.deletebundle').click(function(){                        
                       location.href = "<?php echo $pwyw_del?>";
                       return false;                        
                     })
       <?php endif; ?>

      
    });
});

  </script>


