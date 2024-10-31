=== muse.ai video embedding ===
Contributors: museai
Tags: video embed, iframe, muse.ai, muse ai, embed, oembed, shortcode, shortcodes, embed video, embed wordpress, video hosting, video host
Requires at least: 4.7
Tested up to: 6.3
Stable tag: 0.4.1
Requires PHP: 7.0
License: GPLv2 or later

This plugin enables muse.ai oEmbed links, and adds shortcodes to easily embed videos hosted on muse.ai.

== Description ==

This plugin simplifies the embedding of videos hosted on [muse.ai](https://muse.ai) platform.

It does three things:
 - whitelists muse.ai as an oEmbed provider (which lets you embed videos simply by pasting links),
 - adds shortcodes as an alternative method of embedding that gives you a bit more control,
 - adds an Elementor widget for embedding muse.ai videos.

The shortcodes are essentially a wrapper around muse.ai [embed library](https://muse.ai/docs#embed-player).

To embed videos using oEmbed, simply paste a video link into a separate line in your post or page. For example:

`https://muse.ai/v/VBdrD8v`

If you would like more control, you can use shortcodes. For example:

`[muse-ai id="VBdrD8v" width="100%" title="0"]`

== Changelog ==

= 0.4.1 =
* Fix an Elementor widget issue that was preventing blocks from being removed.

= 0.4 =
* Basic Elementor widget.

= 0.3.4 =
* Support for more shortcode attributes.

= 0.3.3 =
* Support for `resume`, `align`, and `cover_play_position` shortcode attributes.

= 0.3.2 =
* Support for `start` and `loop` shortcode attributes.

= 0.3.1 =
* Support for WordPress 6.1.

= 0.3 =
* Support for more shortcode attributes.

= 0.2 =
* oEmbed support for more video link types.
