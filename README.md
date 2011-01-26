# Band-o-rama

Band-o-rama is 2 things:

1. An open source tool for bands to create gorgeous iPhone/iPad websites.
2. A service to help music lovers discover and connect with new bands.

Both are free. This page is for #1. #2 can be found on the official
Band-o-rama homepage here:

* [http://www.band-o-rama.com/](http://www.band-o-rama.com/)

An example of a real Band-o-rama mobile site is:

* [http://www.johnnybroadway.com/m](http://www.johnnybroadway.com/m)

Visit that link on your iPhone or iPad to see how a Band-o-rama site
looks and feels.

## Getting Help

The official discussion group page for Band-o-rama is:

* [http://band-o-rama.posterous.com/](http://band-o-rama.posterous.com/)

## Prerequisites

You'll need a few things to setup a mobile site for your band:

* Your own website, not just a Myspace or Facebook page. Your website
  must support PHP.
* An FTP program to upload files to your website.
* MP3 files of some of your songs.
* A photo editing program to make images of varying sizes for your site.

## Getting Started

1. Download a copy of the Band-o-rama software from this page:

* [http://github.com/jbroadway/band-o-rama/downloads](http://github.com/jbroadway/band-o-rama/downloads)

2. Unzip the download then use an FTP program to upload it to a folder
named 'm' on your website. This will be where people find the mobile
version of your site from now on (e.g., www.bandname.com/m).

3. Still in your FTP program, edit the file permissions on the folders
`m/admin/config` and `m/admin/files` and set the permissions to 0777 or
read/write/execute for all. Make sure to click the option that says
something to the effect of "Also change permissions on files inside this
folder." For example in Transmit on the Mac, you would right-click the folders and
choose "Get Info", then under "Permissions" check off all the boxes, then
click "Apply to enclosed items."

4. Now open the `m/admin/config` folder and edit the settings.php file
found inside. Change the values for `admin_username`, `admin_password`,
and `default_city` and save the file. You can now close the FTP program.

5. Open your web browser and go to `www.bandname.com/m/admin` on your
website. Log in with the admin username/password from step 4. Bookmark
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

Band-o-rama was created by [Johnny Broadway](http://www.johnnybroadway.com/)
and released under the [GPL Version 2](http://opensource.org/licenses/gpl-2.0.php)
license.

Band-o-rama also makes use of a few 3rd-party open source libraries:

* [jQuery](http://jquery.com/)
* [jQuery Mobile](http://jquerymobile.com/)
* [jQuery UI](http://jqueryui.com/)
* [jPlayer](http://happyworm.com/jquery/jplayer/)
* [Fancybox](http://fancybox.net/)
* [Uploadify](http://www.uploadify.com/)
* [PHP](http://php.net/)
* [SQLite](http://www.sqlite.org/)
