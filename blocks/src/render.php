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
  'zipcode' => isset($_GET['zipcode']) ? $_GET['zipcode'] : 0,
  'zipfound' => null,
  'zipinvalid' => null,
  'zipbanned' => null,
  'state' => array(),
  'submitClicked' => false
);
// error_log(print_r($context, true));
?>
<div
  data-wp-interactive="service-area"
  data-wp-watch="callbacks.setGoogleMap"
  data-wp-init="callbacks.onLoad"
  <?php echo wp_interactivity_data_wp_context($context); ?>>
  <label for="name">Zip Code:</label>
  <input value="<?php echo $context['zipcode'] > 0 ? $context['zipcode'] : ''; ?>" type="number" min="1" step="1" data-wp-on--keyup="callbacks.setZipcode">
  <button data-wp-on--click="actions.submit">Submit</button>

  <div data-wp-init--log="callbacks.toggleMessages" data-wp-bind--hidden="!context.showMessages">
    <div data-wp-bind--hidden="!context.zipfound">
      <!-- <p data-wp-text="context.state.title"></p>
      <p data-wp-text="context.state.code"></p> -->
      <?php
      $content = $attributes['successMessagePattern'];
      echo get_post_field('post_content', $content);

      // $page1 = get_posts([
      //   'name'      => 'success-zipcode',
      //   'post_type' => 'wp_block'
      // ]);
      // if ($page1) {
      //   echo $page1[0]->post_content;
      // }
      ?>
    </div>
    <div data-wp-bind--hidden="!context.zipinvalid">
      <?php echo get_post_field('post_content', $attributes['failMessagePattern']); ?>
    </div>
    <div data-wp-bind--hidden="!context.zipbanned">
      <?php echo get_post_field('post_content', $attributes['bannedMessagePattern']); ?>
    </div>
    <?php



    // error_log(print_r($page, true));
    // if (class_exists('WP_Block_Patterns_Registry')) {

    //   // Replace 'my-pattern-slug' with your pattern's slug
    //   $pattern = WP_Block_Patterns_Registry::get_instance()->get_registered('fuel-logic-service-area/success-zipcode');


    //   if ($pattern && isset($pattern['content'])) {
    //     echo do_blocks($pattern['content']);
    //   }
    // }
    ?>
  </div>
</div>