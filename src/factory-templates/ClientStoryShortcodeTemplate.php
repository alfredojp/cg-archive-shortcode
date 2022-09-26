<?php
/**
 * Client Story Shortcode Template
 *
 * @package      CG/Capgemini_Archive_Shortcode
 * @author       Capgemini GIT
 * @copyright    Capgemini GIT
 * @license      GPL-2.0-or-later
 */

namespace CG\Capgemini_Archive_Shortcode;

class ClientStoryShortcodeTemplate implements ArchiveShortcodeTemplate {

	public function buildArchiveShortcodePage($archiveShortcode) {

		// Filters data
		$industries_options = $archiveShortcode->taxomony_options['industry'] ?? '';
		$services_options = $archiveShortcode->taxomony_options['service'] ?? '';
		$partners_options = $archiveShortcode->taxomony_options['partner'] ?? '';
		$years = $archiveShortcode->posts_years ?? [];
		$custom_filter_options = $archiveShortcode->getData( 'archive_filter_options' ) ?: '';
		rsort($years);
		$years_options = '';
		foreach ( $years as $year ) :
			$years_options .= '<option value="' . esc_attr( $year ) . '">' . esc_html( $year ) . '</option>';
		endforeach;
		$custom_filter_title = $archiveShortcode->getData( 'archive_filter_title' ) ?: __( 'Client Story library', 'cg-archive-shortcode' );
		$pageContent = file_get_contents( WP_PLUGIN_DIR . '/cg-archive-shortcode/page-templates/client-story.php' );

		$page = str_replace(
			[
				'{{ filterHeading }}',
				'{{ searchPlaceholder }}',
				'{{ searchButtonLabel }}',
				'{{ filterLabel }}',
				'{{ filterResultsLabel }}',
				'{{ filterDropdownIndustryLabel }}',
				'{{ filterDropdownIndustryPlaceholder }}',
				'{{ filterDropdownIndustryOptions }}',
				'{{ filterDropdownServiceLabel }}',
				'{{ filterDropdownServicePlaceholder }}',
				'{{ filterDropdownServiceOptions }}',
				'{{ filterDropdownPartnerLabel }}',
				'{{ filterDropdownPartnerPlaceholder }}',
				'{{ filterDropdownPartnerOptions }}',
				'{{ filterDropdownYearLabel }}',
				'{{ filterDropdownYearPlaceholder }}',
				'{{ filterDropdownYearOptions }}',
				'{{ filterClearAllLabel }}',
				'{{ noResultsLabel }}',
				'{{ showMoreLabel }}',
				'{{ searchLabel }}',
				'{{ readMoreLabel }}',
			],
			[
				wp_kses_post( isset( $custom_filter_title ) ? $custom_filter_title : __( 'Client Story library', 'cg-archive-shortcode' ) ),
				esc_attr__( 'Type to search…', 'cg-archive-shortcode' ),
				esc_attr__( 'Search', 'cg-archive-shortcode' ),
				esc_html__( 'Filters', 'cg-archive-shortcode' ),
				esc_html__( 'Filter results', 'cg-archive-shortcode' ),
				esc_attr__( 'Industry', 'cg-archive-shortcode' ),
				esc_attr__( 'Industry', 'cg-archive-shortcode' ),
				$industries_options,
				esc_attr__( 'Service', 'cg-archive-shortcode' ),
				esc_attr__( 'Service', 'cg-archive-shortcode' ),
				$services_options,
				esc_attr__( 'Partner', 'cg-archive-shortcode' ),
				esc_attr__( 'Partner', 'cg-archive-shortcode' ),
				$partners_options,
				esc_attr__( 'Year', 'cg-archive-shortcode' ),
				esc_attr__( 'Year', 'cg-archive-shortcode' ),
				$years_options,
				esc_html__( 'Clear all', 'cg-archive-shortcode' ),
				esc_html__( 'No results matching your search', 'cg-archive-shortcode' ),
				esc_html__( 'Show 10 more stories', 'cg-archive-shortcode' ),
				esc_html__( 'Search', 'cg-archive-shortcode' ),
				esc_html__( 'Read more', 'cg-archive-shortcode' ),
			],
			$pageContent
		);

		if ( ! in_array( 'industry', $custom_filter_options ) ) { // phpcs:ignore
			$industryFilterHtml = $archiveShortcode->get_string_between($page, '<!-- filterDropdownIndustryStart -->', '<!-- filterDropdownIndustryEnd -->');

			$page = str_replace($industryFilterHtml, '', $page);
		}

		if ( ! in_array( 'service', $custom_filter_options ) ) { // phpcs:ignore
			$serviceFilterHtml = $archiveShortcode->get_string_between($page, '<!-- filterDropdownServiceStart -->', '<!-- filterDropdownServiceEnd -->');

			$page = str_replace($serviceFilterHtml, '', $page);
		}

		if ( ! in_array( 'partner', $custom_filter_options ) ) { // phpcs:ignore
			$partnerFilterHtml = $archiveShortcode->get_string_between($page, '<!-- filterDropdownPartnerStart -->', '<!-- filterDropdownPartnerEnd -->');

			$page = str_replace($partnerFilterHtml, '', $page);
		}

		if ( ! in_array( 'year', $custom_filter_options ) ) { // phpcs:ignore
			$yearFilterHtml = $archiveShortcode->get_string_between($page, '<!-- filterDropdownYearStart -->', '<!-- filterDropdownYearEnd -->');

			$page = str_replace($yearFilterHtml, '', $page);
		}

		if ( !is_array( $custom_filter_options ) || count( $custom_filter_options ) < 1 ) {
			$filterHtml = $archiveShortcode->get_string_between($page, '<!-- filterStart -->', '<!-- filterEnd -->');

			$page = str_replace($filterHtml, '', $page);
		}

		return $page;
	}

}
