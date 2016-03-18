Developer Builder for Magento2
====================================

# About

This module add commands to the bin/magento utility in order to easily create specific classes
This use database of magento database

This extension is based on the [Magento 2 module from scratch tutorial](https://github.com/ashsmith/magento2-blog-module-tutorial) from [Ash Smith](https://www.ashsmith.io)


# Use

First, you have to create the table in database for your module, then the commands will use a sql describe to generate classes


## InstallSchema Class

```
php bin/magento dev:builder:schema admin_user Magento\\User
```

will generate the InstallSchema class for the Magento_User module

```php
use Magento\User\Setup

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();
        /**
         * Create table 'admin_user'
         */
        $table = $installer->getConnection()
        ->newTable($installer->getTable('admin_user'))
        ->addColumn(
                'user_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'primary' => true, 'unsigned' => true, 'nullable' => false],
                'user_id'
        )
        ->addColumn(
                'firstname',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                32,
                [],
                'firstname'
        )

...
```

## Interface Class

```
php bin/magento dev:builder:interface admin_user Magento\\User
```

will generate the Interface class for the Magento_User module


```php
use Magento\User\Api\Data

interface AdminUserInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
        
    const USER_ID             = 'user_id';
    const FIRSTNAME           = 'firstname';
    const LASTNAME            = 'lastname';
    const EMAIL               = 'email';
    const USERNAME            = 'username';
    const PASSWORD            = 'password';
    const CREATED             = 'created';
    const MODIFIED            = 'modified';
    const LOGDATE             = 'logdate';
    const LOGNUM              = 'lognum';
    const RELOAD_ACL_FLAG     = 'reload_acl_flag';
    const IS_ACTIVE           = 'is_active';
    const EXTRA               = 'extra';
    const RP_TOKEN            = 'rp_token';
    const RP_TOKEN_CREATED_AT = 'rp_token_created_at';
    const INTERFACE_LOCALE    = 'interface_locale';
    const FAILURES_NUM        = 'failures_num';
    const FIRST_FAILURE       = 'first_failure';
    const LOCK_EXPIRES        = 'lock_expires';

    /**
     * Get user_id
     *
     * @return int|null
     */
    public function getUserId();


    /**
     * Set user_id
     *
     * @param int $user_id
     * @return Magento\User\Api\Data\AdminUserInterface
     */
    public function setUserId($user_id);

        

...
```

## Next

Other classes will come soon
