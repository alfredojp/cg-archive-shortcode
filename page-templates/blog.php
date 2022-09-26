<section class="section--publications section--insights-content archive-pages archive-ExpertPerspective-Page">
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
        <span class="d-none d-md-inline">{{ filterLabel }}</span>
        <span class="d-inline d-md-none">{{ filterResultsLabel }}</span>
      </div>
      <div class="filters-selects-list">
        <!-- filterDropdownIndustryStart -->
        <div class="filters-selects-box">
          <label for="select_pr_industries">
            <select placeholder="{{ filterDropdownIndustryPlaceholder }}" class="js-filter js-with-select2" name="industry" id="select_pr_industries" multiple data-filter-select="0">
              {{ filterDropdownIndustryOptions }}
            </select>
          </label>
        </div>
        <!-- filterDropdownIndustryEnd -->
        <!-- filterDropdownBlogTopicStart -->
        <div class="filters-selects-box">
          <label for="select_pr_terms">
            <select placeholder="{{ filterDropdownBlogTopicPlaceholder }}" class="js-filter js-with-select2" name="theme" id="select_pr_terms" multiple data-filter-select="1">
              {{ filterDropdownBlogTopicOptions }}
            </select>
          </label>
        </div>
        <!-- filterDropdownBlogTopicEnd -->
        <!-- filterDropdownPartnerStart -->
        <div class="filters-selects-box">
          <label for="select_pr_partners">
            <select placeholder="{{ filterDropdownPartnerPlaceholder }}" class="js-filter js-with-select2" name="partner" id="select_pr_partners" multiple data-filter-select="2">
              {{ filterDropdownPartnerOptions }}
            </select>
          </label>
        </div>
        <!-- filterDropdownPartnerEnd -->
        <!-- filterDropdownYearStart -->
        <div class="filters-selects-box">
          <label for="select_pr_years">
            <select placeholder="{{ filterDropdownYearPlaceholder }}" class="js-filter js-with-select2 year-filter" name="year" id="select_pr_years" multiple data-filter-select="3">
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
    <!-- Single Research & Insight Template -->
      <script id="search_result_item_template" type="text/template">
        <div class="box box--event filter-box">
          	{{ featuredimagewithanchor }}
          <div class="box-inner">
            <span class="box-tag">{{ type }}</span>
            <a class="box-title" href="{{ url }}"><h4>{{ title }}</h4></a>
            <a class="box-author link-author" href="{{ authorurl }}">
              <div class="box-author-img">
                <img src="{{ personimage }}" alt="">
              </div>
              <div class="box-author-inner">
                <span class="box-author-name">  {{ personname }}</span>
                <span class="box-date"><span>{{ date }}</span></span>
              </div>
            </a>
          </div>
          <div class="box-right archive-blog-expert">
            <a href="{{ url }}" class="cta-link" aria-label="Read more about {{ title }}">{{ readMoreLabel }}</a>
            <a href="{{ fileurl }}" class="link-download">
              <span>File size: {{ filesize }}</span>
              <span>File type: {{ filetype }}</span>
            </a>
            {{ brandimg }}
          </div>
        </div>
      </script>

      <div class="filters-content filters-content-archive" data-type="blog">
      </div>

      <h3 class="js-no-results">{{ noResultsLabel }}</h3>

      <div class="filters-bottom">
        <a class="filters-more" href="#" id="pr_filters_more" aria-label="Show more" >{{ showMoreLabel }}</a>
      </div>

    </div>
  </div>
</section>
