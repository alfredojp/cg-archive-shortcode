<?php

/**
 * Creates settings page for plugin options
 *
 * Uses Fieldmanager Plugin
 *
 * @package      CG/Capgemini_Archive_Shortcode
 * @author       Capgemini GIT
 * @copyright    Capgemini GIT
 * @license      GPL-2.0-or-later
 */

namespace CG\Capgemini_Archive_Shortcode;

use Fieldmanager_Group;
use Fieldmanager_TextField;
use Fieldmanager_TextArea;
use Fieldmanager_RichTextArea;
use Fieldmanager_Checkboxes;

class ArchiveShortcodeSettings {
	/**
	 * Registers settings page
	 */
	public function register_settings_page(): void {

		fm_register_submenu_page( ArchiveShortcode::OPTION_KEY, 'options-general.php', __( 'Archive Pages Settings', 'cg-archive-shortcode-admin' ) );

		add_action(
			'fm_submenu_' . ArchiveShortcode::OPTION_KEY,
			function() {
				$fm = new \Fieldmanager_Group( array(
					'name'     => ArchiveShortcode::OPTION_KEY,
					'children' => [
						'press-release' => new \Fieldmanager_Group( [
							'label'    => __( 'Press release archive page settings', 'cg-archive-shortcode-admin' ),
							'children' => [
								'archive_filter_title'       => new \Fieldmanager_Textfield( [
									'label' => __( 'Filter title', 'cg-archive-shortcode-admin' ),
								] ),
								'archive_filter_options'         => new Fieldmanager_Checkboxes( [
									'label'         => __( 'Filter options', 'cg-archive-shortcode-admin' ),
									'options'       => [
										'type' 			=> __( 'Category', 'cg-archive-shortcode-admin' ),
										'year' 	=> __( 'Year', 'cg-archive-shortcode-admin' ),
										'date'			=> __( 'Date', 'cg-archive-shortcode-admin' ),
									],
									] ),
								]
							] ),
							'research-and-insight' => new \Fieldmanager_Group( [
								'label'    => __( 'Research and Insights archive page settings', 'cg-archive-shortcode-admin' ),
								'children' => [
									'archive_filter_title'       => new \Fieldmanager_Textfield( [
										'label' => __( 'Filter title', 'cg-archive-shortcode-admin' ),
									] ),
									'archive_filter_options'         => new Fieldmanager_Checkboxes( [
										'label'         => __( 'Filter options', 'cg-archive-shortcode-admin' ),
										'options'       => [
											'type' 			=> __( 'Type', 'cg-archive-shortcode-admin' ),
											'industry' 	=> __( 'Industry', 'cg-archive-shortcode-admin' ),
											'theme'			=> __( 'Topic', 'cg-archive-shortcode-admin' ),
											'year'				=> __( 'Year', 'cg-archive-shortcode-admin' ),
										],
									] ),
								]
							] ),
							'client-story' => new \Fieldmanager_Group( [
								'label'    => __( 'Client Stories archive page settings', 'cg-archive-shortcode-admin' ),
								'children' => [
									'archive_filter_title'       => new \Fieldmanager_Textfield( [
										'label' => __( 'Filter title', 'cg-archive-shortcode-admin' ),
									] ),
									'archive_filter_options'         => new Fieldmanager_Checkboxes( [
										'label'         => __( 'Filter options', 'cg-archive-shortcode-admin' ),
										'options'       => [
											'industry' 	=> __( 'Industry', 'cg-archive-shortcode-admin' ),
											'service' 	=> __( 'Service', 'cg-archive-shortcode-admin' ),
											'partner'			=> __( 'Partner', 'cg-archive-shortcode-admin' ),
											'year'				=> __( 'Year', 'cg-archive-shortcode-admin' ),
										],
									] ),
								]
							] ),
							'analyst-report' => new \Fieldmanager_Group( [
								'label'    => __( 'Analyst reports archive page settings', 'cg-archive-shortcode-admin' ),
								'children' => [
									'archive_filter_title'       => new \Fieldmanager_Textfield( [
										'label' => __( 'Filter title', 'cg-archive-shortcode-admin' ),
									] ),
									'archive_filter_options'         => new Fieldmanager_Checkboxes( [
										'label'         => __( 'Filter options', 'cg-archive-shortcode-admin' ),
										'options'       => [
											'analyst' 	=> __( 'Analyst', 'cg-archive-shortcode-admin' ),
											'industry' 	=> __( 'Industry', 'cg-archive-shortcode-admin' ),
											'service' 	=> __( 'Service', 'cg-archive-shortcode-admin' ),
											'partner'			=> __( 'Partner', 'cg-archive-shortcode-admin' ),
											'year'				=> __( 'Year', 'cg-archive-shortcode-admin' ),
										],
									] ),
								]
							] ),
							'employee-testimonial' => new \Fieldmanager_Group( [
								'label'    => __( 'Testimonial archive page settings', 'cg-archive-shortcode-admin' ),
								'children' => [
									'archive_filter_title'       => new \Fieldmanager_Textfield( [
										'label' => __( 'Filter title', 'cg-archive-shortcode-admin' ),
									] ),
									'archive_filter_options'         => new Fieldmanager_Checkboxes( [
										'label'         => __( 'Filter options', 'cg-archive-shortcode-admin' ),
										'options'       => [
											'grade' 			=> __( 'Experience', 'cg-archive-shortcode-admin' ),
											'job_family' 	=> __( 'Profession', 'cg-archive-shortcode-admin' ),
											'country'			=> __( 'Country', 'cg-archive-shortcode-admin' ),
											'brand'				=> __( 'Brand', 'cg-archive-shortcode-admin' ),
											'industry'		=> __( 'Industry', 'cg-archive-shortcode-admin' ),
										],
									] ),
								]
							] ),
							'location' => new \Fieldmanager_Group( [
								'label'    => __( 'Location archive page settings', 'cg-archive-shortcode-admin' ),
								'children' => [

								]
							] ),
							'post' => new \Fieldmanager_Group( [
								'label'    => __( 'Blogs archive page settings', 'cg-archive-shortcode-admin' ),
								'children' => [
									'archive_filter_title'       => new \Fieldmanager_Textfield( [
										'label' => __( 'Filter title', 'cg-archive-shortcode-admin' ),
									] ),
									'archive_filter_options'         => new Fieldmanager_Checkboxes( [
										'label'         => __( 'Filter options', 'cg-archive-shortcode-admin' ),
										'options'       => [
											'blog_topic'	=> __( 'Type', 'cg-archive-shortcode-admin' ),
											'industry'		=> __( 'Industry', 'cg-archive-shortcode-admin' ),
											'partner' 	=> __( 'Partner', 'cg-archive-shortcode-admin' ),
											'year'			=> __( 'Year', 'cg-archive-shortcode-admin' ),
										],
									] ),
								]
							] ),
						]
					) );
				$fm->activate_submenu_page();
			}
		);
	}

	public function register_shortcodes() {
		$post_types = [
			'research-and-insight',
			'press-release',
			'client-story',
			'analyst-report',
			'post',
			'employee-testimonial',
			'event',
			'location',
		];

		foreach ($post_types as $post_type) {
			$archiveShortcode = new ArchiveShortcode($post_type);
			$archiveShortcode->init();
		}

	}
}
