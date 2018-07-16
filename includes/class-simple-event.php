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
	private function create_event_post_type() {
	    register_post_type('events', 
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
	            'events_category',
	            'events_tag'
	        ) 
	    ));

	    register_taxonomy(
	        'events_category',
	        'events',
	        array(
	            'label'              => 'Categories',
	            'show_in_quick_edit' => true,
	            'show_admin_column'  => true,
	            'hierarchical'       => true,
	            'query_var'          => 'events-category',
				'rewrite' => [
					'hierarchical' => true,
					'slug' => 'events-category',
					'with_front' => true,
					'ep_mask' => EP_NONE,	
				]
	        )
	    );

    	register_taxonomy( 'events_tag', 'events', array(
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
			'query_var' => 'events-tag',
			'rewrite' => [
				'hierarchical' => true,
				'slug' => 'events-tag',
				'with_front' => true,
				'ep_mask' => EP_NONE,	
			],
			'public' => true,
			'show_ui' => true,
			'show_admin_column' => true			
			) 
    	);

	    register_taxonomy_for_object_type('events_category','events'); 
	    register_taxonomy_for_object_type('events_tag','events');
	}

	/**
	 * Flush rewrite rules
	 *
	 * @since 0.0.1
	 */
	public static function flush_rewrite_rules() {
		global $wp_rewrite;
		if ( $wp_rewrite ) $wp_rewrite->flush_rules();
	}

	/**
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

		add_action('init', [$this, 'wp_init'] );

		static::$instance = $this;
	}

	/**
	 * Initializing class properties
	 *
	 * @since 0.0.1
	 */
	public function init() {
		static::$instance = null;
	}

	/**
	 * 
	 * 
	 * @since 0.0.1
	 */
	public function wp_init() {
		$this->create_event_post_type();
	}

	/**
	 * 
	 *
	 * @since 0.0.1
	 */
	public static function activate_plugin() {
		static::flush_rewrite_rules();
	}

	/**
	 *
	 *
	 * @since 0.0.1
	 */
	public static function deactivate_plugin() {

	}

}