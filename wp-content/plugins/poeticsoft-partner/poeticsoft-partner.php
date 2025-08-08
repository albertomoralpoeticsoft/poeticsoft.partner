<?php

/**
 * Plugin Name: Poetic Soft Partner
 * Description: Herramientas que facilitan la vida digital
 * Version: 0.0.1
 * Author: Alberto Moral / poeticsoft.com
 * License: GPL2
 * Text Domain: poeticsoft
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require __DIR__ . '/plugin-update-checker/plugin-update-checker.php';

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
  'https://poeticsoft.com/plugins/poeticsoft-partner.json',
  __FILE__
);