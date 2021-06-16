<?php

    require get_theme_file_path('/inc/SearchRoot.php');

    function university_custom_rest(){
        register_rest_field('post','authorName',array(
            'get_callback'=> function(){return get_the_author();}
        ));

        register_rest_field('note','userNoteCount',array(
            'get_callback'=> function(){return count_user_posts(get_current_user_id(),'note');}
        ));
    }

    add_action('rest_api_init','university_custom_rest');

    function fic_uni_files() {
        
        wp_enqueue_style('custom fonts','//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
        wp_enqueue_style('icon_url','//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
        
        wp_enqueue_script('googleMap','//maps.googleapis.com/maps/api/js?key=AIzaSyDU2ZFmIsy8hC4Lb3jUX041UeU1JofIC6M',NULL,'1.0',true);
        

        if(strstr($_SERVER['SERVER_NAME'],'localhost/wordpress')){
            wp_enqueue_script('main_university_js','http://localhost:3000/bundled.js',NULL,'1.0',true);
        }else{
            wp_enqueue_script('our_vendor_js',get_theme_file_uri('/bundled-assets/vendors~scripts.1fa169383e64a33bfd0c.js'),NULL,'1.0',true); 
            wp_enqueue_script('main_university_js',get_theme_file_uri('/bundled-assets/scripts.5a50a81a1d1ffaa90544.js'),NULL,'1.0',true); 
            
            wp_enqueue_style('main_css',get_theme_file_uri('/bundled-assets/styles.5a50a81a1d1ffaa90544.css'));
        }

        wp_localize_script('main_university_js','universityData',array(
            'root_url'=> get_site_url(),
            'nonce'=>wp_create_nonce('wp_rest')
        ));
     }

    

    function theme_features(){
        register_nav_menu('headerMenuLocation','Header Menu Location');
        register_nav_menu('footerLocationOne','Footer Location One');
        register_nav_menu('footerLocationTwo','Footer Location Two');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails'); 
        add_image_size('professorLandscape',400,260,true);
        add_image_size('professorPortrait',480,650,true);
        add_image_size('pageBanner',1500,350,true);
               
    }

    
    
    function university_adjust_queries($query){

        $today=date('Ymd');
        if(!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()){
            $query->set('meta_key','event_date');
            $query->set('orderby','meta_value_num');
            $query->set('order','ASC');
            $query->set('meta_query',array(
                array(
                  'key'=>'event_date',
                  'compare'=>'>=',
                  'value' => $today,
                  'type' => 'numeric'
                )
              ));
        }
        if(!is_admin() AND is_post_type_archive('campus') AND $query->is_main_query()){
            $query->set('posts_per_page','-1');
        }
    }

    add_action('pre_get_posts','university_adjust_queries');
    add_action('after_setup_theme','theme_features');
    add_action('wp_enqueue_scripts','fic_uni_files');
    
    function pageBanner($args = NULL){
        
        if(!$args['title']){
            $args['title']= get_the_title();
        }

        if(!$args['subtitle']){
            $args['subtitle']= get_field('page_banner_subtitle');
        }

        if(!$args['photo']){
            if(get_field('page_banner_background_image') && !is_home() AND !is_archive()){
                $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
            }else{
                $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
            }
        }

        ?>
        
        <div class="page-banner">
            <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>)"></div>
            <div class="page-banner__content container container--narrow">
                <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
                <div class="page-banner__intro">
                <p><?php echo $args['subtitle']; ?></p>
                </div>
            </div>  
        </div>

        <?php
    }

    function addMapKey($api){
        $api['key']='AIzaSyDU2ZFmIsy8hC4Lb3jUX041UeU1JofIC6M';
        return $api;
    }

    add_filter('acf/fields/google_map/api','addMapKey');
    
    //redirect subscriber account
    add_action('admin_init','redirectSubsToFrontEnd');

    function redirectSubsToFrontEnd(){
        
        $ourCurrentUser=wp_get_current_user();

        if(count($ourCurrentUser->roles)==1 AND $ourCurrentUser->roles[0]=='subscriber'){
            wp_redirect(site_url('/'));
            exit;

        }
    }

    add_action('wp_loaded','noSubsAdminBar');

    function noSubsAdminBar(){
        
        $ourCurrentUser=wp_get_current_user();

        if(count($ourCurrentUser->roles)==1 AND $ourCurrentUser->roles[0]=='subscriber'){
             show_admin_bar(false);
        }
    }

    // Customize login screen
    add_filter('login_headerurl','ourHeaderUrl');

    function ourHeaderUrl(){
        return esc_url(site_url('/'));
    }
    
    //Force note post to be private
    add_filter('wp_insert_post_data','makeNotePrivate',10,2);

    function makeNotePrivate($data, $pstArr){

        if($data['post_type'] == 'note'){

            if(count_user_posts(get_current_user_id(), 'note') > 3 AND !$pstArr['ID']){
                die('You have reached your note limit.');
            }

            $data['post_title'] = sanitize_text_field($data['post_title']);
            $data['post_content'] = sanitize_textarea_field($data['post_content']);
        }

        if($data['post_type']=='note' AND $data['post_status']!='trash'){
            $data['post_status']="private";
        }
        
        return $data;
    }
?>