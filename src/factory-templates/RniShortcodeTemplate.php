<?php
/**
 * Research & insight Shortcode Template
 *
 * @package      CG/Capgemini_Archive_Shortcode
 * @author       Capgemini GIT
 * @copyright    Capgemini GIT
 * @license      GPL-2.0-or-later
 */

namespace CG\Capgemini_Archive_Shortcode;

class RniShortcodeTemplate implements ArchiveShortcodeTemplate {

	public function buildArchiveShortcodePage($archiveShortcode) {

		// Filters data
		$types_options = $archiveShortcode->taxomony_options['research_and_insight_type'] ?? '';
		$industries_options = $archiveShortcode->taxomony_options['industry'] ?? '';
		$topics_options = $archiveShortcode->taxomony_options['theme'] ?? '';
		$years = $archiveShortcode->posts_years ?? [];
		$custom_filter_options = $archiveShortcode->getData( 'archive_filter_options' ) ?: '';
		rsort($years);
		$years_options = '';
		foreach ( $years as $year ) :
			$years_options .= '<option value="' . esc_attr( $year ) . '">' . esc_html( $year ) . '</option>';
		endforeach;

		$custom_filter_title = $archiveShortcode->getData( 'archive_filter_title' ) ?: __( 'Research and insights library', 'cg-archive-shortcode' );

		$pageContent = file_get_contents( WP_PLUGIN_DIR . '/cg-archive-shortcode/page-templates/research-and-insight.php' );

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
				'{{ filterDropdownIndustryLabel }}',
				'{{ filterDropdownIndustryPlaceholder }}',
				'{{ filterDropdownIndustryOptions }}',
				'{{ filterDropdownThemeLabel }}',
				'{{ filterDropdownThemePlaceholder }}',
				'{{ filterDropdownThemeOptions }}',
				'{{ filterDropdownYearLabel }}',
				'{{ filterDropdownYearPlaceholder }}',
				'{{ filterDropdownYearOptions }}',
				'{{ filterClearAllLabel }}',
				'{{ noResultsLabel }}',
				'{{ showMoreLabel }}',
				'{{ searchLabel }}',
				'{{ readMoreLabel }}',
				'{{ filesizeLabel }}',
				'{{ filetypeLabel }}',
			],
			[
				wp_kses_post( isset( $custom_filter_title ) ? $custom_filter_title : __( 'Research and insights library', 'cg-archive-shortcode' ) ),
				esc_attr__( 'Type to search…', 'cg-archive-shortcode' ),
				esc_attr__( 'Search', 'cg-archive-shortcode' ),
				esc_html__( 'Filters', 'cg-archive-shortcode' ),
				esc_html__( 'Filter results', 'cg-archive-shortcode' ),
				esc_attr__( 'Type', 'cg-archive-shortcode' ),
				esc_attr__( 'Type', 'cg-archive-shortcode' ),
				$types_options,
				esc_attr__( 'Industry', 'cg-archive-shortcode' ),
				esc_attr__( 'Industry', 'cg-archive-shortcode' ),
				$industries_options,
				esc_attr__( 'Topic', 'cg-archive-shortcode' ),
				esc_attr__( 'Topic', 'cg-archive-shortcode' ),
				$topics_options,
				esc_attr__( 'Year', 'cg-archive-shortcode' ),
				esc_attr__( 'Year', 'cg-archive-shortcode' ),
				$years_options,
				esc_html__( 'Clear all', 'cg-archive-shortcode' ),
				esc_html__( 'No results matching your search', 'cg-archive-shortcode' ),
				esc_html__( 'Show 10 more research and insights', 'cg-archive-shortcode' ),
				esc_html__( 'Search', 'cg-archive-shortcode' ),
				esc_html__( 'Read more', 'cg-archive-shortcode' ),
				esc_html__( 'File size', 'cg-archive-shortcode' ),
				esc_html__( 'File type', 'cg-archive-shortcode' ),
			],
			$pageContent
		);

		if ( ! in_array( 'type', $custom_filter_options ) ) { // phpcs:ignore
			$typeFilterHtml = $archiveShortcode->get_string_between($page, '<!-- filterDropdownTypeStart -->', '<!-- filterDropdownTypeEnd -->');

			$page = str_replace($typeFilterHtml, '', $page);
		}

		if ( ! in_array( 'industry', $custom_filter_options ) ) { // phpcs:ignore
			$industryFilterHtml = $archiveShortcode->get_string_between($page, '<!-- filterDropdownIndustryStart -->', '<!-- filterDropdownIndustryEnd -->');

			$page = str_replace($industryFilterHtml, '', $page);
		}

		if ( ! in_array( 'theme', $custom_filter_options ) ) { // phpcs:ignore
			$themeFilterHtml = $archiveShortcode->get_string_between($page, '<!-- filterDropdownThemeStart -->', '<!-- filterDropdownThemeEnd -->');

			$page = str_replace($themeFilterHtml, '', $page);
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
