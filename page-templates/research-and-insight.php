<section class="section--publications section--insights-content archive-pages">
  <div class="container">
    <div class="content-title">
      <h3>{{ filterHeading }}</h3>
    </div>

    <div class="filters filters--vertical" data-max="10">

        <div class="archive-search">
            <form class="form--oneliner js-search-form search search-icon" action="" method="get" >
                <div class="form-block">
                    <input type="text" aria-label="Enter search text" type="submit" name="search" id="pr_form_subbmit" alt="{{ searchButtonLabel }}"
                           class="archive_phrase_search noeffect-input archive-search-input" placeholder="{{ searchPlaceholder }}">
                    <div class="search-icon"> </div>
                    <button class="search-button archive-search-button">{{ searchLabel }}</button>
                </div>

            </form>
        </div>
<!-- filterStart -->
      <div class="filter-container">
          <div class="filters-selects-label" tabindex="0" role="button" aria-pressed="false" aria-expanded="false">
              <span class="d-none d-md-inline">{{ filterLabel }}</span>
              <span class="d-inline d-md-none">{{ filterResultsLabel }}</span>
          </div>
          <div class="filters-selects-list">
              <!-- filterDropdownTypeStart -->
              <div class="filters-selects-box">
                  <select aria-label="{{ filterDropdownTypeLabel }} dropdown" placeholder="{{ filterDropdownTypePlaceholder }}" class="js-filter js-with-select2" name="research-and-insight-type" id="select_ra_type" multiple data-filter-select="0">
                      {{ filterDropdownTypeOptions }}
                  </select>
              </div>
              <!-- filterDropdownTypeEnd -->
              <!-- filterDropdownIndustryStart -->
              <div class="filters-selects-box">
                  <select aria-label="{{ filterDropdownIndustryLabel }} dropdown" placeholder="{{ filterDropdownIndustryPlaceholder }}" class="js-filter js-with-select2" name="industry" id="select_ra_industry" multiple data-filter-select="1">
                      {{ filterDropdownIndustryOptions }}
                  </select>
              </div>
              <!-- filterDropdownIndustryEnd -->
              <!-- filterDropdownThemeStart -->
              <div class="filters-selects-box">
                  <select aria-label="{{ filterDropdownThemeLabel }} dropdown" placeholder="{{ filterDropdownThemePlaceholder }}" class="js-filter js-with-select2" name="theme" id="select_ra_topic" multiple data-filter-select="2">
                      {{ filterDropdownThemeOptions }}
                  </select>
              </div>
              <!-- filterDropdownThemeEnd -->
              <!-- filterDropdownYearStart -->
              <div class="filters-selects-box">
                  <select aria-label="{{ filterDropdownYearLabel }} dropdown" placeholder="{{ filterDropdownYearPlaceholder }}" class="js-filter js-with-select2 year-filter" name="year" id="select_ra_years" multiple data-filter-select="3">
                      {{ filterDropdownYearOptions }}
                  </select>
              </div>
              <!-- filterDropdownYearEnd -->
          </div>

          <div class="filters-tags-wrapper">
              <div class="filters-tags-list"></div>
              <button class="filters-clear">{{ filterClearAllLabel }}</button>
          </div>
      </div>
<!-- filterEnd -->
      <!-- Single Research & Insight Template -->
      <script id="search_result_item_template" type="text/template">
        <div class="box box--event filter-box">
	       {{ featuredimagewithanchor }}
          <div class="box-inner">
            <span class="box-tag">{{ theme }}</span>
            <a class="box-title" href="{{ url }}"><h4>{{ title }}</h4></a>
            <a class="box-author link-author" href="{{ authorurl }}">
              <div class="box-author-img">
                {{ authorimage }}
              </div>
              <div class="box-author-inner">
                <span class="box-author-name">  {{ authorname }}</span>
                <span class="box-date"><span>{{ date }}</span></span>
              </div>
            </a>
          </div>
          <div class="box-right">
            <a href="{{ url }}" class="cta-link" aria-label="Read more about {{ title }}">{{ readMoreLabel }}</a>
            <a href="{{ fileurl }}" class="link-download">
              <span>{{ filesizeLabel }}: {{ filesize }}</span>
              <span>{{ filetypeLabel }}: {{ filetype }}</span>
            </a>
            {{ brandimg }}
          </div>
        </div>
      </script>

      <div class="filters-content filters-content-archive" data-type="research-and-insight">
      </div>

      <h3 class="js-no-results">{{ noResultsLabel }}</h3>

      <div class="filters-bottom">
        <a class="filters-more" href="#" id="ra_filters_more">{{ showMoreLabel }}</a>
      </div>

    </div>
  </div>
</section>
