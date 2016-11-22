=== RETAILER TODAY GROUP API PLUGIN ===
Contributors: RETAILER TODAY GROUP
Donate link: www.retailertoday.com
Tags: WooCommerce
Requires at least:  3.0.1
Tested up to: 3.5.1
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The RETAILER TODAY GROUP DEALER API is a plugin thats connecting vendors and dealers.
We collaborate with vendors in the Retail branche in the Netherlands and provide retailers a low-cost solution to bring their business online.

== Description ==
The RETAILER TODAY GROUP DEALER API is a plugin thats connecting vendors and dealers.
We collaborate with vendors in the Retail branche in the Netherlands and provide retailers a low-cost solution to bring their business online.

The plugin taking care for the orders and product information.

This is Custom standalone plugin which totally based upon Woocommerce. This plugin is intermediate between different vendors to dealer. This plugin uses Woocommerce Rest Api for getting all products of particular brands from vendor site to dealer site. This is simple plugin which get all products from one woocommerce site using woocommerce rest api to another woocommerce site.


= Requirement: =
1. Wordpress 4.5.3 or higher.
2. Woocommerce 2.6.4 or higher.
3. Woocommerce API keys.

= Woocommerce REST API =

To get one woocommerce site products to another woocommerce site, requires woocommerce  REST api. Representational State Transfer (REST) is an architectural style used for web development. Systems and sites designed using this style aim for fast performance, reliability and the ability to scale (to grow and easily support extra users). 

= Working: = 
 Module 1.
1.User can get all products which are stored on vendor site. To get product user will need to save vendors details like woocommerce api keys,brands at dealer site. This plugin check which vendor is registered at dealer site and authenticate that vendor by vendor woocoomerce api keys.

2. If vendor site will be successfully authenticated then it check order setting, if order setting is not selected then it gives error and send mail to user from  service@retailertoday.com to select order setting. If order setting is selected then it goes to step 3.

3. Now, Plugin will match brands at both site, and extracts the products of matching brands and proceed to step 4.

4. After Extraction of products plugin will save all products with all information at dealer site and check order setting value
	1. If Order Setting==1, then directly vendor stock will updated product stock .
	2. If Order Setting==2, then only dealer site stock will updated,main stock will not updated directly.
5. If Order Setting==3,then combination of vendor stock and dealer stock will updated at main stock of product.

 Module 2.
1. When orders created at dealer site, then it check first order setting:
	1. If order setting==1,then it check product in order is belongs to any vendor or that product 	is dealer own product.If products in order belongs to vendor then order directly goes to vendor.

	2.If order setting==2,then it check product in order is belongs to any vendor or that product 	is dealer own product.If products in order belongs to vendor then it checks that products 	custom dealer stock. If order quantity is present in deler stock then order is processed.

	3. If order setting==3,then it check product in order is belongs to any vendor or that product 	is dealer own product.If products in order belongs to vendor then it checks that product delar stock. If product order quantity=5,and dealer stock of that product is 2 then remaining 3 products are send to vendor site and 2 quantity of that product is processed by dealer.

== Installation ==

1. Download and install the plugin from WordPress dashboard. You can also upload the entire “Vendor-Products” folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the ‘Plugins’ menu in WordPress
3. back to dashboard and in menu side you have seen vendor product option from here you can use our plugin 

== Frequently asked questions ==
= Is this plugin tested work with SEO by Yoast =

Yes.

= What about support? =

Create a support ticket at WordPress forum and I will take care of any issue.

== Upgrade Notice ==

= 1.0 =
Upgrade notices describe the reason a user should upgrade.  No more than 300 characters.

== Screenshots ==

1. screenshot-1.png
2. screenshot-2.png
3. screenshot-3.png
4. screenshot-4.png

== Changelog ==
1.0 – Plugin Launched.We collaborate with vendors in the Retail branche in the Netherlands and provide retailers a low-cost solution to bring their business online.


== Upgrade notice ==



== Arbitrary section 1 ==


