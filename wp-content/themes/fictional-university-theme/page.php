<?php
    get_header();
    while(have_posts()){
        the_post(); 
        pageBanner();

        ?>
            

        <div class="container container--narrow page-section">

        <div class="metabox metabox--position-up metabox--with-home-link">
        <?php 
         
         $parentPageId=wp_get_post_parent_id(get_the_id());
         if($parentPageId){ ?>
            <p><a class="metabox__blog-home-link" href="<?php echo get_the_permalink($parentPageId); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($parentPageId);?></a>
        
        <?php } ?>   
        
        </div>
       
       <?php 

        $test_array=get_pages(array(
            'child_of'=>get_the_id()
        ));

        if($parentPageId or $test_array){ ?>
        <div class="page-links">
            <h2 class="page-links__title"><a href="<?php get_the_permalink($parentPageId); ?>"><?php echo get_the_title($parentPageId); ?></a></h2>
            <ul class="min-list">
                <?php 
                
                if($parentPageId){
                    $findChildrenOf=$parentPageId;
                }else{
                    $findChildrenOf=get_the_id();
                }
                
                wp_list_pages(array(
                    'title_li'=>NULL,
                    'child_of'=>$findChildrenOf,
                    'sort_column'=>'menu_order'
                )); ?>
            </ul>
        </div>
        <?php } ?>    
        

        <div class="generic-content">
            <?php the_content(); ?>
        </div>

        </div>
    <?php }
    get_footer();
?>