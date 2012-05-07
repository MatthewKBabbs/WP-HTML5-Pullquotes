WP HTML5 Pullquotes plugin
==========================

Wordpress plugin to create pullquotes using pure HTML5 and CSS - without any duplicate content!

Most pullquote solutions involve either duplicating content or taking a regular tag and styling it as a pullquote. Your pullquote content appears twice and it's all too easy for it to end up displayed as duplicate content inline with everything else.

This plugin avoids duplicate content *and* reliance on JavaScript by allowing you to use HTML5's data-* attribute to hold the pullquote content, and then display it with CSS. It works in all modern browsers and IE8+.

Credit for the original technique goes to Maykel Loomans at http://miekd.com/articles/pull-quotes-with-html5-and-css/.

Usage
--------------------------
With plugin installed & activated, create a pullquote in Wordpress's HTML editor. (Not yet possible in the visual editor.) Insert the pullquote content as an HTML5 data-pullquote attribute, eg:

	<p data-pullquote="This is the pullquote content">This is a regular paragraph. It just happens to have a pullquote next to it.</p>

You'll have to add CSS to your theme to display the content of the data-pullquote attribute as a pullquote - this plugin doesn't yet add any default styles to do that! Here's an example:
	\[data-pullquote]:before {
		/* Reset metrics. */
		padding: 0;
		border: none;

		/* Content */
		content: attr(data-pullquote);

		/* Pull out to the right, modular scale based margins. */
		float: right;
		width: 320px;
		margin: 12px -140px 24px 36px;

		/* Baseline correction */
		position: relative;
		top: 5px;

		/* Typography (30px line-height equals 25% incremental leading) */
		font-size: 23px;
		line-height: 30px;
	}

Changelist
--------------------------

### v0.2
Pullquotes are now visible in the Wordpress visual editor.

### v0.1:
Initial version - prevents TinyMCE from stripping out the data-pullquote attribute.
No default styles for pullquotes - must be provided by your theme.
Pullquotes will not be visible in the WordPress visual editor.
