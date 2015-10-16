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
          <a rel="facebook" href="http://facebook.com/brandon.diamond">Brandon Diamond</a>
          Brandon is a avid zombie hunter.
        </address>

        <!-- The cover image shown inside your article --> 
        <figure>
          <img src="http://mydomain.com/path/to/img.jpg" />
          <figcaption>This image is amazing</figcaption>
        </figure>   

      </header>

      <!-- Article body goes here -->
      
      <p><?php echo $content; ?></p> 

      <!-- images BROKEN?? -->
	 <?php if ( $images = get_posts(array(
	  		'post_parent' => $post->ID,
	  		'post_type' => 'attachment',
	  		'numberposts' => -1,
	  		'post_mime_type' => 'image',)))
	  	{
	  		foreach( $images as $image ) {
	  			$attachmenturl=wp_get_attachment_url($image->ID);
	  			$attachmentimage=wp_get_attachment_image_src( $image->ID, full );
	  			$imageDescription = apply_filters( 'the_description' , $image->post_content );
	  			$imageTitle = apply_filters( 'the_title' , $image->post_title );
				echo '<figure>';
	  		echo '<img src="' . $attachmentimage[0] . '" alt=""  />';
			echo '</figure>';
		}
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
