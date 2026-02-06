<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/*
Plugin Name: Shoutcast Icecast HTML5 Radio Player
Plugin URI: https://www.svnlabs.com/store/product/html5-radio-stream-player/
Description: Secure HTML5 MP3 Radio FM MP3 Stream Player for Shoutcast / Icecast / Podcast.
Version: 2.1.8
Author: Sandeep Verma
Author URI: https://www.svnlabs.com/
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/


/* ---------------------------------------------------------------
   Default Options
--------------------------------------------------------------- */

add_option("shoutcast-icecast-html5-player-radiolink", '');
add_option("shoutcast-icecast-html5-player-radiotype", 'shoutcast');
add_option("shoutcast-icecast-html5-player-bcolor", '000000');
add_option("shoutcast-icecast-html5-player-image", '');
add_option("shoutcast-icecast-html5-player-facebook", '');
add_option("shoutcast-icecast-html5-player-twitter", '');
add_option("shoutcast-icecast-html5-player-title", '');
add_option("shoutcast-icecast-html5-player-artist", '');

/* ---------------------------------------------------------------
   Admin Menu
--------------------------------------------------------------- */

if (!class_exists('Shoutcast_Icecast_HTML5_Player')) {
class Shoutcast_Icecast_HTML5_Player {

    public static function add_config_page() {
        add_options_page(
            'Shoutcast Icecast HTML5 Player',
            'Radio Player Options',
            'manage_options',
            basename(__FILE__),
            array('Shoutcast_Icecast_HTML5_Player', 'config_page')
        );
    }

    public static function config_page() {

        // Handle form submit
        if ( isset($_POST['submit']) && check_admin_referer('shoutcast-icecast-html5-player-updatesettings') ) {

            $radiolink = esc_url_raw( wp_unslash($_POST['radiolink']) );
            $radiotype = sanitize_text_field( wp_unslash($_POST['radiotype']) );
            $bcolor    = sanitize_text_field( wp_unslash($_POST['bcolor']) );
            $image     = esc_url_raw( wp_unslash($_POST['image']) );
            $facebook  = esc_url_raw( wp_unslash($_POST['facebook']) );
            $twitter   = esc_url_raw( wp_unslash($_POST['twitter']) );
            $titlez    = sanitize_text_field( wp_unslash($_POST['title']) );
            $artist    = sanitize_text_field( wp_unslash($_POST['artist']) );

            update_option("shoutcast-icecast-html5-player-radiolink", $radiolink);
            update_option("shoutcast-icecast-html5-player-radiotype", $radiotype);
            update_option("shoutcast-icecast-html5-player-bcolor", $bcolor);
            update_option("shoutcast-icecast-html5-player-image", $image);
            update_option("shoutcast-icecast-html5-player-facebook", $facebook);
            update_option("shoutcast-icecast-html5-player-twitter", $twitter);
            update_option("shoutcast-icecast-html5-player-title", $titlez);
            update_option("shoutcast-icecast-html5-player-artist", $artist);
        }

        $radiolink = esc_url( get_option("shoutcast-icecast-html5-player-radiolink") );
        $radiotype = esc_attr( get_option("shoutcast-icecast-html5-player-radiotype") );
        $bcolor    = esc_attr( get_option("shoutcast-icecast-html5-player-bcolor") );
        $image     = esc_url( get_option("shoutcast-icecast-html5-player-image") );
        $facebook  = esc_url( get_option("shoutcast-icecast-html5-player-facebook") );
        $twitter   = esc_url( get_option("shoutcast-icecast-html5-player-twitter") );
        $titlez    = esc_attr( get_option("shoutcast-icecast-html5-player-title") );
        $artist    = esc_attr( get_option("shoutcast-icecast-html5-player-artist") );
?>
<div class="wrap">
<h2>Shoutcast Icecast HTML5 Radio Player Options</h2>

<form method="post">
<?php wp_nonce_field('shoutcast-icecast-html5-player-updatesettings'); ?>

<table class="form-table">

<tr>
<th><label>Radio Stream Link</label></th>
<td><input type="text" name="radiolink" value="<?php echo $radiolink; ?>" class="regular-text">

<p>
<b>Note</b>: Make sure you have valid MP3 Radio Stream, Don't include listen.pls in URL<br>

Shoutcast V1 (https://shoutcast-server-ip.port/)<br>
Shoutcast V2 (https://shoutcast-server-ip:port/streamname)<br>
Icecast (https://icecast-server-ip:port/streamname)<br>
Any MP3/Podcast Link (https://domain.com:port/file.mp3)<br>
</p>

</td>
</tr>

<tr>
<th><label>Radio Type</label></th>
<td>
<select name="radiotype">
<option value="shoutcast1" <?php selected($radiotype,'shoutcast1'); ?>>Shoutcast 1</option>
<option value="shoutcast2" <?php selected($radiotype,'shoutcast2'); ?>>Shoutcast 2</option>
<option value="icecast" <?php selected($radiotype,'icecast'); ?>>Icecast</option>
<option value="podcast" <?php selected($radiotype,'podcast'); ?>>Podcast</option>
</select>
</td>
</tr>

<tr>
<th><label>Background Color</label></th>
<td>#<input type="text" name="bcolor" value="<?php echo $bcolor; ?>"></td>
</tr>

<tr><th><label>Artwork Image</label></th><td><input type="text" name="image" value="<?php echo $image; ?>" class="regular-text"></td></tr>

<tr><th><label>Radio Title</label></th><td><input type="text" name="title" value="<?php echo $titlez; ?>" class="regular-text"></td></tr>

<tr><th><label>Radio Artist</label></th><td><input type="text" name="artist" value="<?php echo $artist; ?>" class="regular-text"></td></tr>

<tr><th><label>Facebook</label></th><td><input type="text" name="facebook" value="<?php echo $facebook; ?>" class="regular-text"></td></tr>

<tr><th><label>Twitter</label></th><td><input type="text" name="twitter" value="<?php echo $twitter; ?>" class="regular-text"></td></tr>

</table>

<p><input type="submit" name="submit" class="button-primary" value="Save Changes"></p>

</form>

<p>
    

<?php echo shoutcast_icecast_html5_player(""); ?>


</p>

</div>
<?php
    }
}

}

add_action('admin_menu', array('Shoutcast_Icecast_HTML5_Player','add_config_page'));

/* ---------------------------------------------------------------
   Shortcode With Sanitization + Escaping (Security Fixed)
--------------------------------------------------------------- */

function shoutcast_icecast_html5_player($atts) {

    // default options
    $defaults = array(
        'radiolink' => get_option("shoutcast-icecast-html5-player-radiolink"),
        'radiotype' => get_option("shoutcast-icecast-html5-player-radiotype"),
        'bcolor'    => get_option("shoutcast-icecast-html5-player-bcolor"),
        'image'     => get_option("shoutcast-icecast-html5-player-image"),
        'facebook'  => get_option("shoutcast-icecast-html5-player-facebook"),
        'twitter'   => get_option("shoutcast-icecast-html5-player-twitter"),
        'title'     => get_option("shoutcast-icecast-html5-player-title"),
        'artist'    => get_option("shoutcast-icecast-html5-player-artist"),
    );

    $a = shortcode_atts($defaults, $atts, 'html5radio');

    // sanitize all attributes
    $radiolink = esc_url_raw($a['radiolink']);
    $radiotype = sanitize_text_field($a['radiotype']);
    $bcolor    = sanitize_text_field($a['bcolor']);
    $image     = esc_url_raw($a['image']);
    $facebook  = esc_url_raw($a['facebook']);
    $twitter   = esc_url_raw($a['twitter']);
    $titlez    = sanitize_text_field($a['title']);
    $artist    = sanitize_text_field($a['artist']);

    // validate radiotype
    $allowed_types = ['shoutcast','shoutcast1','shoutcast2','icecast','podcast'];
    if (!in_array($radiotype, $allowed_types, true)) {
        $radiotype = 'shoutcast';
    }

    // normalize types
    if (in_array($radiotype, ['podcast','shoutcast1','shoutcast2'], true)) {
        $radiotype = 'shoutcast';
    }

    // secure URL building
    $params = array(
        'radiotype' => $radiotype,
        'radiolink' => $radiolink,
        'bcolor'    => $bcolor,
        'image'     => $image,
        'facebook'  => $facebook,
        'twitter'   => $twitter,
        'title'     => $titlez,
        'artist'    => $artist,
        'rand'      => wp_rand(1000,9999)
    );

    $iframe_url = add_query_arg($params, 'https://player.radioforge.com/v2/'.$radiotype.'.html');
    $iframe_url = esc_url($iframe_url);

    $return = "";
    
    if($atts == "")
    {    
      
      $return .= '<h4>Shortcode</h4>';

      $return .= '[html5radio radiolink="'.$radiolink.'" radiotype="'.$radiotype.'" bcolor="'.$bcolor.'" image="'.$image.'" title="'.$titlez.'" artist="'.$artist.'" facebook="'.$facebook.'" twitter="'.$twitter.'"]<br>';

      $return .= '<h4>Embed Code</h4>';

      $return .= '<textarea id="comment" name="userComment" rows="7" cols="70" placeholder="Embed Code..." maxlength="500"><iframe src="'. $iframe_url .'" frameborder="0" width="367" height="227" scrolling="no"></iframe></textarea>';

      $return .= '<h4>Preview</h4>';

    }  


    $return .= '<iframe src="'. $iframe_url .'" frameborder="0" width="367" height="227" scrolling="no"></iframe>';

    return $return;
}

add_shortcode('html5radio', 'shoutcast_icecast_html5_player');

/* ---------------------------------------------------------------
   Upgrade Link
--------------------------------------------------------------- */

function upgrade_to_pro_html5_radio_player($links) { 
    $links[] = '<a href="https://www.radioforge.com/" target="_blank">Go Pro</a>'; 
    return $links;
}

$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_{$plugin}", 'upgrade_to_pro_html5_radio_player');

?>
