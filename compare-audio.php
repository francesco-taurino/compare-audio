<?php if ( ! defined( 'ABSPATH' ) ) exit; 
/**
 * Plugin Name:		Compare Audio
 * Plugin URI:		https://www.francescotaurino.com/wordpress/compare-audio
 * GitHub Plugin URI: francesco-taurino/compare-audio
 * Description:		Ascolta due file audio in modo sincronizzato. Before/After edit. Versione privata.
 * Author:			Francesco Taurino
 * Author URI:		https://www.francescotaurino.com
 * Version:			0.0.3
 * Text Domain:		compare-audio
 * Domain Path:		/languages
 * License:			GPL v3
 *
 * @package     	Compare_Audio
 * @author      	Francesco Taurino <dev.francescotaurino@gmail.com>
 * @copyright   	Copyright (c) 2017, Francesco Taurino
 * @license     	http://www.gnu.org/licenses/gpl-3.0.html
 *              
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see http://www.gnu.org/licenses/gpl-3.0.html.
 */

/**
https://stackoverflow.com/questions/31307306/wordpress-shortcodes-pass-array-of-values?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa
https://stackoverflow.com/a/19792168
document.addEventListener('play', function(e){
    var audios = document.getElementsByTagName('audio');
    for(var i = 0, len = audios.length; i < len;i++){
        if(audios[i] != e.target){
            audios[i].pause();
        }
    }
}, true);
*/


add_shortcode('compare-audio', 'button_shortcode'); 
function button_shortcode( $atts, $content = null ) {

	ob_start();
	$id = uniqid();
	$id1 = 'player1-'.esc_attr($id);
	$id2 = 'player2-'.esc_attr($id);
  	$attributes = shortcode_atts( array(
	'url1' => 'url1',
	'url2' => 'url2',
	'type' => 'type'
	), $atts );

	$url1 = isset($attributes['url1']) ? esc_url($attributes['url1']) : '';
	$url2 = isset($attributes['url2']) ? esc_url($attributes['url2']) : '';
	$type = isset($attributes['type']) ? $attributes['type'] : '';

?>

<audio id="<?php echo $id1; ?>">
  <source src="<?php echo esc_url($url1); ?>">
</audio>

<audio id="<?php echo $id2; ?>">
  <source src="<?php echo esc_url($url2); ?>">
</audio>

<button class="btn btn-primary" onclick="
document.getElementById('<?php echo $id2; ?>').preload = 'auto';
document.getElementById('<?php echo $id1; ?>').play();
document.getElementById('<?php echo $id2; ?>').play();
document.getElementById('<?php echo $id1; ?>').volume = 1.0;
document.getElementById('<?php echo $id2; ?>').volume = 0.0;
">
Before
</button>

<button class="btn btn-primary" onclick="
document.getElementById('<?php echo $id1; ?>').preload = 'auto';
document.getElementById('<?php echo $id2; ?>').play();
document.getElementById('<?php echo $id1; ?>').play();
document.getElementById('<?php echo $id2; ?>').volume = 1.0;
document.getElementById('<?php echo $id1; ?>').volume = 0.0;
">
After
</button>


<?php if( $type == '2' ){ ?>
<button class="btn btn-secondary" onclick="
document.getElementById('<?php echo $id1; ?>').pause(); 
document.getElementById('<?php echo $id2; ?>').pause();
">
Pause
</button>
<?php } ?>

<button class="btn btn-secondary" onclick="
document.getElementById('<?php echo $id1; ?>').pause(); 
document.getElementById('<?php echo $id2; ?>').pause(); 
document.getElementById('<?php echo $id1; ?>').currentTime = 0; 
document.getElementById('<?php echo $id2; ?>').currentTime = 0;
">
Stop
</button>
<br />


<?php
$out = ob_get_contents(); // Store buffer in variable
ob_end_clean(); // End buffering and clean up
echo $out;
}
