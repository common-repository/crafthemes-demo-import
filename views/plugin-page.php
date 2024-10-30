<?php
/**
 * The plugin page view - the "settings" page of the plugin.
 *
 * @package CT_CTDI
 */

namespace CT_CTDI;

$predefined_themes = $this->import_files;

if ( ! empty( $this->import_files ) && isset( $_GET['import-mode'] ) && 'manual' === $_GET['import-mode'] ) {
	$predefined_themes = array();
}


$CT_CTDI_theme = wp_get_theme();

if ( isset( $_GET['ct_notice'] ) ) {
	if ( $_GET['ct_notice'] == 'dismiss-get-started' ) {
		update_option( 'dismissed-get_started', TRUE );

	}
}

/**
 * Hook for adding the custom plugin page header
 */
do_action( 'ct-CT_CTDI/plugin_page_header' );
?>
<style>
	.notice-get-started-class {
		display: none !important;
	}
</style>
<div class="CT_CTDI  wrap <?php echo esc_attr( basename( get_stylesheet_directory() ) ); ?>">

	<?php ob_start(); ?>
		<h1 class="CT_CTDI__title  dashicons-before  dashicons-upload"><?php esc_html_e( 'Crafthemes Demo Import', 'ct-ctdi' ); ?></h1>
	<?php
	$plugin_title = ob_get_clean();

	// Display the plugin title (can be replaced with custom title text through the filter below).
	echo wp_kses_post( apply_filters( 'ct-CT_CTDI/plugin_page_title', $plugin_title ) );

	// Display warrning if PHP safe mode is enabled, since we wont be able to change the max_execution_time.
	if ( ini_get( 'safe_mode' ) ) {
		printf(
			esc_html__( '%sWarning: your server is using %sPHP safe mode%s. This means that you might experience server timeout errors.%s', 'ct-ctdi' ),
			'<div class="notice  notice-warning  is-dismissible"><p>',
			'<strong>',
			'</strong>',
			'</p></div>'
		);
	}

	// Start output buffer for displaying the plugin intro text.
	ob_start();
	?>

	<?php if( $CT_CTDI_theme->get( 'Author' ) != 'Crafthemes' && $CT_CTDI_theme->get( 'Author' ) != 'aruphash' ) : ?>
		<div class="CT_CTDI__intro-notice  notice  notice-error  is-dismissible">
			<p>
				<?php
                    printf( __( '%1$sCrafthemes%2$s Theme needs to be installed and actived to be able to Import Pre-built Website Demos. %1$sClick Here%2$s to Install themes by Crafthemes.com', 'ct-ctdi' ),
                        '<a href="'. admin_url( 'theme-install.php?search=crafthemes' ) . '">',
                        '</a>' );
                ?>
            </p>
		</div>
	<?php endif; // ?>

	<div class="CT_CTDI__intro-text">
		<p><?php esc_html_e( 'When you import the data, No existing posts, pages, categories, images, custom post types or any other data will be deleted or modified.', 'ct-ctdi' ); ?></p>
	</div>

	<?php
	$plugin_intro_text = ob_get_clean();

	// Display the plugin intro text (can be replaced with custom text through the filter below).
	echo wp_kses_post( apply_filters( 'ct-CT_CTDI/plugin_intro_text', $plugin_intro_text ) );
	?>

	<?php if ( empty( $this->import_files ) ) : ?>
		<div class="notice  notice-info  is-dismissible">
			<p><?php esc_html_e( 'There are no predefined import files available in this theme. Please upload the import files manually!', 'ct-ctdi' ); ?></p>
		</div>
	<?php endif; ?>

	<?php if ( empty( $predefined_themes ) ) : ?>

		<div class="CT_CTDI__file-upload-container">
			<h2><?php esc_html_e( 'Manual demo files upload', 'ct-ctdi' ); ?></h2>

			<div class="CT_CTDI__file-upload">
				<h3><label for="content-file-upload"><?php esc_html_e( 'Choose a XML file for content import:', 'ct-ctdi' ); ?></label></h3>
				<input id="CT_CTDI__content-file-upload" type="file" name="content-file-upload">
			</div>

			<div class="CT_CTDI__file-upload">
				<h3><label for="widget-file-upload"><?php esc_html_e( 'Choose a WIE or JSON file for widget import:', 'ct-ctdi' ); ?></label></h3>
				<input id="CT_CTDI__widget-file-upload" type="file" name="widget-file-upload">
			</div>

			<div class="CT_CTDI__file-upload">
				<h3><label for="customizer-file-upload"><?php esc_html_e( 'Choose a DAT file for customizer import:', 'ct-ctdi' ); ?></label></h3>
				<input id="CT_CTDI__customizer-file-upload" type="file" name="customizer-file-upload">
			</div>

			<?php if ( class_exists( 'ReduxFramework' ) ) : ?>
			<div class="CT_CTDI__file-upload">
				<h3><label for="redux-file-upload"><?php esc_html_e( 'Choose a JSON file for Redux import:', 'ct-ctdi' ); ?></label></h3>
				<input id="CT_CTDI__redux-file-upload" type="file" name="redux-file-upload">
				<div>
					<label for="redux-option-name" class="CT_CTDI__redux-option-name-label"><?php esc_html_e( 'Enter the Redux option name:', 'ct-ctdi' ); ?></label>
					<input id="CT_CTDI__redux-option-name" type="text" name="redux-option-name">
				</div>
			</div>
			<?php endif; ?>
		</div>

		<p class="CT_CTDI__button-container">
			<button class="CT_CTDI__button  button  button-hero  button-primary  js-CT_CTDI-import-data"><?php esc_html_e( 'Import Demo Data', 'ct-ctdi' ); ?></button>
		</p>

	<?php elseif ( 1 === count( $predefined_themes ) ) : ?>

		<div class="CT_CTDI__demo-import-notice  js-CT_CTDI-demo-import-notice"><?php
			if ( is_array( $predefined_themes ) && ! empty( $predefined_themes[0]['import_notice'] ) ) {
				echo wp_kses_post( $predefined_themes[0]['import_notice'] );
			}
		?></div>

		<p class="CT_CTDI__button-container">
			<button class="CT_CTDI__button  button  button-hero  button-primary  js-CT_CTDI-import-data"><?php esc_html_e( 'Import Demo Data', 'ct-ctdi' ); ?></button>
		</p>

	<?php else : ?>

		<!-- CT_CTDI grid layout -->
		<div class="CT_CTDI__gl  js-CT_CTDI-gl">
		<?php
			// Prepare navigation data.
			$categories = Helpers::get_all_demo_import_categories( $predefined_themes );
		?>
			<?php if ( ! empty( $categories ) ) : ?>
				<div class="CT_CTDI__gl-header  js-CT_CTDI-gl-header">
					<nav class="CT_CTDI__gl-navigation">
						<ul>
							<li class="active"><a href="#all" class="CT_CTDI__gl-navigation-link  js-CT_CTDI-nav-link"><?php esc_html_e( 'All', 'ct-ctdi' ); ?></a></li>
							<?php foreach ( $categories as $key => $name ) : ?>
								<li><a href="#<?php echo esc_attr( $key ); ?>" class="CT_CTDI__gl-navigation-link  js-CT_CTDI-nav-link"><?php echo esc_html( $name ); ?></a></li>
							<?php endforeach; ?>
						</ul>
					</nav>
					<div clas="CT_CTDI__gl-search">
						<input type="search" class="CT_CTDI__gl-search-input  js-CT_CTDI-gl-search" name="CT_CTDI-gl-search" value="" placeholder="<?php esc_html_e( 'Search demos...', 'ct-ctdi' ); ?>">
					</div>
				</div>
			<?php endif; ?>
			<div class="CT_CTDI__gl-item-container  wp-clearfix  js-CT_CTDI-gl-item-container">
				<?php foreach ( $predefined_themes as $index => $import_file ) : ?>
					<?php
						// Prepare import item display data.
						$img_src = isset( $import_file['import_preview_image_url'] ) ? $import_file['import_preview_image_url'] : '';
						// Default to the theme screenshot, if a custom preview image is not defined.
						if ( empty( $img_src ) ) {
							$theme = wp_get_theme();
							$img_src = $theme->get_screenshot();
						}

					?>

					<div class="CT_CTDI__gl-item js-CT_CTDI-gl-item" data-categories="<?php echo esc_attr( Helpers::get_demo_import_item_categories( $import_file ) ); ?>" data-name="<?php echo esc_attr( strtolower( $import_file['import_file_name'] ) ); ?>">
						<?php if ( ! empty( $import_file['premium_url'] ) ) : ?>
							<div class="ct-pro-badge"><p class="ct-pro-text"><?php esc_html_e( 'PREMIUM', 'ct-ctdi' ); ?></p></div><!-- /.ct-pro-badge -->
						<?php endif; ?>
						<div class="CT_CTDI__gl-item-image-container">
							<?php if ( ! empty( $img_src ) ) : ?>
								<img class="CT_CTDI__gl-item-image" src="<?php echo esc_url( $img_src ) ?>">
							<?php else : ?>
								<div class="CT_CTDI__gl-item-image  CT_CTDI__gl-item-image--no-image"><?php esc_html_e( 'No preview image.', 'ct-ctdi' ); ?></div>
							<?php endif; ?>
						</div>
						<div class="CT_CTDI__gl-item-footer<?php echo ! empty( $import_file['preview_url'] ) ? '  CT_CTDI__gl-item-footer--with-preview' : ''; ?>">
							<h4 class="CT_CTDI__gl-item-title" title="<?php echo esc_attr( $import_file['import_file_name'] ); ?>"><?php echo esc_html( $import_file['import_file_name'] ); ?></h4>

							<?php if ( ! empty( $import_file['preview_url'] ) ) : ?>
								<a class="CT_CTDI__gl-item-button  button" href="<?php echo esc_url( $import_file['preview_url'] ); ?>" target="_blank"><?php esc_html_e( 'Preview', 'ct-ctdi' ); ?></a>
							<?php endif; ?>

							<?php if( $CT_CTDI_theme->get( 'Author' ) == 'Crafthemes' ) : ?>
								<?php if ( ! empty( $import_file['premium_url'] ) && CT_PLUGIN_STATE == 'free' ) : ?>
									<a class="button  button-primary" href="<?php echo esc_url( $import_file['premium_url']  ); ?>" target="_blank"><?php esc_html_e( 'Buy Now', 'ct-ctdi' ); ?></a>
								<?php else : ?>
									<button class="CT_CTDI__gl-item-button  button  button-primary  js-CT_CTDI-gl-import-data" value="<?php echo esc_attr( $index ); ?>"><?php esc_html_e( 'Import', 'ct-ctdi' ); ?></button>
								<?php endif; ?>
							<?php else : ?>
								<button class="button js-CT_CTDI-gl-import-data" disabled value="<?php echo esc_attr( $index ); ?>"><?php esc_html_e( 'Import', 'ct-ctdi' ); ?></button>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<div id="js-CT_CTDI-modal-content"></div>

	<?php endif; ?>

	<p class="CT_CTDI__ajax-loader  js-CT_CTDI-ajax-loader">
		<span class="spinner"></span> <?php esc_html_e( 'Importing, please wait!', 'ct-ctdi' ); ?>
	</p>

	<p class="CT_CTDI__install-plugin  js-CT_CTDI-install-plugin">
		<span class="spinner"></span> <?php esc_html_e( 'Installing Recommended Plugins, please wait!', 'ct-ctdi' ); ?>
	</p>

	<div class="CT_CTDI__response  js-CT_CTDI-ajax-response"></div>
</div>

<?php
/**
 * Hook for adding the custom admin page footer
 */
do_action( 'ct-CT_CTDI/plugin_page_footer' );
