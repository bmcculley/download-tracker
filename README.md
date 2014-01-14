# Download Tracker
## PHP/MySQL Based Download Tracker

Can be used to count the number of times a file gets downloaded. Can  also
track referrers if necessary.

The admin section still needs work to display all the data collected.
Right now it only displays the number of downloads on certain dates,
using d3.js.

### Setup
1. Download the project, place on web server.
2. Create a MySQL database and execute the db.sql file found in _inc directory
3. Update the config.php with time zone and database settings
4. Setup the frontend of the site to use the download.php file to route downloads
5. Rackup some downloads...Enjoy the stats.

#### default admin login: admin : abc123

Code is released under Apache License v2 license.

[![Buy me a coffee](http://i.imgur.com/qB510Gx.png "Buy me a coffee?")](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=WH8N24DEJKVCE) 