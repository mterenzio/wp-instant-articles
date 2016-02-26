<?php
/**
 * Instant Article Feed Template.
 *
 */

header('Content-Type: ' . feed_content_type('rss-http') . '; charset=' . get_option('blog_charset'), true);
$more = 1;

echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';

do_action( 'rss_tag_pre', 'rss2' );
?>

<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	<?php
	do_action( 'rss2_ns' );
	?>
>

<channel>
	<title><?php bloginfo_rss('name'); wp_title_rss(); ?></title>
	<link><?php bloginfo_rss('url') ?></link>
	<description><?php bloginfo_rss("description") ?></description>
	<lastBuildDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></lastBuildDate>
	<language><?php bloginfo_rss( 'language' ); ?></language>
	<?php
	do_action( 'rss2_head');

	while( have_posts()) : the_post();
	?>
	<item>
		<title><?php the_title_rss() ?></title>
		<link><?php the_permalink_rss() ?></link>
		<pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?></pubDate>
		<author><![CDATA[<?php the_author() ?>]]></author>
		<?php the_category_rss('rss2') ?>
		<guid isPermaLink="false"><?php the_guid(); ?></guid>
		<description><![CDATA[<?php the_excerpt_rss(); ?>]]></description>
	<?php $content = get_the_content_feed('rss2'); ?>
	<?php if ( strlen( $content ) > 0 ) : ?>
		<content:encoded>
	
<![CDATA[
<!doctype html>
<html lang="en" prefix="op: http://media.facebook.com/op#">
  <head>
    <meta charset="utf-8">
    <link rel="canonical" href="<?php the_permalink_rss() ?>">
    <meta property="op:markup_version" content="v1.0">
  </head>
  <body>
    <article>
      <header>
        <!-- The title and subtitle shown in your Instant Article -->
        <h1><?php the_title_rss() ?></h1>

        <!-- The date and time when your article was originally published -->
        <time class="op-published" datetime="2014-11-11T04:44:16Z"><?php echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?></time>

        <!-- The date and time when your article was last updated -->
        <time class="op-modified" dateTime="2014-12-11T04:44:16Z"><?php echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?></time>

        <!-- The authors of your article -->
        <address>
          <a rel="facebook" href="<?php the_author_link(); ?>"><?php the_author() ?></a>
          <?php the_author_meta( 'description'); ?> 
        </address>

        <!-- The cover image shown inside your article --> 
        <figure>
	 <?php
     if( has_post_thumbnail( $post->ID ) ) {
         echo '<figure>' . get_the_post_thumbnail( $post->ID, 'thumbnail' ) . '</figure>';
     }
	?>
        </figure>   

      </header>

      <!-- Article body goes here -->

      <!-- Body text for your article -->
      <p><?php echo $content; ?></p> 

      <!-- A video within your article -->
	 <?php
     if( has_post_thumbnail( $post->ID ) ) {
         echo '<figure>' . get_the_post_thumbnail( $post->ID, 'thumbnail' ) . '</figure>';
     }
	?>

    </article>
  </body>
</html>]]>

	</content:encoded>
	<?php else : ?>
		<content:encoded><![CDATA[<?php the_excerpt_rss(); ?>]]></content:encoded>
	<?php endif; ?>

<?php rss_enclosure(); ?>
	<?php
	do_action( 'rss2_item' );
	?>
	</item>
	<?php endwhile; ?>
</channel>
</rss>