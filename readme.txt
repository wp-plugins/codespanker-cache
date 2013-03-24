=== Codespanker Cache ===
Contributors: spencercameron
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=FBUMCC3UDUDTN
Tags: cache, caching, speed, codespanker, optimize, optimization, performance
Requires at least: 3.3
Tested up to: 3.5.1
Stable tag: 1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Supercharge your WordPress site with full-page caching from Codespanker Cache.

== Description ==

Codespanker Cache is the first and only external caching service available for WordPress. With lightning fast response times and an uber reliable cloud infrastructure, you're sure to notice huge performance gains immediately. Not only will the load on your database be dramatically reduced, but also your server will be able to deliver more content to your visitors faster. This makes everybody happy.

Setup is easy and hassle free. Designed and built from the ground up to be simple and efficient, the frustration and guesswork involved in setting up caching is a thing of the past. No account or signup is needed.

Once you activate the plugin, a unique secret will be generated and stored in your database. This will be used to make sure your content stays secure. Caching begins immediately after plugin activation. Your cached pages will be safely stored on Codespanker.com servers.

If you'd like to see how long it's taking to generate your pages, you can view the page source. Just before the closing head tag ( `</head>` ), you'll find the following:

**When the page is not served from the cache:**
`<!-- Page generated without caching in *your generation time* seconds. -->`

**When the page is served from the cache:**
`<!-- Served by Codespanker Cache in *time with caching* seconds. -->`

**Note:**
Nothing is cached for logged in users. If you'd like to see the caching in action ( and see your site actually speeding up ), you'll need to log out or view the page in another browser that's not logged in. Be sure to refresh a few times to see the difference. The first visit caches the page and subsequent visits are served from the cache ( these visits are the fast ones ).

== Installation ==

1. Upload the folder 'codespanker-cache' to the '/wp-content/plugins/' directory.
2. Activate the plugin through the Plugins menu in WordPress.
3. Optional: Set the cache expiration ( in seconds ) via the Settings->Cache menu.
4. Enjoy a faster WordPress site.

== Frequently Asked Questions ==

= I activated the plugin, but my site doesn't seem to be loading any faster. Why? =

Pages aren't cached for logged in users. In fact, nothing is cached for logged in users. Log out and you'll see the cache working.

= Where are the pages cached for my site stored at? =

They are stored on our caching servers at Codespanker.com behind firewalled connections.

= Is my cached content stored in the same place as other sites? =

Yes. We use a distributed cache setup. That means your content could potentially be stored along side many other sites.

= If my cached content is stored in the same place as other sites, can my content get mixed up with theirs? Will I be hacked? =

No. When you first activate the plugin, a secret key will be generated and stored in your WordPress database. Your cached content can't be modified without this secret key. The moral of this story is don't tell anyone your secret key.

= Does this plugin transmit, modify, or store any sensitive data from my database such as user passwords or admin content? =

No. The only content cached is what would have already been visible to the end user. Nothing is cached while an admin ( or any user ) is logged into WordPress.

== Changelog ==

= 1.2 =
* Fixed a bug where the user defined cache expiration was being ignored and the default cache expiration used instead ( 300 seconds ).

= 1.1 =
* Initial release.