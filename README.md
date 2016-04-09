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

```
php bin/magento dev:builder
```

Follow the wizzard
```
Enter the name of the master table (already created in database): adm_pointofsale_copy
Enter the name of the module table (will be created by the module, default: adm_pointofsale_copy): adm_pointofsale
Enter the main classname in lower case with underscore (default: adm_pointofsale): shop
Enter the namespace of the module. (default: YourCompany\YourModule): ADM\PointOfSale
Enter the routename of the module. (default: admpointofsale): pointofsale
```

Let's go
```
Building module files
-- ADM/PointOfSale/Api/Data/ShopInterface.php
-- ADM/PointOfSale/Block/Adminhtml/Shop/Edit.php
-- ADM/PointOfSale/Block/Adminhtml/Shop/Edit/Form.php
-- ADM/PointOfSale/Block/Shop/Index.php
-- ADM/PointOfSale/Block/Shop/View.php
-- ADM/PointOfSale/Controller/Adminhtml/Shop/Delete.php
-- ADM/PointOfSale/Controller/Adminhtml/Shop/Edit.php
-- ADM/PointOfSale/Controller/Adminhtml/Shop/Index.php
-- ADM/PointOfSale/Controller/Adminhtml/Shop/NewAction.php
-- ADM/PointOfSale/Controller/Adminhtml/Shop/Save.php
-- ADM/PointOfSale/Controller/Shop/Index.php
-- ADM/PointOfSale/Controller/Shop/View.php
-- ADM/PointOfSale/Helper/Shop.php
-- ADM/PointOfSale/Model/ResourceModel/Shop.php
-- ADM/PointOfSale/Model/ResourceModel/Shop/Collection.php
-- ADM/PointOfSale/Model/Shop.php
-- ADM/PointOfSale/Setup/InstallSchema.php
-- ADM/PointOfSale/Ui/Component/Listing/Column/ShopActions.php
-- ADM/PointOfSale/composer.json
-- ADM/PointOfSale/etc/acl.xml
-- ADM/PointOfSale/etc/adminhtml/menu.xml
-- ADM/PointOfSale/etc/adminhtml/routes.xml
-- ADM/PointOfSale/etc/config.xml
-- ADM/PointOfSale/etc/di.xml
-- ADM/PointOfSale/etc/frontend/routes.xml
-- ADM/PointOfSale/etc/module.xml
-- ADM/PointOfSale/registration.php
-- ADM/PointOfSale/view/adminhtml/layout/pointofsale_shop_edit.xml
-- ADM/PointOfSale/view/adminhtml/layout/pointofsale_shop_index.xml
-- ADM/PointOfSale/view/adminhtml/ui_component/pointofsale_shop_listing.xml
-- ADM/PointOfSale/view/frontend/layout/pointofsale_shop_index.xml
-- ADM/PointOfSale/view/frontend/layout/pointofsale_shop_view.xml
-- ADM/PointOfSale/view/frontend/templates/list.phtml
-- ADM/PointOfSale/view/frontend/templates/view.phtml
 ------------
In order to test your new module you have to:
1. copy module folder from var/tmp to app/code
2. run "bin/magento setup:upgrade" from the Magento root directory
3. check install visiting the url /pointofsale/shop
```

That'all. Your module should be working

# Changelog

0.2.2
* Add pager on frontend list
* Add breadscrumb
* Class renaming to fit coding standards

0.2.1
* Add adminhtml

0.2.0
* Change command line
* Add full functional module frontend files

0.1.0
*  module initialization 
