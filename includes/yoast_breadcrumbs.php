<?php
/*
Plugin Name:  Yoast Breadcrumbs
Plugin URI:   http://yoast.com/wordpress/breadcrumbs/
Description:  Outputs a fully customizable breadcrumb path.
Version:      0.8.4
Author:       Joost de Valk
Author URI:   http://yoast.com/

Copyright (C) 2008-2009, Joost de Valk
All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
Neither the name of Joost de Valk or Yoast nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.
THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/

function yoast_breadcrumb($home, $sep, $prefix = '', $suffix = '', $display = true) {
	global $wp_query, $post;
	
	$opt['prefix']				= __("You are here:",'wpct');
	$opt['archiveprefix'] 		= __("Archives for",'wpct');
	$opt['searchprefix'] 		= __("Search for",'wpct');
	
	function bold_or_not( $input ) {
		// return '<strong>'.$input.'</strong>';
		return $input;
	}
	// Copied and adapted from WP source
	function yoast_get_category_parents($id, $link = FALSE, $separator = '/', $nicename = FALSE){
		$chain = '';
		$parent = &get_category($id);
		if ( is_wp_error( $parent ) )
		   return $parent;

		if ( $nicename )
		   $name = $parent->slug;
		else
		   $name = $parent->cat_name;

		if ( $parent->parent && ($parent->parent != $parent->term_id) )
		   $chain .= get_category_parents($parent->parent, true, $separator, $nicename);

		$chain .= bold_or_not($name);
		return $chain;
	}
	
	$on_front = get_option('show_on_front');
	
	if ($on_front == "page") {
		$homelink = '<a href="'.get_permalink(get_option('page_on_front')).'">'.$home.'</a>';
		$bloglink = $homelink.' '.$sep.' <a href="'.get_permalink(get_option('page_for_posts')).'">'.get_the_title(get_option('page_for_posts')).'</a>';
	} else {
		$homelink = '<a href="'.get_bloginfo('url').'">'.$home.'</a>';
		$bloglink = $homelink;
	}
		
	if ( ($on_front == "page" && is_front_page()) || ($on_front == "posts" && is_home()) ) {
		$output = $home;
	} elseif ( $on_front == "page" && is_home() ) {
		$output = $homelink.' '.$sep.' '.get_the_title(get_option('page_for_posts'));
	} elseif ( !is_page() ) {
		$output = $bloglink.' '.$sep.' ';
		if (is_single()) {
			$cats = get_the_category();
			$cat = $cats[0];
			if ($cat->parent != 0) {
				$output .= get_category_parents($cat->term_id, true, " ".$sep." ");
			} else {
				$output .= '<a href="'.get_category_link($cat->term_id).'">'.$cat->name.'</a> '.$sep.' '; 
			}
		}
		if ( is_category() ) {
			$cat = intval( get_query_var('cat') );
			$output .= yoast_get_category_parents($cat, false, " ".$sep." ");
		} elseif ( is_tag() ) {
			$output .= bold_or_not($opt['archiveprefix']." ".single_cat_title('',false));
		} elseif (is_date()) { 
			$output .= bold_or_not($opt['archiveprefix']." ".single_month_title(' ',false));
		} elseif (is_author()) { 
			$user = get_userdatabylogin($wp_query->query_vars['author_name']);
			$output .= bold_or_not($opt['archiveprefix']." ".$user->display_name);
		} elseif (is_search()) {
			$output .= bold_or_not($opt['searchprefix'].' "'.get_search_query().'"');
		} else {
			$output .= bold_or_not(get_the_title());
		}
	} else {
		$post = $wp_query->get_queried_object();

		// If this is a top level Page, it's simple to output the breadcrumb
		if ( 0 == $post->post_parent ) {
			$output = $homelink." ".$sep." ".bold_or_not(get_the_title());
		} else {
			if (isset($post->ancestors)) {
				if (is_array($post->ancestors))
					$ancestors = array_values($post->ancestors);
				else 
					$ancestors = array($post->ancestors);				
			} else {
				$ancestors = array($post->post_parent);
			}

			// Reverse the order so it's oldest to newest
			$ancestors = array_reverse($ancestors);

			// Add the current Page to the ancestors list (as we need it's title too)
			$ancestors[] = $post->ID;

			$links = array();			
			foreach ( $ancestors as $ancestor ) {
				$tmp  = array();
				$tmp['title'] 	= strip_tags( get_the_title( $ancestor ) );
				$tmp['url'] 	= get_permalink($ancestor);
				$tmp['cur'] = false;
				if ($ancestor == $post->ID) {
					$tmp['cur'] = true;
				}
				$links[] = $tmp;
			}

			$output = $homelink;
			foreach ( $links as $link ) {
				$output .= ' '.$sep.' ';
				if (!$link['cur']) {
					$output .= '<a href="'.$link['url'].'">'.$link['title'].'</a>';
				} else {
					$output .= bold_or_not($link['title']);
				}
			}
		}
	}
	if ($opt['prefix'] != "") {
		$output = $opt['prefix']." ".$output;
	}
	if ($display) {
		echo $prefix.$output.$suffix;
	} else {
		return $prefix.$output.$suffix;
	}
}

?>