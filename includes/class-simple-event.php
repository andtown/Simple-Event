<?php
/**
 * Simple Event Base Class
 *
 * @since 0.0.1
 */

class Simple_Event {

	/**
	 * @var object
	 *
	 * @since 0.0.1
	 */
	protected static $instance;

	/**
	 * Create Event post type
	 *
	 * @since 0.0.1
	 */
	public static function create_event_post_type() {
	    register_post_type('event', 
	        array(
	        'labels' => array(
	            'name' => __('Events', 'simple-event'),
	            'singular_name' => __('Events', 'simple-event'),
	            'add_new' => __('Add New', 'simple-event'),
	            'add_new_item' => __('Add New Event', 'simple-event'),
	            'edit' => __('Edit', 'simple-event'),
	            'edit_item' => __('Edit Event', 'simple-event'),
	            'new_item' => __('New Event', 'simple-event'),
	            'view' => __('View Event', 'simple-event'),
	            'view_item' => __('View Event', 'simple-event'),
	            'search_items' => __('Search Events', 'simple-event'),
	            'not_found' => __('No Event Posts found', 'simple-event'),
	            'not_found_in_trash' => __('No Event Posts found in Trash', 'simple-event')
	        ),
	        'public' => true,
	        'hierarchical' => true,
	        'has_archive' => true,
	        'show_ui' => true,
	        'publicly_queryable' => true,
	        'query_var' => true,
	        'rewrite' => true,
	        'supports' => array(
	        	'title',
	            'thumbnail'
	        ),
	        'can_export' => true,
	        'taxonomies' => array(
	            'event_category',
	            'event_tag'
	        ) 
	    ));

	    register_taxonomy(
	        'event_category',
	        'event',
	        array(
	            'label'              => 'Categories',
	            'show_in_quick_edit' => true,
	            'show_admin_column'  => true,
	            'hierarchical'       => true,
	            'query_var'          => 'event_category',
				'rewrite' => [
					'hierarchical' => true,
					'slug' => 'event-category',
					'with_front' => true,
					'ep_mask' => EP_NONE,	
				]
	        )
	    );

    	register_taxonomy( 'event_tag', 'event', array(
            'labels' => [
                'name' => _x( 'Tags', 'simple-event' ),
                'singular_name' => _x( 'Tag', 'simple-event' ),
                'search_items' =>  __( 'Search Tags' ),
                'popular_items' => __( 'Popular Tags' ),
                'all_items' => __( 'All Tags' ),
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => __( 'Edit Tag' ), 
                'update_item' => __( 'Update Tag' ),
                'add_new_item' => __( 'Add New Tag' ),
                'new_item_name' => __( 'New Tag Name' ),
                'separate_items_with_commas' => __( 'Separate tags with commas' ),
                'add_or_remove_items' => __( 'Add or remove tags' ),
                'choose_from_most_used' => __( 'Choose from the most used tags' ),
                'menu_name' => __( 'Tags' )
            ],	    		
		 	'hierarchical' => false,
			'query_var' => 'event_tag',
			'rewrite' => [
				'hierarchical' => true,
				'slug' => 'event-tag',
				'with_front' => true,
				'ep_mask' => EP_NONE,	
			],
			'public' => true,
			'show_ui' => true,
			'show_admin_column' => true			
			) 
    	);

	    register_taxonomy_for_object_type('event_category','event'); 
	    register_taxonomy_for_object_type('event_tag','event');

	}

	/**
	 *
	 *
	 * @since 0.0.1
	 */
	public function events_meta_box_description_callback() {
		global $post;
		$cord = get_post_meta($post->ID,'event_location_latitude_longitude',true);
		$date = get_post_meta($post->ID,'event_date',true);
		$url = get_post_meta($post->ID,'event_url',true);
		$addr = get_post_meta($post->ID,'event_location_address',true);
		wp_nonce_field( 'simple_event_nonce', 'simple_event_nonce' );
	?>
        <div class="field wrapper" style="margin-bottom: 12px; overflow: auto;">
            <div class="label" style="float: left; width: 25%; vertical-align: top">
                <label for="event_date">Date</label><p class="description"></p>
            </div>
            <div class="input" style="float: left; width: 75%; vertical-align: top">
                <input name="event_date" id="event_date" placeholder="" readonly autocomplete="off" value="<?=esc_attr($date)?>" class="large-text" type="text"><p class="description">Define the event date by selecting it from the jQuery DatePicker popup</p>
            </div>
        </div>
        <div class="field wrapper" style="margin-bottom: 12px; overflow: auto;">
            <div class="label" style="float: left; width: 25%; vertical-align: top">
                <label for="event_location">Location</label><p class="description"></p>
            </div>        
            <div class="input" style="float: left; width: 75%; vertical-align: top">
			    <div class="pac-card" id="pac-card">
			      <div>
			        <div id="title">
			          Autocomplete search
			        </div>
			        <div id="type-selector" class="pac-controls">
			          <input type="radio" name="type" id="changetype-all" checked="checked">
			          <label for="changetype-all">All</label>

			          <input type="radio" name="type" id="changetype-establishment">
			          <label for="changetype-establishment">Establishments</label>

			          <input type="radio" name="type" id="changetype-address">
			          <label for="changetype-address">Addresses</label>

			          <input type="radio" name="type" id="changetype-geocode">
			          <label for="changetype-geocode">Geocodes</label>
			        </div>
			        <div id="strict-bounds-selector" class="pac-controls">
			          <input type="checkbox" id="use-strict-bounds" value="">
			          <label for="use-strict-bounds">Strict Bounds</label>
			        </div>
			      </div>
			      <div id="pac-container">
			      	<input type="hidden" name="event_location_latitude_longitude" value="<?=$cord?$cord:'-7.7974565,110.37069700000006'?>">
			        <input id="pac-input" name="event_location_address" type="text" placeholder="Enter a location" value="<?=$addr?esc_attr($addr):'Yogyakarta City, Special Region of Yogyakarta, Indonesia'?>">
			      </div>
			    </div>
			    <div id="map"></div>
			    <div id="infowindow-content">
			      <img src="" width="16" height="16" id="place-icon">
			      <span id="place-name"  class="title"></span><br>
			      <span id="place-address"></span>
			    </div>
			    <p class="description">This field is integrated with Google places autocomplete and also the map </p>
			</div>
        </div>
        <div class="field wrapper" style="margin-bottom: 12px; overflow: auto;">
            <div class="label" style="float: left; width: 25%; vertical-align: top">
                <label for="event_url">URL</label><p class="description"></p>
            </div>
            <div class="input" style="float: left; width: 75%; vertical-align: top">
                <input name="event_url" id="event_url" placeholder="" value="<?=esc_url($url)?>" class="large-text" type="url"><p class="description">Please make sure you fill the url starting with http:// or https:// </p>
            </div>
        </div>                
	<?php        
	}

	/**
	 * Create custom metabox
	 *
	 * @since 0.0.1
	 */
	public function create_the_metabox() {
		add_meta_box( 'event-meta-box', 'Event Description', array($this,'events_meta_box_description_callback'), 'event', 'normal', 'high' );  
	}

	/**
	 * Flush rewrite rules
	 *
	 * @since 0.0.1
	 */
	public static function flush_rewrite_rules() {
		flush_rewrite_rules();
	}

	/**
	 *
	 *
	 * @since 0.0.1
	 *
	 * @return object 
	 */
	public static function get_instance() {
        if ( !static::$instance ) new static;
        return static::$instance;
	}

    /**
     * Class Constructor
     */
	public function __construct() {

		$this->init();
		add_action('init', [$this, 'wp_init'] );
		add_action('admin_init', [$this, 'wp_admin_init']);
		add_action('template_include', array($this, 'template_include'));

	}

	/**
	 * 
	 *
	 * Initializing class properties
	 *
	 * @since 0.0.1
	 */
	protected function init() {
		static::$instance = $this;
	}

	/**
	 * 
	 * 
	 * @since 0.0.1
	 */
	public function wp_init() {
		if ( !post_type_exists('event') ) 
			static::create_event_post_type();			
	}

	/**
	 * 
	 * 
	 * @since 0.0.1
	 */
	public function wp_admin_init() {

		global $pagenow, $hook_suffix, $typenow, $post;

		if ( isset( $_GET['post'] ) )
		 	$post_id = (int) $_GET['post'];
		elseif ( isset( $_POST['post_ID'] ) )
		 	$post_id = (int) $_POST['post_ID'];
		else
		 	$post_id = 0;		
		if ( !($typenow == 'event' && $pagenow != 'edit.php' || ($pagenow == 'post.php' && $post_id > 0 && ($post = get_post($post_id)) && $post->post_type == 'event') ) ) return;


	    add_action( 'add_meta_boxes', array($this,'create_the_metabox') );
	    add_action( 'admin_enqueue_scripts', array($this, 'admin_enqueue_scripts') );
	    add_action( 'admin_print_footer_scripts', array($this, 'admin_footer_js') );
	    add_action( 'admin_print_scripts', array($this, 'admin_header_js'), 2, 1 );
	    add_action( 'admin_print_styles', array($this, 'google_location_style') );

        add_action('save_post', array($this,'save_event')); 
        add_filter('pre_delete_post',array($this,'pre_delete_event'), 99, 3);	    
	}

	/**
	 * 
	 * 
	 * @since 0.0.1
	 */
	public function admin_enqueue_scripts( $hook ) {
		global $post;
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_script('google-maps-js', '//maps.googleapis.com/maps/api/js?key=AIzaSyDPv3PPTE1PHXMmPejCmiPSIAVCGaJqlIE&libraries=places&callback=initMap', [], null, true);
		wp_enqueue_style('jquery-ui-css','//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css',[],null);
		$loc = get_post_meta($post->ID,'event_location_latitude_longitude',true);
		if ( empty($loc) ) $loc = '-7.7974565, 110.37069700000006';
		wp_localize_script('google-maps-js','eventLocation',explode(',', $loc));		
	}

	/**
	 * 
	 * 
	 * @since 0.0.1
	 */
    public function template_include( $tmpl ) {
    	//TODO: provide plugin archive and its single template so it can be used to override the use of default theme templates
    	return $tmpl;
    }

	/**
	 * 
	 * 
	 * @since 0.0.1
	 */
    public function save_event( $post_id ) {

        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
        if( !isset( $_POST['simple_event_nonce'] ) || !wp_verify_nonce( $_POST['simple_event_nonce'], 'simple_event_nonce' ) ) return;
        if( !current_user_can( 'edit_post' ) ) return;

        $event_post = stripslashes_deep($_POST);

        update_post_meta( $post_id, 'event_location_latitude_longitude', $event_post['event_location_latitude_longitude'] );
        update_post_meta( $post_id, 'event_location_address', $event_post['event_location_address'] );
        update_post_meta( $post_id, 'event_date', $event_post['event_date'] );
        update_post_meta( $post_id, 'event_url', $event_post['event_url'] );
    }

	/**
	 * 
	 * 
	 * @since 0.0.1
	 */
    public function pre_delete_event($chk, $post, $force_delete) {
        if ( 'event' == $post->post_type ) {
            delete_post_meta( $post->ID, 'event_location_latitude_longitude');    
            delete_post_meta( $post->ID, 'event_location_address');  
            delete_post_meta( $post->ID, 'event_date');       
            delete_post_meta( $post->ID, 'event_url');                  
        }
        return $chk; // go with deletion
    }

	/**
	 * 
	 * 
	 * @since 0.0.1
	 */
	public function google_location_style() {
	?>
	<style type="text/css">
      div#event-meta-box #description {
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
      }

      div#event-meta-box #infowindow-content .title {
        font-weight: bold;
      }

      div#event-meta-box #infowindow-content {
        display: none;
      }

      div#event-meta-box #map #infowindow-content {
        display: inline;
      }

      div#event-meta-box .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

      div#event-meta-box #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      div#event-meta-box .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }

      div#event-meta-box .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      div#event-meta-box #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
      }

      div#event-meta-box #pac-input:focus {
        border-color: #4d90fe;
      }

      div#event-meta-box #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 25px;
        font-weight: 500;
        padding: 6px 12px;
      }
    </style>
	<?php
	}

	/**
	 *
	 *
	 * @since 0.0.1
	 */
	public function admin_header_js() {
	?>
	  <script type="text/javascript">
	  	/*
	  	 * JavaScript code courtesy of Google Maps
	  	 * https://developers.google.com/maps/documentation/javascript/examples/places-autocomplete
	  	 */
	      function initMap() {
	      	var mapDOM = document.getElementById('map');
	      	if ( mapDOM ) {
	      		mapDOM.style.width = '100%';
	      		mapDOM.style.height = '350px';
	      	}
	        var map = new google.maps.Map(document.getElementById('map'), { 
	          center: {lat: parseFloat(eventLocation[0]), lng: parseFloat(eventLocation[1])},
	          zoom: 13
	        });
	        var card = document.getElementById('pac-card');
	        var input = document.getElementById('pac-input');
	        var types = document.getElementById('type-selector');
	        var strictBounds = document.getElementById('strict-bounds-selector');

	        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

	        var autocomplete = new google.maps.places.Autocomplete(input);

	        // Bind the map's bounds (viewport) property to the autocomplete object,
	        // so that the autocomplete requests use the current map bounds for the
	        // bounds option in the request.
	        autocomplete.bindTo('bounds', map);

	        // Set the data fields to return when the user selects a place.
	        autocomplete.setFields(
	            ['address_components', 'geometry', 'icon', 'name']);

	        var infowindow = new google.maps.InfoWindow();
	        var infowindowContent = document.getElementById('infowindow-content');
	        infowindow.setContent(infowindowContent);
	        var marker = new google.maps.Marker({
	          map: map,
	          anchorPoint: new google.maps.Point(0, -29),
	          draggable:true
	        });

	        marker.setPosition({lat: parseFloat(eventLocation[0]), lng: parseFloat(eventLocation[1])});

		    google.maps.event.addListener(marker, "position_changed", function() {
		      document.getElementsByName('event_location_latitude_longitude')[0].value = marker.getPosition().lat().toString()+','+marker.getPosition().lng().toString();
		    });	        

	        autocomplete.addListener('place_changed', function() {
	          infowindow.close();
	          marker.setVisible(false);
	          var place = autocomplete.getPlace();
	          document.getElementsByName('event_location_latitude_longitude')[0].value = place.geometry.location.lat().toString()+','+place.geometry.location.lng().toString();
	          if (!place.geometry) {
	            // User entered the name of a Place that was not suggested and
	            // pressed the Enter key, or the Place Details request failed.
	            window.alert("No details available for input: '" + place.name + "'");
	            return;
	          }

	          // If the place has a geometry, then present it on a map.
	          if (place.geometry.viewport) {
	            map.fitBounds(place.geometry.viewport);
	          } else {
	            map.setCenter(place.geometry.location);
	            map.setZoom(17); 
	          }
	          marker.setPosition(place.geometry.location);
	          marker.setVisible(true);

	          var address = '';
	          if (place.address_components) {
	            address = [
	              (place.address_components[0] && place.address_components[0].short_name || ''),
	              (place.address_components[1] && place.address_components[1].short_name || ''),
	              (place.address_components[2] && place.address_components[2].short_name || '')
	            ].join(' ');
	          }

	          infowindowContent.children['place-icon'].src = place.icon;
	          infowindowContent.children['place-name'].textContent = place.name;
	          infowindowContent.children['place-address'].textContent = address;
	          infowindow.open(map, marker);
	        });

	        // Sets a listener on a radio button to change the filter type on Places
	        // Autocomplete.
	        function setupClickListener(id, types) {
	          var radioButton = document.getElementById(id);
	          radioButton.addEventListener('click', function() {
	            autocomplete.setTypes(types);
	          });
	        }

	        setupClickListener('changetype-all', []);
	        setupClickListener('changetype-address', ['address']);
	        setupClickListener('changetype-establishment', ['establishment']);
	        setupClickListener('changetype-geocode', ['geocode']);

	        document.getElementById('use-strict-bounds')
	            .addEventListener('click', function() {
	              console.log('Checkbox clicked! New state=' + this.checked);
	              autocomplete.setOptions({strictBounds: this.checked});
	            });
	      }		  
	  </script>    
	<?php
	}

	/**
	 * 
	 * 
	 * @since 0.0.1
	 */
	public function admin_footer_js( ) {
	?>
		<script type="text/javascript">
		  ( function($) {
		  	$(window).load(function() {
				$( "#event_date" ).datepicker();
		  	});		    
		  } )(jQuery);
		</script>
	<?php
	}	

	/**
	 * 
	 *
	 * @since 0.0.1
	 */
	public static function activate_plugin() {
		if ( !post_type_exists('event') ) 
			static::create_event_post_type();				
		static::flush_rewrite_rules();
	}

	/**
	 * 
	 *
	 * @since 0.0.1
	 */
	public static function deactivate_plugin() {
		static::flush_rewrite_rules();
	}

}