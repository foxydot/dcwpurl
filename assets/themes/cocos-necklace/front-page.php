<?php
/*
Template Name: Front Page
*/
//remove_all_actions('genesis_loop');
//remove sidebars (jsut in case)
//remove_all_actions('genesis_sidebar');
//remove_all_actions('genesis_sidebar_alt');
remove_action('genesis_entry_header', 'genesis_do_post_title');

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

function msdlab_landingpage_tabs(){
    global $allowedposttags,$landingpage_metabox;
    $landingpage_metabox->the_meta();
    $nav_tabs = $tab_content = array();
    $i=1;
    $allowedposttags['script'] = array('id'=>true,'src'=>true,'type'=>true);

    $allowedposttags['hidden'] = array('id'=>true,'name'=>true,'value'=>true,'class'=>true);
    $allowedposttags['select'] = array('id'=>true,'name'=>true,'value'=>true,'class'=>true,'selected'=>true);
    $allowedposttags['option'] = array('id'=>true,'name'=>true,'value'=>true,'class'=>true);
    $allowedposttags['input'] = array('id'=>true,'name'=>true,'value'=>true,'class'=>true);
    $allowedposttags['submit'] = array('id'=>true,'name'=>true,'value'=>true,'class'=>true);
    $allowedposttags['button'] = array('id'=>true,'name'=>true,'value'=>true,'class'=>true);
    $nav_tabs = $tab_content = array();
    $i=0;
    remove_filter('the_content','wpautop',10);
    while($landingpage_metabox->have_fields('sections')):
        $tab_content[$i] = '
        <div class="section '.$landingpage_metabox->get_the_value('class').'" id="'.sanitize_title(wp_strip_all_tags($landingpage_metabox->get_the_value('title'))).'">
        <div class="wrap">
        <h2 class="section-title">'.apply_filters('the_title',$landingpage_metabox->get_the_value('title')).'</h2>'
        .apply_filters('the_content',$landingpage_metabox->get_the_value('content'))
        .'</div>
        </div>';
        $i++;
    endwhile; //end loop
    add_filter('the_content','wpautop',10);
    //global $wp_filter;
    //ts_var( $wp_filter['the_content'] );
    print '<!-- Tab panes -->
        <div class="section-content">
        '.implode("\n", $tab_content).'
        </div>
        '; 
}
add_action('genesis_entry_content','msdlab_landingpage_tabs',30);

genesis();