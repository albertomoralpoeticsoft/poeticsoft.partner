<?php

/**
 * Plugin Name: Poetic Soft Partner
 * Description: Herramientas que facilitan la vida digital
 * Version: 0.0.11
 * Author: Alberto Moral / poeticsoft.com
 * License: GPL2
 * Text Domain: poeticsoft
 */

if (! defined('ABSPATH')) { exit; }

require __DIR__ . '/tools/plugin-update-checker/plugin-update-checker.php';

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
  'https://poeticsoft.com/plugins/poeticsoft-partner.json',
  __FILE__
);

require_once __DIR__ . '/class/poeticsoft-partner.php';

function poeticsoft_partner_init() {
  
  return Poeticsoft_Partner::get_instance();
}
poeticsoft_partner_init();