Kayako2Wordpress
================

* Contributors: sierag
* Tags: kayako, knowledgebase, tickets, kb, fusion
* Requires at least: 3.3.1
* Tested up to: 3.3.1

List flagged Kayako tickets in Wordpress for processing tickets content your Wordpress website.

Description
-----------
This plugin works on the Kayako REST PHP API and imports all tickets from Kayako with your specific given tag.
In the tools menu you can see all that tickets with that specific tag as an todolist view. You now can do two
things with that tickets:

* Remove them from the todolist by rejecting the ticket (giving a reason for dooing this) 
* Remove them from the todolist by mark the ticket as done (giving feedback about this ticket).

In both cases you will be able to remove the tags or add new ones so you can track the tickets back in Kayako.

Installation
------------

1. Upload Kayako2Wordpress directory to the `/wp-content/plugins/` directory. Or if you would like to use git go to `/wp-content/plugins/` and `git clone https://github.com/Cysource/kayako2wordpress.git` and your done.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Make sure you insert the right settings in the settingsmenu.

Screenshots 
-----------
Screenshot of basic activation within the plugins menu.

![Plugin Activation](https://raw.github.com/Cysource/kayako2wordpress/master/img/activate.png)

This is the settings page, ony for admins.

![Plugin Activation](https://raw.github.com/Cysource/kayako2wordpress/master/img/addsettings.png)

Here you can see that you can edit a ticket, ony small details can be changed.

![Plugin Activation](https://raw.github.com/Cysource/kayako2wordpress/master/img/action.png)


Resources Used
===============
* [Kayako PHP API Library v.1.1.1.](http://forge.kayako.com/projects/kayako-php-api-library)

[![endorse](http://api.coderwall.com/sierag/endorsecount.png)](http://coderwall.com/sierag)