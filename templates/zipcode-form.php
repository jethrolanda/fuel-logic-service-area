<?php
// This template can be called with the following code; \Fuel_Logic_Service_Area\get_template( 'form.php' );
//
// Override this template by creating a new file in your active theme 'wp-content/your-theme/fuel-logic-service-area/form.php' or 'wp-content/your-theme/form.php'


?><form class="fuel-logic-service-area-form-wrap" method="post">
	<?php wp_nonce_field( 'fl_zipcode_check' ); ?>
	<input type="hidden" name="action" value="zipcode_check">

	<label for="zipcode"><?php _e( 'Zipcode', 'fuel-logic-service-area' ); ?></label>
	<input type="text" id="zipcode" name="zipcode" pattern="[0-9]{5}" value="">
	<input type="submit" value="<?php _e( 'Check', 'fuel-logic-service-area' ); ?>">
</form>
