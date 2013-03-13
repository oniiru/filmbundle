jQuery(document).ready(function() {
    
    var successMsgElem = jQuery('.settings-error');
    jQuery('#error-location').append(successMsgElem);
    jQuery('.settings-error').delay(1000).fadeOut(2000);
    
    //Loading current tab using cookie
    if(getCookie("currtab") != "" && getCookie("currtab") != null) {
        jQuery('.settings-menu-tab').removeClass('settings-menu-tab-active');
        var currtab = getCookie("currtab");
        jQuery('#' + currtab).addClass('settings-menu-tab-active');
        var currsection = currtab.replace('menu-tab','content');
        jQuery('.settings-content').hide();
        jQuery('#' + currsection).show();
    }
    
    //Animating tabs
    jQuery('.settings-menu-tab').click(function() {
        var tabId = jQuery(this).attr("id");
        var contentId = tabId.replace("menu-tab","content");
        var currentTabId = jQuery(".settings-menu-tab-active").attr("id");
        if(tabId != currentTabId) {
            jQuery('.settings-menu-tab').removeClass("settings-menu-tab-active");
            jQuery('#' + tabId).addClass("settings-menu-tab-active");
            jQuery('.settings-content').slideUp("fast");
	    jQuery('#' + contentId).slideDown("slow");
        }
    });    
   
    //Upload image script
    var formfieldID;
    jQuery('.image_upload').click(function() {
	var btnId = jQuery(this).attr("id");
        formfieldID = btnId.replace("_upload","");
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        return false;
    });
    window.send_to_editor = function(html) {
        imgurl = jQuery('img',html).attr('src');
        jQuery('#' + formfieldID).val(imgurl);
        tb_remove();
    }
    
    //Font size increment/decrement
    jQuery('#font_size_incr_btn').click(function() {
	var fontsize = parseFloat(jQuery('#font_size').val());
	fontsize = fontsize + 1.5;
	jQuery('#font_size').val(fontsize);
    });
    jQuery('#font_size_decr_btn').click(function() {
	var fontsize = parseFloat(jQuery('#font_size').val());
	fontsize = fontsize - 1.5;
	if(fontsize < 0) fontsize = 83.3;
	jQuery('#font_size').val(fontsize);
    });    
    
    //Setting cookie to remember last tab
    jQuery('#settings-submit').click(function() {
        var currentTabId = jQuery('.settings-menu-tab-active').attr("id");
        setCookie("currtab",currentTabId,3);
    });
    jQuery('#settings-reset').click(function() {
        var currentTabId = jQuery('.settings-menu-tab-active').attr("id");
        setCookie("currtab",currentTabId,3);
    });
    /* Videogall specific */
    jQuery('#add_video_submit').click(function() {
        var currentTabId = jQuery('.settings-menu-tab-active').attr("id");
        setCookie("currtab",currentTabId,3);
    });
    jQuery('#edit_done_submit').click(function() {
        var currentTabId = jQuery('.settings-menu-tab-active').attr("id");
        setCookie("currtab",currentTabId,3);
    });
    jQuery('#add_category_submit').click(function() {
        var currentTabId = jQuery('.settings-menu-tab-active').attr("id");
        setCookie("currtab",currentTabId,3);
    });
    jQuery('#rename_category_submit').click(function() {
        var currentTabId = jQuery('.settings-menu-tab-active').attr("id");
        setCookie("currtab",currentTabId,3);
    });
        
    /* Videogall specific */
    //Setting the id to delete/edit
    jQuery('.delete_video_submit').click(function(event) {
	var id = jQuery(this).attr("id").replace('delete_video_submit_','');
	var confirmation = confirm("Are you sure you want to delete this video ?");		
	if(!confirmation) {
	    event.preventDefault();
	}
	jQuery('#id_list').val(id);
    });
    
    jQuery('.edit_video_button').click(function() {
	var id = jQuery(this).attr("id").replace('edit_video_button_','');
	jQuery('.edit-form').fadeOut(500);
	jQuery('#edit-form-' + id).fadeIn(500);
	jQuery('#settings-submit').attr("disabled",true);
	jQuery('#id_list').val(id);
    });
    
    jQuery('.edit_cancel_submit').click(function() {
	jQuery('#id_list').val("");
	jQuery('.edit-form').fadeOut(500);
	jQuery('#settings-submit').attr("disabled",false);
    });
    
    jQuery('#rename_category').change(function() {
	if(jQuery(this).val() != '') {
	    jQuery('#rename-category-section').fadeIn(400);
	} else
	    jQuery('#rename-category-section').hide();
    });
});

function confirmAction() {
    var confirmation = confirm("Do you want to delete your settings and restore to default settings ?");
    return confirmation;
}

function setCookie(name,value,secs) {
    if(secs) {
	var date = new Date();
	date.setTime(date.getTime()+(secs*1000));
	var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

/* Videogall specific */
function hideEditScreen() {
    jQuery('.edit-form').fadeOut(500);
}