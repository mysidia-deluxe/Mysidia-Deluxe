# Mysidia-Deluxe
Mysidia Deluxe is an open-source custom version of the [Mysidia Adoptables](http://mysidiaadoptables.com/) framework, based off of v1.3.4 and maintained by the community.
## Features
This version overhauls and adds many things, including:
- [x] Bugfixes (like the "rn" issue, and reading other user's PMs)
- [ ] Smoother installation
- [ ] AJAX support
- [x] Reskinned ACP for a more modern look
- [x] 4 brand new themes (2 using Bootstrap 4 and 2 using CSS grids)
- [ ] Overhauled trade system
- [ ] Auction and Raffle system
- [ ] User shops
- [ ] Built-in forum (a forum right on the site, not SMF or myBB)
- [ ] Layered pet image support
- [ ] Bank system
- [ ] Cronjobs
- [x] More HTML (no formbuilders or tablebuilders, html will be used instead)
- [x] More comments in the code, so it's easier to understand what's going on
- And more to come!

## Server Requirements
- PHP 5.3.0+ (5.4 is recommended)
  - *Will not work on PHP 7*
- PDO support
- (optional) Imagick support. Layered pet images won't work without it.
- (optional) A little PHP knowledge is advised if you wish to expand and add your own features (like custom pages).
- (optional) Cronjob support (won't be able to use cronjob features without it)

## Download information
If you already built a site using Mysidia v1.3.4 or below and plan to use this version, it is recommended to backup your old site and use Mysidia Deluxe as a fresh install. That being said, all features in this version are compatible with sites running v1.3.4. If you have some PHP knowledge and wish to upgrade without reinstallation, see the "Updating to a new Mysidia Deluxe version" section below.

If you're planning to use Mysidia Deluxe for a new site, please use the latest version from the releases section. Releases are finalized and you are less likely to run bugs caused by newly added features.

## Updating to a new Mysidia Deluxe version (or upgrading from v1.3.4)
If you used Mysidia Deluxe in the past and a new version is released, you can select the latest branch and use the files to update your own. Make sure you don't forget the related files! It's not really recommended to completely overwrite your old file with the latest one without making a backup, since it will erase any changes that you made to the original code.

This script is completely free to use. The [original ToS](http://www.mysidiaadoptables.com/tos.php) still applies here, and you may use this script for a commercial site. **You are not allowed to sell the script itself.**
