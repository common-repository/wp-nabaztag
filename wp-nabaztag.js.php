<?
/*
   Copyright (C) 2009 Sergio Conde (http://skg.eien-no-ai.net/)

   This file was intended for distribution with the WP-Nabaztag
   Wordpress plugin by Sergio Conde. See wp-nabaztag.php for
   addition information.

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
header('Content-type: text/javascript');
// Incluir funciones del WordPress
$wptrd = dirname(dirname(dirname(dirname(__FILE__))));
if (file_exists($wptrd.'/wp-load.php')) {
	require_once($wptrd.'/wp-load.php'); // Wordpress >= 2.6
} else {
	require_once($wptrd.'/wp-config.php'); // Wordpres < 2.6
}
// Compatibilidad con Wordpres < 2.6
if (!defined('WP_CONTENT_DIR')) { define('WP_CONTENT_DIR', ABSPATH . 'wp-content'); }
if (!defined('WP_CONTENT_URL')) { define('WP_CONTENT_URL', get_option('siteurl') . '/wp-content'); }
if (!defined('WP_PLUGIN_DIR')) { define('WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins'); }
if (!defined('WP_PLUGIN_URL')) { define('WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins'); }
// URL y Directorio del plugin
$wpn_dir = WP_PLUGIN_DIR.'/'.plugin_basename(dirname(__FILE__));
$wpn_url = WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__));
// Comienzo del javascript
?>
jQuery(document).ready(function(){
	// Configuracion
	jQuery("#wpnabaztag-listatts").click(function(){
		jQuery('#wpnabaztag-error').html('');
		jQuery.post(
			"<? echo $wpn_url; ?>/wp-nabaztag.sn.php",
			"nserie="+jQuery('#wpnabaztag-nserie').val()+"&nautor="+jQuery('#wpnabaztag-nautor').val(),
			function(resp){
				if (jQuery(resp).find('message').text()) {
					jQuery('#wpnabaztag-error').html('<strong>ERROR</strong>: '+jQuery(resp).find('comment').text());
				} else {
					jQuery("#wpnabaztag-voztts").html('');
					jQuery(resp).find('voice').each(function(){
						jQuery("#wpnabaztag-voztts").html(jQuery("#wpnabaztag-voztts").html()+'<option value='+jQuery(this).attr('command')+'>'+jQuery(this).attr('command')+' ('+jQuery(this).attr('lang')+')'+'</option>');
					});
				}
			},
			"xml"
		);
	});
	// Widget
	jQuery("#wpnabaztag-volver").click(function(){
		jQuery('#wpnabaztag-resp').hide();
		jQuery('#wpnabaztag-resp').html('');
		jQuery('#wpnabaztag-volver').hide();
		jQuery('#wpnabaztag-mensaje').val('');
		jQuery('#wpnabaztag-form').fadeIn();
	});
	jQuery("#wpnabaztag-form").submit(function(){
		jQuery('#wpnabaztag-form').hide();
		if(jQuery('#wpnabaztag-mensaje').val()) {
			jQuery('#wpnabaztag-carga').fadeIn();
			jQuery.post(
				"<? echo $wpn_url; ?>/wp-nabaztag.sn.php",
				"wpnabaztag-mensaje=" + jQuery('#wpnabaztag-mensaje').val(),
				function(resp){
					if (jQuery(resp).find('message').text() != 'TTSSENT') {
						jQuery('#wpnabaztag-resp').html('<strong>ERROR</strong>: '+jQuery(resp).find('comment').text());
					} else {
						jQuery('#wpnabaztag-resp').html('<? _e('Message sent', 'wp-nabaztag'); ?>');
					}
					jQuery('#wpnabaztag-carga').hide();
				},
				"xml"
			);
		} else {
			jQuery('#wpnabaztag-resp').html('<? _e('You have not written a message', 'wp-nabaztag'); ?>');
		}
		jQuery('#wpnabaztag-resp').fadeIn();
		jQuery('#wpnabaztag-volver').fadeIn();
	return false;
	});
});