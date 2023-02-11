<?php
/*
Plugin Name: Hasan Plugin
Plugin URI:
description: Hello! This is a test plugin. I am learning WordPress plugin development in this file. !
Version: 1.0.0
Author: Md Al Mehedi Hasan
*/

/**
 * @package MhPlugin
 */

defined('ABSPATH') or die('Hey, you can\t access this file, you silly human!!!');

if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
  require_once dirname(__FILE__) . '/vendor/autoload.php';
}

use Inc\Activate;
use Inc\Deactivate;
use Inc\Admin\AdminPages;
use Admin\admin;

class MhPlugin
{
  // Constructor
  // This is only need when we want to pass data when class is initializing 
  /* function __construct($string)
  {
    echo $string;
  } */

  public $plugin;
  function __construct()
  {
    //Initialize variables only is the best practice.

    /**
     * to have plugin name dynamicaly
     * to inject basename we have to use construct() 
     */
    $this->plugin = plugin_basename(__FILE__);
  }

  function register()
  {
    /**
     * add_action() function good to practice to call it in another function
     * We can use add_action() in construct but construct will be use only for initializing may be best practice.
     */

    /**
     * CUSTOM POST TYPE
     */
    add_action('init', array($this, 'custom_post_type'));

    /**
     * 
     * Tigger this enqueue only when it is called.
     * Developer can call it any specific time
     * In class instance initialization rest off the part
     * 
     * 
     * "admin_enqueue_scripts" this method enque file in admin end.
     * If we want to enqueue somthing to the front/general end just replace "admin" with "wp". Look next line.
     * "wp_enqueue_scripts"
     * 
     * If we need both admin end and general end enqueue we can use both of them in separeted register function
     * a) "function register_admin_scripts(){}"
     * b) "function register_general_scripts(){}"
     */
    add_action('admin_enqueue_scripts', array($this, 'enqueue'));


    /**
     * Adding Admin Menu
     */
    add_action('admin_menu', array($this, 'add_admin_pages'));

    /**
     * Adding admin menu page link
     * to have plugin name after "plugin_action_links_" in the first perameter we have to use plugin_basename
     * to set link we create new method called "settings_link"
     */
    // add_filter('plugin_action_links_' . $this->plugin, array($this, 'settings_link'));
    //second way off concatination using "";
    add_filter("plugin_action_links_$this->plugin", array($this, 'settings_link'));
  }

  /**
   * Defining the page and its properti
   *
   */
  public function add_admin_pages()
  {
    /**
     * always use underscore in slug
     * 110 is the menu position number, because we want it in the last menu that is why we use bigger number
     */
    add_menu_page('Mh Plugin', 'Mh Admin', 'manage_options', 'mh_plugin', array($this, 'admin_index'), 'dashicons-heart', 110);
  }
  /**
   * Admin menu page html and css file
   */
  public function admin_index()
  {
    //required template
    // require_once plugin_dir_path(__FILE__) . 'templates/admin.php';
    Admin::callAdmin();
  }
  /** 
   * Admin menu page link settings 
   * 
   */
  public function settings_link($links)
  {

    // To have href click custom menu in browser and copy the url after "wp-admin/"

    //add custom settings link
    // $settings_link = '<a href="options-general.php?page=mh_plugin">Settings</a>';
    $settings_link = '<a href="admin.php?page=mh_plugin">Settings</a>';
    array_push($links, $settings_link);
    return $links;
  }

  /**
   * Activate and Deactivate file is in "inc" folder
   * Call the "inc" folder's file system is given bellow. Search for "Register_Plugin_Files"
   */
  // Plugin Life cycle
  /* function activate()
  {
    // CPT => Custop Post Type
    // generated a CPT 
    $this->custom_post_type();

    // When someting change in database wordpress tiger refresh by this rule
    // flush rewrite rules
    flush_rewrite_rules();
  }
 */
  /*   function deactivate()
  {
    // flush rewrite rules
    flush_rewrite_rules();
  } */

  // This method file is created in "mh-plugin" folder as "uninstall.php"
  // function uninstall()
  // {
  //   // delete CPT

  // }

  // CPT Function
  function custom_post_type()
  {
    register_post_type('book', ['public' => true, 'label' => 'Books', 'menu_position' => 6]);
  }

  /**
   * Enqueue file in plugin development
   * "enqueue" function
   * Rest of the part is in "register" function after the "construct" function
   * This is an example of "how to use static method"
   */
  function enqueue()
  {
    //enqueue all our scripts
    wp_enqueue_style('mypluginstyle', plugins_url('/assets/mystyle.css', __FILE__));
    wp_enqueue_script('mypluginscript', plugins_url('/assets/myscript.js', __FILE__));
  }

  /** 
   * 2nd method of calling "inc" folder's file.
   * Search for "Activation--2nd method"
   */

  function activate()
  {
    // require_once plugin_dir_path(__FILE__) . 'inc/mh-plugin-activate.php';
    // MhPluginActivate::activate();
    Activate::activate();
  }
}

if (class_exists('MhPlugin')) {
  //This if condition is for safety precortion before initialize the class
  /* This initializing is used when constructor is being used
  $mhPlugin = new MhPlugin('Hello, I am passing a string'); */
  $mhPlugin = new MhPlugin();

  /**
   * Calling the enqueue function
   */
  $mhPlugin->register();
}

// regular function stracture
/* function customFunction($arg)
{
  echo $arg;
}
customFunction('This is my argument to echo'); */

/*
// Activation
register_activation_hook(__FILE__, array($mhPlugin, 'activate'));

// Deactivation
register_deactivation_hook(__FILE__, array($mhPlugin, 'deactivate'));
 */

//  Register_Plugin_Files
// Activation--1st method
// require_once plugin_dir_path(__FILE__) . 'inc/mh-plugin-activate.php';
// register_activation_hook(__FILE__, array('MhPluginActivate', 'activate'));

// Deactivation
// require_once plugin_dir_path(__FILE__) . 'inc/mh-plugin-deactivate.php';
// register_deactivation_hook(__FILE__, array('MhPluginDeactivate', 'deactivate'));

// Using namespace
Deactivate::deactivate();

// Activation--2nd method
/**
 * require_once function called in main class body after "enqueue" function
 * if we use this type of code we have wrap the whole code with if condition, & the condition is => "!class_exists('MhPlugin')"
 */

// register_activation_hook(__FILE__, array('MhPluginActivate', 'activate'));




/** 
 * composer is a package/dependency manager for php
 * composer.json is DNA of the php project.
 * to create the json file we have to do from command prompt
 * * go back to c drive
 * * goto to plugin folder
 * * "composer init" and enter
 */
