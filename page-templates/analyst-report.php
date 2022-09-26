<section class="section section--publications section--press-news archive-pages">
  <div class="container">
    <div class="content-title">
      <h3>{{ filterHeading }}</h3>
    </div>
        <div class="filters filters--vertical" data-max="10">
          <div class="archive-search">
            <form class="form--oneliner js-search-form search search-icon" action="" method="get">
              <div class="form-block">
                <input type="text" aria-label="Enter search text"  type="submit" name="search" id="pr_form_subbmit" alt="{{ searchButtonLabel }}"
                  class="archive_phrase_search noeffect-input archive-search-input" placeholder="{{ searchPlaceholder }}">
                  <div class="search-icon"> </div>
                  <button class="search-button archive-search-button">{{ searchLabel }}</button>
              </div>

            </form>
          </div>
      <!-- filterStart -->
      <div class="filter-container">
      <div class="filters-selects-label" tabindex="0" role="button" aria-pressed="false" aria-expanded="false">
        <h4 class="d-none d-md-inline">{{ filterLabel }}</h4>
        <h4 class="d-inline d-md-none">{{ filterResultsLabel }}</h4>
      </div>
      <div class="filters-selects-list">
        <!-- filterDropdownAnalystStart -->
        <div class="filters-selects-box">
          <label for="select_cs_sectors">
            <select placeholder="{{ filterDropdownAnalystPlaceholder }}" class="js-filter js-with-select2" name="analyst" id="select_cs_analysts" multiple data-filter-select="0">
              {{ filterDropdownAnalystOptions }}
            </select>
          </label>
        </div>
        <!-- filterDropdownAnalystEnd -->
        <!-- filterDropdownIndustryStart -->
        <div class="filters-selects-box">
          <label for="select_cs_sectors">
            <select placeholder="{{ filterDropdownIndustryPlaceholder }}" class="js-filter js-with-select2" name="industry" id="select_cs_industries" multiple data-filter-select="1">
              {{ filterDropdownIndustryOptions }}
            </select>
          </label>
        </div>
        <!-- filterDropdownIndustryEnd -->
        <!-- filterDropdownServiceStart -->
        <div class="filters-selects-box">
          <label for="select_cs_services">
            <select placeholder="{{ filterDropdownServicePlaceholder }}" class="js-filter js-with-select2" name="service" id="select_cs_services" multiple data-filter-select="2">
              {{ filterDropdownServiceOptions }}
            </select>
          </label>
        </div>
        <!-- filterDropdownServiceEnd -->
        <!-- filterDropdownPartnerStart -->
        <div class="filters-selects-box">
          <label for="select_cs_partners">
            <select placeholder="{{ filterDropdownPartnerPlaceholder }}" class="js-filter js-with-select2" name="partner" id="select_cs_partners" multiple data-filter-select="3">
              {{ filterDropdownPartnerOptions }}
            </select>
          </label>
        </div>
        <!-- filterDropdownPartnerEnd -->
        <!-- filterDropdownYearStart -->
        <div class="filters-selects-box">
          <label for="select_cs_years">
            <select placeholder="{{ filterDropdownYearPlaceholder }}" class="js-filter js-with-select2 year-filter" name="year" id="select_cs_years" multiple data-filter-select="4">
              {{ filterDropdownYearOptions }}
            </select>
          </label>
        </div>
        <!-- filterDropdownYearEnd -->
      </div>

      <div class="filters-tags-wrapper">
        <div class="filters-tags-list"></div>
        <button class="filters-clear">{{ filterClearAllLabel }}</button>
      </div>
    </div>
    <!-- filterEnd -->
      <!-- Single Press Release REST Template -->
      <script id="search_result_item_template" type="text/template">
      	<div class="box filter-box">

      		<div class="box-inner">
      			<span class="box-tag">{{ type }}</span>
      			<a class="box-title" href="{{ url }}"><h4>{{ title }}</h4></a>
            <div class="box-author-inner">
              <span class="box-date"><span>{{ date }}</span></span>
            </div>
          </div>
          <div class="box-right">
            <a href="{{ url }}" class="cta-link" aria-label="Read more about {{ title }}">{{ readMoreLabel }}</a>
            <!-- <a class="more2" aria-label="read-more-link">Read more</a> -->
            <div class="">{{ brandimg }}</div>
          </div>
      	</div>

      </script>

      <div class="filters-content filters-content-archive" data-type="analyst-report">
      </div>

      <h3 class="js-no-results">{{ noResultsLabel }}</h3>

      <div class="filters-bottom">
        <a class="filters-more filtersNoBottomSpace" href="#" id="ar_filters_more" aria-label="Show more">{{ showMoreLabel }}</a>
      </div>

    </div>
      </div>

</section>
