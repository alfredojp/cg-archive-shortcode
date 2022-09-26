<?php
/**
 * Archive Shortcode
 *
 * @package      CG/Capgemini_Archive_Shortcode
 * @author       Capgemini GIT
 * @copyright    Capgemini GIT
 * @license      GPL-2.0-or-later
 */

namespace CG\Capgemini_Archive_Shortcode;
use Georedirect;
require_once WP_PLUGIN_DIR . '/cg-georedirect/inc/class-georedirect.php';

class ArchiveShortcode {

	const OPTION_KEY = 'archive_page_fields';

	public function __construct( $post_type ) {
		$this->post_type = $post_type;
	}

	public function init() {
		$this->populate();
	}

	public function populate() {
		$data = get_option( self::OPTION_KEY );
		$this->data = $data ?: [];
		$this->posts_years = $this->posts_years();

		switch ($this->post_type) {
			case 'research-and-insight':
				$this->taxomony_options['research_and_insight_type'] = $this->get_taxonomy_filter_options('research-and-insight-type');
				$this->taxomony_options['industry'] = $this->get_taxonomy_filter_options('industry');
				$this->taxomony_options['theme'] = $this->get_taxonomy_filter_options('theme');

				add_shortcode(
					'rni_archive',
					function() {
						return $this->buildArchive(new RniShortcodeFactory());
					}
				);

				break;

			case 'press-release':
				$this->taxomony_options['press_release_type'] = $this->get_taxonomy_filter_options('press-release-type');

				add_shortcode(
					'news_archive',
					function() {
						return $this->buildArchive(new PrShortcodeFactory());
					}
				);

				break;

			case 'client-story':
				$this->taxomony_options['industry'] = $this->get_taxonomy_filter_options('industry');
				$this->taxomony_options['service'] = $this->get_taxonomy_filter_options('service');
				$this->taxomony_options['partner'] = $this->get_taxonomy_filter_options('partners');

				add_shortcode(
					'client_story_archive',
					function() {
						return $this->buildArchive(new ClientStoryShortcodeFactory());
					}
				);

				break;

			case 'analyst-report':
				$this->taxomony_options['analyst'] = $this->get_taxonomy_filter_options('analyst');
				$this->taxomony_options['industry'] = $this->get_taxonomy_filter_options('industry');
				$this->taxomony_options['service'] = $this->get_taxonomy_filter_options('service');
				$this->taxomony_options['partner'] = $this->get_taxonomy_filter_options('partners');
				$this->taxomony_options['brand'] = $this->get_taxonomy_filter_options('brand');
				add_shortcode(
					'analyst_archive',
					function() {
						return $this->buildArchive(new AnalystShortcodeFactory());
					}
				);

				break;

			case 'post':
				$this->taxomony_options['industry'] = $this->get_taxonomy_filter_options('industry');
				$this->taxomony_options['blog_topic'] = $this->get_taxonomy_filter_options('blog-topic');
				$this->taxomony_options['partner'] = $this->get_taxonomy_filter_options('partners');

				add_shortcode(
					'blog_archive',
					function() {
						return $this->buildArchive(new BlogShortcodeFactory());
					}
				);

				break;

			case 'employee-testimonial':
				$this->taxomony_options['grade'] = $this->get_taxonomy_filter_options('grade');
				$this->taxomony_options['job_family'] = $this->get_taxonomy_filter_options('job_family');
				$this->taxomony_options['country'] = $this->get_taxonomy_filter_options('country');
				$this->taxomony_options['brand'] = $this->get_taxonomy_filter_options('brand');
				$this->taxomony_options['industry'] = $this->get_taxonomy_filter_options('industry');

				add_shortcode(
					'testimonial_archive',
					function() {
						return $this->buildArchive(new TestimonialShortcodeFactory());
					}
				);

				break;

			case 'event':

				add_shortcode(
					'event_archive',
					function() {
						return $this->buildArchive(new EventShortcodeFactory());
					}
				);

				break;

			case 'location':

				add_shortcode(
					'location_archive',
					function() {
						return $this->buildArchive(new LocationShortcodeFactory());
					}
				);

				break;

			default:
				// code...
				break;
		}
	}

	public function getData( $field ) {
		return $this->data[ $this->post_type ][ $field ] ?? [];
	}

	/**
	 * Return array with post years
	 */
	public function posts_years() {
		global $wpdb;
				$result = array();

				$query_prepare = $wpdb->prepare("SELECT YEAR(post_date) as year FROM ($wpdb->posts) WHERE post_status = 'publish' AND post_type = %s GROUP BY YEAR(post_date) DESC", $this->post_type);

				$years = $wpdb->get_results($query_prepare); // phpcs:ignore

				if ( is_array( $years ) && count( $years ) > 0 ) {
					foreach ( $years as $year ) {
						$result[] = $year->year;
					}
				}
				return $result;
	}

	public function get_taxonomy_filter_options($tax_term) {
		$terms =
			get_terms(
				[
					'taxonomy'   => $tax_term,
					'hide_empty' => true,
					'orderby'    => 'name',
					'order'      => 'ASC',
				]
			);

		$options = '';
		foreach ( $terms as $term ) {
			if ( isset($term->name) ) {
				$options .= '<option value="' . esc_attr( $term->slug ) . '">' . esc_html( $term->name ) . '</option>';
			}
		}

		return $options;

	}

	public function get_string_between($string, $start, $end){
		$string = ' ' . $string;
		$ini = strpos($string, $start);
		if ($ini === 0) return '';
		$ini += strlen($start);
		$len = strpos($string, $end, $ini) - $ini;
		return substr($string, $ini, $len);
	}

	public function buildLoctionData() {
		global $post;
		$locationData = [];
		$locations = [];
		$allCountries = [];
		$headOffices = [];
		$latLongStr = '';
		$countryLatLongStr = '';
		$headOfficeLatLongStr = defined( 'AS_DEFAULT_LOCATION' ) ? AS_DEFAULT_LOCATION : '';
		$regionMap = defined( 'AS_ALL_REGIONS' ) ? AS_ALL_REGIONS : [];
		$countryMap = defined( 'AS_ALL_COUNTRIES' ) ? AS_ALL_COUNTRIES : [];
		$siteToCountryMap = defined( 'AS_SITE_TO_COUNTRY_MAP' ) ? AS_SITE_TO_COUNTRY_MAP : [];
		$codeToCountryMap = defined( 'AS_CODE_TO_COUNTRY_MAP' ) ? AS_CODE_TO_COUNTRY_MAP : [];
		$user_country_code = '';
		$pathName = '';
		$args = [
			'post_status' => 'publish',
			'post_type' => 'location',
			'posts_per_page'=>'-1'
		];

		if ( ! is_admin() ) {
			if ( class_exists( 'Georedirect' ) ) {
				$geo = new Georedirect(true);

				if ( ! empty( $geo->get_user_country_code() ) ) {
					$user_country_code = $geo->get_user_country_code();
				}
			}
		}

		$currentSiteDetails = get_blog_details();
		if ( isset($currentSiteDetails->path) ) {
			$pathName = str_replace("/", "", $currentSiteDetails->path);
		}

		$list_of_posts = new \WP_Query($args);

		while( $list_of_posts->have_posts() ) : $list_of_posts->the_post();

			$region       = get_post_meta( $post->ID, 'cg_location_region', true ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			$country      = get_post_meta( $post->ID, 'cg_location_country', true ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			$latitude     = get_post_meta( $post->ID, 'cg_location_lat', true ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			$longitude    = get_post_meta( $post->ID, 'cg_location_long', true ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			$address      = nl2br( get_post_meta( $post->ID, 'cg_location_addr', true ) ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			$phone1       = get_post_meta( $post->ID, 'cg_location_phone1', true ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			$phone2       = get_post_meta( $post->ID, 'cg_location_phone2', true ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			$isHeadOffice = get_post_meta( $post->ID, 'cg_location_is_head_office', true ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			$picture      = get_the_post_thumbnail( $post->ID, 'medium' );

			$locations[$region][$country][] = array(
				'location' => $post,// phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
				'latitude' => $latitude,
				'longitude' => $longitude,
				'address' => $address,
				'phone1' => $phone1,
				'phone2' => $phone2,
				'isHeadOffice' => $isHeadOffice,
				'picture' => $picture,
			);

			$allCountries[ $country ][] = array(
				'location'     => $post,// phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
				'latitude'     => $latitude,
				'longitude'    => $longitude,
				'address'      => $address,
				'phone1'       => $phone1,
				'phone2'       => $phone2,
				'isHeadOffice' => $isHeadOffice,
				'picture'      => $picture,
			);

			if ( $latitude !== '' && $longitude !== '') {
				$latitude = preg_replace('/[^0-9\.-]/', '', $latitude);
				$longitude = preg_replace('/[^0-9\.-]/', '', $longitude);
				$latitude = preg_replace('/-+/', '-', $latitude);
				$longitude = preg_replace('/-+/', '-', $longitude);

				if( !is_numeric($latitude) || $latitude < -90 || $latitude > 90 ) {
					$latitude = 0;
				}

				if( !is_numeric($longitude) || $longitude < -180 || $longitude > 180 ) {
					$longitude = 0;
				}

				$latLongStr .= '{ lat: ' . str_replace(",", "", $latitude) . ', lng: ' . str_replace(",", "", $longitude) . ' },';

				if ( $pathName !== '' ) { // when the user is on a country site
					if ( $country === $siteToCountryMap[$pathName] ) {
						$countryLatLongStr .= '{ lat: ' . str_replace(",", "", $latitude) . ', lng: ' . str_replace(",", "", $longitude) . ' },';
					}
				} else { // when the user is on global site
					if ( $user_country_code !== '' && $country === $codeToCountryMap[$user_country_code] ) {
						$countryLatLongStr .= '{ lat: ' . str_replace(",", "", $latitude) . ', lng: ' . str_replace(",", "", $longitude) . ' },';
					}
				}
			}

			if ( $isHeadOffice ) {
				$headOffices[$country] = [
					'latitude' => $latitude,
					'longitude' => $longitude,
				];
			}

		endwhile;

		wp_reset_query();

		$sort = array();
		foreach( $locations as $k => $v ) {
			$sort['region'][$k] = $regionMap[$k];
		}
		array_multisort($sort['region'], SORT_ASC, $locations);

		$sort = array();
		foreach( $allCountries as $k => $v ) {
			$sort['country'][$k] = $countryMap[$k];
		}
		array_multisort($sort['country'], SORT_ASC, $allCountries);

		if ( $pathName !== '' && isset($siteToCountryMap[$pathName]) ) {
			if ( isset($headOffices[$siteToCountryMap[$pathName]]) ) {
				$headOfficeLatLongStr = $headOffices[$siteToCountryMap[$pathName]]['latitude'].",".$headOffices[$siteToCountryMap[$pathName]]['longitude'];
			}
		}

		$countryBoxesHtml = '';
		foreach ($locations as $region => $regionData) {
			foreach ($regionData as $country => $countryData) {
				$sort = array();
				foreach($countryData as $k=>$v) {
					$sort['location'][$k] = $v['location']->post_title;
				}
				array_multisort($sort['location'], SORT_ASC, $countryData);

				foreach ($countryData as $locationKey => $locationValue) {

					$countryBoxesHtml .= '<div class="box-info-inner" id="'. esc_attr( str_replace(array(".", ","), "", $locationValue['latitude'].$locationValue['longitude']) ) . '">';

					if ( ! empty( $locationValue['picture'] ) ) {
						$countryBoxesHtml .= '<div class="box-image-wrapper">' . $locationValue['picture'] . '</div>';
					}

					$countryBoxesHtml .= '<h5 class="location-name">' . esc_html( $locationValue['location']->post_title ) . '</h5><p class="location-address">' . wp_kses( html_entity_decode($locationValue['address']), array('br' => array()) ) . '</p>';


					if( ($locationValue['phone1'] !== '') || ($locationValue['phone2'] !== '') || ($locationValue['latitude'] !== '' && $locationValue['longitude'] !== '') ) {
						$countryBoxesHtml .= '<div class="contactNumberWrapper">';

						if( $locationValue['phone1'] !== '' ) {
							$countryBoxesHtml .= '<p><a class="link-icon" href="tel:' . esc_attr( $locationValue['phone1'] ) . '"><span class="locationContactNumber"><i class="icon-phone2" aria-hidden="true"></i> <span><span class="location-phone">' . esc_html( $locationValue['phone1'] ) . '</span></span></span></a></p>';
						}

						if( $locationValue['phone2'] !== '' ) {
							$countryBoxesHtml .= '<p><a class="link-icon" href="tel:' . esc_attr( $locationValue['phone2'] ) . '"><span class="locationContactNumber"><i class="icon-phone2" aria-hidden="true"></i> <span><span class="location-phone">' . esc_html( $locationValue['phone2'] ) . '</span></span></span></a></p>';
						}

						if( $locationValue['latitude'] !== '' && $locationValue['longitude'] !== '' ) {
							$countryBoxesHtml .= '<p><a class="link-icon" target="_blank" href="https://maps.google.com?saddr=Current+Location&daddr=' . esc_attr( $locationValue['latitude'] ) . ',' . esc_attr( $locationValue['longitude'] ) . '"><i class="cg-icon cg-icon__direction"></i> <span><span>' . esc_html__( 'Directions', 'cg-archive-shortcode' ) . '</span></span></a></p>';
						}

						$countryBoxesHtml .= '</div>';
					}

					$countryBoxesHtml .= '</div>';
				}
			}
		}

		$regionFiltersHtml = '';
		foreach ($locations as $region => $regionData) {
			$regionFiltersHtml .= '<li data-filter="' . esc_attr( $region ) . '"><a href="#" class="filters-nav-anchor" onclick="$(\'#all_countries_expanders\').hide();$(\'#country_wise_expanders\').show();">' . esc_html__( $regionMap[$region], 'cg-archive-shortcode' ) . '</a></li>';
		}

		$countryExpanderHtml = '';
		foreach ($allCountries as $country => $countryData) {
			$sort = array();
			foreach($countryData as $k=>$v) {
				$sort['location'][$k] = $v['location']->post_title;
			}
			array_multisort($sort['location'], SORT_ASC, $countryData);

			$countryExpanderHtml .= '<div class="expander-box filter-box tag-active" data-filter="' . esc_attr( $region ) . '" style=""><div class="expander-title" tabindex="0" role="button" aria-expanded="false" aria-pressed="false">' . esc_html__( $countryMap[$country], 'cg-archive-shortcode' ) . '</div><div class="expander-content"><div class="row">';

			foreach ($countryData as $locationKey => $locationValue) {
				$countryExpanderHtml .= '<div class="col-md-4"><div class="box"><span class="box-title">' . esc_html( $locationValue['location']->post_title ) . '</span><p class="location-address">' . wp_kses( html_entity_decode($locationValue['address']), array('br' => array()) ) . '</p>';

				if( ($locationValue['phone1'] !== '') || ($locationValue['phone2'] !== '') ) {
					$countryExpanderHtml .= '<div class="contactNumberWrapper">';

					if( $locationValue['phone1'] !== '' ) {
						$countryExpanderHtml .= '<span class="locationContactNumber"><i class="icon-phone2" aria-hidden="true"></i> ' . esc_html( $locationValue['phone1'] ) . '</span>';
					}

					if( $locationValue['phone2'] !== '' ) {
						$countryExpanderHtml .= '<span class="locationContactNumber"><i class="icon-phone2" aria-hidden="true"></i> ' . esc_html( $locationValue['phone2'] ) . '</span>';
					}

					$countryExpanderHtml .= '</div>';
				}

				if( $locationValue['latitude'] !== '' && $locationValue['longitude'] !== '' ) {
					$countryExpanderHtml .= '<!--<a class="link map-show-button" href="#" onclick="seeOnMap(\'' . esc_attr( str_replace( array(","), "", $locationValue['latitude'].'#'.$locationValue['longitude'] ) ) . '\');">' . esc_html__( 'See on map', 'cg-archive-shortcode' ) . '</a>-->';
				}

				$countryExpanderHtml .= '</div></div>';
			}

			$countryExpanderHtml .= '</div></div></div>';
		}

		$countrywiseExpanderHtml = '';
		foreach ($locations as $region => $regionData) {
			$sort = array();
			foreach($regionData as $k=>$v) {
				$sort['country'][$k] = $countryMap[$k];
			}
			array_multisort($sort['country'], SORT_ASC, $regionData);

			foreach ($regionData as $country => $countryData) {
				$sort = array();
				foreach($countryData as $k=>$v) {
					$sort['location'][$k] = $v['location']->post_title;
				}
				array_multisort($sort['location'], SORT_ASC, $countryData);

				$countrywiseExpanderHtml .= '<div class="expander-box filter-box tag-active" data-filter="' . esc_attr( $region ) . '" style=""><div class="expander-title" tabindex="0" role="button" aria-expanded="false" aria-pressed="false">' . esc_html__( $countryMap[$country], 'cg-archive-shortcode' ) . '</div><div class="expander-content"><div class="row">';

				foreach ($countryData as $locationKey => $locationValue) {
					$countrywiseExpanderHtml .= '<div class="col-sm-12 col-md-4"><div class="box"><span class="box-title">' . esc_html( $locationValue['location']->post_title ) . '</span> <p class="location-address">' . wp_kses( html_entity_decode($locationValue['address']), array('br' => array()) ) . '</p>';

					if( ($locationValue['phone1'] !== '') || ($locationValue['phone2'] !== '') ) {
						$countrywiseExpanderHtml .= '<div class="contactNumberWrapper">';

						if( $locationValue['phone1'] !== '' ) {
							$countrywiseExpanderHtml .= '<span class="locationContactNumber"><i class="icon-phone2" aria-hidden="true"></i> ' . esc_html( $locationValue['phone1'] ) . '</span>';
						}

						if( $locationValue['phone2'] !== '' ) {
							$countrywiseExpanderHtml .= '<span class="locationContactNumber"><i class="icon-phone2" aria-hidden="true"></i> ' . esc_html( $locationValue['phone2'] ) . '</span>';
						}

						$countrywiseExpanderHtml .= '</div>';
					}

					if( $locationValue['latitude'] !== '' && $locationValue['longitude'] !== '' ) {
						$countrywiseExpanderHtml .= '<!--<a class="link map-show-button" href="#" onclick="seeOnMap(\'' . esc_attr( str_replace( array(","), "", $locationValue['latitude'].'#'.$locationValue['longitude'] ) ) . '\');"><div class="linkWrapper"><span>' . esc_html__( 'See on map', 'cg-archive-shortcode' ) . '</span></div></a>-->';
					}

					$countrywiseExpanderHtml .= '</div></div>';
				}

				$countrywiseExpanderHtml .= '</div></div></div>';
			}
		}

		$scriptsMarkup = '<script type="text/javascript">
	    function myMap() {
	      var countryMarkers = [];
	      if ( countryLocations.length > 0 ) {
	        countryMarkers = countryLocations.map((location, i) => {
	          let marker = new google.maps.Marker({
	            position: location,
	  					icon: "/wp-content/themes/capgemini2020/assets/images/map/m2.png"
	          });
              marker.addListener("click", (e) => {
                  //console.log("clicked in country marker",e);
              });

	  				return marker;
	        });
	      }

	      /*
	      //  Logic for adaptive map rendering
	      //  A] Country site: Map will be centered to the portion of the country in a way that all locations will
	      //        be visible where Capgemini offices are listed for that country. User\'s location does not matter.
	      //  B] Global site:
	      //    1. When user is from the country where Capgemini offices are present: Map will be centered to the
	      //        portion of the country in a way that all locations will be visible where Capgemini offices are
	      //        listed for that country
	      //    2. When user is from the country where Capgemini offices are not present: Map will be centered to
	      //        Paris, France which is the head office of Capgemini
	      */

	        var myLatLng = new google.maps.LatLng(' . esc_attr($headOfficeLatLongStr) . ');
	        var mapProp= {
	        center:myLatLng,
	        zoom:15,
					disableDefaultUI: true,
	      };
	      map = new google.maps.Map(document.getElementById("map"),mapProp);

	      if ( countryMarkers.length > 0 ) {
	        var landingBounds = new google.maps.LatLngBounds();
	        for( i=0; i < countryMarkers.length; i++ ) {
	           landingBounds.extend(countryMarkers[i].getPosition());
	        }

	        map.setCenter(landingBounds.getCenter());

	        map.fitBounds(landingBounds);
	      }

				initZoomControl(map);

	      markers = locations.map((location, i) => {
	        let marker = new google.maps.Marker({
	          position: location,
			  icon: "/wp-content/themes/capgemini2020/assets/images/map/m2.png",
			  optimized: false,
	        });

	        marker.addListener("click", (e) => {
              //  console.log("clicked from marker",e);
                openMapBox();
		        var pos = marker.position.toString().replace(/[(), .]/g,"");
		        showLocation(pos);
						$("#pac-input").val("");
						toggleSearchButton();
						marker.setIcon("/wp-content/themes/capgemini2020/assets/images/map/m3.png");
            });


//					google.maps.event.addListener(marker, "click", function (c) {
//		        openMapBox();
//		        var pos = marker.position.toString().replace(/[(), .]/g,"");
//		        showLocation(pos);
//						$("#pac-input").val("");
//						toggleSearchButton();
//						marker.setIcon("/wp-content/themes/capgemini2020/assets/images/map/m3.png");
//		      });

					return marker;
	      });
	      // Add a marker clusterer to manage the markers.
//	      var markerCluster = new markerClusterer.MarkerClusterer(map, markers, {
//	        imagePath:
//	          "/wp-content/themes/capgemini2020/assets/images/map/m",
//						styles: [{
//							fontFamily:"Ubuntu, sans-serif;",
//							height: 62,
//							url: "/wp-content/themes/capgemini2020/assets/images/map/m1.png",
//							width: 54
//						}],
//					clusterClass:"map-point",
//	      });


        const clusterRenderer = ({ count, position }, stats) => {
            return new google.maps.Marker(
            {
                position: position,
                icon: {
                  url: `/wp-content/themes/capgemini2020/assets/images/map/m1.png`
                },
               label: {
                    text: String(count),
                    color: "rgba(255,255,255,0.9)",
                    fontSize: "24px",
                },
            });
         };


	      var markerCluster = new markerClusterer.MarkerClusterer({ markers, map, renderer: {
	        render: (clusters, stats) => {return clusterRenderer(clusters, stats)}
	      }});

		google.maps.event.addListener(markerCluster, "click", function (c) {
		   // console.log("clicked marker", c);
	        openMapBox();
//	        var m = c.getMarkers();
	        var m = c.markers;
	        for (var i = 0; i < m.length; i++) {
						var pos = m[i].getPosition().toString().replace(/[(), .]/g,"");
	          showLocation(pos);
						$("#pac-input").val("");
						toggleSearchButton();
	        }
	      });

//		  google.maps.event.addDomListener(markerCluster, "keydown", function (c) {
//
//            console.log("c", c);
//
//			if(c.code === "Enter" || c.keyCode === 13) {
//				openMapBox();
//				var m = c.getMarkers();
//				for (var i = 0; i < m.length; i++) {
//							var pos = m[i].getPosition().toString().replace(/[(), .]/g,"");
//				  showLocation(pos);
//							$("#pac-input").val("");
//							toggleSearchButton();
//				}
//			}
//
//	      });


		  const input = document.getElementById( "pac-input" );

		  const locationSearchResults = document.getElementById( "box_location_search" );

		  let service = new google.maps.places.PlacesService( map );

		  let oldMarkers = [];

		  const icon = {
              url: "",
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25),
            };

		  input.addEventListener( "keyup", () => {

		    if ( "" !== input.value ) {

		      var request = {
			    query: input.value,
		        fields: [ "name", "geometry" ]
		      };

			  // service.findPlaceFromQuery( request, function( places, status ) {
			  service.textSearch( request, function( places, status ) {

			    closeMapBox();
			    locationSearchResults.innerHTML = "";

			    if ( status === google.maps.places.PlacesServiceStatus.OK ) {

			      if ( 0 === places.length ) {
		            return;
		          }

		          places = places.slice(0, 5);

		          // Clear out the old markers.
		          oldMarkers.forEach((marker) => {
		            marker.setMap(null);
		          });

		          oldMarkers = [];

		          places.forEach((place, index) => {

		            if ( ! place.geometry ) {
		              //console.log("Returned place contains no geometry");
		              return;
		            }

		            let searchItem = document.createElement( "p" );

		            searchItem.innerHTML = place.name;

		            searchItem.setAttribute( "data-place", index );

		            locationSearchResults.appendChild( searchItem );

		            // Create a marker for each place.
//		            markers.push(
//		              new google.maps.Marker({
//		                map,
//		                icon,
//		                title: place.name,
//		                position: place.geometry.location,
//		              })
//		            );
//
//		            if (place.geometry.viewport) {
//		              bounds.union(place.geometry.viewport);
//		            } else {
//		              bounds.extend(place.geometry.location);
//		            }
		          });
//		          map.fitBounds(bounds);
			    }
			  });

			}

		  } );

		  const pacSubmit = document.getElementById( "pac-submit" );

		  pacSubmit.addEventListener( "click", () => {

				if ( "" !== input.value ) {

			      var request = {
				    query: input.value,
			        fields: [ "name", "geometry" ]
			      };

				  service.findPlaceFromQuery( request, function( places, status ) {
				  // service.textSearch( request, function( places, status ) {

				    closeMapBox();
				    locationSearchResults.innerHTML = "";

				    if ( status === google.maps.places.PlacesServiceStatus.OK ) {

				      if ( 0 === places.length ) {
			            return;
			          }

			          places = places.slice(0, 5);

			          // Clear out the old markers.
			          oldMarkers.forEach((marker) => {
			            marker.setMap(null);
			          });

			          oldMarkers = [];

			          // For each place, get the icon, name and location.
                      const bounds = new google.maps.LatLngBounds();

			          places.forEach((place, index) => {

			            if ( ! place.geometry ) {
			            //  console.log("Returned place contains no geometry");
			              return;
			            }

			            // Create a marker for each place.
			            markers.push(
			              new google.maps.Marker({
			                map,
			                icon,
			                title: place.name,
			                position: place.geometry.location,
			              })
			            );

			            if (place.geometry.viewport) {
			              bounds.union(place.geometry.viewport);
			            } else {
			              bounds.extend(place.geometry.location);
			            }
			          });
			          map.fitBounds(bounds);
				    }
				  });

				}

			} );

//	      const searchBox = new google.maps.places.SearchBox(input);
//
//	      map.addListener("bounds_changed", () => {
//	        searchBox.setBounds(map.getBounds());
//	      });
//
////				let oldMarkers = [];
//				searchBox.addListener("places_changed", () => {
//						closeMapBox();
//	          const places = searchBox.getPlaces();
//
//	          if (places.length == 0) {
//	            return;
//	          }
//	          // Clear out the old markers.
//	          oldMarkers.forEach((marker) => {
//	            marker.setMap(null);
//	          });
//	          oldMarkers = [];
//
//	          console.log( places );
//
//	          const bounds = new google.maps.LatLngBounds();
//	          places.forEach((place) => {
//	            if (!place.geometry) {
//	              console.log("Returned place contains no geometry");
//	              return;
//	            }
//
//	            const icon = {
//	              url: "",
//	              size: new google.maps.Size(71, 71),
//	              origin: new google.maps.Point(0, 0),
//	              anchor: new google.maps.Point(17, 34),
//	              scaledSize: new google.maps.Size(25, 25),
//	            };
//	            // Create a marker for each place.
//	            markers.push(
//	              new google.maps.Marker({
//	                map,
//	                icon,
//	                title: place.name,
//	                position: place.geometry.location,
//	              })
//	            );
//
//	            if (place.geometry.viewport) {
//	              bounds.union(place.geometry.viewport);
//	            } else {
//	              bounds.extend(place.geometry.location);
//	            }
//	          });
//	          map.fitBounds(bounds);
//	        });

	    }

	    const locations = [
	      ' . esc_attr( $latLongStr ) . '
	    ];

	    const countryLocations = [
	      ' . esc_attr( $countryLatLongStr ) . '
	    ];

			var map;
			var markers;


			function initZoomControl(map) {
	      document.querySelector(".zoom-control-in").onclick = function () {
	        map.setZoom(map.getZoom() + 1);
	      };

	      document.querySelector(".zoom-control-out").onclick = function () {
	        map.setZoom(map.getZoom() - 1);
	      };
	      map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(
	        document.querySelector(".zoom-control")
	      );
	    }

			function openMapBox() {
				$( "#box_location_search" ).empty();
				var mapBox = $(".map-box");
			  mapBox.addClass("active");
			  mapBox.find(".box-info").slideDown();
			  mapBox.find(".box-title").slideUp();
				$(".box-info-inner").hide();
			}

			function openSelectedMapBox() {
				var mapBox = $( ".map-box" );
				mapBox.addClass("active");
				mapBox.find(".box-info").slideDown();
				mapBox.find(".box-title").slideUp();
			}

			function closeMapBox() {
				$( "#box_location_search" ).empty();
				var mapBox = $(".map-box");
			    mapBox.removeClass("active");
			    mapBox.find(".box-info").slideUp();
			    mapBox.find(".box-title").slideDown();
				$(".box-info-inner").hide();
			}

			function showLocation(id) {
			  var offset = $(".map-container").offset().top;
			  $("html, body").animate({
			    scrollTop: offset
			  }, 500);

			  let currentItem = $("#"+id);

			  if ( currentItem.length > 0 ) {

				  currentItem.fadeOut(function () {
				    currentItem.show();
				  });
			  }
			}

			function seeOnMap(id) {

				$( "#box_location_search" ).empty();
				$( ".box-image-wrapper" ).hide();

				if(id != "") {
					var positionSelected = "(" + id.replace("#", ", ") + ")";
					markers.map(function (marker) {
						if(marker.position == positionSelected) {
							var offset = $(".map-container").offset().top;
						  $("html, body").animate({
						    scrollTop: offset
						  }, 500);
							map.setZoom(14);
							map.setCenter(marker.position);
						}
					});

					id = id.toString().replace(/[(), .]/g,"");
					id = id.replace("#", "");

					closeMapBox();

					$( "#" + id ).children( ".box-image-wrapper" ).show();
				    $( "#" + id ).show();

					openSelectedMapBox();
				}
			}

			function toggleSearchButton() {
				if($("#pac-input").val() != "") {
					$("#location-search-btn").fadeOut();
				} else {
					$("#location-search-btn").fadeIn();
				}
			}
	  </script>

		<!--<script src="https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js"></script><script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC9qqtYUz0rdcVPJXL3w1abjKGTrbtvWp0&libraries=places&v=weekly&callback=myMap"></script>-->'; // phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript

		$locationData['locations'] = $locations;
		$locationData['allCountries'] = $allCountries;
		$locationData['headOffices'] = $headOffices;
		$locationData['latLongStr'] = $latLongStr;
		$locationData['countryLatLongStr'] = $countryLatLongStr;
		$locationData['headOfficeLatLongStr'] = $headOfficeLatLongStr;
		$locationData['regionMap'] = $regionMap;
		$locationData['countryMap'] = $countryMap;
		$locationData['countryBoxesHtml'] = $countryBoxesHtml;
		$locationData['regionFiltersHtml'] = $regionFiltersHtml;
		$locationData['countryExpanderHtml'] = $countryExpanderHtml;
		$locationData['countrywiseExpanderHtml'] = $countrywiseExpanderHtml;
		$locationData['scriptsMarkup'] = $scriptsMarkup;

		return $locationData;

	}

	public function buildArchive(ArchiveShortcodeFactory $factory) {
		$this->init();
		$archiveShortcodeTemplate = $factory->fetchArchiveShortcodeTemplate();

		return $archiveShortcodeTemplate->buildArchiveShortcodePage($this);
	}
}
