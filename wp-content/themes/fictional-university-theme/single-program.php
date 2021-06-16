<?php
    get_header();
    while(have_posts()){
        the_post();
        pageBanner();
        ?>

      
        <div class="container container--narrow page-section">
            
            <div class="metabox metabox--position-up metabox--with-home-link">  
                <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to program list</a>
            </div>
             

            <h2><?php the_title(); ?></h2>
            <?php the_content(); ?>

            <!-- Start of the related professors -->
            <?php
            $today=date('Ymd');
            $homePageProfs=new WP_Query(array(
              'posts_per_page'=>-1,
              'post_type'=> 'professor',
              'orderby'=> 'title',
              'order'=>'ASC',
              'meta_query' => array(
                
                array(
                    'key'=>'related_programs',
                    'compare'=>'LIKE',
                    'value' => '"'.get_the_id().'"'
                  )
              )
            ));
            
            
            if($homePageProfs->have_posts()){
                
                echo '<hr class="section-break">';
                echo '<h2 class="headline headline--medium"> Related '.get_the_title().' Professors</h2>';

                echo '<ul class="professor-cards">';
                while($homePageProfs->have_posts()){
                    $homePageProfs->the_post(); ?>
                    
                    <li class="professor-card__list-item"><a class="professor-card" href="<?php echo get_the_permalink(); ?>">
                        <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape'); ?>">
                        <span class="professor-card__name"><?php echo the_title(); ?></span>
                    </a>
                    
                    </li>
                    
                <?php
                }
                echo '</ul>';
             }
          ?>
            <!-- End of the related professors -->
            <?php
            wp_reset_postdata();

            $today=date('Ymd');
            $homePageEvents=new WP_Query(array(
              'posts_per_page'=>2,
              'post_type'=> 'event',
              'meta_key'=> 'event_date',
              'orderby'=> 'meta_value_num',
              'order'=>'ASC',
              'meta_query' => array(
                array(
                  'key'=>'event_date',
                  'compare'=>'>=',
                  'value' => $today,
                  'type' => 'numeric'
                ),
                array(
                    'key'=>'related_programs',
                    'compare'=>'LIKE',
                    'value' => '"'.get_the_id().'"'
                  )
              )
            ));
            
            if($homePageEvents->have_posts()){
                
                echo '<hr class="section-break">';
                echo '<h2 class="headline headline--medium"> Upcoming '.get_the_title().' Events</h2>';

                while($homePageEvents->have_posts()){
                    $homePageEvents->the_post(); 
                    get_template_part('template-parts/content','event');
                }
             }

             wp_reset_postdata();

            $relatedCampuses=get_field('related_campus');

            if($relatedCampuses){

              echo '<hr class="section-break">';
              echo '<h2 class="headline headline--medium"> Available campuses </h2>';
              echo '<ul class="min-list link-list">';
              foreach($relatedCampuses as $campus){ ?>
                
                <li><a href="<?php get_the_permalink(); ?>">
                <?php echo get_the_title($campus); ?>
                </a></li>
              <?php }
              echo '</ul>';
            }
          ?>
          
        </div>
    <?php }
    get_footer();
?>