=== VideoGall ===
Contributors: DezineAppz
Tags: video, gallery, widget, youtube, metacafe, flv, vimeo, quicktime, ShadowBox
Requires at least: 2.8
Tested up to: 3.4
Stable tag: 2.5.1

Automatically generate a beautiful video gallery by adding videos from different websites

== Description ==

Display a video gallery on your site. Add videos from different sites through the admin panel and get a beautiful video gallery with ShadowBox effect. Also available are options to edit or delete already added videos. Videos can be categorized and displayed according to their categories aswell. You can also add a videogall widget on sidebar. Translation ready. English and Spanish versions available. For more details, visit http://dezineappz.com/videogall/

== Screenshots ==

1. Video Gallery
2. Video with shadowbox effect
3. Videogall Shortcode button

== Installation ==

* Unzip the VideoGall plugin in the plugins folder in wp-content directory i.e "wp-content/plugins"
* Go to your wordpress site admin and plugins section and activate the VideoGall plugin
* Go to settings --> VideoGall Settings to set your options and add videos
* In a page or a post use the button in the editor to add the vidoeogall shortcode e.g. [myvideogall:all] will display all the videos. To display videos from a certain category, replace "all" with your desired category name

== Frequently Asked Questions ==

* How to generate thumbnail ? - While adding the video information in the admin page, do not populate the thumbnail and it will automatically fetch the thumbnail from the video site.
* How do I find the URL of the video ? - Add the URL found in the browser's address bar of the Video website. For Blip videos, see Other Notes section
* Do I need to deactivate Lightbox plugin if I have installed one ? - Not really. If you choose the option to display images using videogall's shadowbox then videogall will still work and open images in shadowbox. Your installed Lightbox plugin won't open images.
* How do I change the look of the gallery ? - By making changes to the videogall.css stylesheet

== Other Notes ==

* VideoGall v2.5 will now use the Options to save your videos, all your videos from the existing tables will be migrated automatically and the database table WP_Videogall and its category table will be deleted
* Blip video is no longer directly supported. Blip API is not directly available. To display Blip videos, get the video source URL from its embed code and then add it to through VideoGall settings page
* WordPress videos can now be added by just adding the Permalink of the WordPress website
* Directly Supported sites: YouTube, Vimeo, DailyMotion, Metacafe, Google, FLV, QuickTime movies, WordPress Blogs

== ChangeLog ==

** Version 2.5 **

* VideoGall will now use the Options table to store videos instead of custom videogall database table
* VideoGall Admin page renovated
* New pagination implemented
* Better looking borders for video thumbnails

** Version 2.4.1 **

* Bug fixes

** Version 2.4 **

* Adding the actual video URL into Database
* Fixed out of memory errors
* Fixed issue of limiting videos in the widget

** Version 2.3 **

* Added fix for out of memory errors

** Version 2.2 **

* Fixed the issue of videos not opening in shadowbox
* Blip no longer supported directly
* Support for wordpress videos added
* Redesigned & redeveloped the settings page
* Fixed layout issues and improved the layout
* Shortcode button added
* Fixed issue of not being able to fetch thumbnails
* Multiple widgets can now be added
* Improved pagination
* More customization features

** Version 2.1 **

* Support for Blip.tv

** Version 2.0 **

* Added description field again, on popular demand
* Added option to set number of videos per row to avoid breaking of horizontal layout
* Fixed issue of unrecognizable URL, in which case, page will be redirected to that URL instead of shadowbox

** Version 1.9 **

* Fixed bug for creating tables for new users
* Added a fixed height for caption in order to preserve horizontal layout

** Version 1.8 **

* Changed the function names to avoid conflicts with other plugins

** Version 1.7 **

* Fixed issue with pagination

** Version 1.6 **

* Pagination feature added
* Limit number of videos in the sidebar widget
* Shadowbox effect available for images
* Removed description section
* Translation ready
* Bug fixes

** Version 1.5.5 **

* Sort videos by in order of ascending or descending
* Put videos on sidebar widget
* Fixed the issue with horizontal layout

** Version 1.5.3 **

* Sort videos by Caption, Date and Categories
* Option to display border around the video thumbnails

** Version 1.5.1 **

* Added code to ignore PHP warnings if argument is not passed to function

** Version 1.5 **

* Switched to ShadowBox instead of VidBox
* Now you can categorize your videos by adding categories and display your videos based on categories
* Removed the vertical style display. Only horizontal style display available
* Added a name field to the video entries. After the upgrade, existing videos will get the name "default"
* Each video can have a different size
* Shadowbox can be used for images as well

** Version 1.4 **

* Switched back to VideoBox instead of LightWindow
* Added option to enable videobox effect for images as well

** Version 1.3 **

* Fixed the issue of incorrect path of stylesheets and javascripts
* Added option to specify height and width of the video

** Version 1.2 **

* Modified the plugin to use LightWindow instead of VideoBox
* Updated to work with Wordpress 2.9.1

** Version 1.1 **

* Added option to show/hide date below videos. Updated to work with Wordpress 2.86

** Version 1.0 **

* Initial release of VideoGall plugin