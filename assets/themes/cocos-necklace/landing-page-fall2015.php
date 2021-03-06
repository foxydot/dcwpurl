<?php
/*
Template Name: Fall 2015 Landing Page
*/
$lpc = "landing-page-fall2015";
remove_action('wp_enqueue_scripts', 'msdlab_add_styles');
add_action('wp_enqueue_scripts', 'orange_add_styles');


//remove_all_actions('genesis_loop');
//remove sidebars (jsut in case)
//remove_all_actions('genesis_sidebar');
//remove_all_actions('genesis_sidebar_alt');
remove_action('genesis_entry_header', 'genesis_do_post_title');
add_action('wp_enqueue_scripts','register_landingpage_scripts');

/**
 * hero + 3 widgets
 */
//add the hero
//add_action('genesis_after_header','msdlab_hero');
//add the callout
//add_action('genesis_after_header','msd_call_to_action');
//move footer and add three homepage widgets
remove_action('genesis_before_footer','genesis_footer_widget_areas');
add_action('genesis_before_footer','msdlab_homepage_widgets',-4);
add_action('genesis_before_footer','genesis_footer_widget_areas');
/**
 * long scrollie
 */
//remove_all_actions('genesis_loop');
//add_action('genesis_loop','msd_scrollie_page');

add_action('genesis_entry_content','msdlab_landingpage_tabs',30);

genesis();

function orange_add_styles() {
    global $is_IE, $lpc;
    if(!is_admin()){
        //use cdn        
            wp_enqueue_style('bootstrap-style','//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.no-icons.min.css');
            wp_enqueue_style('font-awesome-style','//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css',array('bootstrap-style'));
        //use local
           // wp_enqueue_style('bootstrap-style',get_stylesheet_directory_uri().'/lib/bootstrap/css/bootstrap.css');
           // wp_enqueue_style('font-awesome-style',get_stylesheet_directory_uri().'/lib/font-awesome/css/font-awesome.css',array('bootstrap-style'));
            $queue[] = 'bootstrap-style';
            $queue[] = 'font-awesome-style';
        wp_enqueue_style('msd-style',get_stylesheet_directory_uri().'/lib/'.$lpc.'/css/style.css',$queue);
        $queue[] = 'msd-style';
            wp_enqueue_style('msd-landingpage',get_stylesheet_directory_uri().'/lib/'.$lpc.'/css/landingpage.css',$queue);
            $queue[] = 'msd-landingpage';
        if($is_IE){
            wp_enqueue_style('ie-style',get_stylesheet_directory_uri().'/lib/'.$lpc.'/css/ie.css',$queue);
            $queue[] = 'ie-style';
            
            wp_enqueue_style('ie8-style',get_template_directory_uri() . '/lib/'.$lpc.'/css/ie8.css');
            global $wp_styles;
            $wp_styles->add_data( 'ie8-style', 'conditional', 'lte IE 8' );
        }    
    }
}