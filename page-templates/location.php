<section class="section section--locations-map">

	<!--<div class="map-container">

		<div id="map" class="map-wrapper"></div>

		<div class="map-zoom-controls">

			<div class="controls zoom-control map-buttons">
				<button class="zoom-control-in map-button-plus" title="Zoom In">+</button>
				<button class="zoom-control-out map-button-minus" title="Zoom Out">−</button>
			</div>

		</div>

		<div class="map-box">

			<h3 class="box-title">{{ customTitle }}</h3>

			<form class="form--oneliner" onsubmit="return false;">

				<div class="form-block">
					<input aria-label="Search Location Input box" type="text" placeholder="{{ searchLocationPlaceholder }}"
						id="pac-input">
				</div>

				<div class="button-wrapper" id="location-search-btn">
					<input type="submit" value="" aria-label="submit-button" id="pac-submit">
				</div>

			</form>

			<div id="box_location_search" class="box-location-search"></div>

			<div class="box-info">{{ countryBoxesHtml }}</div>

		</div>

	</div>-->

</section>

<section class="section section--locations-expanders">

	<div class="container">

		<h3 class="location-title">{{ locationTitle }}</h3>

		<div class="filters filters--vertical" data-max="100">

			<div class="filters-nav-outer">

				<div class="filters-nav-window">

					<ul class="filters-nav">
						<li data-filter="0" class="active">
							<a href="#" class="filters-nav-anchor"
							   onclick="$('#all_countries_expanders').show();$('#country_wise_expanders').hide();">{{ allLabel }}</a>
						</li>
						{{ regionFiltersHtml }}
					</ul>

				</div>

			</div>

			<div class="expanders filters-content" id="all_countries_expanders">
				{{ countryExpanderHtml }}
			</div>

			<div class="expanders filters-content" id="country_wise_expanders" style="display:none;">
				{{ countrywiseExpanderHtml }}
			</div>

		</div>

	</div>

</section>

{{ scriptsMarkup }}
