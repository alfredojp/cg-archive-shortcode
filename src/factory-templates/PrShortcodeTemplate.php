<?php
/**
 * Press release Shortcode Template
 *
 * @package      CG/Capgemini_Archive_Shortcode
 * @author       Capgemini GIT
 * @copyright    Capgemini GIT
 * @license      GPL-2.0-or-later
 */

namespace CG\Capgemini_Archive_Shortcode;

class PrShortcodeTemplate implements ArchiveShortcodeTemplate {

	public function buildArchiveShortcodePage($archiveShortcode) {

		// Filters data
		$types_options = $archiveShortcode->taxomony_options['press_release_type'] ?? '';
		$years = $archiveShortcode->posts_years ?? [];
		$custom_filter_options = $archiveShortcode->getData( 'archive_filter_options' ) ?: '';
		rsort($years);
		$years_options = '';
		foreach ( $years as $year ) :
			$years_options .= '<option value="' . esc_attr( $year ) . '">' . esc_html( $year ) . '</option>';
		endforeach;
		$custom_filter_title = $archiveShortcode->getData( 'archive_filter_title' ) ?: "";
		$pageContent = file_get_contents( WP_PLUGIN_DIR . '/cg-archive-shortcode/page-templates/press-release.php' );

		$page = str_replace(
			[
				'{{ filterHeading }}',
				'{{ searchPlaceholder }}',
				'{{ searchButtonLabel }}',
				'{{ filterLabel }}',
				'{{ filterResultsLabel }}',
				'{{ filterDropdownTypeLabel }}',
				'{{ filterDropdownTypePlaceholder }}',
				'{{ filterDropdownTypeOptions }}',
				'{{ filterDropdownYearLabel }}',
				'{{ filterDropdownYearPlaceholder }}',
				'{{ filterDropdownYearOptions }}',
				'{{ filterDateFromPlaceholder }}',
				'{{ filterDateToPlaceholder }}',
				'{{ filterClearAllLabel }}',
				'{{ noResultsLabel }}',
				'{{ showMoreLabel }}',
				'{{ searchLabel }}',
				'{{ readMoreLabel }}',
			],
			[
				wp_kses_post( isset( $custom_filter_title ) ? $custom_filter_title : __( 'Press Release library', 'cg-archive-shortcode' ) ),
				esc_attr__( 'Type to search…', 'cg-archive-shortcode' ),
				esc_attr__( 'Search', 'cg-archive-shortcode' ),
				esc_html__( 'Filters', 'cg-archive-shortcode' ),
				esc_html__( 'Filter results', 'cg-archive-shortcode' ),
				esc_attr__( 'Category', 'cg-archive-shortcode' ),
				esc_attr__( 'Category', 'cg-archive-shortcode' ),
				$types_options,
				esc_attr__( 'Year', 'cg-archive-shortcode' ),
				esc_attr__( 'Year', 'cg-archive-shortcode' ),
				$years_options,
				esc_attr__( 'Date from', 'cg-archive-shortcode' ),
				esc_attr__( 'Date to', 'cg-archive-shortcode' ),
				esc_html__( 'Clear all', 'cg-archive-shortcode' ),
				esc_html__( 'No results matching your search', 'cg-archive-shortcode' ),
				esc_html__( 'Show 10 more news', 'cg-archive-shortcode' ),
				esc_html__( 'Search', 'cg-archive-shortcode' ),
				esc_html__( 'Read more', 'cg-archive-shortcode' ),
			],
			$pageContent
		);

		if ( ! in_array( 'type', $custom_filter_options ) ) { // phpcs:ignore
			$typeFilterHtml = $archiveShortcode->get_string_between($page, '<!-- filterDropdownTypeStart -->', '<!-- filterDropdownTypeEnd -->');

			$page = str_replace($typeFilterHtml, '', $page);
		}

		if ( ! in_array( 'year', $custom_filter_options ) ) { // phpcs:ignore
			$yearFilterHtml = $archiveShortcode->get_string_between($page, '<!-- filterDropdownYearStart -->', '<!-- filterDropdownYearEnd -->');

			$page = str_replace($yearFilterHtml, '', $page);
		}

		if ( ! in_array( 'date', $custom_filter_options ) ) { // phpcs:ignore
			$dateFilterHtml = $archiveShortcode->get_string_between($page, '<!-- filterDateFromStart -->', '<!-- filterDateToEnd -->');

			$page = str_replace($dateFilterHtml, '', $page);
		}

		if ( !is_array( $custom_filter_options ) || count( $custom_filter_options ) < 1 ) {
			$filterHtml = $archiveShortcode->get_string_between($page, '<!-- filterStart -->', '<!-- filterEnd -->');

			$page = str_replace($filterHtml, '', $page);
		}

		return $page;
	}

}
