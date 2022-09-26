<?php
/**
 * Testimonial Shortcode Template
 *
 * @package      CG/Capgemini_Archive_Shortcode
 * @author       Capgemini GIT
 * @copyright    Capgemini GIT
 * @license      GPL-2.0-or-later
 */

namespace CG\Capgemini_Archive_Shortcode;

class TestimonialShortcodeTemplate implements ArchiveShortcodeTemplate {

	public function buildArchiveShortcodePage($archiveShortcode) {

		// Filters data
		$grades_options = $archiveShortcode->taxomony_options['grade'] ?? '';
		$job_families_options = $archiveShortcode->taxomony_options['job_family'] ?? '';
		$countries_options = $archiveShortcode->taxomony_options['country'] ?? '';
		$brands_options = $archiveShortcode->taxomony_options['brand'] ?? '';
		$industries_options = $archiveShortcode->taxomony_options['industry'] ?? '';
		$custom_filter_options = $archiveShortcode->getData( 'archive_filter_options' ) ?: '';
		$custom_filter_title = $archiveShortcode->getData( 'archive_filter_title' ) ?: "";
		$pageContent = file_get_contents( WP_PLUGIN_DIR . '/cg-archive-shortcode/page-templates/employee-testimonial.php' );

		$page = str_replace(
			[
				'{{ filterHeading }}',
				'{{ filterLabel }}',
				'{{ filterResultsLabel }}',
				'{{ filterDropdownGradeLabel }}',
				'{{ filterDropdownGradePlaceholder }}',
				'{{ filterDropdownGradeOptions }}',
				'{{ filterDropdownJobFamilyLabel }}',
				'{{ filterDropdownJobFamilyPlaceholder }}',
				'{{ filterDropdownJobFamilyOptions }}',
				'{{ filterDropdownCountryLabel }}',
				'{{ filterDropdownCountryPlaceholder }}',
				'{{ filterDropdownCountryOptions }}',
				'{{ filterDropdownBrandLabel }}',
				'{{ filterDropdownBrandPlaceholder }}',
				'{{ filterDropdownBrandOptions }}',
				'{{ filterDropdownIndustryLabel }}',
				'{{ filterDropdownIndustryPlaceholder }}',
				'{{ filterDropdownIndustryOptions }}',
				'{{ filterClearAllLabel }}',
				'{{ noResultsLabel }}',
			],
			[
				wp_kses_post( isset( $custom_filter_title ) ) ? $custom_filter_title : esc_html__( 'Testimonials', 'cg-archive-shortcode'  ),
				esc_html__( 'Filters', 'cg-archive-shortcode' ),
				esc_html__( 'Filter results', 'cg-archive-shortcode' ),
				esc_attr__( 'Experience', 'cg-archive-shortcode' ),
				esc_attr__( 'Experience', 'cg-archive-shortcode' ),
				$grades_options,
				esc_attr__( 'Profession', 'cg-archive-shortcode' ),
				esc_attr__( 'Profession', 'cg-archive-shortcode' ),
				$job_families_options,
				esc_attr__( 'Country', 'cg-archive-shortcode' ),
				esc_attr__( 'Country', 'cg-archive-shortcode' ),
				$countries_options,
				esc_attr__( 'Brand', 'cg-archive-shortcode' ),
				esc_attr__( 'Brand', 'cg-archive-shortcode' ),
				$brands_options,
				esc_attr__( 'Industry', 'cg-archive-shortcode' ),
				esc_attr__( 'Industry', 'cg-archive-shortcode' ),
				$industries_options,
				esc_html__( 'Clear all', 'cg-archive-shortcode' ),
				esc_html__( 'No results matching your search', 'cg-archive-shortcode' ),
			],
			$pageContent
		);

		if ( ! in_array( 'grade', $custom_filter_options ) ) { // phpcs:ignore
			$gradeFilterHtml = $archiveShortcode->get_string_between($page, '<!-- filterDropdownGradeStart -->', '<!-- filterDropdownGradeEnd -->');

			$page = str_replace($gradeFilterHtml, '', $page);
		}

		if ( ! in_array( 'job_family', $custom_filter_options ) ) { // phpcs:ignore
			$jobFamilyFilterHtml = $archiveShortcode->get_string_between($page, '<!-- filterDropdownJobFamilyStart -->', '<!-- filterDropdownJobFamilyEnd -->');

			$page = str_replace($jobFamilyFilterHtml, '', $page);
		}

		if ( ! in_array( 'country', $custom_filter_options ) ) { // phpcs:ignore
			$countryFilterHtml = $archiveShortcode->get_string_between($page, '<!-- filterDropdownCountryStart -->', '<!-- filterDropdownCountryEnd -->');

			$page = str_replace($countryFilterHtml, '', $page);
		}

		if ( ! in_array( 'brand', $custom_filter_options ) ) { // phpcs:ignore
			$brandFilterHtml = $archiveShortcode->get_string_between($page, '<!-- filterDropdownBrandStart -->', '<!-- filterDropdownBrandEnd -->');

			$page = str_replace($brandFilterHtml, '', $page);
		}

		if ( ! in_array( 'industry', $custom_filter_options ) ) { // phpcs:ignore
			$industryFilterHtml = $archiveShortcode->get_string_between($page, '<!-- filterDropdownIndustryStart -->', '<!-- filterDropdownIndustryEnd -->');

			$page = str_replace($industryFilterHtml, '', $page);
		}

		if ( !is_array( $custom_filter_options ) || count( $custom_filter_options ) < 1 ) {
			$filterHtml = $archiveShortcode->get_string_between($page, '<!-- filterStart -->', '<!-- filterEnd -->');

			$page = str_replace($filterHtml, '', $page);
		}

		return $page;
	}

}
