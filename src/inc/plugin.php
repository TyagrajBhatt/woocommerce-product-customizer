<?php 
namespace MKL\PC;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * This is the main entry point to the plugin. Everything starts here.
 */
class Plugin {
	/**
	 * @var Plugin
	 */
	public static $_instance = null;
	public $db = null;
	public $ajax = null;
	/**
	 * @var Extensions
	 */
	private $_extensions = array();

	/**
	 * Throw error on object clone
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	private function __clone() {
		// Cloning instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'No new class... Cheatin&#8217; huh?', MKL_PC_DOMAIN ), '1.0.0' );
	}

	/**
	 * Disable unserializing of the class
	 *
	 * @since 1.0.0
	 * @return void
	 */
	private function __wakeup() {
		// Unserializing instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'No serializing... Cheatin&#8217; huh?', MKL_PC_DOMAIN ), '1.0.0' );
	}

	/**
	 * Get the instance
	 *
	 * @return Plugin
	 */
	public static function instance() {
		if ( self::$_instance == null ) {
			self::$_instance = new Plugin();
		}
		return static::$_instance;
	}

	/**
	 * Include all the required dependencies
	 *
	 * @return void
	 */
	private function _includes() {
		include( MKL_PC_INCLUDE_PATH . 'utils.php' );
		include( MKL_PC_INCLUDE_PATH . 'images.php' );
		include( MKL_PC_INCLUDE_PATH . 'functions.php' );
		
		include( MKL_PC_INCLUDE_PATH . 'base/product.php' );
		include( MKL_PC_INCLUDE_PATH . 'base/layer.php' );
		include( MKL_PC_INCLUDE_PATH . 'base/angle.php' );
		include( MKL_PC_INCLUDE_PATH . 'base/choice.php' );
		include( MKL_PC_INCLUDE_PATH . 'base/configuration.php' );

		include( MKL_PC_INCLUDE_PATH . 'cache.php' );
		include( MKL_PC_INCLUDE_PATH . 'db.php' );
		include( MKL_PC_INCLUDE_PATH . 'ajax.php' );
		include( MKL_PC_INCLUDE_PATH . 'update.php' );

		include( MKL_PC_INCLUDE_PATH . 'frontend/frontend-woocommerce.php' );

		if( is_admin() ) {
			include ( MKL_PC_INCLUDE_PATH . 'admin/admin-woocommerce.php' );
		}
	}

	/**
	 * Register an extension / addon
	 *
	 * @param string $name  - The addon name
	 * @param object $class - Addon instance
	 * @return void
	 */
	public function register_extension( $name, $class ) {
		if( ! isset( $this->_extensions[$name]) ) {
			$this->_extensions[$name] = $class; 
		}
	}

	/**
	 * Get an extension instance
	 *
	 * @param string $name
	 * @return object
	 */
	public function get_extension( $name ) {
		if( ! isset( $this->_extensions[$name]) ) {
			return false;
		}
		return $this->_extensions[$name];
	}

	/**
	 * Get all extensions
	 *
	 * @return array
	 */
	public function get_extensions() {
		return $this->_extensions;
	}

	/**
	 * Construct and setup hooks
	 */
	protected function __construct() {
		add_action('plugins_loaded', array( $this, 'init'), 10 );
	}

	/**
	 * Initialize the plugin
	 *
	 * @return void
	 */
	public function init() {
		if ( ! version_compare( WC()->version, '3.0', '>=' ) ) {
			add_action( 'admin_notices', 'mkl_pc_fail_woocommerce_version' );
			return;
		}

		$this->_includes();

		$this->frontend = new Frontend_Woocommerce();

		if( is_admin() ) {
			$this->admin = new Admin_Woocommerce();
		}

		$this->cache = new Cache();
		$this->db = new DB();
		$this->ajax = new Ajax();

		do_action( 'mkl_pc_is_loaded' );
	}
}

Plugin::instance();
// var_dump('$mkl_pl', $mkl_pl);

function mkl_pc() {
	return Plugin::instance();
}