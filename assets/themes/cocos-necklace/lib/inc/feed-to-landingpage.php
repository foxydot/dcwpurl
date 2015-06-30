<?php
add_shortcode('feed','msdlab_feed_to_landingpage');
function jig_add_force_rss($feed,$url){
    $feed->enable_order_by_date(false);
}
    function msdlab_feed_to_landingpage($atts){
        extract( shortcode_atts( array(
            'url' => 'http://www.datacenterknowledge.com/?feed=dcw',
        ), $atts ) );
        
        // Get RSS Feed(s)
        include_once( ABSPATH . WPINC . '/feed.php' );
        add_filter( 'wp_feed_cache_transient_lifetime', create_function( '$a','return 14400;' ) ); //4 hours
        
        // Get a SimplePie feed object from the specified feed source.
        add_action('wp_feed_options', 'jig_add_force_rss', 10,2);
        $rss = fetch_feed($url);
        remove_action('wp_feed_options','jig_add_force_rss', 10);

        $maxitems = FALSE;

        if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly
        
            // Figure out how many total items there are, but limit it to 5. 
            $maxitems = $rss->get_item_quantity( 5 ); 
        
            // Build an array of all the items, starting with element 0 (first element).
            $rss_items = $rss->get_items( 0, $maxitems );
        
        endif;
        $i = 0;
        if ( !$maxitems ) : 
            return;
        else : 
            foreach ( $rss_items as $item ) : 
                $i++;
                //ts_data($item);
                //ts_data($item->get_item_tags('http://search.yahoo.com/mrss/','meta_inet_share_counts'));
                $image_object = $item->get_item_tags('http://search.yahoo.com/mrss/','content');
                $image = '<img width="" height="" class="alignnone size-full" alt="" src="'.$image_object[0]['data'].'">';
                $title = '<h3>'.esc_html( $item->get_title() ).'</h3>';
                $content = esc_html( $item->get_content() );
                $link = esc_url( $item->get_permalink() );
                $date = $item->get_date('M j, Y');
                $author_object = $item->get_author();
                $author = '<span class="author-name">'.$author_object->get_email().'</span>';
                $share_object = $item->get_item_tags('http://search.yahoo.com/mrss/','meta_inet_share_counts');
                $share_data = unserialize($share_object[0]['data']);
                //ts_data($share_data);
                $content_column = '<div class="col-md-6 col-sm-12">
                    '.$title.'
                    <div class="meta-info">
                        <i class="fa fa-star"></i> featured / by '. $author .' / <i class="fa fa-clock-o"></i> '.$date.'</div>
                        '.$content.'
                        <div class="row">
                            <div class="button-wrapper">
                                <a target="_blank" href="'.$link.'" class="button">Learn More</a>
                        </div>
                        <ul class="social-media">
                            <li><i class="fa fa-facebook fa-2x"></i> '.$share_data['stats']['facebook'].'</li>
                            <li><i class="fa fa-twitter fa-2x"></i> '.$share_data['stats']['twitter'].'</li>
                        </ul>
                    </div>
                </div>';
                $image_column = '<div class="col-md-6 col-sm-12">
                    '.$image.'
                </div>';
                if($i%2==0){
                    $ret[] = '<div class="wrap row">'.$content_column.$image_column.'</div>';
                } else {
                    $ret[] = '<div class="wrap row">'.$image_column.$content_column.'</div>';
                }
            endforeach;
        endif; 
        
        $ret = implode('',$ret);
        return $ret;
    }
