<?php

add_action('rest_api_init','university_register_search');


function university_register_search(){
    register_rest_route('university/v1','search',array(
        'methods'=> WP_REST_SERVER::READABLE,
        'callback' => 'universitySearchResult'
    ));
}

function universitySearchResult($data){

    $list=new WP_Query(array(
        'post_type'=> array('post','event','professor','program','page','campus'),
        's'=>sanitize_text_field($data['term'])
    ));

    $results=array(
        'general_info'=>array(),
        'event'=> array(),
        'professor'=>array(),
        'program'=>array(),
        'campus'=>array()
    );

    while($list->have_posts()){
        $list->the_post();

        if(get_post_type()=='post' OR get_post_type()=='page'){
            array_push($results['general_info'],array(
                'title'=>get_the_title(),
                'permalink'=>get_the_permalink(),
                'type'=>get_post_type(),
                'authorName'=>get_the_author()
            ));
        }
        if(get_post_type()=='event'){
            $eventDate=new DateTime(get_field('event_date'));
            $eventExcerpt=null;

            if(has_excerpt()){
                $eventExcerpt=get_the_excerpt();
            }else{
                $eventExcerpt=wp_trim_words(get_the_content(),18);
            } 

            array_push($results['event'],array(
                'title'=>get_the_title(),
                'permalink'=>get_the_permalink(),
                'month'=>$eventDate->format('M'),
                'day'=>$eventDate->format('d'),
                'eventExcerpt'=>$eventExcerpt
            ));
        }
        
        if(get_post_type()=='professor'){
            array_push($results['professor'],array(
                'title'=>get_the_title(),
                'permalink'=>get_the_permalink(),
                'image'=>get_the_post_thumbnail_url(0,'professorLandscape')
            ));
        }
        if(get_post_type()=='campus'){
            array_push($results['campus'],array(
                'title'=>get_the_title(),
                'permalink'=>get_the_permalink()
            ));
        }

        if(get_post_type()=='program'){

            $relatedCampuses=get_field("related_campus");

            if($relatedCampuses){
                foreach($relatedCampuses as $campus){
                    array_push($results['campus'],array(
                        'title'=> get_the_title($campus),
                        'permalink'=>get_the_permalink($campus)
                    ));        
                }
            }

            array_push($results['program'],array(
                'title'=>get_the_title(),
                'permalink'=>get_the_permalink(),
                'id'=>get_the_id()
            ));
        }
        
    }

    if($results['program']){
        
       $professorMetaQuery=array('relation' => 'OR');

        foreach($results['program'] as $item){
            array_push($professorMetaQuery, array(
                    'key' => 'related_programs',
                    'compare' => 'LIKE',
                    'value' => '"'.$item['id'].'"'    
                
            ));

        }
        
        $programRelationshipQuery=new WP_Query(array(
            'post_type'=> array('professor', 'event'),
            'meta_query'=> $professorMetaQuery
        ));

        
    
        while($programRelationshipQuery->have_posts()){
            $programRelationshipQuery->the_post();
            
            if(get_post_type()=='event'){
                $eventDate=new DateTime(get_field('event_date'));
                $eventExcerpt=null;
    
                if(has_excerpt()){
                    $eventExcerpt=get_the_excerpt();
                }else{
                    $eventExcerpt=wp_trim_words(get_the_content(),18);
                } 
    
                array_push($results['event'],array(
                    'title'=>get_the_title(),
                    'permalink'=>get_the_permalink(),
                    'month'=>$eventDate->format('M'),
                    'day'=>$eventDate->format('d'),
                    'eventExcerpt'=>$eventExcerpt
                ));
            }
            
            if(get_post_type()=='professor'){
                array_push($results['professor'],array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'image'=>get_the_post_thumbnail_url(0,'professorLandscape')
                ));
            }
        }
        $results['professor']=array_values(array_unique($results['professor'], SORT_REGULAR));
        $results['event']=array_values(array_unique($results['event'], SORT_REGULAR));
        $results['campus']=array_values(array_unique($results['campus'], SORT_REGULAR));
    }

    
    return $results;
}


