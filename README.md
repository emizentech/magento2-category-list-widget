# Category List Widget for Magento 2

## Features
* Display a list of store categories, anywhere you can place a widget.
* Optionally, displays images for categories
* Size of images can be adjusted from the widget settings in the admin panel.
* By default, shows the child categories under the store's root category
* Can be configured to display any category's children

## Composer Installation Instructions
First you must add the GIT Repository to composer by running this command
```
composer config repositories.emizentech-magento2-category-widget vcs https://github.com/ParamountVentures/magento2-category-list-widget/
```

Then, to install the module, run these commands
```
composer require magento/magento-composer-installer
composer require emizentech/categorywidget
```

## Manual Installation Instructions
First, create the directory structure for the module:
```
mkdir -p Magento2Project/app/code/Emizentech/CategoryWidget
```
*In our example, the Magento 2 files are stored in `Magento2Project`. Your Magento 2 installation path is probably different, so be sure to replace `Magento2Project` with your own path.*

### Enable Emizentech/CategoryWidget Module
To Enable this module you need to follow these steps:

1. **Enable the Module**
```
bin/magento module:enable Emizentech_CategoryWidget
```
2. **Run Upgrade Setup**
```
bin/magento setup:upgrade
```
3. **Re-Compile** (if you have compilation enabled)
```
bin/magento setup:di:compile
```