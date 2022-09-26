<section class="section--publications section--press-news section--events-listing archive-pages eventPage">

	<div class="container">

		<div class="filters filters--vertical" data-max="10">

			{{ searchForm }}

			<div class="filter-container filter-data">

				<a class="js-event-filter more2 upcomingEventBtn event-button" href="#upcoming"  data-value="upcoming">{{ filterUpcomingEventsLabel }}</a>

				<a class="js-event-filter more2 pastEventBtn event-button" href="#past"  data-value="past">{{ filterPastEventsLabel }}</a>

				<a class="js-event-type-filter more2 pastEventBtn event-button" href="#business"  data-value="business">{{ filterBusinessEventsLabel }}</a>

				<a class="js-event-type-filter more2 pastEventBtn event-button" href="#careers" data-value="careers">{{ filterCareersEventsLabel }}</a>

			</div>

			<!-- Single Event REST Template -->
			<script id="search_result_item_template" type="text/template">

				<div class="box box--event filter-box">

					<a href={{ url }}>

						<div class="box-inner-dateTimeInfo event-box-inner event-box-inner-{{ eventtype }}">

							<!-- Add to cal button -->
							<div title="{{ addToCalendar }}" class="addeventatc event-calendar-mobile {{ eventclass }}" data-styling="none">
								<span class="start">{{ addtocalendstart }}</span>
								<span class="end">{{ addtocalendend }}</span>
								<span class="title">{{ title }}</span>
								<span class="location">{{ location }}</span>
							</div>

							<!-- date divided for particular sections -->
							<p class="month">{{ month }} {{ day }}</p>
							<p class="year">{{ year }}</p>
							<p class="time">{{ hour }} {{ eventtimezone }}</p>

						</div>

					</a>

					<div class="box-inner">
						<span class="box-tag">{{ eventtype }}</span>
						<a class="box-title" href="{{ url }}"><h4>{{ title }}</h4></a>
						{{ banner }}
						<div class="box-date">
							<span>{{ location }}</span>
						</div>
					</div>

					<div class="box-right {{ eventclass }}">

						<div class="event-add-to-calendar">

							<span class="event-add-to-calendar__text">{{ addToCalendar }}</span>

							<!-- Add to cal button -->
							<div title="{{ addToCalendar }}" class="addeventatc" data-styling="none">
								<span class="start">{{ addtocalendstart }}</span>
								<span class="end">{{ addtocalendend }}</span>
								<span class="title">{{ title }}</span>
								<span class="location">{{ location }}</span>
							</div>

						</div>

						<div class="registerBtnWrapper">
							<a href="{{ url }}" class="event-register">{{ registerLabel }}</a>
						</div>

					</div>

				</div>

			</script>

			<div class="filters-content filters-content-archive" data-type="event"></div>

		</div>

	</div>

	<h3 class="js-no-results">{{ noResultsLabel }}</h3>

	<div class="filters-bottom">
		<a class="filters-more" href="#" id="pr_filters_more">{{ showMoreLabel }}</a>
	</div>

</section>
