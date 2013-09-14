<script type='text/javascript'>
jQuery(document).ready(function($) {
  // Image Insert button
  $('#bg_image_button').click(function() {
    console.log('here3');
    wp.media.editor.send.attachment = function(props, attachment) {
      $('#bg_image').val(attachment.url);
    }
    wp.media.editor.open(this);
    return false;
  });
  $('#face_image_button').click(function() {
    console.log('here3');
    wp.media.editor.send.attachment = function(props, attachment) {
      $('#face_image').val(attachment.url);
    }
    wp.media.editor.open(this);
    return false;
  });
});
</script>
<?php
class shareCount {
private $url,$timeout;
function __construct($url,$timeout=10) {
$this->url=rawurlencode($url);
$this->timeout=$timeout;
}
function get_tweets() { 
$json_string = $this->file_get_contents_curl('http://urls.api.twitter.com/1/urls/count.json?url=' . $this->url);
$json = json_decode($json_string, true);
return isset($json['count'])?intval($json['count']):0;
}

function get_fb() {
$json_string = $this->file_get_contents_curl('http://api.facebook.com/restserver.php?method=links.getStats&format=json&urls='.$this->url);
$json = json_decode($json_string, true);
return isset($json[0]['total_count'])?intval($json[0]['total_count']):0;
}

private function file_get_contents_curl($url){
$ch=curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_FAILONERROR, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
$cont = curl_exec($ch);
if(curl_error($ch))
{
die(curl_error($ch));
}
return $cont;
}
}
$obj=new shareCount("http://www.humblebundle.com");  //Use your website or URL
$twittershares = $obj->get_tweets(); //to get tweets
$facebookshares = $obj->get_fb(); //to get facebook total count (likes+shares+comments)
$twitterstart = $pwyw_data['bundle']->twitterstart;
$facestart = $pwyw_data['bundle']->facestart;
$twitterend = $pwyw_data['bundle']->twitterend;
$faceend = $pwyw_data['bundle']->faceend;
$currenttwitter = ($twittershares - $twitterstart);
$currentface = ($facebookshares - $facestart);
?>

<h2>Bundle Settings</h2>
<div class="postbox-container" style="width: 980px">
      <div class="metabox-holder">
          <div class="postbox" id="first">
            <h3 class="hndle"><span><?php echo isset($pwyw_data['bundle']->title)?$pwyw_data['bundle']->title:'';?></span></h3>
            <div class="inside">
              <div class="bluerevbox">
                <h2>Total Revenue: $<?php echo isset($pwyw_data['payment_info'])?number_format($pwyw_data['payment_info']->total_payments,2):'0.00'?></h2>
                <h4>Avg. Purchase Price: $<?php echo isset($pwyw_data['payment_info'])?number_format($pwyw_data['payment_info']->avg_price,2):'0.00' ?>  |  # <?php echo isset($pwyw_data['payment_info'])?$pwyw_data['payment_info']->total_sales:'0' ?></h4>
				<h4>Facebook: <?php if($faceend != '0') {echo $faceend;} else { echo $currentface;};?> / Twitter: <?php if($twitterend != '0') {echo $twitterend;} else { echo $currenttwitter;};?></h4>
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
                  <div class="bundledescriptioninput">
                    <h4>Bundle Description</h4>
                    <textarea name="description" type="textarea"><?php
                      echo isset($pwyw_data['bundle'])?$pwyw_data['bundle']->description:'';
                    ?></textarea>
                  </div>
                  <div class="bundlebgimageinput">
                    <h4>Bundle Background Image</h4>
                    <input name="bg_image" id="bg_image" type="text" value="<?php
                      echo isset($pwyw_data['bundle'])?$pwyw_data['bundle']->bg_image:'';
                    ?>" />
                    <a class="button-secondary" id="bg_image_button" title="Media Image Library">Media Image Library</a>
                  </div>
                  <div class="bundleendtimeinput">
                    <h4>Bundle End Time</h4>
                    <input name="end_time" type="text" value="<?php echo isset($pwyw_data['bundle'])?$pwyw_data['bundle']->end_time:'';?>" />
                  </div>
				  
				
				  
				  
                  <div class="bundlestartingshares">
                    <h4>Bundle Starting Shares</h4>
					<p style="display:inline-block">Facebook:</p>
                    <input id="face_start" style="display:inline-block;width:100px" name="facestart" type="text" value="<?php echo isset($pwyw_data['bundle'])?$pwyw_data['bundle']->facestart:'';?>" />
					<p style="display: inline-block;margin-left: 20px;">Twitter:</p>
                    <input id="twitter_start" style="display:inline-block;width:100px" name="twitterstart" type="text" value="<?php echo isset($pwyw_data['bundle'])?$pwyw_data['bundle']->twitterstart:'';?>" />
					<a id="bundleshares" style="display:block; width:120px" class="button button-primary">Get Starting Value</a>
  				  <script>
  				  jQuery('#bundleshares').click(function() {
  				      var twitvalue = <?php echo $twittershares; ?>;
  				      var facevalue = <?php echo $facebookshares; ?>;
  				   		jQuery('#twitter_start').val(twitvalue);
  				   		jQuery('#face_start').val(facevalue);
						
  				      return false;
  				  });
  				  </script>
                  </div>
				  

                  <div class="facebooksharegoal">
                    <h4>Facebook Shares Goal</h4>
                    <input name="facegoal" type="text" value="<?php echo isset($pwyw_data['bundle'])?$pwyw_data['bundle']->facegoal:'';?>" />
                  </div>

                  <div class="twittersharegoal">
                    <h4>Twittersharegoal</h4>
                    <input name="twittergoal" type="text" value="<?php echo isset($pwyw_data['bundle'])?$pwyw_data['bundle']->twittergoal:'';?>" />
                  </div>
				  
				  
                  <div class="bundleendingshares">
                    <h4>Bundle Ending Shares</h4>
					<p style="display:inline-block">Facebook:</p>
                    <input id="face_end" style="display:inline-block;width:100px" name="faceend" type="text" value="<?php echo isset($pwyw_data['bundle'])?$pwyw_data['bundle']->faceend:'';?>" />
					<p style="display: inline-block;margin-left: 20px;">Twitter:</p>
                    <input id="twitter_end" style="display:inline-block;width:100px" name="twitterend" type="text" value="<?php echo isset($pwyw_data['bundle'])?$pwyw_data['bundle']->twitterend:'';?>" />
					<a id="bundleendshares" style="display:block; width:120px" class="button button-primary">Get Ending Value</a>
  				  <script>
  				  jQuery('#bundleendshares').click(function() {
  				      var twitendvalue = <?php echo ($twittershares - $pwyw_data['bundle']->twitterstart); ?>;
  				      var faceendvalue = <?php echo ($facebookshares - $pwyw_data['bundle']->facestart); ?>;
  				   		jQuery('#twitter_end').val(twitendvalue);
  				   		jQuery('#face_end').val(faceendvalue);
						
  				      return false;
  				  });
  				  </script>
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


              <div class="bundletitleinput">
                <h4>Facebook Title</h4>
                <input name="facetitle" type="text" value="<?php echo isset($pwyw_data['bundle'])?$pwyw_data['bundle']->facetitle:'';?>" />
              </div>
			  
              <div class="bundledescriptioninput">
                <h4>Facebook Description</h4>
                <textarea name="facedescription" type="textarea"><?php
                  echo isset($pwyw_data['bundle'])?$pwyw_data['bundle']->facedescription:'';
                ?></textarea>
              </div>
              <div class="bundlebgimageinput">
                <h4>Facebook Image</h4>
                <input name="face_image" id="face_image" type="text" value="<?php
                  echo isset($pwyw_data['bundle'])?$pwyw_data['bundle']->face_image:'';
                ?>" />
                <a class="button-secondary" id="face_image_button" title="Media Image Library">Media Image Library</a>
              </div>
			  
              <div class="bundletitleinput">
                <h4>Twitter Message</h4>
                <input name="twittermessage" type="text" value="<?php echo isset($pwyw_data['bundle'])?$pwyw_data['bundle']->twittermessage:'';?>" />
              </div>

              <div class="PWYWmemberships">
                <?php
                // Get all available products
                $args = array(
                  'post_type' => 'download',
                  'posts_per_page' => -1,
                  'post_status' => 'any'
                );
                $products = get_posts($args);
                ?>
                <h4>Easy Digital Download Product Integration:</h4>
                <div class="belowmembership">
                  <p>Below Average Product:</p>
                  <select name='belowaverage'>
                    <option value='0'>-- Select Product --</option>
                    <?php
                    foreach ($products as $product) {
                      $current = isset($pwyw_data['bundle'])?$pwyw_data['bundle']->belowaverage: '';
                      $selected = selected($current, $product->ID, false);
                      echo "<option value='{$product->ID}' {$selected}>";
                      echo $product->post_title;
                      echo "</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="abovemembership">
                  <p>Above Average Product:</p>
                  <select name='aboveaverage'>
                    <option value='0'>-- Select Product --</option>
                    <?php
                    foreach ($products as $product) {
                      $current = isset($pwyw_data['bundle'])?$pwyw_data['bundle']->aboveaverage: '';
                      $selected = selected($current, $product->ID, false);
                      echo "<option value='{$product->ID}' {$selected}>";
                      echo $product->post_title;
                      echo "</option>";
                    }
                    ?>
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
$bundle_id = isset($_REQUEST['bundle']) ? ($_REQUEST['bundle']) : 0;

// Initialize the film views
$data = array('films' => Pwyw_Films::all($bundle_id));
echo Pwyw_View::make('films', $data);

// Initialize the charity views
$data = array('charities' => Pwyw_Charities::all($bundle_id));
echo Pwyw_View::make('charities', $data);
?>
        </form>
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
          if (confirm("Are you sure you want to delete the bundle?")) {
            location.href = "<?php echo $pwyw_del?>";
            return false;
          }
        })
       <?php endif; ?>


    });
});

  </script>


