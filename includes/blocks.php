<?php

namespace Fuel_Logic_Service_Area\Blocks;


class Blocks
{

  /**
   * Constructor.
   *
   * @since  1.0.0
   */
  public function __construct()
  {
    add_action('init', array($this, 'create_block_blocks_block_init'));
  }


  /**
   * Registers the block using the metadata loaded from the `block.json` file.
   * Behind the scenes, it registers also all assets so they can be enqueued
   * through the block editor in the corresponding context.
   *
   * @see https://developer.wordpress.org/reference/functions/register_block_type/
   */
  public function create_block_blocks_block_init()
  {
    register_block_type(BLOCKS_ROOT_DIR . 'build/fuel_logic_zipcode_form');
    register_block_type(BLOCKS_ROOT_DIR . 'build/fuel_logic_map');
    register_block_type(BLOCKS_ROOT_DIR . 'build/fuel_logic_order_form');
    register_block_type(BLOCKS_ROOT_DIR . 'build/fuel_logic_zipcode');
  }
}
