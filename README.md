# Band-o-matic

Band-o-matic is an open source web application for bands to create beautiful iPhone/iPad/mobile websites. Think of it like Wordpress for mobile band sites. Features include:

* Beautiful full-screen photos and album covers for backgrounds, or choose from 10 built-in themes
* Auto-resizing for multiple device sizes/orientations
* Automatically pulls your latest news from RSS or Twitter
* Automatically pulls your show listings from RSS (Gigpress or Artistdata currently work)
* Popups show fresh messages, including links and photos, to visitors while they listen
* Music is organized into albums for listening
* Customizable contact/email page to connect with fan newsletter, and link to Facebook, Twitter, etc.

Band-o-matic also ties into [Band-o-rama](http://www.band-o-rama.com/), a free iPhone/iPad app for listeners to discover and share new music and connect with new bands.

An example of a real Band-o-matic mobile site is:

* [http://www.johnnybroadway.com/m](http://www.johnnybroadway.com/m)

Visit that link on your iPhone or iPad to see how a Band-o-matic site looks and feels (also works in most browsers too).

## Getting Help

The official discussion group page for Band-o-matic is:

* [http://band-o-matic.posterous.com/](http://band-o-matic.posterous.com/)

## Prerequisites

You'll need a few things to setup a mobile site for your band:

* Your own website, not just a Myspace or Facebook page. Your website
  must support PHP5.
* An FTP program to upload files to your website.
* MP3 files of some of your songs.
* A photo editing program to make images of varying sizes for your site.

## Getting Started

1. Download a copy of the Band-o-matic software from this page:

* [http://github.com/jbroadway/band-o-matic/downloads](http://github.com/jbroadway/band-o-matic/downloads)

2. Unzip the download then use an FTP program to upload it to a folder
named 'm' on your website. This will be where people find the mobile
version of your site from now on (e.g., www.bandname.com/m).

3. Still in your FTP program, edit the file permissions on the folders
`m/admin/config` and `m/admin/files` and set the permissions to 0777 or
read/write/execute for all. Make sure to click the option that says
something to the effect of "Also change permissions on files inside this
folder." For example in [Transmit](http://panic.com/transmit/) on the Mac,
right-click the folders and choose "Get Info", then under
"Permissions" check off all the boxes, then click "Apply to enclosed items."
Using [FlashFXP](http://flashfxp.com/) on Windows, you would right-click the folders and choose
"Attributes (CHMOD)", check off all the boxes, then click "Apply changes recursively to sub-folders and files".

4. Now open the `m/admin/config` folder and edit the settings.php file
found inside. Change the values for `admin_username`, `admin_password`,
and `default_city` and save the file. You can now close the FTP program.

5. Open your web browser and go to `www.bandname.com/m/admin` on your
website. Log in with the admin username/password from step 5. Bookmark
this or save the link somewhere because this is where you'll go to keep
your mobile site up-to-date. Follow the steps on each tab to setup your
new site.

6. Test it out on your iPhone/iPad and make sure it looks good. It should
also work in any web browser, but the experience is tailored a bit to
mobile devices.

7. To redirect iPhone/iPad users from your main website so they automatically
see your new mobile site, add this line to the `<head>` section of your
main site's `index.html` file: `<script src="/m/js/redirect.js"></script>`

8. Now go to [http://www.band-o-rama.com/artists](http://www.band-o-rama.com/artists) and register your band
for the Band-o-rama service so that listeners can find you on there!

## Credits

Band-o-matic was created by [Johnny Broadway](http://www.johnnybroadway.com/)
and released under the [GPL Version 2](http://opensource.org/licenses/gpl-2.0.php)
license.

Band-o-matic also makes use of a few 3rd-party open source libraries:

* [jQuery](http://jquery.com/)
* [jQuery Mobile](http://jquerymobile.com/)
* [jQuery UI](http://jqueryui.com/)
* [jPlayer](http://happyworm.com/jquery/jplayer/)
* [jGFeed](http://jquery-howto.blogspot.com)
* [Fancybox](http://fancybox.net/)
* [Uploadify](http://www.uploadify.com/)
* [PHP](http://php.net/)
* [SQLite](http://www.sqlite.org/)
* [SimplePie](http://simplepie.org/)
* [SG-iCalendar](http://github.com/fangel/SG-iCalendar)
