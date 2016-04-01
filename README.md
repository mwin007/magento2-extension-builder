Developer Builder for Magento2
====================================

# About

This module add commands to the bin/magento utility in order to generate files for a functional module.

Make a functional module in double-quick time:
* create table in database
* launch magento command line

This extension is based on the [Magento 2 module from scratch tutorial](https://github.com/ashsmith/magento2-blog-module-tutorial) from [Ash Smith](https://www.ashsmith.io)


# Use

First, you have to create the table in database for your module, then the commands will use a sql describe to generate classes, templates and xml.


## InstallSchema Class

```
php bin/magento dev:builder
```

Follow the wizzard
```
Enter the name of the master table (already created in database): ashsmith_blog_post_copy
Enter the name of the module table (will be created by the module, default: ashsmith_blog_post_copy): ashsmith_blog_post     
Enter the main classname in lower case with underscore (default: ashsmith_blog_post): post
Enter the namespace of the module. (default: YourCompany\YourModule): Ashsmith\Blog
Enter the routename of the module. (default: ashsmithblog): blog
```

Let's go
```
Building module files
-- Ashsmith/Blog/Api/Data/PostInterface.php
-- Ashsmith/Blog/Block/Adminhtml/Post/Edit.php
-- Ashsmith/Blog/Block/Adminhtml/Post/Edit/Form.php
-- Ashsmith/Blog/Block/PostList.php
-- Ashsmith/Blog/Block/PostView.php
-- Ashsmith/Blog/Controller/Adminhtml/Post/Delete.php
-- Ashsmith/Blog/Controller/Adminhtml/Post/Edit.php
-- Ashsmith/Blog/Controller/Adminhtml/Post/Index.php
-- Ashsmith/Blog/Controller/Adminhtml/Post/NewAction.php
-- Ashsmith/Blog/Controller/Adminhtml/Post/Save.php
-- Ashsmith/Blog/Controller/Index/Index.php
-- Ashsmith/Blog/Controller/View/Index.php
-- Ashsmith/Blog/Helper/Post.php
-- Ashsmith/Blog/Model/ResourceModel/Post.php
-- Ashsmith/Blog/Model/ResourceModel/Post/Collection.php
-- Ashsmith/Blog/Model/Post.php
-- Ashsmith/Blog/Setup/InstallSchema.php
-- Ashsmith/Blog/Ui/Component/Listing/Column/PostActions.php
-- Ashsmith/Blog/composer.json
-- Ashsmith/Blog/etc/acl.xml
-- Ashsmith/Blog/etc/adminhtml/menu.xml
-- Ashsmith/Blog/etc/adminhtml/routes.xml
-- Ashsmith/Blog/etc/di.xml
-- Ashsmith/Blog/etc/frontend/routes.xml
-- Ashsmith/Blog/etc/module.xml
-- Ashsmith/Blog/registration.php
-- Ashsmith/Blog/view/adminhtml/layout/blog_post_edit.xml
-- Ashsmith/Blog/view/adminhtml/layout/blog_post_index.xml
-- Ashsmith/Blog/view/adminhtml/ui_component/blog_post_listing.xml
-- Ashsmith/Blog/view/frontend/layout/blog_index_index.xml
-- Ashsmith/Blog/view/frontend/layout/blog_view_index.xml
-- Ashsmith/Blog/view/frontend/templates/list.phtml
-- Ashsmith/Blog/view/frontend/templates/view.phtml
 ------------
In order to test your new module you have to:
1. copy module folder from var/tmp to app/code
2. run "bin/magento setup:upgrade" from the Magento root directory
3. check install visiting the url /blog
```

That'all. Your module should be working

## Next


