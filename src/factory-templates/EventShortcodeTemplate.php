<?php
/**
 * Event Shortcode Template
 *
 * @package      CG/Capgemini_Archive_Shortcode
 * @author       Capgemini GIT
 * @copyright    Capgemini GIT
 * @license      GPL-2.0-or-later
 */

namespace CG\Capgemini_Archive_Shortcode;

class EventShortcodeTemplate implements ArchiveShortcodeTemplate {

	public function buildArchiveShortcodePage($archiveShortcode) {

		$pageContent = file_get_contents( WP_PLUGIN_DIR . '/cg-archive-shortcode/page-templates/event.php' );

		$page = str_replace(
			array(
				'{{ filterUpcomingEventsLabel }}',
				'{{ filterPastEventsLabel }}',
				'{{ filterBusinessEventsLabel }}',
				'{{ filterCareersEventsLabel }}',
				'{{ noResultsLabel }}',
				'{{ showMoreLabel }}',
				'{{ addToCalendar }}',
				'{{ registerLabel }}',
				'{{ searchForm }}',
			),
			array(
				esc_html__( 'Upcoming Events', 'cg-archive-shortcode' ),
				esc_html__( 'Past Events', 'cg-archive-shortcode' ),
				esc_html__( 'Business', 'cg-archive-shortcode' ),
				esc_html__( 'Careers', 'cg-archive-shortcode' ),
				esc_html__( 'No results matching your search', 'cg-archive-shortcode' ),
				esc_html__( 'Load more', 'cg-archive-shortcode' ),
				esc_html__( 'Add to Calendar', 'cg-archive-shortcode' ),
				esc_html__( 'Register', 'cg-archive-shortcode' ),
				$this->getSearchForm(),
			),
			$pageContent
		);

		return $page;
	}

	/**
	 * Get search from.
	 *
	 * @return string
	 */
	public function getSearchForm() {

		$search_form_template = file_get_contents( WP_PLUGIN_DIR . '/cg-archive-shortcode/page-templates/search-bar.php' );

		if ( ! empty( $search_form_template ) ) {

			return str_replace(
				array(
					'{{ searchPlaceholder }}',
					'{{ searchButtonLabel }}',
				),
				array(
					esc_attr__( 'Type to search…', 'cg-archive-shortcode' ),
					esc_attr__( 'Search', 'cg-archive-shortcode' ),
					$search_form_template,
				),
				$search_form_template
			);
		}

		return '';
	}

}
