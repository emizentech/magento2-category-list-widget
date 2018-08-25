# Category List Widget for Magento 2

## Features
* Display a list of store categories, anywhere you can place a widget.
* Optionally, displays images for categories
* Size of images can be adjusted from the widget settings in the admin panel.
* By default, shows the child categories under the store's root category
* Can be configured to display any category's children
* Sub-Categories can be rendered as pages.

# Usage
Most of the functionalty is self-evident in Widget Options page when inserting the widget. Below is any further useful tips.

### Parent Category Id (optional)
Set this to the Id of the catergory whose children you want to list. This id can be found at the top of the Category management page.

### Category as Page (optional)
By default, the list of categories rendered link to a category page that shows the products within that category. Sometimes I can be useful to link to a page that shows the sub-categories rather than the products (e.g. The "pizzas" category shows a list of pizza categories rather than the pizzas themselves).

Adding a comma separated list of ant category id's that should be rendered as a page will create a link to a page name that is the same as the category name - you should then create that page in the CMS and you can add another widget that renders the products themselves (using the category id as above).

# Installation

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