<?php
/*
Plugin Name: WP References
Plugin URI: http://gadean.de/
Description: WP References - A simple references plugin for wordpress
Version: 1.0
Author: Oliver Haucke
Author URI: http://gadean.de/
Min WP Version: 1.5
Max WP Version: 4.0
License: BSD 2-Clause
License URI: http://opensource.org/licenses/BSD-2-Clause
*/

add_action('wp_enqueue_scripts', 'wpStylesheet');
add_filter('the_content', 'wpReferences');
add_action('init', 'wpButton');

function wpStylesheet()
{
	wp_register_style('wpReferences', plugins_url('wpReferences/wpReferences.css'));
	wp_enqueue_style('wpReferences');
}

function wpReferences($content)
{
    $pattern = '/\[ref( title="(?<title>.*?)")?\](?<url>.*?)\[\/ref\]/i';
    if(preg_match_all($pattern, $content, $matches))
    {
        $content = preg_replace($pattern, '', $content);
        $content = str_replace("<p><br />\n</p>", "", $content);
        $content = rtrim($content);
        $content .= PHP_EOL.'<div class="wpReferences"><p>Quellen</p><ul>';
        for($i = 0; $i < count($matches['url']); $i++)
        {
            $content .= '<li><a href="'.$matches['url'][$i].'" target="_blank">'.($matches['title'][$i] == '' ? $matches['url'][$i] : $matches['title'][$i]).'</a></li>';
        }
        $content .= '</ul></div>';
    }
    return $content;
}

function wpButton()
{
    if(is_admin()){
        if(current_user_can('edit_posts') && current_user_can('edit_pages'))
        {
            add_filter("mce_external_plugins", "mce_external_plugins");
            add_filter('mce_buttons', 'mce_buttons');
        }
    }
}

function mce_buttons($buttons) {
    array_push($buttons, "wprb" );
    return $buttons;
}
function mce_external_plugins($plugin_array) {
    $plugin_array['wprButton']  =  plugins_url('/wpReferences/button.js');
    return $plugin_array;
}


?>