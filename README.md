# magento2-category-list-widget

#Features
<ul>
<li>Add Category List Any Where</li>
<li>Automatic Pick Default Store Category as Parent</li>
<li>Category Image into List</li>
<li>Can Manage Image Size</li>
<li>Can Assign Custom Parent Category</li>
</ul>

<h2>Composer Installation Instructions</h2>
Add GIT Repository to composer
<pre>
composer config repositories.harriswebworks-magento2-category-widget vcs https://github.com/harriswebworks/magento2-category-list-widget/
</pre>

After that, need to install this module as follows:
<pre>
  composer require magento/magento-composer-installer
  composer require harriswebworks/categorywidget
</pre>


<br/>
<h2> Mannual Installation Instructions</h2>
go to Magento2Project root dir 
create following Directory Structure :<br/>
<strong>/Magento2Project/app/code/Harriswebworks/CategoryWidget</strong>
you can also create by following command:
<pre>
cd /Magento2Project
mkdir app/code/Harriswebworks
mkdir app/code/Harriswebworks/CategoryWidget
</pre>



<h3> Enable Harriswebworks/CategoryWidget Module</h3>
to Enable this module you need to follow these steps:

<ul>
<li>
<strong>Enable the Module</strong>
<pre>bin/magento module:enable Harriswebworks_CategoryWidget</pre></li>
<li>
<strong>Run Upgrade Setup</strong>
<pre>bin/magento setup:upgrade</pre></li>
<li>
<strong>Re-Compile (in-case you have compilation enabled)</strong>
	<pre>bin/magento setup:di:compile</pre>
</li>
</ul>

