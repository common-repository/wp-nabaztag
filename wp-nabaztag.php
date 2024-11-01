<?
/*
Plugin Name: WP-Nabaztag
Plugin URI: http://skg.eien-no-ai.net/mis-proyectos/
Description: Widget to allow your visitors contact you through your Nabaztag
Author: >-]~SkG~[-->
Version: 1.0.1
Author URI: http://skg.eien-no-ai.net/
Text Domain: wp-nabaztag
*/
/*
   Copyright (C) 2009 Sergio Conde (http://skg.eien-no-ai.net/)

   This program is free software; you can redistribute it and/or
   modify it under the terms of the GNU General Public License
   as published by the Free Software Foundation; either version 2
   of the License, or (at your option) any later version.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
   GNU General Public License for more details.

   GNU GPL v2: http://www.gnu.org/licenses/gpl-2.0.txt
*/
function widget_wpnabaztag_init() {
	if (!function_exists('register_sidebar_widget')) { return; }
	// Carga de idiomas
	load_plugin_textdomain('wp-nabaztag', 'wp-content/plugins/wp-nabaztag');
	// Funcion del Widget
	function widget_wpnabaztag($args) {
		// Compatibilidad con Wordpres < 2.6
		if (!defined('WP_CONTENT_DIR')) { define('WP_CONTENT_DIR', ABSPATH . 'wp-content'); }
		if (!defined('WP_CONTENT_URL')) { define('WP_CONTENT_URL', get_option('siteurl') . '/wp-content'); }
		if (!defined('WP_PLUGIN_DIR')) { define('WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins'); }
		if (!defined('WP_PLUGIN_URL')) { define('WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins'); }
		// URL y Directorio del plugin
		$wpn_dir = WP_PLUGIN_DIR.'/'.plugin_basename(dirname(__FILE__));
		$wpn_url = WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__));
		// Comienzo del widget
		extract($args);
		$opciones = get_option('widget_wpnabaztag');
		echo $before_widget;
		echo $before_title . $opciones['titulo'] . $after_title;
		if((!$opciones['nserie']) || (!$opciones['nautor'])) { ?>
			<p><? _e('This widget must be configurated before use it', 'wp-nabaztag'); ?></p>
		<? } else {
			if ($opciones['texto']) { ?><? echo $opciones['texto']; ?><br /><? } ?>
			<script type="text/javascript">//<![CDATA[
				if (typeof jQuery == 'undefined') { document.write('<script type="text/javascript" src="<? echo $wpn_url; ?>/jquery.js"><\/script>'); }
			//]]></script>
			<script type="text/javascript" src="<? echo $wpn_url; ?>/wp-nabaztag.js.php"></script>
			<form id="wpnabaztag-form" method="post" action="">
				<p style="margin: 0;"><textarea <? if ($opciones['tclass']) { echo 'class="'.$opciones['tclass'].'" '; } if ($opciones['tstyle']) { echo 'style="'.$opciones['tstyle'].'" '; } ?>id="wpnabaztag-mensaje" cols="<? echo $opciones['tcols']; ?>" rows="<? echo $opciones['trows']; ?>"></textarea></p>
				<p style="margin: 0; text-align: <? echo $opciones['balign']; ?>;"><input <? if ($opciones['bclass']) { echo 'class="'.$opciones['bclass'].'" '; } if ($opciones['bstyle']) { echo 'style="'.$opciones['bstyle'].'" '; } ?>type="submit" id="wpnabaztag-enviar" value="<? _e('Send', 'wp-nabaztag'); ?>" /></p>
			</form>
			<div id="wpnabaztag-carga" style="display:none;text-align:center;"><img src="<? echo $wpn_url; ?>/load.gif" alt="Loading..." /></div>
			<div id="wpnabaztag-resp" style="display:none;text-align:center;"></div>
			<div id="wpnabaztag-volver" style="display:none;text-align:center;"><a href="#"><? _e('Go back', 'wp-nabaztag'); ?></a></div>
		<? }
		echo $after_widget;
	}
	// Funcion de la configuracion del Widget
	function widget_wpnabaztag_control() {
		// Compatibilidad con Wordpres < 2.6
		if (!defined('WP_CONTENT_DIR')) { define('WP_CONTENT_DIR', ABSPATH . 'wp-content'); }
		if (!defined('WP_CONTENT_URL')) { define('WP_CONTENT_URL', get_option('siteurl') . '/wp-content'); }
		if (!defined('WP_PLUGIN_DIR')) { define('WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins'); }
		if (!defined('WP_PLUGIN_URL')) { define('WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins'); }
		// URL y Directorio del plugin
		$wpn_dir = WP_PLUGIN_DIR.'/'.plugin_basename(dirname(__FILE__));
		$wpn_url = WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__));
		// Comienzo de la configuracion
		$opciones = get_option('widget_wpnabaztag');
		if (!is_array($opciones)) { $opciones = array('titulo'=>'Nabaztag', 'tcols' => '30', 'trows' => '4'); }
		if ($_POST['wpnabaztag-submit']) {
			$opciones['titulo'] = htmlspecialchars($_POST['wpnabaztag-titulo'], ENT_QUOTES);
			$opciones['texto'] = htmlspecialchars($_POST['wpnabaztag-texto'], ENT_QUOTES);
			$opciones['tcols'] = $_POST['wpnabaztag-tcols'];
			$opciones['trows'] = $_POST['wpnabaztag-trows'];
			$opciones['tclass'] = $_POST['wpnabaztag-tclass'];
			$opciones['tstyle'] = $_POST['wpnabaztag-tstyle'];
			$opciones['balign'] = $_POST['wpnabaztag-balign'];
			$opciones['bclass'] = $_POST['wpnabaztag-bclass'];
			$opciones['bstyle'] = $_POST['wpnabaztag-bstyle'];
			$opciones['nserie'] = $_POST['wpnabaztag-nserie'];
			$opciones['nautor'] = $_POST['wpnabaztag-nautor'];
			$opciones['voztts'] = $_POST['wpnabaztag-voztts'];
			update_option('widget_wpnabaztag', $opciones);
		}
		?>
		<script type="text/javascript">//<![CDATA[
			if (typeof jQuery == 'undefined') { document.write('<script type="text/javascript" src="<? echo $wpn_url; ?>/jquery.js"><\/script>'); }
		//]]></script>
		<script type="text/javascript" src="<? echo $wpn_url; ?>/wp-nabaztag.js.php"></script>
		<p>
			<strong><? _e('Widget config', 'wp-nabaztag'); ?></strong><br /><br />
			<label for="wpnabaztag-titulo"><? _e('Title', 'wp-nabaztag'); ?><input type="text" class="widefat" id="wpnabaztag-titulo" name="wpnabaztag-titulo" value="<? echo html_entity_decode($opciones['titulo'], ENT_QUOTES); ?>" /></label><br />
			<label for="wpnabaztag-texto"><? _e('Main text', 'wp-nabaztag'); ?><input type="text" class="widefat" id="wpnabaztag-texto" name="wpnabaztag-texto" value="<? echo html_entity_decode($opciones['texto'], ENT_QUOTES); ?>" /></label><br /><br />
			<? _e('Textarea', 'wp-nabaztag'); ?>:<br /><br />
			<label for="wpnabaztag-tcols">Cols: <input type="text" class="widefat" id="wpnabaztag-tcols" name="wpnabaztag-tcols" value="<? echo $opciones['tcols']; ?>" /></label><br />
			<label for="wpnabaztag-trows">Rows: <input type="text" class="widefat" id="wpnabaztag-trows" name="wpnabaztag-trows" value="<? echo $opciones['trows']; ?>" /></label><br />
			<label for="wpnabaztag-tclass">Class: <input type="text" class="widefat" id="wpnabaztag-tclass" name="wpnabaztag-tclass" value="<? echo $opciones['tclass']; ?>" /></label><br />
			<label for="wpnabaztag-tstyle">Style: <input type="text" class="widefat" id="wpnabaztag-tstyle" name="wpnabaztag-tstyle" value="<? echo $opciones['tstyle']; ?>" /></label><br /><br />
			<? _e('Submit button', 'wp-nabaztag'); ?>:<br /><br />
			<label for="wpnabaztag-balign"><? _e('Align', 'wp-nabaztag'); ?>:<select class="widefat" id="wpnabaztag-balign" name="wpnabaztag-balign" style="width: 92%;">
				<option value="left"<? if ($opciones['balign'] == 'left') { echo ' selected="selected"'; } ?>><? _e('Left', 'wp-nabaztag'); ?></option>
				<option value="center"<? if ($opciones['balign'] == 'center') { echo ' selected="selected"'; } ?>><? _e('Center', 'wp-nabaztag'); ?></option>
				<option value="right"<? if ($opciones['balign'] == 'right') { echo ' selected="selected"'; } ?>><? _e('Right', 'wp-nabaztag'); ?></option>
			</select></label>
			<label for="wpnabaztag-bclass">Class:<input type="text" class="widefat" id="wpnabaztag-bclass" name="wpnabaztag-bclass" value="<? echo $opciones['bclass']; ?>" /></label><br />
			<label for="wpnabaztag-bstyle">Style:<input type="text" class="widefat" id="wpnabaztag-bstyle" name="wpnabaztag-bstyle" value="<? echo $opciones['bstyle']; ?>" /></label>
		</p>
		<hr>
		<p>
			<strong><? _e('Nabaztag config', 'wp-nabaztag'); ?></strong><br /><br />
			<label for="wpnabaztag-nserie"><? _e('Serial number', 'wp-nabaztag'); ?>:<input type="text" class="widefat" id="wpnabaztag-nserie" name="wpnabaztag-nserie" value="<? echo $opciones['nserie']; ?>" /></label><br />
			<label for="wpnabaztag-nautor"><? _e('Token number', 'wp-nabaztag'); ?>:<input type="text" class="widefat" id="wpnabaztag-nautor" name="wpnabaztag-nautor" value="<? echo $opciones['nautor']; ?>" /></label><br />
			<label for="wpnabaztag-voztts"><? _e('TTS Voice', 'wp-nabaztag'); ?>:<select class="widefat" id="wpnabaztag-voztts" name="wpnabaztag-voztts" style="width: 92%;">
			<? if ($opciones['voztts']) { echo '<option value="'.$opciones['voztts'].'" selected="selected">-- '.$opciones['voztts'].' --</option>'; } else { $seluna = __('Select one', 'wp-nabaztag'); echo '<option value="'.$seluna.'" selected="selected">-- '.$seluna.' --</option>'; } ?>
			</select><a href="#" id="wpnabaztag-listatts"><? _e('Get list', 'wp-nabaztag'); ?></a></label>
			<div id="wpnabaztag-error"></div>
		</p>
		<input type="hidden" id="wpnabaztag-submit" name="wpnabaztag-submit" value="1" />
		<?
	}
	wp_register_sidebar_widget('wp-nabaztag', 'WP-Nabaztag', 'widget_wpnabaztag', array('classname' => 'widget_wpnabaztag', 'description' => __('Widget to allow your visitors contact you through your Nabaztag', 'wpnabaztag')));
	wp_register_widget_control('wp-nabaztag', 'WP-Nabaztag', 'widget_wpnabaztag_control');
}
add_action('widgets_init', 'widget_wpnabaztag_init');
?>
