<section class="section--publications section--press-news archive-pages">
    <div class="container">
      <div class="filters filters--vertical" data-max="10">
        <div class="archive-search">
          <form class="form--oneliner js-search-form search search-icon" action="" method="get" >
            <div class="form-block">
              <input type="text" aria-label="Enter search text" name="search" class="archive_phrase_search noeffect-input archive-search-input archive-search-input" placeholder="{{ searchPlaceholder }}">
              <div class="search-icon"> </div>
              <button class="search-button archive-search-button">{{ searchLabel }}</button>
            </div>
            <!-- <div class="button-wrapper">
              <input aria-label="search button" type="submit" id="pr_form_subbmit" alt="{{ searchButtonLabel }}" value="Search">
            </div> -->
          </form>
        </div>
        <!-- filterStart -->
        <div class="filter-container">
            <div class="filters-selects-label" tabindex="0" role="button" aria-pressed="false" aria-expanded="false">
              <h4 class="d-none d-md-inline">{{ filterLabel }}</h4>
              <h4 class="d-inline d-md-none">{{ filterResultsLabel }}</h4>
            </div>
            <div class="filters-selects-list">
              <!-- filterDropdownTypeStart -->
              <div class="filters-selects-box">
                <label for="select_pr_terms">
                  <select placeholder="{{ filterDropdownTypePlaceholder }}" class="js-filter js-with-select2" name="press-release-type" id="select_pr_terms" multiple data-filter-select="0">
                    {{ filterDropdownTypeOptions }}
                  </select>
                </label>
              </div>
              <!-- filterDropdownTypeEnd -->
              <!-- filterDropdownYearStart -->
              <div class="filters-selects-box">
                <label for="select_pr_years">
                  <select placeholder="{{ filterDropdownYearPlaceholder }}" class="js-filter js-with-select2 year-filter" name="year" id="select_pr_years" multiple data-filter-select="1">
                    {{ filterDropdownYearOptions }}
                  </select>
                </label>
              </div>
              <!-- filterDropdownYearEnd -->
              <!-- filterDateFromStart -->
              <div class="filters-selects-box">
                <div class="filter-input-fld-cont date-range">
                  <input type="text" aria-label="Please Press Down Arrow Key To Select a Date" class="js-filter pr_date filter-input-fld" autocomplete="off" name="date-from" id="pr_datefrom" placeholder="{{ filterDateFromPlaceholder }}">
                </div>
              </div>
              <!-- filterDateFromEnd -->
              <!-- filterDateToStart -->
              <div class="filters-selects-box">
                <div class="filter-input-fld-cont date-range">
                <input type="text" aria-label="Please Press Down Arrow Key To Select a Date" class="js-filter pr_date filter-input-fld" autocomplete="off" name="date-to" id="pr_dateto" placeholder="{{ filterDateToPlaceholder }}">
                </div>
              </div>
              <!-- filterDateToEnd -->
            </div>
            <div class="filters-tags-wrapper">
              <div class="filters-tags-list"></div>
              <button class="filters-clear" id="clearDates" >{{ filterClearAllLabel }}</button>
            </div>
        </div>
        <!-- filterEnd -->
        <!-- Single Press Release REST Template -->
        <script id="search_result_item_template" type="text/template">
            <div class="box filter-box">
                <div class="box-inner">
                    <span class="box-tag">{{ type }}</span>
                    <a class="box-title" href="{{ url }}"><h4>{{ title }}</h4></a>
                    <div class="box-date">
                        <span>{{ date }}</span>
                    </div>
                </div>
                <div class="box-right">
                    <a href="{{ url }}" class="more2 cta-link" aria-label="Read more about {{ title }}">{{ readMoreLabel }}</a>
                    {{ brandimg }}
                </div>
            </div>
        </script>
        <div class="filters-content filters-content-archive" data-type="press-release">
        </div>
        <h3 class="js-no-results">{{ noResultsLabel }}</h3>
        <div class="filters-bottom">
          <a class="filters-more" href="#" id="pr_filters_more">{{ showMoreLabel }}</a>
        </div>
      </div>
    </div>
  </section>
