<?php

/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 *
 * The following variables are exposed to the file:
 *     $attributes (array): The block attributes.
 *     $content (string): The block default content.
 *     $block (WP_Block): The block instance.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

// Global State
wp_interactivity_state('service-area', array(
  'state_zipcodes' => FLSA_STATE_ZIPCODES,
  'banned_zipcodes' => array(),
  'attributes' => $attributes,
  'current_url' => get_permalink(get_the_ID())
));

// Local Context
$context = array(
  'showMessages' => false,
  'zipcode' => isset($_GET['zipcode']) ? $_GET['zipcode'] : null,
  'zipfound' => null,
  'zipinvalid' => null,
  'zipbanned' => null,
  'state' => array(),
  'submitClicked' => false,
  'textRef' => null
);

$successMessagePattern = '';
$failMessagePattern = '';
$bannedMessagePattern = '';
if (isset($attributes['successMessagePattern'])) {
  $successMessagePattern = $attributes['successMessagePattern'];
}
if (isset($attributes['failMessagePattern'])) {
  $failMessagePattern = $attributes['failMessagePattern'];
}
if (isset($attributes['bannedMessagePattern'])) {
  $bannedMessagePattern = $attributes['bannedMessagePattern'];
}
?>
<div class="fuel-logic-service-area-wrapper-class">
  <div
    data-wp-interactive="service-area"
    data-wp-watch="callbacks.setGoogleMap"
    data-wp-init="callbacks.onLoad"
    <?php echo wp_interactivity_data_wp_context($context); ?>
    <?php echo get_block_wrapper_attributes(); ?>>
    <div class="flex gap-4 justify-center items-center">
      <label for="zip-code">Zip Code:</label>
      <input id="zip-code" class="rounded-md bg-white py-2 px-4 text-base text-gray-900 " data-wp-bind--value="context.zipcode" value="<?php echo $context['zipcode'] > 0 ? $context['zipcode'] : ''; ?>" type="number" min="1" step="1" data-wp-on--keyup="callbacks.setZipcode">
      <button data-wp-on--click="actions.submit" class="bg-lime-400 p-2 text-black rounded-md text-md">Submit</button>
      <button class="text-sm" data-wp-on--click="actions.clear">Clear</button>
    </div>

    <div data-wp-init--log="context.showMessages" data-wp-bind--hidden="!context.showMessages">
      <!-- <button data-wp-bind--hidden="!state.hasResult" data-wp-on--click="actions.goBack">Back</button> -->
      <div data-wp-bind--hidden="!context.zipfound">
        <?php echo do_blocks(get_post_field('post_content', $successMessagePattern)); ?>
      </div>
      <div data-wp-bind--hidden="!context.zipinvalid">
        <?php echo do_blocks(get_post_field('post_content', $failMessagePattern)); ?>
      </div>
      <div data-wp-bind--hidden="!context.zipbanned">
        <?php echo do_blocks(get_post_field('post_content', $bannedMessagePattern)); ?>
      </div>
    </div>
  </div>
</div>