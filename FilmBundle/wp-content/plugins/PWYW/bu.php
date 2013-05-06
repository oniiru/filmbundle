

    if (!current_user_can('manage_options')) {
        wp_die('You do not have sufficient permissions to access this page.');
    } else {
        screen_icon('options-general');
        $options = get_option('Bundle_1');
?>
        <h2><?php echo get_admin_page_title();?></h2>
        <div class="postbox-container" style="width: 980px">
            <div class="metabox-holder">
                <div class="meta-box-sortables">
                    <div class="postbox" id="first">
                        <div class="handlediv" title="Click to toggle"><br /></div>
                        <h3 class="hndle"><span><?php echo $options['Bundletitle'];?></span></h3>
                        <div class="inside">
                            <div class="bluerevbox">
                                <h2>Total Revenue: $7,000,000.00</h2>
                                <h4>Avg. Purchase Price: $12.00  |  # of Purchases: 250,000</h4>
                            </div>
                            <div class="statsbox">
                                <div class="totalsbox">
                                    <h3><span>Totals:</span></h3>
                                    <ul>
                                        <li>Films: <span>$100,000.00</span>
                                            <ul>
                                                <li>Boom Town: <span>$100,000.00</span></li>
                                                <li>AnyTown: <span>$100,000.00</span></li>
                                                <li>ThisTown: <span>$100,000.00</span></li>
                                                <li>MyTown: <span>$100,000.00</span></li>
                                            </ul>
                                        </li>
                                        <li>Charities:<span>$100,000.00</span>
                                            <ul>
                                                <li>Sundance Institute:<span>$100,000.00</span></li>
                                                <li>Film Independent:<span>$100,000.00</span></li>
                                            </ul>
                                        </li>
                                        <li>FilmBundle:<span>$100,000.00</span></li>
                                    </ul>
                                </div>
                                <div class="leadersbox">
                                    <h3><span>Leaders:</span></h3>
                                    <ul>
                                        <li>1. @moo: <span>$1000.00</span></li>
                                        <li>2. @hello: <span>$400.00</span></li>
                                        <li>3. Standupmaster: <span>$100.00</span></li>
                                        <li>4. mt8634: <span>$100.00</span></li>
                                        <li>5. @boo: <span>$99.00</span></li>
                                        <li>6. @richguy: <span>$80.00</span></li>
                                        <li>7. @payme: <span>$70.00</span></li>
                                        <li>8. @for_charity: <span>$67.00</span></li>
                                        <li>9. @heehee: <span>$55.00</span></li>
                                        <li>10. Teehee: <span>$40.00</span></li>
                                    </ul>
                                </div>
                            </div>
                            <form method="post" action="options.php">
<?php settings_fields('PWYW_Bundle_options');?>
                                <div class="bundlesettings">
                                    <h3><span>Settings</span></h3>
                                    <div class="bundletitleinput">
                                        <h4>Bundle Title</h4>
                                        <input name="Bundle_1[Bundletitle]" type="text" value="<?php echo $options['Bundletitle'];?>" />
                            </div>
                            <div class="suggestedvalues">
                                <h4>Suggested Values:</h4>
                                <div class="indivvalues">
                                    1. <input type="text" name="Bundle_1[indivvalues1]" value="<?php echo $options['indivvalues1'];?>" />
                                </div>
                                <div class="indivvalues">
                                    2. <input type="text" name="Bundle_1[indivvalues2]" value="<?php echo $options['indivvalues2'];?>" />
                                </div>
                                <div class="indivvalues">
                                    3. <input type="text" name="Bundle_1[indivvalues3]" value="<?php echo $options['indivvalues3'];?>" />
                                </div>
                                <div class="indivvalues">
                                    4. PWYW Suggestion <input type="text" name="Bundle_1[indivvalues4]" value="<?php echo $options['indivvalues4'];?>" />
                                </div>
                            </div>
                            <script>

                                var min=0;
                                var max=100;

                                $(function() {
                                    $( ".selector" ).slider(
                                    { animate: true },
                                    { min: min },
                                    { max: max },
                                    {change: function(event, ui) {
                                            $('.filmmakerpercent').val($("#slider_filmmakers").slider("value"));
                                            $('.charitypercent').val($("#slider_charities").slider("value"));
                                            $('.bundlepercent').val($("#slider_bundle").slider("value"));
                                        }},
                                    {slide: function(event, ui) {
                                            $('.filmmakerpercent').val($("#slider_filmmakers").slider("value"));
                                            $('.charitypercent').val($("#slider_charities").slider("value"));
                                            $('.bundlepercent').val($("#slider_bundle").slider("value"));
                                        }});
                
                                    $("#slider_filmmakers").slider('value', <?php echo $options['mainslider1'];?>);
                                    $("#slider_charities").slider('value', <?php echo $options['mainslider2'];?>);
                                    $("#slider_bundle").slider('value', <?php echo $options['mainslider3'];?>);

                                    $('.filmmakerpercent').val($("#slider_filmmakers").slider("value"));
                                    $('.charitypercent').val($("#slider_charities").slider("value"));
                                    $('.bundlepercent').val($("#slider_bundle").slider("value"));
            
                                    $(".charitypercent").change(function() {
                                        $("#slider_charities").slider("value" , $(this).val())
                                    });

                                    $(".filmmakerpercent").change(function() {
                                        $("#slider_filmmakers").slider("value" , $(this).val())
                                    });

                                    $(".bundlepercent").change(function() {
                                        $("#slider_bundle").slider("value" , $(this).val())
                                    });
            	
                                    $(function () {
                                        $('div.linked3').linkedSliders({
                                            total: 100,  // The total for all the linked sliders
                                            policy: 'next' // Adjustment policy: 'next', 'prev', 'first', 'last', 'all'
                                        });
                                    });
            	
                                });
                            </script>

                            <div class="bundlecategories">
                                <h4>Categories <span>Starting Value</span></h4>
                                <div class="indivcategory">
                                    <p>Filmmakers:</p>
                                    <div class="indivcategoryslider">
                                        <div id="slider_filmmakers" class="selector linked3" value="<?php echo $options['mainslider1'];?>" ></div>
                                        <input type="text" class="filmmakerpercent" name="Bundle_1[mainslider1]" value="<?php echo $options['mainslider1'];?>" />
                                    </div>
                                </div>
                                <div class="indivsubcategory">
                                    <a href="#">Add Sub-Category</a>
                                </div>
                                <div class="indivcategory">
                                    <p>Charities:</P>
                                    <div class="indivcategoryslider">
                                        <div id="slider_charities" class="selector linked3" value="<?php echo $options['mainslider2'];?>" ></div>
                                        <input type="text" class="charitypercent" name="Bundle_1[mainslider2]" value="<?php echo $options['mainslider2'];?>" />
                                    </div>
                                </div>
                                <div class="indivsubcategory">
                                    <a href="#">Add Sub-Category</a>
                                </div>
                                <div class="indivcategory">
                                    <p>Bundle:</p>
                                    <div class="indivcategoryslider">
                                        <div id="slider_bundle" class="selector linked3" value="<?php echo $options['mainslider3'];?>" ></div>
                                        <input type="text"  class="bundlepercent" name="Bundle_1[mainslider3]" value="<?php echo $options['mainslider3'];?>" />
                                    </div>

                                </div>
                            </div>
                            <div class="PWYWmemberships">
<?php
        global $wpdb;
        $levels = $wpdb->get_results("SELECT * FROM {$wpdb->pmpro_membership_levels}", OBJECT);
?>
                                <h4>Above/Below Average Memberships:</h4>
                                <div class="belowmembership">
                                    <p>Below Average Memberships:</p>
                                    <select name="Bundle_1[belowaverage]" >

<?php
        foreach ($levels as $level) {
?>
                                        <option <?php if ($options['belowaverage'] == $level->id)
                                            echo "selected='selected'";?> value="<?php echo $level->id?>"><?php echo $level->name?></option>
<?php
                                    }
?>
                                    </select>
                                </div>
                                <div class="abovemembership">
                                    <p>Above Average Memberships:</p>
                                    <select name="Bundle_1[aboveaverage]">

<?php
                                    foreach ($levels as $level) {
?>
                                        <option <?php if ($options['aboveaverage'] == $level->id)
                                            echo "selected='selected'";?> value="<?php echo $level->id?>"><?php echo $level->name?></option>
                                        <?php
                                    }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="action" value="update" />
                            <input type="hidden" name="page_options" value="Bundle_1" />
                            <input class='button-primary activatebutton' type='submit' value="<?php _e('Save Changes')?>">
                            <div class="activatediv">Activated: <input name="Bundle_1[activate]" type="checkbox" value="1" <?php if ($options['activate'] == '1')
                                            echo 'checked'?> />
                                </div><span class="deletebundle">Delete</span>
                        </form>
                    </div>
                </div>
            </div>
<?php }?>
                                    </div>
                                    <form method="post" action="options.php">
                                        <input type="text">
                                        <input style="padding-right: 18px;" class='button-primary savebundle' type='submit' value="<?php _e('Add New Bundle')?>">
                                        </div>
                                        </div>









        <?php