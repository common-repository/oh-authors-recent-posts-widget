<?php if ($r->have_posts()) :?>
<?php if ( $title ) echo $before_title . $title . $after_title; ?>
<?php if ( $text ) echo apply_filters('the_content', $text) ; ?>
<div class="padd10">
    <div class="author clearfix border-bottom-blue">
        <a class="author-avatar" href="<?php echo get_author_posts_url( $user->ID ); ?>">
            <?php echo get_avatar($user->ID, 100); ?>
        </a>
        <div class="author-meta">
            <h4><a href="<?php echo get_author_posts_url( $user->ID ); ?>"><?php echo $user->display_name ?> </a></h4>
            <p><?php echo $user->description ?></p>
        </div>
    </div>
    <ul id="ul_<?php echo $widget_id ?>"class="author-recent-post-slider  ">
    <?php while ( $r->have_posts() ) : $r->the_post(); ?>
        <li class="clearfix">
            <a href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ? get_the_title() : get_the_ID() ); ?>">
            <?php the_post_thumbnail('thumbnail');   ?>
            </a>
            <h4>
                <a href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ? get_the_title() : get_the_ID() ); ?>">
                <?php if ( get_the_title() ) the_title(); else the_ID(); ?>
                </a>
            </h4>
            <?php if ($show_date) : ?><span class="post-date"><?php echo get_the_date(); ?></span>  <?php endif; ?>
            <?php if($show_excerpt):
                if(!$limit_words): ?>
                <p> <?php the_excerpt() ;?></p>
                <?php else:?>
                 <p> <?php echo apply_filters('the_excerpt',wp_trim_words(get_the_excerpt() , $limit_words )) ;?>
                    <a class="readmore" href="<?php the_permalink() ?>" ><?php _e('Read more')?></a>
                 </p>
                <?php endif; ?>
            <?php endif; ?>
        </li>
    <?php endwhile; ?>
    </ul>
</div>
    <a class="author-link all_posts" href="<?php echo  get_author_posts_url( $user->ID ) ?>">
        <?php printf( __( 'All posts by %s', $this->loc ),$user->display_name )  ;?></a>
    <a class="all_posts arial" href="<?php echo $link ?>"><?php  echo $link_text ;?></a>
<?php wp_reset_postdata();
endif;