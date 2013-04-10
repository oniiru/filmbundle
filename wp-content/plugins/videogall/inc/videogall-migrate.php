<?php
/** One time script to migrate existing videos **/
global $wpdb, $video_table_name, $category_table_name;
$video_table_name = $wpdb->prefix.'videogall';
$category_table_name = $wpdb->prefix.'vidcategory';
function videogall_migrate() {
    global $wpdb, $video_table_name, $category_table_name;
    if($wpdb->get_var("SHOW TABLES LIKE '$video_table_name'") == $video_table_name) {
        $sql = "SELECT * FROM ".$video_table_name;
        $videos = $wpdb->get_results($sql);        
        $video_list = get_option('videogall_videos'); 
        foreach($videos as $entry) {            
            $name = $entry->name;
            $url = $entry->url;
            $category = $entry->category;
            $thumbnail = $entry->thumbnail;
            $caption = $entry->caption;
            $description = $entry->description;
            $next_id = intval(get_option('videogall_sequence_id')) + 1;
            $mig_entry = array('id' => $next_id, 'name' => $name, 'url' => $url, 'thumbnail' => $thumbnail, 'category' => $category, 'caption' => $caption, 'description' => $description);
            array_push($video_list,$mig_entry);
	    update_option('videogall_videos',$video_list);
	    update_option('videogall_sequence_id',$next_id);
        }
        $wpdb->query("DROP TABLE IF EXISTS $video_table_name");
    }    
    
    if($wpdb->get_var("SHOW TABLES LIKE '$category_table_name'") == $category_table_name) {
        $sql = "SELECT * FROM ".$category_table_name;
        $categories = $wpdb->get_results($sql);
        $video_categories = get_option('videogall_categories');
        foreach($categories as $entry) {
            $categoryname = $entry->catname;
            array_push($video_categories,$categoryname);
	    update_option('videogall_categories',$video_categories);
        }
        $wpdb->query("DROP TABLE IF EXISTS $category_table_name");
    }
}
?>