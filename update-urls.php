<?php
/*
Plugin Name: ATH Update Urls
Plugin URI:
Description:
Version: 1.0
Author: Anh-Tuan Hoang
Author URI:
Update Server:
*/
add_action('admin_menu', function() {
    add_options_page( 'Update Urls Page', 'Mysql - Update Urls', 'manage_options', 'ath-update-urls-plugin', 'ath_update_urls_page' );
});
function ath_update_urls_page(){
  $current = site_url();

  $args = array(
    'sort_order' => 'desc',
  	'sort_column' => 'post_date',
    'post_type' => 'page'
  );
  $pages = get_pages( $args );
  if($pages){

    $guids = array();
    foreach( $pages as $page ){
      $thisURL  = explode('?', $page->guid, 2)[0];
      $guids[]  = substr($thisURL, 0, -1);
    }

    if (count(array_unique($guids)) > 0) {
      $guid_arr = array_unique($guids);
      foreach( $guid_arr as $old_url ){
        // $old_url = $guids[0];
        echo '<ul class="notice notice-success" style="margin-top:30px;margin-bottom:20px;padding:10px">';
        echo "<li>UPDATE wp_options SET option_value = replace(option_value, '".$old_url."', '".$current."') WHERE option_name = 'home' OR option_name = 'siteurl';</li>";
        echo "<li>UPDATE wp_posts SET guid = replace(guid, '".$old_url."','".$current."');</li>";
        echo "<li>UPDATE wp_posts SET post_content = replace(post_content, '".$old_url."', '".$current."');</li>";
        echo "<li>UPDATE wp_postmeta SET meta_value = replace(meta_value,'".$old_url."','".$current."');</li>";
        echo '</ul>';
      }
    }
  }
}
?>
