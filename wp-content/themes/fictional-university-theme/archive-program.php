<?php
get_header(); 
pageBanner(array(
    'title'=> 'All programs',
    'subtitle'=>'All program list here'
)

);
?>

<div class="container container--narrow page-section">
    <?php 
        while(have_posts()){
            the_post(); ?>
            <li><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></li>
            
        <?php }
        echo paginate_links();
    ?>
    
</div>
<?php 
    get_footer();
?>