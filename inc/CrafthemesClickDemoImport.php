<?php

/**
 * Main Crafthemes Demo Import plugin class/file.
 *
 * @package CT_CTDI
 */

namespace CT_CTDI;

/**
 * Crafthemes Demo Import class, so we don't have to worry about namespaces.
 */
class CrafthemesClickDemoImport {
	/**
	 * The instance *Singleton* of this class
	 *
	 * @var object
	 */
	private static $instance;

	/**
	 * The instance of the CT_CTDI\Importer class.
	 *
	 * @var object
	 */
	public $importer;

	/**
	 * The resulting page's hook_suffix, or false if the user does not have the capability required.
	 *
	 * @var boolean or string
	 */
	private $plugin_page;

	/**
	 * Holds the verified import files.
	 *
	 * @var array
	 */
	public $import_files;

	/**
	 * The path of the log file.
	 *
	 * @var string
	 */
	public $log_file_path;

	/**
	 * The index of the `import_files` array (which import files was selected).
	 *
	 * @var int
	 */
	private $selected_index;

	/**
	 * The paths of the actual import files to be used in the import.
	 *
	 * @var array
	 */
	private $selected_import_files;

	/**
	 * Holds any error messages, that should be printed out at the end of the import.
	 *
	 * @var string
	 */
	public $frontend_error_messages = array();

	/**
	 * Was the before content import already triggered?
	 *
	 * @var boolean
	 */
	private $before_import_executed = false;

	/**
	 * Make plugin page options available to other methods.
	 *
	 * @var array
	 */
	private $plugin_page_setup = array();

	/**
	 * Returns the *Singleton* instance of this class.
	 *
	 * @return OneClickDemoImport the *Singleton* instance.
	 */
	public static function get_instance() {
		if (null === static::$instance) {
			static::$instance = new static();
		}

		return static::$instance;
	}


	/**
	 * Class construct function, to initiate the plugin.
	 * Protected constructor to prevent creating a new instance of the
	 * *Singleton* via the `new` operator from outside of this class.
	 */
	protected function __construct() {
		// Actions.
		add_action('admin_menu', array($this, 'create_plugin_page'));
		add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
		add_action('wp_ajax_CT_CTDI_import_demo_data', array($this, 'import_demo_data_ajax_callback'));
		add_action('wp_ajax_CT_CTDI_import_customizer_data', array($this, 'import_customizer_data_ajax_callback'));
		add_action('wp_ajax_CT_CTDI_after_import_data', array($this, 'after_all_import_data_ajax_callback'));
		add_action('after_setup_theme', array($this, 'setup_plugin_with_filter_data'));
		add_action('plugins_loaded', array($this, 'load_textdomain'));
	}


	/**
	 * Private clone method to prevent cloning of the instance of the *Singleton* instance.
	 *
	 * @return void
	 */
	private function __clone() {
	}


	/**
	 * Private unserialize method to prevent unserializing of the *Singleton* instance.
	 *
	 * @return void
	 */
	public function __wakeup() {
	}


	/**
	 * Creates the plugin page and a submenu item in WP Appearance menu.
	 */
	public function create_plugin_page() {
		$this->plugin_page_setup = apply_filters('ct-CT_CTDI/plugin_page_setup', array(
			'parent_slug' => 'themes.php',
			'page_title'  => esc_html__('Crafthemes Demo Import', 'ct-ctdi'),
			'menu_title'  => esc_html__('Import Demo', 'ct-ctdi'),
			'capability'  => 'import',
			'menu_slug'   => 'ct-crafthemes-demo-import',
		));

		$CT_CTDI_theme = wp_get_theme();
		$this->plugin_page = add_menu_page(
			$this->plugin_page_setup['page_title'],
			$this->plugin_page_setup['menu_title'],
			$this->plugin_page_setup['capability'],
			$this->plugin_page_setup['menu_slug'],
			apply_filters('ct-CT_CTDI/plugin_page_display_callback_function', array($this, 'display_plugin_page')),
			'dashicons-download',
			59
		);

		register_importer($this->plugin_page_setup['menu_slug'], $this->plugin_page_setup['page_title'], $this->plugin_page_setup['menu_title'], apply_filters('ct-CT_CTDI/plugin_page_display_callback_function', array($this, 'display_plugin_page')));
	}


	/**
	 * Plugin page display.
	 * Output (HTML) is in another file.
	 */
	public function display_plugin_page() {
		require_once PT_CT_CTDI_PATH . 'views/plugin-page.php';
	}


	/**
	 * Enqueue admin scripts (JS and CSS)
	 *
	 * @param string $hook holds info on which admin page you are currently loading.
	 */
	public function admin_enqueue_scripts($hook) {
		// Enqueue the scripts only on the plugin page.
		if ($this->plugin_page === $hook || ('admin.php' === $hook && $this->plugin_page_setup['menu_slug'] === esc_attr($_GET['import']))) {
			wp_enqueue_script('jquery-ui-dialog');
			wp_enqueue_style('wp-jquery-ui-dialog');

			wp_enqueue_script('CT_CTDI-main-js', PT_CT_CTDI_URL . 'assets/js/main.js', array('jquery', 'jquery-ui-dialog'), PT_CT_CTDI_VERSION);

			// Get theme data.
			$theme = wp_get_theme();

			wp_localize_script(
				'CT_CTDI-main-js',
				'CT_CTDI',
				array(
					'ajax_url'         => admin_url('admin-ajax.php'),
					'ajax_nonce'       => wp_create_nonce('CT_CTDI-ajax-verification'),
					'import_files'     => $this->import_files,
					'wp_customize_on'  => apply_filters('ct-CT_CTDI/enable_wp_customize_save_hooks', false),
					'import_popup'     => apply_filters('ct-CT_CTDI/enable_grid_layout_import_popup_confirmation', true),
					'theme_screenshot' => $theme->get_screenshot(),
					'texts'            => array(
						'missing_preview_image' => esc_html__('No preview image defined for this import.', 'ct-ctdi'),
						'dialog_title'          => esc_html__('Are you sure?', 'ct-ctdi'),
						'dialog_no'             => esc_html__('Cancel', 'ct-ctdi'),
						'dialog_yes'            => esc_html__('Yes, import!', 'ct-ctdi'),
						'selected_import_title' => esc_html__('Selected demo import:', 'ct-ctdi'),
					),
					'dialog_options' => apply_filters('ct-CT_CTDI/confirmation_dialog_options', array())
				)
			);

			wp_enqueue_style('CT_CTDI-main-css', PT_CT_CTDI_URL . 'assets/css/main.css', array(), PT_CT_CTDI_VERSION);
		}

		wp_enqueue_style('CT_CTDI-admin-css', PT_CT_CTDI_URL . 'assets/css/admin.css', array(), PT_CT_CTDI_VERSION);
	}


	/**
	 * Main AJAX callback function for:
	 * 1). prepare import files (uploaded or predefined via filters)
	 * 2). execute 'before content import' actions (before import WP action)
	 * 3). import content
	 * 4). execute 'after content import' actions (before widget import WP action, widget import, customizer import, after import WP action)
	 */
	public function import_demo_data_ajax_callback() {
		// Try to update PHP memory limit (so that it does not run out of it).
		ini_set('memory_limit', apply_filters('ct-CT_CTDI/import_memory_limit', '350M'));

		// Verify if the AJAX call is valid (checks nonce and current_user_can).
		Helpers::verify_ajax_call();

		// Is this a new AJAX call to continue the previous import?
		$use_existing_importer_data = $this->use_existing_importer_data();

		if (!$use_existing_importer_data) {
			// Create a date and time string to use for demo and log file names.
			Helpers::set_demo_import_start_time();

			// Define log file path.
			$this->log_file_path = Helpers::get_log_path();

			// Get selected file index or set it to 0.
			$this->selected_index = empty($_POST['selected']) ? 0 : absint($_POST['selected']);

			/**
			 * 1). Prepare import files.
			 * Manually uploaded import files or predefined import files via filter: ct-CT_CTDI/import_files
			 */
			if (!empty($_FILES)) { // Using manual file uploads?
				// Get paths for the uploaded files.
				$this->selected_import_files = Helpers::process_uploaded_files($_FILES, $this->log_file_path);

				// Set the name of the import files, because we used the uploaded files.
				$this->import_files[$this->selected_index]['import_file_name'] = esc_html__('Manually uploaded files', 'ct-ctdi');
			} elseif (!empty($this->import_files[$this->selected_index])) { // Use predefined import files from wp filter: ct-CT_CTDI/import_files.

				// Download the import files (content, widgets and customizer files).
				$this->selected_import_files = Helpers::download_import_files($this->import_files[$this->selected_index]);

				// Check Errors.
				if (is_wp_error($this->selected_import_files)) {
					// Write error to log file and send an AJAX response with the error.
					Helpers::log_error_and_send_ajax_response(
						$this->selected_import_files->get_error_message(),
						$this->log_file_path,
						esc_html__('Downloaded files', 'ct-ctdi')
					);
				}

				// Add this message to log file.
				$log_added = Helpers::append_to_file(
					sprintf(
						__('The import files for: %s were successfully downloaded!', 'ct-ctdi'),
						$this->import_files[$this->selected_index]['import_file_name']
					) . Helpers::import_file_info($this->selected_import_files),
					$this->log_file_path,
					esc_html__('Downloaded files', 'ct-ctdi')
				);
			} else {
				// Send JSON Error response to the AJAX call.
				wp_send_json(esc_html__('No import files specified!', 'ct-ctdi'));
			}
		}

		// Save the initial import data as a transient, so other import parts (in new AJAX calls) can use that data.
		Helpers::set_CT_CTDI_import_data_transient($this->get_current_importer_data());

		if (!$this->before_import_executed) {
			$this->before_import_executed = true;

			/**
			 * 2). Execute the actions hooked to the 'ct-CT_CTDI/before_content_import_execution' action:
			 *
			 * Default actions:
			 * 1 - Before content import WP action (with priority 10).
			 */
			do_action('ct-CT_CTDI/before_content_import_execution', $this->selected_import_files, $this->import_files, $this->selected_index);
		}

		/**
		 * 3). Import content (if the content XML file is set for this import).
		 * Returns any errors greater then the "warning" logger level, that will be displayed on front page.
		 */
		if (!empty($this->selected_import_files['content'])) {
			$this->append_to_frontend_error_messages($this->importer->import_content($this->selected_import_files['content']));
		}

		/**
		 * 4). Execute the actions hooked to the 'ct-CT_CTDI/after_content_import_execution' action:
		 *
		 * Default actions:
		 * 1 - Before widgets import setup (with priority 10).
		 * 2 - Import widgets (with priority 20).
		 * 3 - Import Redux data (with priority 30).
		 */
		do_action('ct-CT_CTDI/after_content_import_execution', $this->selected_import_files, $this->import_files, $this->selected_index);

		// Save the import data as a transient, so other import parts (in new AJAX calls) can use that data.
		Helpers::set_CT_CTDI_import_data_transient($this->get_current_importer_data());

		// Request the customizer import AJAX call.
		if (!empty($this->selected_import_files['customizer'])) {
			wp_send_json(array('status' => 'customizerAJAX'));
		}

		// Request the after all import AJAX call.
		if (false !== has_action('ct-CT_CTDI/after_all_import_execution')) {
			wp_send_json(array('status' => 'afterAllImportAJAX'));
		}

		// Send a JSON response with final report.
		$this->final_response();
	}


	/**
	 * AJAX callback for importing the customizer data.
	 * This request has the wp_customize set to 'on', so that the customizer hooks can be called
	 * (they can only be called with the $wp_customize instance). But if the $wp_customize is defined,
	 * then the widgets do not import correctly, that's why the customizer import has its own AJAX call.
	 */
	public function import_customizer_data_ajax_callback() {
		// Verify if the AJAX call is valid (checks nonce and current_user_can).
		Helpers::verify_ajax_call();

		// Get existing import data.
		if ($this->use_existing_importer_data()) {
			/**
			 * Execute the customizer import actions.
			 *
			 * Default actions:
			 * 1 - Customizer import (with priority 10).
			 */
			do_action('ct-CT_CTDI/customizer_import_execution', $this->selected_import_files);
		}

		// Request the after all import AJAX call.
		if (false !== has_action('ct-CT_CTDI/after_all_import_execution')) {
			wp_send_json(array('status' => 'afterAllImportAJAX'));
		}

		// Send a JSON response with final report.
		$this->final_response();
	}


	/**
	 * AJAX callback for the after all import action.
	 */
	public function after_all_import_data_ajax_callback() {
		// Verify if the AJAX call is valid (checks nonce and current_user_can).
		Helpers::verify_ajax_call();

		// Get existing import data.
		if ($this->use_existing_importer_data()) {
			/**
			 * Execute the after all import actions.
			 *
			 * Default actions:
			 * 1 - after_import action (with priority 10).
			 */
			do_action('ct-CT_CTDI/after_all_import_execution', $this->selected_import_files, $this->import_files, $this->selected_index);
		}

		// Send a JSON response with final report.
		$this->final_response();
	}


	/**
	 * Send a JSON response with final report.
	 */
	private function final_response() {
		// Delete importer data transient for current import.
		delete_transient('CT_CTDI_importer_data');

		// Display final messages (success or error messages).
		if (empty($this->frontend_error_messages)) {
			$response['message'] = '';

			$response['message'] .= sprintf(
				__('%1$s%3$sThat\'s it, all done!%4$s%2$sThe demo import has finished. Please check your page and make sure that everything has imported correctly. %6$sClick here%7$s to check your home page!%5$s', 'ct-ctdi'),
				'<div class="notice  notice-success"><p>',
				'<br>',
				'<strong>',
				'</strong>',
				'</p></div>',
				'<a href=" ' . esc_url(get_home_url()) . ' ">',
				'</a>'
			);
		} else {
			$response['message'] = $this->frontend_error_messages_display() . '<br>';
			$response['message'] .= sprintf(
				__('%1$sThe demo import has finished, but there were some import errors.%2$sMore details about the errors can be found in this %3$s%5$slog file%6$s%4$s%7$s', 'ct-ctdi'),
				'<div class="notice  notice-warning"><p>',
				'<br>',
				'<strong>',
				'</strong>',
				'<a href="' . Helpers::get_log_url($this->log_file_path) . '" target="_blank">',
				'</a>',
				'</p></div>'
			);
		}

		wp_send_json($response);
	}


	/**
	 * Get content importer data, so we can continue the import with this new AJAX request.
	 *
	 * @return boolean
	 */
	private function use_existing_importer_data() {
		if ($data = get_transient('CT_CTDI_importer_data')) {
			$this->frontend_error_messages = empty($data['frontend_error_messages']) ? array() : $data['frontend_error_messages'];
			$this->log_file_path           = empty($data['log_file_path']) ? '' : $data['log_file_path'];
			$this->selected_index          = empty($data['selected_index']) ? 0 : $data['selected_index'];
			$this->selected_import_files   = empty($data['selected_import_files']) ? array() : $data['selected_import_files'];
			$this->before_import_executed  = empty($data['before_import_executed']) ? false : $data['before_import_executed'];
			$this->importer->set_importer_data($data);

			return true;
		}
		return false;
	}


	/**
	 * Get the current state of selected data.
	 *
	 * @return array
	 */
	public function get_current_importer_data() {
		return array(
			'frontend_error_messages' => $this->frontend_error_messages,
			'log_file_path'           => $this->log_file_path,
			'selected_index'          => $this->selected_index,
			'selected_import_files'   => $this->selected_import_files,
			'before_import_executed'  => $this->before_import_executed,
		);
	}


	/**
	 * Getter function to retrieve the private log_file_path value.
	 *
	 * @return string The log_file_path value.
	 */
	public function get_log_file_path() {
		return $this->log_file_path;
	}


	/**
	 * Setter function to append additional value to the private frontend_error_messages value.
	 *
	 * @param string $additional_value The additional value that will be appended to the existing frontend_error_messages.
	 */
	public function append_to_frontend_error_messages($text) {
		$lines = array();

		if (!empty($text)) {
			$text = str_replace('<br>', PHP_EOL, $text);
			$lines = explode(PHP_EOL, $text);
		}

		foreach ($lines as $line) {
			if (!empty($line) && !in_array($line, $this->frontend_error_messages)) {
				$this->frontend_error_messages[] = $line;
			}
		}
	}


	/**
	 * Display the frontend error messages.
	 *
	 * @return string Text with HTML markup.
	 */
	public function frontend_error_messages_display() {
		$output = '';

		if (!empty($this->frontend_error_messages)) {
			foreach ($this->frontend_error_messages as $line) {
				$output .= esc_html($line);
				$output .= '<br>';
			}
		}

		return $output;
	}


	/**
	 * Load the plugin textdomain, so that translations can be made.
	 */
	public function load_textdomain() {
		load_plugin_textdomain('ct-CT_CTDI', false, plugin_basename(dirname(dirname(__FILE__))) . '/languages');
	}


	/**
	 * Get data from filters, after the theme has loaded and instantiate the importer.
	 */
	public function setup_plugin_with_filter_data() {
		// Get info of import data files and filter it.
		$this->import_files = Helpers::validate_import_file_info(apply_filters('ct-CT_CTDI/import_files', array()));

		/**
		 * Register all default actions (before content import, widget, customizer import and other actions)
		 * to the 'before_content_import_execution' and the 'ct-CT_CTDI/after_content_import_execution' action hook.
		 */
		$import_actions = new ImportActions();
		$import_actions->register_hooks();

		// Importer options array.
		$importer_options = apply_filters('ct-CT_CTDI/importer_options', array(
			'fetch_attachments' => true,
		));

		// Logger options for the logger used in the importer.
		$logger_options = apply_filters('ct-CT_CTDI/logger_options', array(
			'logger_min_level' => 'warning',
		));

		// Configure logger instance and set it to the importer.
		$logger            = new Logger();
		$logger->min_level = $logger_options['logger_min_level'];

		// Create importer instance with proper parameters.
		$this->importer = new Importer($importer_options, $logger);
	}
}
