jQuery(function ($) {
	'use strict';

	/**
	 * ---------------------------------------
	 * ------------- Events ------------------
	 * ---------------------------------------
	 */

	/**
	 * No or Single predefined demo import button click.
	 */
	$('.js-CT_CTDI-import-data').on('click', function () {

		// Reset response div content.
		$('.js-CT_CTDI-ajax-response').empty();

		// Prepare data for the AJAX call
		var data = new FormData();
		data.append('action', 'CT_CTDI_import_demo_data');
		data.append('security', CT_CTDI.ajax_nonce);
		data.append('selected', $('#CT_CTDI__demo-import-files').val());
		if ($('#CT_CTDI__content-file-upload').length) {
			data.append('content_file', $('#CT_CTDI__content-file-upload')[0].files[0]);
		}
		if ($('#CT_CTDI__widget-file-upload').length) {
			data.append('widget_file', $('#CT_CTDI__widget-file-upload')[0].files[0]);
		}
		if ($('#CT_CTDI__customizer-file-upload').length) {
			data.append('customizer_file', $('#CT_CTDI__customizer-file-upload')[0].files[0]);
		}
		if ($('#CT_CTDI__redux-file-upload').length) {
			data.append('redux_file', $('#CT_CTDI__redux-file-upload')[0].files[0]);
			data.append('redux_option_name', $('#CT_CTDI__redux-option-name').val());
		}

		// AJAX call to import everything (content, widgets, before/after setup)
		ajaxCall(data);

	});


	/**
	 * Grid Layout import button click.
	 */
	$('.js-CT_CTDI-gl-import-data').on('click', function () {
		var selectedImportID = $(this).val();
		var $itemContainer = $(this).closest('.js-CT_CTDI-gl-item');

		// If the import confirmation is enabled, then do that, else import straight away.
		if (CT_CTDI.import_popup) {
			displayConfirmationPopup(selectedImportID, $itemContainer);
		}
		else {
			gridLayoutImport(selectedImportID, $itemContainer);
		}
	});


	/**
	 * Grid Layout categories navigation.
	 */
	(function () {
		// Cache selector to all items
		var $items = $('.js-CT_CTDI-gl-item-container').find('.js-CT_CTDI-gl-item'),
			fadeoutClass = 'CT_CTDI-is-fadeout',
			fadeinClass = 'CT_CTDI-is-fadein',
			animationDuration = 200;

		// Hide all items.
		var fadeOut = function () {
			var dfd = jQuery.Deferred();

			$items
				.addClass(fadeoutClass);

			setTimeout(function () {
				$items
					.removeClass(fadeoutClass)
					.hide();

				dfd.resolve();
			}, animationDuration);

			return dfd.promise();
		};

		var fadeIn = function (category, dfd) {
			var filter = category ? '[data-categories*="' + category + '"]' : 'div';

			if ('all' === category) {
				filter = 'div';
			}

			$items
				.filter(filter)
				.show()
				.addClass('CT_CTDI-is-fadein');

			setTimeout(function () {
				$items
					.removeClass(fadeinClass);

				dfd.resolve();
			}, animationDuration);
		};

		var animate = function (category) {
			var dfd = jQuery.Deferred();

			var promise = fadeOut();

			promise.done(function () {
				fadeIn(category, dfd);
			});

			return dfd;
		};

		$('.js-CT_CTDI-nav-link').on('click', function (event) {
			event.preventDefault();

			// Remove 'active' class from the previous nav list items.
			$(this).parent().siblings().removeClass('active');

			// Add the 'active' class to this nav list item.
			$(this).parent().addClass('active');

			var category = this.hash.slice(1);

			// show/hide the right items, based on category selected
			var $container = $('.js-CT_CTDI-gl-item-container');
			$container.css('min-width', $container.outerHeight());

			var promise = animate(category);

			promise.done(function () {
				$container.removeAttr('style');
			});
		});
	}());


	/**
	 * Grid Layout search functionality.
	 */
	$('.js-CT_CTDI-gl-search').on('keyup', function (event) {
		if (0 < $(this).val().length) {
			// Hide all items.
			$('.js-CT_CTDI-gl-item-container').find('.js-CT_CTDI-gl-item').hide();

			// Show just the ones that have a match on the import name.
			$('.js-CT_CTDI-gl-item-container').find('.js-CT_CTDI-gl-item[data-name*="' + $(this).val().toLowerCase() + '"]').show();
		}
		else {
			$('.js-CT_CTDI-gl-item-container').find('.js-CT_CTDI-gl-item').show();
		}
	});

	/**
	 * ---------------------------------------
	 * --------Helper functions --------------
	 * ---------------------------------------
	 */

	/**
	 * Prepare grid layout import data and execute the AJAX call.
	 *
	 * @param int selectedImportID The selected import ID.
	 * @param obj $itemContainer The jQuery selected item container object.
	 */
	function gridLayoutImport(selectedImportID, $itemContainer) {
		// Reset response div content.
		$('.js-CT_CTDI-ajax-response').empty();

		// Hide all other import items.
		$itemContainer.siblings('.js-CT_CTDI-gl-item').fadeOut(500);

		$itemContainer.animate({
			opacity: 0
		}, 500, 'swing', function () {
			$itemContainer.animate({
				opacity: 1
			}, 500)
		});

		// Hide the header with category navigation and search box.
		$itemContainer.closest('.js-CT_CTDI-gl').find('.js-CT_CTDI-gl-header').fadeOut(500);

		// Append a title for the selected demo import.
		$itemContainer.parent().prepend('<h3>' + CT_CTDI.texts.selected_import_title + '</h3>');

		// Remove the import button of the selected item.
		$itemContainer.find('.js-CT_CTDI-gl-import-data').remove();

		// Prepare data for the AJAX call
		var data = new FormData();
		data.append('action', 'CT_CTDI_import_demo_data');
		data.append('security', CT_CTDI.ajax_nonce);
		data.append('selected', selectedImportID);

		// if newsletter checked
		var nwCheck = 'no';
		var getEmail = '';
		if ($('input.nwsltr').is(':checked')) {
			var nwCheck = 'yes';
			getEmail = $('input.email-id').val();
		}

		var info = [];
		info[0] = CT_CTDI.import_files[selectedImportID]['additional_plugin'];
		info[1] = nwCheck;
		info[2] = getEmail;

		var plugin_data = {
			action: 'ct_ctdi_install_act_plugin',
			plugin_slug: info
		};

		$('.js-CT_CTDI-install-plugin').css({ 'display': 'block' });

		$.ajax({
			method: 'POST',
			url: CT_CTDI.ajax_url,
			data: plugin_data,
			success: function (response) {
				$('.js-CT_CTDI-install-plugin').css({ 'display': 'none' });
				// AJAX call to import everything (content, widgets, before/after setup)
				ajaxCall(data);
			}
		})
	}

	/**
	 * Display the confirmation popup.
	 *
	 * @param int selectedImportID The selected import ID.
	 * @param obj $itemContainer The jQuery selected item container object.
	 */
	function displayConfirmationPopup(selectedImportID, $itemContainer) {
		var $dialogContiner = $('#js-CT_CTDI-modal-content');
		var currentFilePreviewImage = CT_CTDI.import_files[selectedImportID]['import_preview_image_url'] || CT_CTDI.theme_screenshot;
		var previewImageContent = '';
		var importNotice = CT_CTDI.import_files[selectedImportID]['import_notice'] || '';
		var importNoticeContent = '';
		var dialogOptions = $.extend(
			{
				'dialogClass': 'wp-dialog',
				'resizable': false,
				'height': 'auto',
				'modal': true
			},
			CT_CTDI.dialog_options,
			{
				'buttons':
					[
						{
							text: CT_CTDI.texts.dialog_no,
							click: function () {
								$(this).dialog('close');
							}
						},
						{
							text: CT_CTDI.texts.dialog_yes,
							class: 'button  button-primary',
							click: function () {
								$(this).dialog('close');
								gridLayoutImport(selectedImportID, $itemContainer);
							}
						}
					]
			});

		if ('' === currentFilePreviewImage) {
			previewImageContent = '<p>' + CT_CTDI.texts.missing_preview_image + '</p>';
		}
		else {
			previewImageContent = '<div class="CT_CTDI__modal-image-container"><img src="' + currentFilePreviewImage + '" alt="' + CT_CTDI.import_files[selectedImportID]['import_file_name'] + '"></div>'
		}

		importNoticeContent = '<label class="newsletter-form"><input class="nwsltr" type="checkbox" value="1" name="subscribe" checked="checked"> Subscribe to our newsletters & Learn to Improve your site.</label>';
		importNoticeContent += '<input type="text" name="email-id" class="email-id id-admin" placeholder="Enter Email Address">';

		// Prepare notice output.
		if ('' !== importNotice) {
			importNoticeContent += '<div class="CT_CTDI__modal-notice  CT_CTDI__demo-import-notice">' + importNotice + '</div>';
		}

		// Populate the dialog content.
		$dialogContiner.prop('title', CT_CTDI.texts.dialog_title);
		$dialogContiner.html(
			'<p class="CT_CTDI__modal-item-title">' + CT_CTDI.import_files[selectedImportID]['import_file_name'] + '</p>' +
			previewImageContent +
			importNoticeContent
		);

		// Display the confirmation popup.
		$dialogContiner.dialog(dialogOptions);
	}

	/**
	 * The main AJAX call, which executes the import process.
	 *
	 * @param FormData data The data to be passed to the AJAX call.
	 */
	function ajaxCall(data) {
		$.ajax({
			method: 'POST',
			url: CT_CTDI.ajax_url,
			data: data,
			contentType: false,
			processData: false,
			beforeSend: function () {
				$('.js-CT_CTDI-ajax-loader').show();
			}
		})
			.done(function (response) {
				if ('undefined' !== typeof response.status && 'newAJAX' === response.status) {
					ajaxCall(data);
				}
				else if ('undefined' !== typeof response.status && 'customizerAJAX' === response.status) {
					// Fix for data.set and data.delete, which they are not supported in some browsers.
					var newData = new FormData();
					newData.append('action', 'CT_CTDI_import_customizer_data');
					newData.append('security', CT_CTDI.ajax_nonce);

					// Set the wp_customize=on only if the plugin filter is set to true.
					if (true === CT_CTDI.wp_customize_on) {
						newData.append('wp_customize', 'on');
					}

					ajaxCall(newData);
				}
				else if ('undefined' !== typeof response.status && 'afterAllImportAJAX' === response.status) {
					// Fix for data.set and data.delete, which they are not supported in some browsers.
					var newData = new FormData();
					newData.append('action', 'CT_CTDI_after_import_data');
					newData.append('security', CT_CTDI.ajax_nonce);
					ajaxCall(newData);
				}
				else if ('undefined' !== typeof response.message) {
					$('.js-CT_CTDI-ajax-response').append('<p>' + response.message + '</p>');
					$('.js-CT_CTDI-ajax-loader').hide();

					// Trigger custom event, when CT_CTDI import is complete.
					$(document).trigger('CT_CTDIImportComplete');
				}
				else {
					$('.js-CT_CTDI-ajax-response').append('<div class="notice  notice-error  is-dismissible"><p>' + response + '</p></div>');
					$('.js-CT_CTDI-ajax-loader').hide();
				}
			})
			.fail(function (error) {
				$('.js-CT_CTDI-ajax-response').append('<div class="notice  notice-error  is-dismissible"><p>Error: ' + error.statusText + ' (' + error.status + ')' + '</p></div>');
				$('.js-CT_CTDI-ajax-loader').hide();
			});
	}

});
