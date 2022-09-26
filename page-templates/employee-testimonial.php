<section class="section section--grey-boxes section--testimonial-boxes archive-pages">

	<div class="container">

		<div class="filters filters--vertical" data-max="10">

			<!-- filterStart -->
			<div class="filter-container">
				<div class="filters-selects-label" tabindex="0" role="button" aria-pressed="false" aria-expanded="false">
					<span class="d-none d-md-inline">{{ filterLabel }}</span>
					<span class="d-inline d-md-none">{{ filterResultsLabel }}</span>
				</div>

				<div class="filters-selects-list">

					<!-- filterDropdownGradeStart -->
					<div class="filters-selects-box">
						<select aria-label="{{ filterDropdownGradeLabel }} dropdown"
						        placeholder="{{ filterDropdownGradePlaceholder }}" class="js-filter js-with-select2"
						        name="grade" id="select_et_grade" multiple data-filter-select="0">
							{{ filterDropdownGradeOptions }}
						</select>
					</div>
					<!-- filterDropdownGradeEnd -->

					<!-- filterDropdownJobFamilyStart -->
					<div class="filters-selects-box">
						<select aria-label="{{ filterDropdownJobFamilyLabel }} dropdown"
						        placeholder="{{ filterDropdownJobFamilyPlaceholder }}" class="js-filter js-with-select2"
						        name="job_family" id="select_et_job_family" multiple data-filter-select="1">
							{{ filterDropdownJobFamilyOptions }}
						</select>
					</div>
					<!-- filterDropdownJobFamilyEnd -->

					<!-- filterDropdownCountryStart -->
					<div class="filters-selects-box">
						<select aria-label="{{ filterDropdownCountryLabel }} dropdown"
						        placeholder="{{ filterDropdownCountryPlaceholder }}" class="js-filter js-with-select2"
						        name="country" id="select_et_country" multiple data-filter-select="2">
							{{ filterDropdownCountryOptions }}
						</select>
					</div>
					<!-- filterDropdownCountryEnd -->

					<!-- filterDropdownBrandStart -->
					<div class="filters-selects-box">
						<select aria-label="{{ filterDropdownBrandLabel }} dropdown"
						        placeholder="{{ filterDropdownBrandPlaceholder }}" class="js-filter js-with-select2"
						        name="brand" id="select_et_brand" multiple data-filter-select="3">
							{{ filterDropdownBrandOptions }}
						</select>
					</div>
					<!-- filterDropdownBrandEnd -->

					<!-- filterDropdownIndustryStart -->
					<div class="filters-selects-box">
						<select aria-label="{{ filterDropdownIndustryLabel }} dropdown"
						        placeholder="{{ filterDropdownIndustryPlaceholder }}" class="js-filter js-with-select2"
						        name="industry" id="select_et_industry" multiple data-filter-select="4">
							{{ filterDropdownIndustryOptions }}
						</select>
					</div>
					<!-- filterDropdownIndustryEnd -->

				</div>

				<div class="filters-tags-wrapper">
					<div class="filters-tags-list"></div>
					<button class="filters-clear">{{ filterClearAllLabel }}</button>
				</div>
			</div>
			<!-- filterEnd -->

			<div class="row">

				<!-- Single Research & Insight REST Template -->
				<script id="search_result_item_template" type="text/template">

					<div class="col-sm-12 col-md-6 col-lg-4 card-detail">

						<div class="box">
							{{ featuredimage }}

							<div class="box-inner">

								<a class="box-title" href="{{ url }}"><h4 class="box-title__text">{{ title }}</h4></a>

								<p class="box-position">{{ testimonialtitle }}</p>

								<p class="box-subtitle">{{ excerpt }}</p>

								<div class="box-tags"></div>

							</div>

						</div>

					</div>

				</script>

			</div>

			<div class="row filters-content filters-content-archive" data-page="1" data-type="employee-testimonial"></div>

			<h3 class="js-no-results">{{ noResultsLabel }}</h3>

			<div class="slider-bottom filters-pagination"></div>

		</div>

	</div>

</section>
