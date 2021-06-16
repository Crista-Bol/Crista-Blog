<?php
    function university_post_types(){

            // Event type
            register_post_type('event', array(
                'capability_type'=>'event',
                'map_meta_cap'=> 'true',
                'show_in_rest'=> true,
                'supports'=> array('title','editor','excerpt'),
                'rewrite' => array('slug' => 'events'),
                'has_archive'=>true,
                'public'=>true,
                'labels'=> array(
                    'name'=>'Events',
                    'add_new_item'=>'Add New Event',
                    'edit_item'=>'Edit Event',
                    'all_items'=>'All Events',
                    'singular_item'=> 'Event'

                ),
                'menu_icon' => 'dashicons-calendar-alt'
            ));

            // program type
            register_post_type('program', array(
                'show_in_rest'=> true,
                'supports'=> array('title','editor'),
                'rewrite' => array('slug' => 'programs'),
                'has_archive'=>true,
                'public'=>true,
                'labels'=> array(
                    'name'=>'Programs',
                    'add_new_item'=>'Add New Program',
                    'edit_item'=>'Edit Program',
                    'all_items'=>'All Programs',
                    'singular_item'=> 'Program'

                ),
                'menu_icon' => 'dashicons-awards'
            ));

            // professor type
            register_post_type('professor', array(
                'show_in_rest'=>true,
                'supports'=> array('title','editor','thumbnail'),
                'public'=>true,
                'labels'=> array(
                    'name'=>'Professor',
                    'add_new_item'=>'Add New Professor',
                    'edit_item'=>'Edit Professor',
                    'all_items'=>'All Professors',
                    'singular_item'=> 'Professor'

                ),
                'menu_icon' => 'dashicons-welcome-learn-more'
            ));

            // campus type
            register_post_type('campus', array(
                'capability_type'=> 'campus',
                'map_meta_cap'=>true,
                'show_in_rest'=> true,
                'supports'=> array('title','editor','excerpt'),
                'rewrite' => array('slug' => 'campuses'),
                'has_archive'=>true,
                'public'=>true,
                'labels'=> array(
                    'name'=>'Campus',
                    'add_new_item'=>'Add New Campus',
                    'edit_item'=>'Edit Campus',
                    'all_items'=>'All Campuses',
                    'singular_item'=> 'Campus'

                ),
                'menu_icon' => 'dashicons-location-alt'
            ));

            // notes type
            register_post_type('note', array(
                'capability_type'=> 'note',
                'map_meta_cap'=> true,
                'show_in_rest'=> true,
                'supports'=> array('title','editor'),
                'public'=>false,
                'show_ui'=> true,
                'labels'=> array(
                    'name'=>'Notes',
                    'add_new_item'=>'Add New Note',
                    'edit_item'=>'Edit Note',
                    'all_items'=>'All Notes',
                    'singular_item'=> 'Note'

                ),
                'menu_icon' => 'dashicons-edit-page'
            ));
       }  
        
        add_action('init', 'university_post_types');
?>