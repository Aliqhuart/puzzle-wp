@extends('layouts.public')

@section('extend-head')
@parent
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php 
// Load Wordpress head, for plugins
wp_head(); 
?>
@stop

@section('body')

<!-- Start the Wordpress Loop. -->
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <!-- Test if the current post is in category 3. -->
        <!-- If it is, the div box is given the CSS class "post-cat-three". -->
        <!-- Otherwise, the div box is given the CSS class "post". -->

        <div class="post">


            <!-- Display the Title as a link to the Post's permalink. -->

            <h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>


            <!-- Display the date (November 16th, 2009 format) and a link to other posts by this posts author. -->

            <small><?php the_time('F jS, Y'); ?> by <?php the_author_posts_link(); ?></small>


            <!-- Display the Post's content in a div box. -->

            <div class="entry">
                <?php the_content(); ?>
            </div>


            <!-- Display a comma separated list of the Post's Categories. -->

            <p class="postmetadata"><?php _e('Posted in'); ?> <?php the_category(', '); ?></p>
        </div> <!-- closes the first div box -->


        <!-- Stop The Loop (but note the "else:" - see next line). -->

    <?php endwhile;
else :
    ?>


    <!-- The very first "if" tested to see if there were any Posts to -->
    <!-- display.  This "else" part tells what do if there weren't any. -->
    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>


    <!-- REALLY stop The Loop. -->
<?php endif; ?>
@stop

@section('extend-body')
@parent
<?php 
// Load Wordpres footer, for plugins
wp_footer(); 
?>
<script type="text/javascript" src="<?= "/public/js/public.js" ?>"></script>
@stop