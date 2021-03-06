<?php
/*** Bootstrappin **/

add_filter( 'genesis_attr_site-inner', 'msdlab_bootstrap_site_inner', 10);
add_filter( 'genesis_attr_breadcrumb', 'msdlab_bootstrap_breadcrumb', 10);
add_filter( 'genesis_attr_content-sidebar-wrap', 'msdlab_bootstrap_content_sidebar_wrap', 10);
add_filter( 'genesis_attr_content', 'msdlab_bootstrap_content', 10);
add_filter( 'genesis_attr_sidebar-primary', 'msdlab_bootstrap_sidebar', 10);

 /*** Bootstrappin **/

function msdlab_bootstrap_site_inner( $attributes ){
    $attributes['class'] .= ' container';
    return $attributes;
}

function msdlab_bootstrap_breadcrumb( $attributes ){
    $attributes['class'] .= ' row';
    return $attributes;
}

function msdlab_bootstrap_content_sidebar_wrap( $attributes ){
    $attributes['class'] .= ' row';
    return $attributes;
}

function msdlab_bootstrap_content( $attributes ){
    $layout = genesis_site_layout();
    $template = get_page_template();
    switch($layout){
        case 'content-sidebar':
        case 'sidebar-content':
            $attributes['class'] .= ' col-md-8 col-sm-12';
            break;
        case 'content-sidebar-sidebar':
        case 'sidebar-sidebar-content':
        case 'sidebar-content-sidebar':
            break;
        case 'full-width-content':
            $attributes['class'] .= '';
            break;
    }
    return $attributes;
}

function msdlab_bootstrap_sidebar( $attributes ){
    $layout = genesis_site_layout();
    $template = get_page_template();
    switch($layout){
        case 'content-sidebar':
        case 'sidebar-content':
            $attributes['class'] .= ' col-md-4 hidden-sm hidden-xs';
            break;
        case 'content-sidebar-sidebar':
        case 'sidebar-sidebar-content':
        case 'sidebar-content-sidebar':
            break;
        case 'full-width-content':
            $attributes['class'] .= ' hidden';
            break;
    }
    return $attributes;
}