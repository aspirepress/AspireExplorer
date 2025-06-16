<?php
header( 'Access-Control-Allow-Origin: *' );
header( 'Content-Type: application/json' );
$theme_url = isset( $_GET['theme'] ) ? htmlspecialchars( $_GET['theme'], ENT_QUOTES, 'UTF-8' ) : '';
?>
{
	"$schema": "https://playground.wordpress.net/blueprint-schema.json",
	"landingPage": "/",
	"features": {
		"networking": true
	},
	"steps": [
		{
			"step": "installTheme",
			"themeData": {
				"resource": "url",
				"url": "<?php echo $theme_url; ?>"
			},
			"options": {
				"activate": true,
				"importStarterContent": true
			}
		}
	]
}
