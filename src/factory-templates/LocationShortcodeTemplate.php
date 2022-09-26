<?php
/**
 * Location Shortcode Template
 *
 * @package      CG/Capgemini_Archive_Shortcode
 * @author       Capgemini GIT
 * @copyright    Capgemini GIT
 * @license      GPL-2.0-or-later
 */

namespace CG\Capgemini_Archive_Shortcode;

class LocationShortcodeTemplate implements ArchiveShortcodeTemplate {

	public function buildArchiveShortcodePage($archiveShortcode) {

		$custom_title = $archiveShortcode->getData( 'custom_title' ) ?: '';

		$locationData = $archiveShortcode->buildLoctionData();

		$pageContent = file_get_contents( WP_PLUGIN_DIR . '/cg-archive-shortcode/page-templates/location.php' );

		$page = str_replace(
			array(
				'{{ customTitle }}',
				'{{ countryBoxesHtml }}',
				'{{ regionFiltersHtml }}',
				'{{ countryExpanderHtml }}',
				'{{ countrywiseExpanderHtml }}',
				'{{ scriptsMarkup }}',
				'{{ searchLocationPlaceholder }}',
				'{{ locationTitle }}',
				'{{ allLabel }}',
			),
			array(
				esc_html( $custom_title !== '' ? $custom_title : __( 'Search for location', 'cg-archive-shortcode' ) ),
				$locationData['countryBoxesHtml'],
				$locationData['regionFiltersHtml'],
				$locationData['countryExpanderHtml'],
				$locationData['countrywiseExpanderHtml'],
				$locationData['scriptsMarkup'],
				esc_html__( 'Type to search location…', 'cg-archive-shortcode' ),
				esc_html__( 'Browse list of locations Capgemini operates in', 'cg-archive-shortcode' ),
				esc_html__( 'All', 'cg-archive-shortcode' ),
			),
			$pageContent
		);

		return $page;
	}

}
