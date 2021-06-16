<?php
get_header(); 
pageBanner(array(
 'title'=>'All events',
 'subtitle'=> 'See what is going on in our world'   
));
?>

<div class="container container--narrow page-section">
    <?php 
        while(have_posts()){
            the_post(); 
            get_template_part('/template-parts/content','event');
        }
        echo paginate_links();
    ?>
    <hr class="section-break">
    Looking for a recap of past events. <a href="<?php echo site_url('/past-event'); ?>"> Check out our past events archive </a>
</div>
<?php 
    get_footer();
?>