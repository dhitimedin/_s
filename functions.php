<?php
/**
 * _s functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package _s
 */

@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '100M');
@ini_set( 'max_execution_time', '300' );

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( '_s_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function _s_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on _s, use a find and replace
		 * to change '_s' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( '_s', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary Menu', '_s' ),
                                'menu-2' => esc_html__( 'Secondary Menu', '_s' ),
			)
		);
                
                //Add editor CSS to style the wordpress visual posts / page editors. Ours mainly
                //pulls in all the front end CSS
               // add_editor_style( 'css/editor-style.css' );
                
		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'_s_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 150,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', '_s_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function _s_content_width() {
	$GLOBALS['content_width'] = apply_filters( '_s_content_width', 640 );
}
add_action( 'after_setup_theme', '_s_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function _s_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', '_s' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', '_s' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title text-success"><strong>',
			'after_title'   => '</strong></h2>',
		)
	);
}
add_action( 'widgets_init', '_s_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function _s_scripts() {

        // Adding Bootstrap and fontawesome to the Theme
        wp_enqueue_style('bootstrap-style', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css');
        wp_enqueue_style('bootstrapicon-style', get_template_directory_uri() . '/icons/font/bootstrap-icons.css');
        wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/bootstrap/js/bootstrap.bundle.min.js', array('jquery'));
        // Adding Bootstrap to the Theme - End 
        
        //Enquing _s Theme base css, script, and data 
        wp_enqueue_style( '_s-style', get_stylesheet_uri(), array(), _S_VERSION );
        wp_style_add_data( '_s-style', 'rtl', 'replace' );
        wp_enqueue_script( '_s-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );        
        
        /*Enquing for Carousel Script*/
        //Check if we are viewing a page
        if(is_page(array(
                    'home', 'energy-service-franchise-model', 'enhanced-rural-revenue-franchise-e-rrf-program', 
                        'mini-grid-model', 'micro-enterprise-development', 'innovation', 'knowledge', 'media'
                    )))
        { 
            
            wp_enqueue_script( '_s-coverflow-carousel', get_template_directory_uri() . '/js/carousel.js', array(), _S_VERSION, true);
        }
                       

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', '_s_scripts' );

/**
 * Register Custom Navigation Walker
 */
/*function register_navwalker(){
	require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';
}
add_action( 'after_setup_theme', 'register_navwalker' );*/


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * All Slider Post Creation Initialized over here
 */

/**
 * Code for Bootstrap carousel 
 */
add_action('init', 'custom_bootstrap_slider');

/**
 * Register a Custom post type for.
 */
function custom_bootstrap_slider() {
    $labels = array(
        'name' => _x('Slider', 'post type general name'),
        'singular_name' => _x('Slide', 'post type singular name'),
        'menu_name' => _x('Slider Uploads', 'admin menu'),
        'name_admin_bar' => _x('Slide', 'add new on admin bar'),
        'add_new' => _x('Add New', 'Slide'),
        'add_new_item' => __('Name'),
        'new_item' => __('New Slide'),
        'edit_item' => __('Edit Slide'),
        'view_item' => __('View Slide'),
        'all_items' => __('All Slide'),
        'featured_image' => __('Featured Image', 'text_domain'),
        'search_items' => __('Search Slide'),
        'parent_item_colon' => __('Parent Slide:'),
        'not_found' => __('No Slide found.'),
        'not_found_in_trash' => __('No Slide found in Trash.'),
    );

    $args = array(
        'labels' => $labels,
        'menu_icon' => 'dashicons-format-gallery',
        'description' => __('Description.'),
        'public' => false,
        'publicly_queryable' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => true,
        'menu_position' => null,
        'exclude_from_search' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields')
    );

    register_post_type('slider', $args);
}


/**
 * Creating a Tab for the Team Pictures
 */
add_action('init', 'team_portfolio');

/**
 * Register a Custom post type for.
 */
function team_portfolio() {
    $labels = array(
        'name' => _x('Team-Portfolio', 'post type general name'),
        'singular_name' => _x('TeamPortfolio', 'post type singular name'),
        'menu_name' => _x('Team Porfolio', 'admin menu'),
        'name_admin_bar' => _x('Upload Team Profile', 'add new on admin bar'),
        'add_new' => _x('Add New', 'Function'),
        'add_new_item' => __('Name'),
        'new_item' => __('New Function'),
        'edit_item' => __('Edit Fucntion'),
        'view_item' => __('View Function'),
        'all_items' => __('All Functions'),
        'featured_image' => __('Featured Image', 'text_domain'),
        'search_items' => __('Search Function'),
        'parent_item_colon' => __('Parent Function:'),
        'not_found' => __('No Function found.'),
        'not_found_in_trash' => __('No Function found in Trash.'),
    );

    $args = array(
        'labels' => $labels,
        'menu_icon' => 'dashicons-format-image',
        'description' => __('Description.'),
        'public' => false,
        'publicly_queryable' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => true,
        'menu_position' => null,
        'exclude_from_search' => true,
        'supports' => array('title', 'editor', 'thumbnail')
    );

    register_post_type('team-portfolio', $args);
}

/**
 * Function to exclude certain categories from home.php (Blog Page)
 * @param type $query
 * @return type
 */
function exclude_category_home( $query ) {
    if ( $query->is_home ) {
        $cat1 = get_category_by_slug('events');
        $cat2 = get_category_by_slug('media');
        $cat3 = get_category_by_slug('newsletter');
        $query->set( 'cat', "-{$cat1->term_id}, -{$cat2->term_id}, -{$cat3->term_id}" );
    }
    return $query;
}
 
add_filter( 'pre_get_posts', 'exclude_category_home' );

/**
 * For Multiple featured images
 */

if ( class_exists('MultiPostThumbnails') ) {
    new MultiPostThumbnails(
        array(
            // Replace [YOUR THEME TEXT DOMAIN] below with the text domain of your theme (found in the theme's `style.css`).
            'label' => __( 'Secondary Image', '_s'),
            'id' => 'secondary-image',
            'post_type' => 'page'
        )
    );
}



/**
 * Register Custom Navigation Walker
 *
 * Introduced in version 1.1
 */
function register_navwalker(){

    if ( ! file_exists( get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php' ) ) {
        // File does not exist... return an error.
        return new WP_Error( 'class-wp-bootstrap-navwalker-missing', __( 'It appears the class-wp-bootstrap-navwalker.php file may be missing.', 'wp-bootstrap-navwalker' ) );
    } else {
        // File exists... require it.
        require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';
    }

}
add_action( 'after_setup_theme', 'register_navwalker' );

add_filter( 'nav_menu_link_attributes', 'prefix_bs5_dropdown_data_attribute', 20, 3 );
/**
 * Use namespaced data attribute for Bootstrap's dropdown toggles.
 *
 * @param array    $atts HTML attributes applied to the item's `<a>` element.
 * @param WP_Post  $item The current menu item.
 * @param stdClass $args An object of wp_nav_menu() arguments.
 * @return array
 */
function prefix_bs5_dropdown_data_attribute( $atts, $item, $args ) {
    if ( is_a( $args->walker, 'WP_Bootstrap_Navwalker' ) ) {
        if ( array_key_exists( 'data-toggle', $atts ) ) {
            unset( $atts['data-toggle'] );
            $atts['data-bs-toggle'] = 'dropdown';
        }
    }
    return $atts;
}


/**
* Added since 1.1 get search form in the navbar
*/

// add_filter('wp_list_pages','add_search_box', 10, 2);
add_filter('wp_nav_menu_items','add_search_box', 10, 2);
function add_search_box($items, $args) {
    if( $args->theme_location == 'menu-1' ) {
        ob_start();
        get_search_form();
        $searchform = ob_get_contents();
        ob_end_clean();

        $items .= '<li id="menu-item-search">' . $searchform . '</li>';

        return $items;
    }
    else {
        return $items;
    }
}

/**
 * For Google Tag Manager
 */

function add_gtm_to_head() {

    $google_head_script = <<<EOD

    <!-- Google Tag Manager -->

    <script>
        (
            function( w, d, s, l, i ) {
            w[l]=w[l]||[];
            w[l].push( { 'gtm.start':new Date().getTime(),event:'gtm.js' } );
            var f = d.getElementsByTagName( s )[0], j = d.createElement( s ), dl = l!='dataLayer'?'&l='+l:'';
            j.async=true;
            j.src= "https://www.googletagmanager.com/gtm.js?id="+i+dl;f.parentNode.insertBefore(j,f);
        })( window, document, 'script', 'dataLayer', 'GTM-WRH3HJJ' );
    </script>

    <!-- End Google Tag Manager -->

    EOD;

    echo $google_head_script;

}

add_action('wp_head', 'add_gtm_to_head');

function add_gtm_to_body( $classes ) {

    $block = <<<EOD

    <!-- Google Tag Manager (noscript) -->

    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WRH3HJJ"
                height="0" width="0" style="display:none; visibility:hidden;">
        </iframe>
    </noscript>

    <!-- End Google Tag Manager (noscript) -->

    EOD;

    $classes[] = '">' . $block . '<br style="display:none';

    return $classes;

}

add_filter( 'body_class', 'add_gtm_to_body', 10000 );

 /**
  * Google Verification Code
  */

function spi_google_verification_code() {
    if( ! ( is_home() || is_front_page() ) ) return;

    $google_head_script = <<<EOD

    <!-- Google Verification Code -->

    <meta name="google-site-verification" content="BcWl78fFNUdXMaBdARuCwklZciNPFJTJFPFoLgX22xQ" />

    <!-- End Google Verification Code -->

    EOD;

    echo $google_head_script;   

}
add_action( 'wp_head', 'spi_google_verification_code' );