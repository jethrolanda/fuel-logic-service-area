<?php
// This template can be called with the following code; \Fuel_Logic_Service_Area\get_template( 'form.php' );
//
// Override this template by creating a new file in your active theme 'wp-content/your-theme/fuel-logic-service-area/form.php' or 'wp-content/your-theme/form.php'


/**
 * @var string $google_api_key Google Maps API key
 * @var string $url Google Maps API URL
 * @var string $signature      Google digital signature (https://developers.google.com/maps/documentation/maps-static/digital-signature?authuser=1)
 */

/* Static map (no proper search / selection): <img src="https://maps.googleapis.com/maps/api/staticmap?query=75211,TX&zoom=14&size=400x400&key=<?php echo esc_attr( $google_api_key ); ?>" alt=""> */
?>


<iframe
	width="400"
	height="400"
	style="border:0; max-width: 100%;"
	loading="lazy"
	allowfullscreen
	referrerpolicy="no-referrer-when-downgrade"
	src="<?php echo esc_url( $url ); ?>">
</iframe>
