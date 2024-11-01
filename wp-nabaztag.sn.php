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
header('Content-type: text/xml');
// Incluir funciones del WordPress
$wptrd = dirname(dirname(dirname(dirname(__FILE__))));
if (file_exists($wptrd.'/wp-load.php')) {
	require_once($wptrd.'/wp-load.php'); // Wordpress >= 2.6
} else {
	require_once($wptrd.'/wp-config.php'); // Wordpres < 2.6
}
// Comienzo del sistema de envio
$opciones = get_option('widget_wpnabaztag');
if (($_POST['wpnabaztag-mensaje']) && ($enviar = fopen('http://api.nabaztag.com/vl/FR/api.jsp?sn='.$opciones['nserie'].'&token='.$opciones['nautor'].'&tts='.str_replace(" ", "+",$_POST['wpnabaztag-mensaje']).'&voice='.$opciones['voztts'], 'rb'))) {
	echo stream_get_contents($enviar);
	fclose($enviar);
} elseif (($_POST['nautor']) && ($_POST['nserie']) && ($enviar = fopen('http://api.nabaztag.com/vl/FR/api.jsp?sn='.$_POST['nserie'].'&token='.$_POST['nautor'].'&action=9', 'rb'))) {
	echo stream_get_contents($enviar);
	fclose($enviar);
} else {
	$error = __('Unexpected error', 'wp-nabaztag');
	echo '<?xml version="1.0" encoding="UTF-8"?><rsp><message>WP-NABAZTAG ERROR</message><comment>'.$error.'</comment></rsp>';
}
?>