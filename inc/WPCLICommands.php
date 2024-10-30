<?php
/**
 * The class for WP-CLI commands for Crafthemes Demo Import plugin.
 *
 * @package CT_CTDI
 */

namespace CT_CTDI;

use WP_CLI;

class WPCLICommands extends \WP_CLI_Command {

	/**
	 * @var object Main CT_CTDI class object.
	 */
	private $CT_CTDI;

	public function __construct() {
		parent::__construct();

		$this->CT_CTDI = CrafthemesClickDemoImport::get_instance();

		Helpers::set_demo_import_start_time();

		$this->CT_CTDI->log_file_path = Helpers::get_log_path();
	}

	/**
	 * List all predefined demo imports.
	 */
	public function list_predefined() {
		if ( empty( $this->CT_CTDI->import_files ) ) {
			WP_CLI::error( esc_html__( 'There are no predefined demo imports for currently active theme!', 'ct-ctdi' ) );
		}

		WP_CLI::success( esc_html__( 'Here are the predefined demo imports:', 'ct-ctdi' ) );

		foreach ( $this->CT_CTDI->import_files as $index => $import_file ) {
			WP_CLI::log( sprintf(
				'%d -> %s [content: %s, widgets: %s, customizer: %s, redux: %s]',
				$index,
				$import_file['import_file_name'],
				empty( $import_file['import_file_url'] ) && empty( $import_file['local_import_file'] ) ? 'no' : 'yes',
				empty( $import_file['import_widget_file_url'] ) && empty( $import_file['local_import_widget_file'] ) ? 'no' : 'yes',
				empty( $import_file['import_customizer_file_url'] ) && empty( $import_file['local_import_customizer_file'] ) ? 'no' : 'yes',
				empty( $import_file['import_redux'] ) && empty( $import_file['local_import_redux'] ) ? 'no' : 'yes'
			) );
		}
	}

	/**
	 * Import content/widgets/customizer settings with the CT_CTDI plugin.
	 *
	 * ## OPTIONS
	 *
	 * [--content=<file>]
	 * : Content file (XML), that will be used to import the content.
	 *
	 * [--widgets=<file>]
	 * : Widgets file (JSON or WIE), that will be used to import the widgets.
	 *
	 * [--customizer=<file>]
	 * : Customizer file (DAT), that will be used to import the customizer settings.
	 *
	 * [--predefined=<index>]
	 * : The index of the predefined demo imports (use the 'list_predefined' command to check the predefined demo imports)
	 */
	public function import( $args, $assoc_args ) {
		if ( ! $this->any_import_options_set( $assoc_args ) ) {
			WP_CLI::error( esc_html__( 'At least one of the possible options should be set! Check them with --help', 'ct-ctdi' ) );
		}

		if ( isset( $assoc_args['predefined'] ) ) {
			$this->import_predefined( $assoc_args['predefined'] );
		}

		if ( ! empty( $assoc_args['content'] ) ) {
			$this->import_content( $assoc_args['content'] );
		}

		if ( ! empty( $assoc_args['widgets'] ) ) {
			$this->import_widgets( $assoc_args['widgets'] );
		}

		if ( ! empty( $assoc_args['customizer'] ) ) {
			$this->import_customizer( $assoc_args['customizer'] );
		}
	}

	/**
	 * Check if any of the possible options are set.
	 *
	 * @param array $options
	 *
	 * @return bool
	 */
	private function any_import_options_set( $options ) {
		$possible_options = array(
			'content',
			'widgets',
			'customizer',
			'predefined',
		);

		foreach ( $possible_options as $option ) {
			if ( array_key_exists( $option, $options ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Import the predefined demo content/widgets/customizer settings with CT_CTDI.
	 *
	 * @param int $predefined_index Index of a CT_CTDI predefined demo import.
	 */
	private function import_predefined( $predefined_index ) {
		if ( ! is_numeric( $predefined_index ) ) {
			WP_CLI::error( esc_html__( 'The "predefined" parameter should be a number (an index of the CT_CTDI predefined demo import)!', 'ct-ctdi' ) );
		}

		$predefined_index = absint( $predefined_index );

		if ( ! array_key_exists( $predefined_index, $this->CT_CTDI->import_files ) ) {
			WP_CLI::warning( esc_html__( 'The supplied predefined index does not exist! Please take a look at the available predefined demo imports:', 'ct-ctdi' ) );

			$this->list_predefined();

			return false;
		}

		WP_CLI::log( esc_html__( 'Predefined demo import started! All other parameters will be ignored!', 'ct-ctdi' ) );

		$selected_files = $this->CT_CTDI->import_files[ $predefined_index ];

		if ( ! empty( $selected_files['import_file_name'] ) ) {
			WP_CLI::log( sprintf( esc_html__( 'Selected predefined demo import: %s', 'ct-ctdi' ), $selected_files['import_file_name'] ) );
		}

		WP_CLI::log( esc_html__( 'Preparing the demo import files...', 'ct-ctdi' ) );

		$import_files =	Helpers::download_import_files( $selected_files );

		if ( empty( $import_files ) ) {
			WP_CLI::error( esc_html__( 'Demo import files could not be retrieved!', 'ct-ctdi' ) );
		}

		WP_CLI::log( esc_html__( 'Demo import files retrieved successfully!', 'ct-ctdi' ) );

		WP_CLI::log( esc_html__( 'Importing...', 'ct-ctdi' ) );

		if ( ! empty( $import_files['content'] ) ) {
			$this->do_action( 'ct-CT_CTDI/before_content_import_execution', $import_files, $this->CT_CTDI->import_files, $predefined_index );

			$this->import_content( $import_files['content'] );
		}

		if ( ! empty( $import_files['widgets'] ) ) {
			$this->do_action( 'ct-CT_CTDI/before_widgets_import', $import_files );

			$this->import_widgets( $import_files['widgets'] );
		}

		if ( ! empty( $import_files['customizer'] ) ) {
			$this->import_customizer( $import_files['customizer'] );
		}

		$this->do_action( 'ct-CT_CTDI/after_all_import_execution', $import_files, $this->CT_CTDI->import_files, $predefined_index );

		WP_CLI::log( esc_html__( 'Predefined import finished!', 'ct-ctdi' ) );
	}

	/**
	 * Import the content with CT_CTDI.
	 *
	 * @param string $relative_file_path Relative file path to the content import file.
	 */
	private function import_content( $relative_file_path ) {
		$content_import_file_path = realpath( $relative_file_path );

		if ( ! file_exists( $content_import_file_path ) ) {
			WP_CLI::warning( esc_html__( 'Content import file provided does not exist! Skipping this import!', 'ct-ctdi' ) );
			return false;
		}

		// Change the single AJAX call duration so the whole content import will be done in one go.
		add_filter( 'ct-CT_CTDI/time_for_one_ajax_call', function() {
			return 3600;
		} );

		WP_CLI::log( esc_html__( 'Importing content (this might take a while)...', 'ct-ctdi' ) );

		Helpers::append_to_file( '', $this->CT_CTDI->log_file_path, esc_html__( 'Importing content' , 'ct-ctdi' ) );

		$this->CT_CTDI->append_to_frontend_error_messages( $this->CT_CTDI->importer->import_content( $content_import_file_path ) );

		if( empty( $this->CT_CTDI->frontend_error_messages ) ) {
			WP_CLI::success( esc_html__( 'Content import finished!', 'ct-ctdi' ) );
		}
		else {
			WP_CLI::warning( esc_html__( 'There were some issues while importing the content!', 'ct-ctdi' ) );

			foreach ( $this->CT_CTDI->frontend_error_messages as $line ) {
				WP_CLI::log( $line );
			}

			$this->CT_CTDI->frontend_error_messages = array();
		}
	}

	/**
	 * Import the widgets with CT_CTDI.
	 *
	 * @param string $relative_file_path Relative file path to the widgets import file.
	 */
	private function import_widgets( $relative_file_path ) {
		$widgets_import_file_path = realpath( $relative_file_path );

		if ( ! file_exists( $widgets_import_file_path ) ) {
			WP_CLI::warning( esc_html__( 'Widgets import file provided does not exist! Skipping this import!', 'ct-ctdi' ) );
			return false;
		}

		WP_CLI::log( esc_html__( 'Importing widgets...', 'ct-ctdi' ) );

		WidgetImporter::import( $widgets_import_file_path );

		if( empty( $this->CT_CTDI->frontend_error_messages ) ) {
			WP_CLI::success( esc_html__( 'Widgets imported successfully!', 'ct-ctdi' ) );
		}
		else {
			WP_CLI::warning( esc_html__( 'There were some issues while importing widgets!', 'ct-ctdi' ) );

			foreach ( $this->CT_CTDI->frontend_error_messages as $line ) {
				WP_CLI::log( $line );
			}

			$this->CT_CTDI->frontend_error_messages = array();
		}
	}

	/**
	 * Import the customizer settings with CT_CTDI.
	 *
	 * @param string $relative_file_path Relative file path to the customizer import file.
	 */
	private function import_customizer( $relative_file_path ) {
		$customizer_import_file_path = realpath( $relative_file_path );

		if ( ! file_exists( $customizer_import_file_path ) ) {
			WP_CLI::warning( esc_html__( 'Customizer import file provided does not exist! Skipping this import!', 'ct-ctdi' ) );
			return false;
		}

		WP_CLI::log( esc_html__( 'Importing customizer settings...', 'ct-ctdi' ) );

		CustomizerImporter::import( $customizer_import_file_path );

		if( empty( $this->CT_CTDI->frontend_error_messages ) ) {
			WP_CLI::success( esc_html__( 'Customizer settings imported successfully!', 'ct-ctdi' ) );
		}
		else {
			WP_CLI::warning( esc_html__( 'There were some issues while importing customizer settings!', 'ct-ctdi' ) );

			foreach ( $this->CT_CTDI->frontend_error_messages as $line ) {
				WP_CLI::log( $line );
			}

			$this->CT_CTDI->frontend_error_messages = array();
		}
	}

	/**
	 * Run the registered actions.
	 *
	 * @param string $action            Name of the action.
	 * @param array  $selected_files    Selected import files.
	 * @param array  $all_import_files  All predefined demos.
	 * @param null   $selected_index    Selected predefined index.
	 */
	private function do_action( $action, $import_files = array(), $all_import_files = array(), $selected_index = null ) {
		if ( false !== has_action( $action ) ) {
			WP_CLI::log( sprintf( esc_html__( 'Executing action: %s ...', 'ct-ctdi' ), $action ) );

			ob_start();
				do_action( $action, $import_files, $all_import_files, $selected_index );
			$message = ob_get_clean();

			Helpers::append_to_file( $message, $this->CT_CTDI->log_file_path, $action );
		}
	}
}
