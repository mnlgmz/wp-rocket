# How to clear WP-Rocket Cache at a specific time
You can clear WP-Rocket Cache at a specific time using a helper and a cron job. To set up a specific time to clear WP-Rocket Cache, follow the steps below:

## 1. Install the "Disable Cache Clearing" plugin

Install and enable the following plugin: [Automatic Cache Clearing](https://github.com/wp-media/wp-rocket-helpers/raw/master/cache/wp-rocket-no-cache-auto-purge/wp-rocket-no-cache-auto-purge.zip)

## 2. Disable Cache Lifespan

Go to WP-Rocket Settings > Cache > Cache Lifespan > Set to 0

## 3. Disable WP_CRON from WordPress

Since you will use a real server cron job instead of the native cron job functionality, you can save server resources by disabling **WP_CRON**.

To make this happen, insert the following code snippet inside your **wp-config.php** before the "/* Happy publishing */" line:

```
define('DISABLE_WP_CRON', true);
```

It should look like this:

```
define('DISABLE_WP_CRON', true);

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
  define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
```

## 4. Upload PHP file to your WordPress root folder

[Download](https://github.com/mnlgmz/wp-rocket/archive/refs/heads/main.zip) this PHP File and upload to your root directory (where wp-config.php and wp-load.php are located).

Here is a short video so you can see where it should be uploaded: http://recordit.co/jbtM0WPfcw

If you installed WordPress in a different location, make sure to edit the path to match its location, for instance:

```
require( 'installation-folder/wp-load.php' );
```

> :bulb: **Don't forget** to upload this file where **wp-config.ph**p and **wp-load.php** are located.

## 5. Set up a Cron Job

Since you will disable the automatic cache clearing using the plugin mentioned in step #1, the content will not be updated on the website until you manually clear the cache. 

To manually clear the cache at a specific time each day, you need to create a cron job on your server. We understand each server has different ways to add cron jobs, so if you are not sure how to do that, you can ask your hosting provider to assist you here.

If you are using cPanel, you can follow this video to create the cron job: https://recordit.co/A4Jj1Kg7x9

Set the custom time and use this command below to clear WP-Rocket Cache at the desired time.

```
wget -q -O - https://example.com/rocket-clear-cache.php >/dev/null 2>&1
```

## 6. Troubleshooting

### Testing PHP File

Try to load the PHP file and check if the cache is cleared:

https://example.com/rocket-clear-cache.php

If the cache is cleared, we can confirm the PHP file is not the culprit, and a cron job misconfiguration could causing the issue.


### Check cron log files

By default, in Ubuntu, the cron jobs log is located at **/var/log/syslog**. We can use the command below to check for any cron entries in that file:


```
sudo grep cron /var/log/syslog
```

### Check if cron is running

We can check if the cron is running on the server. If you are using Ubuntu, you can use the following command to check the cron status:

```
sudo service cron status
```

If cron is running, you might get a message like this:
```
sudo@wprocket:~$ sudo service cron status
● cron.service - Regular background program processing daemon
   Loaded: loaded (/lib/systemd/system/cron.service; enabled; vendor preset: ena
   Active: active (running) since Sun 2021-06-06 16:46:05 EDT; 2 months 15 days
   Docs: man:cron(8)
   Main PID: 759 (cron)
   Tasks: 1 (limit: 4657)
   CGroup: /system.slice/cron.service
           └─759 /usr/sbin/cron -f
```

### Check if the cron job was created
The next step you would do is check if the cron job was created. To get a list of all cron jobs for the user you are currently logged in as, use the crontab command:

```
crontab -l
```

If the client created the cron job, you would see it there. If not, you will get a message like this:

```
sudo@wprocket:~$ crontab -l
no crontab for sudo
```

If there is no cron created, you can create the cron job using the following command:

```
crontab –e
```

Assuming the user wants to run the cron job at midnight, you can use the following command:

```
MAILTO=email@example.com
0 0 * * * wget -q -O - https://example.com/rocket-clear-cache.php >/dev/null 2>&1
```

## 7. Still need help? :rocket: 
Support for WP Rocket is our business. :man_technologist: :wave:
- **Got a valid license for WP Rocket?** Feel free to use our dedicated [contact form!](https://wp-rocket.me/contact/?nocache)
- **Don’t own a valid license?** You can get one [right here!](https://wp-rocket.me/pricing/)
