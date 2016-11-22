<?php
/*
Plugin Name: RETAILER TODAY GROUP API PLUGINs
Plugin URI:  www.retailertoday.com
Description: This describes my plugin in a short sentence
Version:     1.0
Author:      RETAILER TODAY GROUP
Author URI:  www.retailertoday.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
 
 RETAILER TODAY GROUP API PLUGIN is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
RETAILER TODAY GROUP API PLUGIN is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with RETAILER TODAY GROUP API PLUGIN. If not, see License https://www.gnu.org/licenses/gpl-2.0.html.

The RETAILER TODAY GROUP DEALER API is a plugin thats connecting vendors and dealers.
We collaborate with vendors in the Retail branche in the Netherlands and provide retailers a low-cost solution to bring their business online.

The plugin taking care for the orders and productinformation.
 
You should have received a copy of the GNU General Public License
along with Vendor. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/


ini_set('max_execution_time', 300);

			if ( ! defined( 'ABSPATH' ) ) {
				exit; // Exit if accessed directly.
			}

			foreach ( glob( plugin_dir_path( __FILE__ ) . "lib/*.php" ) as $file ) {
				include_once $file;
			}
			
			// Register our "book" custom post type
			
			if (!function_exists('wvpsrsinfo_setup_post_type')) { 
			function wvpsrsinfo_setup_post_type() {
			 	register_post_type( 'book', array( 'public' => 'true' ) );
			}
		
			add_action( 'init', 'wvpsrsinfo_setup_post_type' );
			}
		 
		 
			if (!function_exists('wvpsrsinfo_install')) { 
			function wvpsrsinfo_install() {
			 
			// Trigger our function that registers the custom post type
			wvpsrsinfo_setup_post_type();
			 
			 //Create Tables for plugin
				 global $wpdb;
				

				$srstable_name1 = $wpdb->prefix . 'product_vendors_data';
				$srstable_name2 = $wpdb->prefix . 'product_history';
				$srstable_name3 = $wpdb->prefix . 'product_attribute';
				$srstable_name4 = $wpdb->prefix . 'product_vendor_setting';
				$srstable_name5 = $wpdb->prefix . 'store_own_api_keys';
				$srstable_name6 = $wpdb->prefix . 'product_brands_details';
				
				$charset_collate = $wpdb->get_charset_collate();

				if($wpdb->get_var("SHOW TABLES LIKE '$srstable_name1'") != $srstable_name1) {
					$sql = "CREATE TABLE $srstable_name1  (
						id mediumint(9) NOT NULL AUTO_INCREMENT,
						vendor_id int(11) NULL,
						vendor_product_id int(11) NULL,
						store_product_id int(11) NULL,
						json longtext NULL,
						product_image longtext NULL,
						created_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
						updated_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
						flag int(11) NULL,
						UNIQUE KEY id (id)
					) $charset_collate;";
					 $wvpsrsinfo_url1=admin_url('includes/upgrade.php');
					 //require_once($srs_url1);
					require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
					dbDelta( $sql );
				}

				if($wpdb->get_var("SHOW TABLES LIKE '$srstable_name2'") != $srstable_name2) {
					$sql = "CREATE TABLE $srstable_name2 (
						id mediumint(9) NOT NULL AUTO_INCREMENT,
						vendor_id int(11) NULL,
						product_json longtext NULL,
						flag varchar(20) NULL,
						date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
						UNIQUE KEY id (id)
					) $charset_collate;";
					$wvpsrsinfo_url1=admin_url('includes/upgrade.php');
					require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
					dbDelta( $sql );
				}

				if($wpdb->get_var("SHOW TABLES LIKE '$srstable_name3'") != $srstable_name3) {
					$sql = "CREATE TABLE $srstable_name3 (
						id mediumint(9) NOT NULL AUTO_INCREMENT,
						vendor_id int(11) NULL,
						vendor_product_id int(11) NULL,
						attribute_json longtext NULL,
						date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
						UNIQUE KEY id (id)
					) $charset_collate;";
					$wvpsrsinfo_url1=admin_url('includes/upgrade.php');
					require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
					dbDelta( $sql );
				}
				
				if($wpdb->get_var("SHOW TABLES LIKE '$srstable_name4'") != $srstable_name4) {
					$sql = "CREATE TABLE $srstable_name4 (
						id mediumint(9) NOT NULL AUTO_INCREMENT,
						active_preference int(11) NULL,
						user_id int(11) NULL,
						UNIQUE KEY id (id)
					) $charset_collate;";
					$wvpsrsinfo_url1=admin_url('includes/upgrade.php');
					require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
					dbDelta( $sql );
				}
				if($wpdb->get_var("SHOW TABLES LIKE '$srstable_name5'") != $srstable_name5) {
					$sql = "CREATE TABLE $srstable_name5 (
						id int(11) NOT NULL AUTO_INCREMENT,
						store_consumer_key longtext NULL,
						store_secret_key longtext NULL,
						code varchar(50) NULL,
						UNIQUE KEY id (id)
					) $charset_collate;";
					$wvpsrsinfo_url1=admin_url('includes/upgrade.php');
					require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
					dbDelta( $sql );
				}
				if($wpdb->get_var("SHOW TABLES LIKE '$srstable_name6'") != $srstable_name6) {
					$sql = "CREATE TABLE $srstable_name6 (
						id int(11) NOT NULL AUTO_INCREMENT,
						vendor_id int(11) NULL,
						brand_json longtext NULL,
						UNIQUE KEY id (id)
					) $charset_collate;";
					$wvpsrsinfo_url1=admin_url('includes/upgrade.php');
					require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
					dbDelta( $sql );
				}
				
				// Clear the permalinks after the post type has been registered
				wvpsrsinfo_my_plugin_setting();
				flush_rewrite_rules();

			 
			}
			register_activation_hook( __FILE__, 'wvpsrsinfo_install' );
			}
		
		
			if (!function_exists('wvpsrsinfo_my_plugin_setting'))
			{ 
			function  wvpsrsinfo_my_plugin_setting()
			{
				global $wpdb;

				$qry1 =''; 
				$records_total = $wpdb->get_results($wpdb->prepare("SELECT * FROM %s",'wp_product_vendors_data'));
				if(count($records_total)==0){
					$records_posts = $wpdb->get_results($wpdb->prepare("SELECT * FROM wp_posts WHERE post_type =%s",'product'));
					if(count($records_posts)>0){
						foreach($records_posts as $v){
							update_post_meta($v->ID,"product_from","dealer",$prev_value='');
						}
					}
				}else{
					$records_posts = $wpdb->get_results("SELECT wp.ID,wp.post_title FROM wp_posts wp WHERE  NOT EXISTS (SELECT 1 FROM   wp_product_vendors_data wpm WHERE  wp.ID = wpm.store_product_id ) AND wp.post_title !='Auto Draft' AND wp.post_type='product'"  , OBJECT);
					if(count($records_posts)>0){
						foreach($records_posts as $v){
							update_post_meta($v->ID,"product_from","dealer",$prev_value='');
						}
					}
					
				}
			}

			}
	
	
			if (!function_exists('wvpsrsinfo_cronstarter_activation')) 
			{ 
	
			function wvpsrsinfo_cronstarter_activation() {
				if( !wp_next_scheduled( 'cron_job' ) ) {  
				   wp_schedule_event( time(), 'daily', 'cron_job' );  
				}
			}

			add_action('wp', 'wvpsrsinfo_cronstarter_activation');
			}

			if (!function_exists('wvpsrsinfo_cronstarter_activation')) 
			{ 
				function wvpsrsinfo_cron_repeat_function(){
				wvpsrsinfo_vendor_db();
			
			}

			add_action ('cron_job', 'wvpsrsinfo_cron_repeat_function'); 
			}
			
			if (!function_exists('wvpsrsinfo_deactivation')) 
			{
			function wvpsrsinfo_deactivation() {
				flush_rewrite_rules();
			}
			register_deactivation_hook( __FILE__, 'wvpsrsinfo_deactivation' );
			}
			
			
			if (!function_exists('wvpsrsinfo_cronstarter_deactivate')) 
			{
			function wvpsrsinfo_cronstarter_deactivate() {	
				$timestamp = wp_next_scheduled ('cron_job');
				wp_unschedule_event ($timestamp, 'cron_job');
			} 
			register_deactivation_hook (__FILE__, 'wvpsrsinfo_cronstarter_deactivate');
			}
			
			if (!function_exists('wvpsrsinfo_wc_custom_stock_product_field')) 
			{
			add_action( 'woocommerce_product_options_stock_status', 'wvpsrsinfo_wc_custom_stock_product_field' );
			function wvpsrsinfo_wc_custom_stock_product_field() {

				woocommerce_wp_checkbox( array( 'id' => 'manage_dealer_stock',  'label' => __( 'Manage Dealer Stock', 'woocommerce'),'description'   => __( 'Combination of stock enabled  in your order settings.Leave stock on 0 or blank if you dont have stock of product', 'woocommerce' )  )  ) ;

				woocommerce_wp_text_input( array( 'id' => 'dealer_stock', 'class' => 'wc_input_price short', 'label' => __( 'Dealer Stock Quantity', 'woocommerce' ) ) );
			}
			}
			
			
			if (!function_exists('wvpsrsinfo_wc_rrp_save_product')) 
			{
			add_action( 'save_post', 'wvpsrsinfo_wc_rrp_save_product' );
			function wvpsrsinfo_wc_rrp_save_product( $product_id ) {
				// If this is a auto save do nothing, we only save when update button is clicked
				if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
					return;
				if (isset($_POST['dealer_stock'])){
					if ( is_numeric($_POST['dealer_stock'] ) )
						
						if($_POST['dealer_stock']!=""){
							$dStock = $_POST['dealer_stock'];
						}else{
							$dStock = 0;
						}
						
						$stock_updated = floatval(get_post_meta($product_id, '_stock', true))+floatval($dStock);
						$order_id = wvpsrsinfo_get_order_setting();
						if($order_id == 3){
							update_post_meta( $product_id, '_stock', floatval($stock_updated) );
							if($stock_updated!="" || $dStock!=0){
								update_post_meta( $product_id, '_stock_status','instock',$prev_value='');
							}
						}
						if($order_id == 2){
							update_post_meta( $product_id, '_stock', sanitize_text_field($_POST['dealer_stock']));
							if(isset($_POST['dealer_stock'])){
								update_post_meta( $product_id, '_stock_status','instock',$prev_value='');
							}
						}
						
					update_post_meta( $product_id, 'dealer_stock', sanitize_text_field($_POST['dealer_stock'])) ;
				} else delete_post_meta( $product_id, 'dealer_stock' );
			}
			}
			
			if (!function_exists('wvpsrsinfo_vendor_setup_menu')) 
			{
			add_action('admin_menu', 'wvpsrsinfo_vendor_setup_menu');
			function wvpsrsinfo_vendor_setup_menu(){
				   add_menu_page( 'Vendor Products', 'Vendor Products', 'manage_options', 'vendorproducts', 'wvpsrsinfo_vendorproduct_display','dashicons-products');
			}
			}
			
			if (!function_exists('wvpsrsinfo_vendorproduct_basicjscss')) 
			{
			function wvpsrsinfo_vendorproduct_basicjscss(){	
				wp_register_style( 'jquicss', plugins_url('css/bootstrap.min.css', __FILE__) );
				wp_enqueue_style( 'jquicss' );   
				wp_register_script( 'jquibootstrap', plugins_url( 'js/bootstrap.min.js' , __FILE__ ) );
				wp_enqueue_script( 'jquibootstrap' );
				wp_enqueue_script('jquery');   
                              
			}
			add_action( 'wp_enqueue_scripts', 'wvpsrsinfo_vendorproduct_basicjscss' ); 
			add_action( 'admin_enqueue_scripts', 'wvpsrsinfo_vendorproduct_basicjscss' ); 
			}

			if (!function_exists('wvpsrsinfo_vendorproduct_display')) 
			{
			function wvpsrsinfo_vendorproduct_display()
			{
				global $wpdb;
				
                                 echo '<div id="loading">
				  <img id="loading-image" src="'.plugins_url( 'assets/loading.gif', __FILE__ ).'" alt="Loading..." />
				</div>
			<style>
			#loading {width: 100%;height: 100%;top: 0px;left: 200px;position:relative;display:block;opacity:0.7;background-color: #fff;z-index: 99;text-align: center;}
			#loading-image {position: absolute; top: 100px;left: 240px;z-index: 100;}
			</style>';
				
				 $dealer = get_option( 'siteurl' );
				  if(isset($_GET['savekeys']))
				 {
				 $wocom_apikey = wvpsrsinfo_cvf_convert_object_to_array($wpdb->get_results($wpdb->prepare( "SELECT consumer_key,consumer_secret FROM wp_woocommerce_api_keys WHERE description = %s", sanitize_text_field($_POST['description']))));
					if($wocom_apikey[0]['consumer_secret']==$_POST['secret_key'] && $wocom_apikey[0]['consumer_key']==wc_api_hash( $_POST['consumer_key'] )){
						$wpdb->insert('wp_store_own_api_keys',
							array('store_consumer_key' =>sanitize_text_field($_POST['consumer_key']),
							'store_secret_key' =>sanitize_text_field($_POST['secret_key']),'code'=>sanitize_text_field($_POST['store_code'])),array('%s','%s','%s'));  		
						$lastid = $wpdb->insert_id;
						if(isset($lastid)){
						echo '<br><div class="alert alert-success" style="width:700px">WooCommerce API Keys are Saved Successfully!Thank You!.</div>';
						echo 'Your Dealer Code is '.sanitize_text_field($_POST['store_code']);
						
						}
					}else{
						echo '<br><div class="alert alert-danger" style="width:700px">Invalid WoCommerce API Keys.</div>';
					}
				 }
				 
				//Check Woocommerce store api keys are availble in our database
				
				$store_apikey = $wpdb->get_results("SELECT * FROM wp_store_own_api_keys");
				if(count($store_apikey)==0)
				{
				
					echo '<br><h3>Enter Your WooCommerce API Keys</h3><br> 
					<form method="post" action="'.admin_url('admin.php?page=vendorproducts&savekeys=1').'">
					<div><div class="form-group">
					  <label>KEY DESCRIPTION:</label>
					  <input type="text" class="form-control" name="description" id="desc" style="width:500px" required>
					</div>
					<div><div class="form-group">
					  <label>CONSUMER KEY:</label>
					  <input type="text" class="form-control" name="consumer_key" id="usr" style="width:500px" required>
					</div>
					<div class="form-group">
					  <label>SECRET KEY:</label>
					  <input type="text" class="form-control" name="secret_key" id="pwd" style="width:500px" required>
					</div>
					<div class="form-group">
					  <label>DEALER CODE:</label>
					  <input type="text" class="form-control" name="store_code" id="store_code" style="width:500px" required >
					</div>
					<div>If you dont know how to generate WooComerce keys then refer folowing link:<br><a target="_blank" href="https://docs.woothemes.com/document/woocommerce-rest-api/">https://docs.woothemes.com/document/woocommerce-rest-api/</a></div><br>
					<div><input type="submit" class="btn btn-primary" value="Save Keys" style="width:200px"></div>
					</div></form>';
				}
				else
				{
				 
				//when api keys are stored in our database
				
				$dealer_code =$wpdb->get_results("SELECT code FROM wp_store_own_api_keys");
				echo "<br><br><div style='text-align:left'>
					<a id='button1' href='".admin_url('admin.php?page=vendorproducts&vendorproductpage=1')."'>
						<button type='button'  class='btn btn-primary' style='height:50px'>Extract Products</button>
					</a>
					<a style='margin-left:50px;height:45px' href='".admin_url('admin.php?page=vendorproducts&vendorproductpage=2')."'>
					<button type='button'  class='btn btn-primary' style='height:50px'>Order Settings</button>
					</a>";
					
					echo "<a style='margin-left:50px;height:45px' href='".admin_url('admin.php?page=vendorproducts&vendorproductpage=3')."'>
						<button type='button'  class='btn btn-primary' style='height:50px'>Brand Settings</button>
					</a>";
					
					echo "<span style='margin-left:50px;width:200px;height:10px' class='alert alert-info'>Your Dealer Code is <strong> ".$dealer_code[0]->code."</strong></span>
				  </div>";
				  
				  if(isset($_GET['vendorproductpage']))
				  {
					if($_GET['vendorproductpage']==1){
					//Extract Data of vendor and store to our database
						wvpsrsinfo_vendor_db();
						
					}
					if($_GET['vendorproductpage']==2){
					//Product Setting 
						wvpsrsinfo_product_setting();
					}
					if($_GET['vendorproductpage']==3){
					//Brands Setting 
						wvpsrsinfo_product_brands_setting();
					}
				  }
				  
				  //For product setting saved successfuly.
				  if($_GET['success']== 1){
				  if(isset($_POST['optradio'])){
						
					$user_id = get_current_user_id();
					
					$setting_count = $wpdb->get_results($wpdb->prepare( "SELECT * FROM wp_product_vendor_setting"));
					$setting_d = wvpsrsinfo_cvf_convert_object_to_array($setting_count);
					
					if(count($setting_count)==0){
						$wpdb->insert('wp_product_vendor_setting',
						array('active_preference' => sanitize_text_field($_POST['optradio'])),array('%d'));  		
						$lastid = $wpdb->insert_id;
						if(isset($lastid)){
							echo '<br><div class="alert alert-success" style="width:700px">
							Product Setting Saved Successfully.
							</div>';
							
						}
					}else{
						$pchildstock = array();
						$pvariations = array();
						$pvar = 0;
						
						
						$sql =	$wpdb->prepare("UPDATE `wp_product_vendor_setting` SET `active_preference`= %s WHERE `id`=%d",sanitize_text_field($_POST['optradio']), $setting_d[0]['id']) ;
						
						$res = $wpdb->query($sql);

						if($_POST['optradio']== "2"){
							
							global $wpdb;
							$products = $wpdb->get_results($wpdb->prepare("SELECT * from wp_posts as wp,wp_product_vendors_data as wpvd WHERE wp.ID = wpvd.store_product_id AND post_type = %s AND post_status=%s",'product','publish'));
							$products = wvpsrsinfo_cvf_convert_object_to_array($products);
							
							foreach($products as $p){
								$pvariations =& get_children( 'post_type=product_variation&post_parent='.$p['ID'] );
								
								if(!empty($pvariations)){
									foreach($pvariations as $pv){
										$pchildstock[$pvar] = get_post_meta($pv->ID,'_variation_dealer_stock',true);
										update_post_meta($pv->ID,'_stock',$pchildstock[$pvar],$prev_value='');
										if($pchildstock[$pvar] !=''){
											update_post_meta($pv->ID,'_stock_status','instock',$prev_value='');
										}
										
										$pvar++;
									}
									$upstock = array_sum($pchildstock);
									update_post_meta($p['ID'],"_stock",$upstock,$prev_value='');
									 }else{
									$dealer_stock = get_post_meta($p['ID'],'dealer_stock',$single = false );
									update_post_meta($p['ID'],"_stock",$dealer_stock[0],$prev_value='');
									if($dealer_stock !='' || $dealer_stock != 0){
									update_post_meta($p['ID'],'_stock_status','instock',$prev_value='');
									}else{
									update_post_meta($p['ID'],'_stock_status','outofstock',$prev_value='');
									}
								}
							}
						}
						if($_POST['optradio']== "3"){
							global $wpdb;
							
							$products = $wpdb->get_results($wpdb->prepare("SELECT * from wp_posts as wp,wp_product_vendors_data as wpvd WHERE wp.ID =wpvd.store_product_id AND post_type = %s AND post_status=%s",'product','publish'));
							$products = wvpsrsinfo_cvf_convert_object_to_array($products);
							
							foreach($products as $p){
								$dealer_stock = get_post_meta($p['ID'],'dealer_stock',$single = false );
								$vendor_stock = get_post_meta($p['ID'],'vendor_stock',$single = false );
								$total_stock = floatval($dealer_stock[0])+floatval($vendor_stock[0]);
								update_post_meta($p['ID'],"_stock",$total_stock,$prev_value='');
								if($vendor_stock!='' || $total_stock !=''){
									update_post_meta($p['ID'],'_stock_status','instock',$prev_value='');
								}
								
								
								$pvariations =& get_children( 'post_type=product_variation&post_parent='.$p['ID'] );
								if(!empty($pvariations)){
									foreach($pvariations as $pv){
										$var_vendor_stock = "";
										$var_dealer_stock = "";
										$vstock = "";
										$var_vendor_stock = get_post_meta($pv->ID,'_variation_vendor_stock',true );
										$var_dealer_stock = get_post_meta($pv->ID,'_variation_dealer_stock',true );
										if($var_dealer_stock =="")
										{
											update_post_meta($pv->ID,'_stock',$var_vendor_stock,$prev_value='');
										}else{
											$vstock = floatval($var_vendor_stock)+floatval($var_dealer_stock);
											update_post_meta($pv->ID,'_stock',$vstock,$prev_value='');
										}
										if($var_vendor_stock !=''){
											update_post_meta($pv->ID,'_stock_status','instock',$prev_value='');
										}
									}
								}
							}
						}
						if($_POST['optradio'] == "1"){
							global $wpdb;
							$products = $wpdb->get_results($wpdb->prepare("SELECT * from wp_posts as wp,wp_product_vendors_data as wpvd WHERE wp.ID = wpvd.store_product_id AND post_type = %s AND post_status= %s",'product','publish'));
							$products = wvpsrsinfo_cvf_convert_object_to_array($products);
							
							foreach($products as $p){
								$dealer_stock = get_post_meta($p['ID'],'dealer_stock',$single = false );
								$vendor_stock = get_post_meta($p['ID'],'vendor_stock',$single = false );
								$total_stock = floatval($dealer_stock)+floatval($vendor_stock);
								update_post_meta($p['ID'],"_stock",$vendor_stock[0],$prev_value='');
								if($vendor_stock!=''){
									update_post_meta($p['ID'],'_stock_status','instock',$prev_value='');
								}

								$pvariations =& get_children( 'post_type=product_variation&post_parent='.$p['ID'] );
								if(!empty($pvariations)){
									foreach($pvariations as $pv){
										$v_vendor_stock = "";
										 $v_vendor_stock = get_post_meta($pv->ID,'_variation_vendor_stock',true );
										
										update_post_meta($pv->ID,'_stock',$v_vendor_stock,$prev_value='');
										if($v_vendor_stock !=''){
											update_post_meta($pv->ID,'_stock_status','instock',$prev_value='');
										}
									}
									
								}
							}
						}
						
						echo '<br><div class="alert alert-success" style="width:700px">
						Product Setting Saved Successfully.
						</div>';

					
					}
				  }
				  else{
					  echo '<br><div class="alert alert-danger" style="width:700px">
						Please Select Order Setting.
						 </div>';
						 echo '<br><form method="post" action="'.admin_url('admin.php?page=vendorproducts&success=1').'"><div style="text-align:left;font-size:20px;">
						 <div class="radio alert alert-success" style="width:500px">
						  <label><input type="radio" name="optradio" value="1" ';if($setting_id==1){ echo 'checked';}echo '>USE VENDOR STOCK FOR THE SHOP</label>
						</div>
						<div class="radio alert alert-success" style="width:500px">
						  <label><input type="radio" name="optradio" value="2" ';if($setting_id==2){ echo 'checked';}echo '>USE YOUR OWN STOCK</label>
						</div>
						<div class="radio alert alert-success" style="width:500px">
						  <label><input type="radio" name="optradio" value="3" ';if($setting_id==3){ echo 'checked';}echo '>USE COMBINATION OF STOCKS</label>
						</div>
						<div><a style="width:150px;font-size:18px" href="'.admin_url('admin.php?page=vendorproducts&success=1').'">
						<input type="submit" class="btn btn-primary" value="Save Settings"></a></div></form</div>';
					}
				  }
			  
				  //for saving brand details
				  if($_GET['success']==2){
					  $data = array();
					  for($k=1;$k<=count($_POST);$k++){
						  if($_POST['brand'.$k]!=null && $_POST['code'.$k] !=null){
							$data = array_merge($data, array($_POST['brand'.$k]=>$_POST['code'.$k]));
						  }
					}
					if(!empty($data)){
						$data = json_encode($data);
					}else{
						echo '<br><div class="alert alert-danger">
						Debtor Code should not blank.It is Mandatory!.
						</div>';
							
						$brand_data = $wpdb->get_results($wpdb->prepare("SELECT meta_value FROM wp_postmeta WHERE post_id=%d",sanitize_text_field($_GET['vendor_id'])));
						$brand_details = $wpdb->get_results($wpdb->prepare("SELECT brand_json FROM wp_product_brands_details WHERE vendor_id= %d", sanitize_text_field($_GET['vendor_id'])));
						$brand_details = wvpsrsinfo_cvf_convert_object_to_array($brand_details);
						$brand_details =json_decode($brand_details[0]['brand_json'],true);
						
						echo "<h4>Brands</h4><br>";
						echo "<form method='post' action='".admin_url('admin.php?page=vendorproducts&success=2&vendor_id='.$_GET["vendor_id"])."'> <table class='table'>
									<thead>
									  <tr>
										<th>Sr.No.</th>
										<th>Brand Name</th>
										<th>Debtor Code</th>
									  </tr>
									</thead>";
							
							if(count($brand_data)!=0)
								{
								$brand_data = wvpsrsinfo_cvf_convert_object_to_array($brand_data);
								
								foreach($brand_data as $bd)
								{	$j=1;
									$data = @unserialize($bd['meta_value']);
									if ($data !== false) {
									
									foreach($data as $bd){
									   echo "<tr>
											<td>".$j."</td>
											<td><input type='hidden' name='brand".$j."' value='".$bd[0]."'>".$bd[0]."</td>";
										if(!empty($brand_details)){
												if (array_key_exists($bd[0],$brand_details)){
													echo "<td><input type='text' name='code".$j."' value='".$brand_details[$bd[0]]."'/></td>";
												}
												else{
													echo "<td><input type='text' name='code".$j."' /></td>";
												}
											}
											else{
												 echo "<td><input type='text' name='code".$j."' /></td>";
											}
										   
										  echo "</tr>";
										
										$j++;
										}
									 }
								}
							}
							echo '</table>
							<a style="width:150px;font-size:18px" href="'.admin_url('admin.php?page=vendorproducts&success=2&vendor_id='.sanitize_text_field($_GET["vendor_id"])).'">
							<input type="submit" class="btn btn-success" value="Save Details"></a></form>';
							echo "<script language='javascript' type='text/javascript'>
									$('#loading').hide();
								</script>";
							exit;
					}


						
					$brand_details = $wpdb->get_results($wpdb->prepare("SELECT * FROM wp_product_brands_details WHERE vendor_id= %d",sanitize_text_field($_GET['vendor_id'])));
					if(count($brand_details)==0)
					{
						$wpdb->insert('wp_product_brands_details',
						array('vendor_id' => sanitize_text_field($_GET['vendor_id']),
						'brand_json' =>$data),array('%d','%s'));  		
						$lastid = $wpdb->insert_id;
						if(isset($lastid)){
							echo '<br><div class="alert alert-success">
							<strong>Brands Debtor Code</strong> Saved Successfully.
							</div>';
							wvpsrsinfo_product_brands_setting();
						}
					}else{
						
						
						$sql =$wpdb->prepare("UPDATE `wp_product_brands_details`
							SET `brand_json` = %s WHERE  `vendor_id` =%d",$data,sanitize_text_field($_GET['vendor_id']));
						$res = $wpdb->query($sql);
						if($res){
							echo '<br><div class="alert alert-success">
						<strong>Brands Debtor Code</strong> Saved Successfully.
						</div>';
						wvpsrsinfo_product_brands_setting();
						}
					}
				  }
				  //For showing vendor wise product list
				  if(isset($_GET["productvendorid"]))
				  {
						
					$total_db_records = $wpdb->get_results($wpdb->prepare("SELECT DISTINCT wp.ID,wp.post_title,wpm.meta_value FROM wp_product_vendors_data AS wvd, wp_posts AS wp,wp_postmeta AS wpm WHERE wvd.store_product_id = wp.ID AND wp.ID = wpm.post_id AND wp.post_status = %s AND wp.post_type =  %s AND wvd.vendor_id=%d AND wpm.meta_key =%s",'publish','product',sanitize_text_field($_GET["productvendorid"]),'_sku'));
					
					$total_db_records = json_encode($total_db_records);
					$total_db_records = json_decode($total_db_records,TRUE);
					
					
					  echo "<h4>Vendor No :".$_GET["productvendorid"]."</h4>";
						  echo "<br><br><div id='output' >
						  <table class='table'>
						  <tr>
						  <th>Product Id</th>
						 <th>Product Name</th>
						<th>Price</th>
						<th>Stock Status</th>
						<th>Stock</th>
						 </tr>";  
					foreach($total_db_records as $v){
						$min_price = get_post_meta($v["ID"],"_min_variation_price",true);
						$max_price = get_post_meta($v["ID"],"_max_variation_price",true);
						if($min_price !="" && $max_price!=""){
							$price = $min_price."-".$max_price;
						}else{
							$price = get_post_meta($v["ID"],"_price",true);
						}
			 
			$stock_count = $wpdb->get_results($wpdb->prepare("SELECT meta_value FROM wp_postmeta WHERE meta_key =%s AND post_id=%d",'stock_quantity',$v["ID"]));
			$stock_db_status = $wpdb->get_results($wpdb->prepare("SELECT meta_value FROM wp_postmeta WHERE meta_key =%s AND post_id= %d",'_stock_status',$v["ID"]));
						 echo "<tr>
						 <td>".$v['ID']."</td>
						 <td>".$v['post_title']."</td>
						 <td>".$price."</td>
						 <td>".$stock_db_status[0]->meta_value."</td>
						 <td>".$stock_count[0]->meta_value."</td>
						 <tr>
						  ";
					}
					echo "</table></div>";
				}
				if(isset($_GET['brandsID'])){
					$brand_data = $wpdb->get_results($wpdb->prepare("SELECT meta_value FROM wp_postmeta WHERE post_id= %d",sanitize_text_field($_GET['brandsID'])));
					
					$brand_details = $wpdb->get_results($wpdb->prepare("SELECT brand_json FROM wp_product_brands_details WHERE vendor_id= %d",sanitize_text_field($_GET['brandsID'])));
					
					$brand_details = wvpsrsinfo_cvf_convert_object_to_array($brand_details);
					$brand_details =json_decode($brand_details[0]['brand_json'],true);
					
					echo "<h4>Brands</h4><br>";
					echo "<form method='post' action='".admin_url('admin.php?page=vendorproducts&success=2&vendor_id='.$_GET["brandsID"])."'> <table class='table'>
								<thead>
								  <tr>
									<th>Sr.No.</th>
									<th>Brand Name</th>
									<th>Debtor Code</th>
								  </tr>
								</thead>";
						
						if(count($brand_data)!=0)
							{
							$brand_data = wvpsrsinfo_cvf_convert_object_to_array($brand_data);
							
							foreach($brand_data as $bd)
							{	$j=1;
								$data = @unserialize($bd['meta_value']);
								if ($data !== false) {
								
								foreach($data as $bd){
								   echo "<tr>
										<td>".$j."</td>
										<td><input type='hidden' name='brand".$j."' value='".$bd[0]."'>".$bd[0]."</td>";
										if(!empty($brand_details)){
											if (array_key_exists($bd[0],$brand_details)){
												echo "<td><input type='text' name='code".$j."' value='".$brand_details[$bd[0]]."'/></td>";
											}
											else{
												echo "<td><input type='text' name='code".$j."' /></td>";
											}
										}
										else{
											 echo "<td><input type='text' name='code".$j."' /></td>";
										}
									   
									  echo "</tr>";
									
									$j++;
									}
								 }
							}
						}else{
						echo "No Brands Found!";
						}
					
					echo '</table>
			<a style="width:150px;font-size:18px" href="'.admin_url('admin.php?page=vendorproducts&success=2&vendor_id='.$_GET["brandsID"]).'">
			<input type="submit" class="btn btn-success" value="Save Details"></a></form>';
				}
				}
				 echo "<script language='javascript' type='text/javascript'>
					jQuery('#button1').click( function() {
						jQuery('#loading').show();
					});
						jQuery(window).load(function() {
						jQuery('#loading').hide();
					});
					</script>";
			}

			}
		
		
			if (!function_exists('wvpsrsinfo_woo_add_custom_general_fields_save')) 
			{
		
			add_action( 'woocommerce_process_product_meta', 'wvpsrsinfo_woo_add_custom_general_fields_save' );
			function wvpsrsinfo_woo_add_custom_general_fields_save($data){
				$vendor_post = get_post_meta( $data, 'product_from', $single = false );
				if(empty($vendor_post) || $vendor_post==""){
					add_post_meta($data, "product_from", "dealer", $unique="");
				}
			}
			}
		
		
		
			
			if (!function_exists('wvpsrsinfo_order_info')) 
			{
		
			add_action( 'woocommerce_order_status_processing', 'wvpsrsinfo_order_info', 10, 1 );
			function wvpsrsinfo_order_info()
			{
			$order_id = wvpsrsinfo_get_order_setting();
				global $wpdb;
				$options = array(
					'debug'           => true,
					'return_as_array' => false,
					'validate_url'    => false,
					'timeout'         => 60,
					'ssl_verify'      => false,
					);
				$filters = array(
					'post_status' => 'wc_processing',
					'post_type' => 'shop_order',
					'posts_per_page' => 200,
					'paged' => 1,
					'orderby' => 'modified',
					'order' => 'ASC'
				);
				$loop = new WP_Query($filters);

				$vendor_order = array();
				$vendor_order_data = array();
				$product_data = array();
				$qty = "";
				$y=0;
				$dealer_keys = wvpsrsinfo_db_woocommerce_api_keys();

				$client=wvpsrsinfo_client_api($dealer_keys['url'],$dealer_keys['consumer_key'],$dealer_keys['secret_key'],$options);
				$order_data = $client->orders->get();
				$order_products = wvpsrsinfo_cvf_convert_object_to_array($order_data);
				$order_id = wvpsrsinfo_get_order_setting();

			
				$db_debtor_code = $wpdb->get_results($wpdb->prepare("SELECT code FROM wp_store_own_api_keys"));
				$vo=0;
				$var_meta = array();
				foreach($order_products as $op){
					$vendor_order[] = $op[0]['line_items'];
				}
				foreach($vendor_order as $li)
				{
					if(!empty($li)){
						foreach($li as $l){
							$var_meta[$vo]['product_id'] = $l['product_id'];
							$var_meta[$vo]['meta'] = $l['meta'];
							$vo++;
						}
					}
				}
				$order_product_ids = array();
				
				if($order_id == 1)
				{
					global $post;
					if (class_exists('WC_Order')) {
					$order = new WC_Order( $order_products['orders'][0]['id'] );
					}
					$items = $order->get_items();
					$od=0;
					foreach($items as $items){
						$order_product_ids['product_details'][$od]['product_id'] = $items['product_id'];
						$producttype = get_product($items['product_id']);
						$order_product_ids['product_details'][$od]['product_type'] =$producttype->product_type;
						$order_product_ids['product_details'][$od]['quantity'] =$items['qty'];
						$order_product_ids['product_details'][$od]['total'] =$items['line_total'];
						$order_product_ids['product_details'][$od]['subtotal'] =$items['line_subtotal'];
						$order_product_ids['product_details'][$od]['tax'] =$items['line_tax'];
						$order_product_ids['product_details'][$od]['variation_id'] =$items['variation_id'];
						$order_product_ids['product_details'][$od]['tax_class'] =$items['tax_class'];
						$order_product_ids['product_details'][$od]['meta'] =$var_meta[$od]['meta'];

						$od++;
					}
					
					foreach($order_product_ids['product_details'] as $odp){
						if($odp['product_type'] == 'simple'){
							wvpsrsinfo_order_for_simple_product($odp,$order_products);
						}else{
							wvpsrsinfo_order_for_variable_product($odp,$order_products);
						}
					}
				}
				
				if($order_id == 3)
				{
					global $post;
					if (class_exists('WC_Order')) {
					$order = new WC_Order( $order_products['orders'][0]['id'] );
					}
					$items = $order->get_items();
					$od=0;
					foreach($items as $items){
						$order_product_ids['product_details'][$od]['product_id'] = $items['product_id'];
						$producttype = get_product($items['product_id']);
						$order_product_ids['product_details'][$od]['product_type'] =$producttype->product_type;
						$order_product_ids['product_details'][$od]['quantity'] =$items['qty'];
						$order_product_ids['product_details'][$od]['total'] =$items['line_total'];
						$order_product_ids['product_details'][$od]['subtotal'] =$items['line_subtotal'];
						$order_product_ids['product_details'][$od]['tax'] =$items['line_tax'];
						$order_product_ids['product_details'][$od]['variation_id'] =$items['variation_id'];
						$order_product_ids['product_details'][$od]['tax_class'] =$items['tax_class'];
						$order_product_ids['product_details'][$od]['meta'] =$var_meta[$od]['meta'];

						$od++;
					}
					
					foreach($order_product_ids['product_details'] as $odp){
						if($odp['product_type'] == 'simple'){
							wvpsrsinfo_order_for_comb_simple_product($odp,$order_products);
						}else{
							wvpsrsinfo_order_for_comb_variable_product($odp,$order_products);
						}
					}
				}
			}
			}
		
			if (!function_exists('wvpsrsinfo_order_for_simple_product')) 
			{
			function wvpsrsinfo_order_for_simple_product($l,$order_products){
				global $wpdb;
				$vendor_order_data = array();
				$d = array();
				$d1 = array();
				$v_product_id = array();
				$brands_debtor_code = array();
				$k=0;
				
				$vendor_pro_id = wvpsrsinfo_pro_vendor_store_id($l['product_id']);
				$l['main_product_id'] = $l['product_id'];				
				$l['product_id'] = $vendor_pro_id[0]['vendor_product_id'];
				$l['brands'] = json_decode($vendor_pro_id[0]['json']);
				
				if(isset($l['brands']->Brands)){
					$l['brands'] = (array)$l['brands']->Brands;
				}else{
					$l['brands'] = (array)$l['brands']->Brand;
				}
				
				$vendor_order_data[] = $l;
				foreach($vendor_order_data as $vod)
				{
						$vendor_id = wvpsrsinfo_pro_vendor_id($vod['product_id']);
						if(in_array($vendor_id[0]['vendor_id'],$d))
						{
							$total = $total+$vod['total'];
							$subtotal = $subtotal+$vod['subtotal'];
							$quantity = $quantity+$vod['quantity'];
							$v_pro_id[0] = $v_product_id;
							unset($v_product_id);
							$v_pro_id[$k] = array("product_id"=>$vod['product_id'],"quantity"=>$vod['quantity']);
							
							$vendor_brands_details = $wpdb->get_results($wpdb->prepare("SELECT brand_json FROM wp_product_brands_details WHERE vendor_id= %s",$vendor_id[0]['vendor_id']));
						
						
						
							$brands_db = wvpsrsinfo_get_brandwise_code($vod['brands'],$vendor_brands_details);
							$brands_code[0] = $brands_debtor_code;
							unset($brands_debtor_code);
							$brands_code[$k]=array("brands_debtor_code"=>$brands_db);
							$d1[0] = array("total"=>$total,"subtotal"=>$subtotal,"quantity"=>$quantity,"product_id"=>$v_pro_id,"brands_debtor_code"=>$brands_code);
						}else{
							$d[] = $vendor_id[0]['vendor_id'];
							$total = $vod['total'];
							$subtotal = $vod['subtotal'];
							$quantity = $vod['quantity'];
							$v_product_id = array("product_id"=>$vod['product_id'],"quantity"=>$vod['quantity']);
							
							$vendor_brands_details = $wpdb->get_results($wpdb->prepare("SELECT brand_json FROM wp_product_brands_details WHERE vendor_id= %s",$vendor_id[0]['vendor_id']));
							$brands_db = get_brandwise_code($vod['brands'],$vendor_brands_details);
							$brands_debtor_code=$brands_db;
							$d1[$k] = array("total"=>$total,"subtotal"=>$subtotal,"quantity"=>$quantity,"product_id"=>$v_product_id,"brands_debtor_code"=>$brands_debtor_code);
						}
						$k++;
				}
				
				foreach($d1 as $v){
					if(count($d1)!=1 || empty($v['product_id'][0])){
					$vendor_id = wvpsrsinfo_pro_vendor_id($v['product_id']['product_id']);
					$v['pro_id'][] = $v['product_id'];
					unset($v['product_id']);
					$v['product_id'] = $v['pro_id'];
					unset($v['pro_id']);
					}
					foreach($v['product_id'] as $vpi){
						
						$m_stock = get_post_meta($l['main_product_id'],"vendor_stock",true)."<br>";
						$ustock = floatval($m_stock) - floatval($vpi['quantity']);
						update_post_meta($l['main_product_id'],"vendor_stock",$ustock,$prev_value='');
					}
					
					foreach($order_products as $op)
					{
						$i=0;
						if($i<count($d1))
						{
							if($op[$i] !="" && isset($op[$i]) && !empty($op[$i]))
							{
								$data[] = array("vendor_id"=>$vendor_id[0]['vendor_id'],
									"order"=>array(	
									"status"=>$op[$i]['status'],
									"currency"=>$op[$i]['currency'],
									"total"=>$v['total'],
									"subtotal"=>$v['subtotal'],
									"total_line_items_quantity"=>$v['quantity'],
									"total_tax"=>$op[$i]['total_tax'],
									"total_shipping"=>$op[$i]['total_shipping'],
									"cart_tax"=>$op[$i]['cart_tax'],
									"shipping_tax"=>$op[$i]['shipping_tax'],
									"total_discount"=>$op[$i]['total_discount'],
									"shipping_methods"=>$op[$i]['shipping_methods'],
									"billing_address"=>$op[$i]['billing_address'],
									"shipping_address"=>$op[$i]['shipping_address'],
									"note"=>$op[$i]['note'],
									"customer_ip"=>$op[$i]['customer_ip'],
									"customer_user_agent"=>$op[$i]['customer_user_agent'],
									"view_order_url"=>$op[$i]['view_order_url'],
									"line_items"=>$v['product_id'],
									"customer"=>$op[$i]['customer'],
									"order_meta"=>$v['brands_debtor_code']
								));
							}	
							$i++;
						}
					}
				}
				
				foreach($data as $v){
					$product_api = wvpsrsinfo_pro_vendors_info($v['vendor_id']);
					$client1=wvpsrsinfo_client_api($product_api[0],$product_api[1],$product_api[2],$options);
					$response = $client1->orders->create(array("order"=>$v['order']));
				}
			}
		
			}
		
			if (!function_exists('wvpsrsinfo_order_for_variable_product')) 
			{
			function wvpsrsinfo_order_for_variable_product($l,$order_products){
				global $wpdb;
				$vendor_order_data = array();
				$d = array();
				$d1 = array();
				$varation_meta = array();
				$v_product_id = array();
				$vendor_id = array();
				$brands_debtor_code = array();
				$k=0;
				$c =1;

		$parent_product = $wpdb->get_results($wpdb->prepare("SELECT post_parent FROM wp_posts WHERE post_type=%s AND ID=%s",'product_variation',$l['variation_id']));
				
				$parent_id = $parent_product[0]->post_parent;
				if($parent_id!=''){
					$vendor_pro_id = wvpsrsinfo_pro_vendor_store_id($parent_id);
					$l['main_product_id'] = $vendor_pro_id[0]['vendor_product_id'];
					$l['product_id'] = get_post_meta($l['variation_id'],"vendor_attribute_id",true);
					$l['meta_value_order'] = $l['meta'];
				}else{
					$vendor_pro_id = wvpsrsinfo_pro_vendor_store_id($l['variation_id']);
					$l['product_id'] = $vendor_pro_id[0]['vendor_product_id'];
					$l['main_product_id'] = $l['product_id'];
				}
				$l['brands'] = json_decode($vendor_pro_id[0]['json']);
				if(isset($l['brands']->Brands)){
					$l['brands'] = (array)$l['brands']->Brands;
				}else{
					$l['brands'] = (array)$l['brands']->Brand;
				}
				
				$vendor_order_data[] = $l;
				

				foreach($vendor_order_data as $vod)
				{
						$vendor_id = wvpsrsinfo_pro_vendor_id($vod['main_product_id']);
						
						if(in_array($vendor_id[0]['vendor_id'],$d))
						{
							$total = $total+$vod['total'];
							$subtotal = $subtotal+$vod['subtotal'];
							$quantity = $quantity+$vod['quantity'];
							$v_pro_id = $v_product_id;
							unset($v_product_id);


							$v_pro_id[$k] = array("product_id"=>$vod['product_id'],"quantity"=>$vod['quantity'],"meta"=>$vod['meta_value_order']);

							$vendor_brands_details = $wpdb->get_results($wpdb->prepare("SELECT brand_json FROM wp_product_brands_details WHERE vendor_id=%s",$vendor_id[0]['vendor_id']));
							$brands_db = wvpsrsinfo_get_brandwise_code($vod['brands'],$vendor_brands_details);

							$brands_code[0] = $brands_debtor_code[0];
							unset($brands_debtor_code);
							foreach($vod['meta'] as $vmeta){
								$brands_code[0][$vmeta['label']." ".$c] = $vmeta['value'];
							}
							$newbrandfound = array();
							foreach($brands_db as $brd=>$vld){
								foreach($brands_code as $brd1=>$vld1){
									if($brd != $brd1){
										$newbrandfound[$k] = array($brd=>$vld);
										$brands_code[$k] = $newbrandfound[$k];
									}
								}
							}
							$d1[0] = array("total"=>$total,"subtotal"=>$subtotal,"quantity"=>$quantity,"product_id"=>$v_pro_id,"brands_debtor_code"=>$brands_code,"variation_meta"=>$vod['meta'],"main_vendor_id"=>$vendor_id[0]['vendor_id']);
						}else{
							$d[] = $vendor_id[0]['vendor_id'];
							$total = $vod['total'];
							$subtotal = $vod['subtotal'];
							$quantity = $vod['quantity'];
							$v_product_id[0] = array("product_id"=>$vod['product_id'],"quantity"=>$vod['quantity'],"meta"=>$vod['meta_value_order']);
							
							
		
							$vendor_brands_details = $wpdb->get_results($wpdb->prepare("SELECT brand_json FROM wp_product_brands_details WHERE vendor_id= %s",$vendor_id[0]['vendor_id']));
							$brands_db = wvpsrsinfo_get_brandwise_code($vod['brands'],$vendor_brands_details);

							$brands_debtor_code[$k]=$brands_db;
							foreach($vod['meta'] as $vmeta){
								$brands_debtor_code[$k][$vmeta['label'].$c] = $vmeta['value'];
							}
							$d1[$k]['main_vendor_product_id'] =  $vendor_id[0]['vendor_id'];
							$d1[$k] = array("total"=>$total,"subtotal"=>$subtotal,"quantity"=>$quantity,"product_id"=>$v_product_id,"brands_debtor_code"=>$brands_debtor_code,"variation_meta"=>$vod['meta'],"main_vendor_id"=>$vendor_id[0]['vendor_id']);
							$d1[$k]['testvendorid'] =  $vendor_id[0]['vendor_id'];
						}
						$k++;
						$c++;
				}
				
				$order_custom_meta = array();
				$getvendorid=  array();
				foreach($d1 as $u){
					foreach($u['brands_debtor_code'] as $vbdc){
						$order_custom_meta[] = $vbdc;
					}
				}
				
				$t=0;
				foreach($d1 as $v){
					foreach($v['product_id'] as $vpi){
						$m_stock = get_post_meta($l['variation_id'],"_variation_vendor_stock",true)."<br>";
						$ustock = floatval($m_stock) - floatval($vpi['quantity']);
						update_post_meta($l['variation_id'],"_variation_vendor_stock",$ustock,$prev_value='');
					}
					foreach($order_products as $op)
					{
						$i=0;
						if($i<count($d1))
						{
							if($op[$i] !="" && isset($op[$i]) && !empty($op[$i]))
							{
								$data[] = array("vendor_id"=>$v['main_vendor_id'],
									"order"=>array(	
									"status"=>$op[$i]['status'],
									"currency"=>$op[$i]['currency'],
									"total"=>$v['total'],
									"subtotal"=>$v['subtotal'],
									"total_line_items_quantity"=>$v['quantity'],
									"total_tax"=>$op[$i]['total_tax'],
									"total_shipping"=>$op[$i]['total_shipping'],
									"cart_tax"=>$op[$i]['cart_tax'],
									"shipping_tax"=>$op[$i]['shipping_tax'],
									"total_discount"=>$op[$i]['total_discount'],
									"shipping_methods"=>$op[$i]['shipping_methods'],
									"billing_address"=>$op[$i]['billing_address'],
									"shipping_address"=>$op[$i]['shipping_address'],
									"note"=>$op[$i]['note'],
									"customer_ip"=>$op[$i]['customer_ip'],
									"customer_user_agent"=>$op[$i]['customer_user_agent'],
									"view_order_url"=>$op[$i]['view_order_url'],
									"line_items"=>$v['product_id'],
									"customer"=>$op[$i]['customer'],
									"order_meta"=>$order_custom_meta[$t]
								));
							}	
							$i++;
						}
					}
					$t++;
				}
				
				foreach($data as $v){

					$product_api = wvpsrsinfo_pro_vendors_info($v['vendor_id']);
					$client1=wvpsrsinfo_client_api($product_api[0],$product_api[1],$product_api[2],$options);
					$response = $client1->orders->create(array("order"=>$v['order']));
					
					
				}
			}
			}
		
			if (!function_exists('wvpsrsinfo_order_for_comb_simple_product')) 
			{
			function wvpsrsinfo_order_for_comb_simple_product($l,$order_products){
				global $wpdb;
				$vendor_order_data = array();
				$store_order_data = array();
				$d = array();
				$d1 = array();
				$v_product_id = array();
				$brands_debtor_code = array();
				$k=0;

				$vendor_pro_id = wvpsrsinfo_pro_vendor_store_id($l['product_id']);
								
				if($vendor_pro_id[0]['vendor_product_id'] == ""){
					 $store_id = wvpsrsinfo_pro_owner($l['product_id']);
					 $l['main_product_id'] = $l['product_id'];
					 $l['product_id']=$store_id[0]['ID'];
					 $store_order_data[] = $l;
				}else{
					$order_goes_to = wvpsrsinfo_check_stock_for_product($l['product_id'],$l['quantity']);
					if(isset($order_goes_to['dealer_order']) && !empty($order_goes_to['dealer_order'])){
						$l['product_id']=$order_goes_to['dealer_order']['product_id'];
						if($order_goes_to['dealer_order']['quantity']!=0){
							$l['quantity']=$order_goes_to['dealer_order']['quantity'];
							$store_order_data[] = $l;
						}
					}
					if(isset($order_goes_to['vendor_order']) && !empty($order_goes_to['vendor_order'])){
						$l['quantity'] = $order_goes_to['vendor_order']['quantity'];
						$l['product_id'] = $vendor_pro_id[0]['vendor_product_id'];
						$l['brands'] = json_decode($vendor_pro_id[0]['json']);
						if(isset($l['brands']->Brands)){
							$l['brands'] = (array)$l['brands']->Brands;
						}else{
							$l['brands'] =(array)$l['brands']->Brand;
						}
						
						$vendor_order_data[] = $l;
					}
				}
				$d = array();
				$d1 = array();
				$d2 = array();
				
				if(!empty($store_order_data))
				{
					$k=0;
					$v_product_id = array();
					foreach($store_order_data as $vod)
					{
							if($k==0)
							{
								$total = $vod['total'];
								$subtotal = $vod['subtotal'];
								$quantity = $vod['quantity'];
								$v_product_id = array("product_id"=>$vod['product_id'],"quantity"=>$vod['quantity']);
								$d2[$k] = array("total"=>$total,"subtotal"=>$subtotal,"quantity"=>$quantity,"product_id"=>$v_product_id);
							}else{
								$total = $total+$vod['total'];
								$subtotal = $subtotal+$vod['subtotal'];
								$quantity = $quantity+$vod['quantity'];
								$v_pro_id[0] = $v_product_id;
								unset($v_product_id);
								$v_pro_id[$k] = array("product_id"=>$vod['product_id'],"quantity"=>$vod['quantity']);
								$d2[0] = array("total"=>$total,"subtotal"=>$subtotal,"quantity"=>$quantity,"product_id"=>$v_pro_id);
							}
							$k++;
					}
					
					foreach($d2 as $v)
					{
						if(count($d2)!=1 || empty($v['product_id'][0])){
						$vendor_id = pro_vendor_id($v['product_id']['product_id']);
						$v['pro_id'][] = $v['product_id'];
						unset($v['product_id']);
						$v['product_id'] = $v['pro_id'];
						unset($v['pro_id']);
						}
						
						foreach($order_products as $op)
						{
							$i=0;
							if($i<count($d2))
							{
								if($op[$i] !="" && isset($op[$i]) && !empty($op[$i]))
								{
									$store_data[] = array("order"=>array(	
										"status"=>$op[$i]['status'],
										"currency"=>$op[$i]['currency'],
										"total"=>$v['total'],
										"subtotal"=>$v['subtotal'],
										"total_line_items_quantity"=>$v['quantity'],
										"total_tax"=>$op[$i]['total_tax'],
										"total_shipping"=>$op[$i]['total_shipping'],
										"cart_tax"=>$op[$i]['cart_tax'],
										"shipping_tax"=>$op[$i]['shipping_tax'],
										"total_discount"=>$op[$i]['total_discount'],
										"shipping_methods"=>$op[$i]['shipping_methods'],
										"billing_address"=>$op[$i]['billing_address'],
										"shipping_address"=>$op[$i]['shipping_address'],
										"note"=>$op[$i]['note'],
										"customer_ip"=>$op[$i]['customer_ip'],
										"customer_user_agent"=>$op[$i]['customer_user_agent'],
										"customer_id"=>$op[$i]['customer_id'],
										"view_order_url"=>$op[$i]['view_order_url'],
										"line_items"=>$v['product_id'],
										"customer"=>$op[$i]['customer']
									));
								}	
								$i++;
							}
						}
					}
					foreach($store_data as $v){
						$product_api = wvpsrsinfo_db_woocommerce_api_keys();
						$client1=wvpsrsinfo_client_api($product_api['url'],$product_api['consumer_key'],$product_api['secret_key'],$options);
						$response = $client1->orders->create(array("order"=>$v['order']));
					}
				}
				
				if(!empty($vendor_order_data))
				{
					$k=0;
					$v_product_id = array();
					foreach($vendor_order_data as $vod)
					{
							$vendor_id = wvpsrsinfo_pro_vendor_id($vod['product_id']);
							if(in_array($vendor_id[0]['vendor_id'],$d))
							{
								$total = $total+$vod['total'];
								$subtotal = $subtotal+$vod['subtotal'];
								$quantity = $quantity+$vod['quantity'];
								$v_pro_id[0] = $v_product_id;
								unset($v_product_id);
								$v_pro_id[$k] = array("product_id"=>$vod['product_id'],"quantity"=>$vod['quantity']);

								$vendor_brands_details = $wpdb->get_results($wpdb->prepare("SELECT brand_json FROM wp_product_brands_details WHERE vendor_id= %s",$vendor_id[0]['vendor_id']));
								$brands_db = wvpsrsinfo_get_brandwise_code($vod['brands'],$vendor_brands_details);

								$brands_code[0] = $brands_debtor_code;
								unset($brands_debtor_code);

								$brands_code[$k]=array("brands_debtor_code"=>$brands_db);

								$d1[0] = array("total"=>$total,"subtotal"=>$subtotal,"quantity"=>$quantity,"product_id"=>$v_pro_id,"brands_debtor_code"=>$brands_code);
							}else{
								$d[] = $vendor_id[0]['vendor_id'];
								$total = $vod['total'];
								$subtotal = $vod['subtotal'];
								$quantity = $vod['quantity'];
								$v_product_id = array("product_id"=>$vod['product_id'],"quantity"=>$vod['quantity']);
								
							$vendor_brands_details = $wpdb->get_results($wpdb->prepare("SELECT brand_json FROM wp_product_brands_details WHERE vendor_id=%s", $vendor_id[0]['vendor_id']));

								$brands_db = wvpsrsinfo_get_brandwise_code($vod['brands'],$vendor_brands_details);

								$brands_debtor_code=$brands_db;

								$d1[$k] = array("total"=>$total,"subtotal"=>$subtotal,"quantity"=>$quantity,"product_id"=>$v_product_id,"brands_debtor_code"=>$brands_debtor_code);
							}
							$k++;
					}
					
					foreach($d1 as $v){
						if(count($d1)!=1 || empty($v['product_id'][0])){
						$vendor_id = wvpsrsinfo_pro_vendor_id($v['product_id']['product_id']);
						$v['pro_id'][] = $v['product_id'];
						unset($v['product_id']);
						$v['product_id'] = $v['pro_id'];
						unset($v['pro_id']);
						}
						foreach($order_products as $op)
						{
							$i=0;
							if($i<count($d1))
							{
								if($op[$i] !="" && isset($op[$i]) && !empty($op[$i]))
								{
									$data[] = array("vendor_id"=>$vendor_id[0]['vendor_id'],
										"order"=>array(	
										"status"=>$op[$i]['status'],
										"currency"=>$op[$i]['currency'],
										"total"=>$v['total'],
										"subtotal"=>$v['subtotal'],
										"total_line_items_quantity"=>$v['quantity'],
										"total_tax"=>$op[$i]['total_tax'],
										"total_shipping"=>$op[$i]['total_shipping'],
										"cart_tax"=>$op[$i]['cart_tax'],
										"shipping_tax"=>$op[$i]['shipping_tax'],
										"total_discount"=>$op[$i]['total_discount'],
										"shipping_methods"=>$op[$i]['shipping_methods'],
										"billing_address"=>$op[$i]['billing_address'],
										"shipping_address"=>$op[$i]['shipping_address'],
										"note"=>$op[$i]['note'],
										"customer_ip"=>$op[$i]['customer_ip'],
										"customer_user_agent"=>$op[$i]['customer_user_agent'],
										"view_order_url"=>$op[$i]['view_order_url'],
										"line_items"=>$v['product_id'],
										"customer"=>$op[$i]['customer'],
										"order_meta"=>$v['brands_debtor_code']
									));
								}	
								$i++;
							}
						}
					}
					foreach($data as $v){
						$product_api = wvpsrsinfo_pro_vendors_info($v['vendor_id']);
						$client1=wvpsrsinfo_client_api($product_api[0],$product_api[1],$product_api[2],$options);
						$response = $client1->orders->create(array("order"=>$v['order']));
					}
				}
			}
			}
		
			if (!function_exists('wvpsrsinfo_order_for_comb_simple_product')) 
			{
			function wvpsrsinfo_order_for_comb_variable_product($l,$order_products){
				global $wpdb;
				$vendor_order_data = array();
				$d = array();
				$d1 = array();
				$d2 = array();
				$varation_meta = array();
				$v_product_id = array();
				$vendor_id = array();
				$brands_debtor_code = array();
				$k=0;
				$c =1;

				$vendor_pro_id = wvpsrsinfo_pro_vendor_store_id($l['product_id']);
								
				if($vendor_pro_id[0]['vendor_product_id'] == ""){
					 $store_id = wvpsrsinfo_pro_owner($l['product_id']);
					 $l['product_id']=$store_id[0]['ID'];
					 $store_order_data[] = $l;
				}else{
					$order_goes_to = wvpsrsinfo_check_stock_for_variation_product($l['variation_id'],$l['quantity']);
					if(isset($order_goes_to['dealer_order']) && !empty($order_goes_to['dealer_order'])){
						$l['variation_id']=$order_goes_to['dealer_order']['product_id'];
						if($order_goes_to['dealer_order']['quantity']!=0){
							$l['quantity']=$order_goes_to['dealer_order']['quantity'];
							$store_order_data[] = $l;
						}
					}
					if(isset($order_goes_to['vendor_order']) && !empty($order_goes_to['vendor_order'])){

						$l['quantity'] = $order_goes_to['vendor_order']['quantity'];
					$parent_product = $wpdb->get_results($wpdb->prepare("SELECT post_parent FROM wp_posts WHERE post_type=%s AND ID= %d",'product_variation',$l['variation_id']));
						$parent_id = $parent_product[0]->post_parent;
						if($parent_id!=''){
							$vendor_pro_id = wvpsrsinfo_pro_vendor_store_id($parent_id);
							$l['main_product_id'] = $vendor_pro_id[0]['vendor_product_id'];
							$l['product_id'] = get_post_meta($l['variation_id'],"vendor_attribute_id",true);
							$l['meta_value_order'] = $l['meta'];
						}else{
							$vendor_pro_id = wvpsrsinfo_pro_vendor_store_id($l['variation_id']);
							$l['product_id'] = $vendor_pro_id[0]['vendor_product_id'];
							$l['main_product_id'] = $l['product_id'];
						}
						$l['brands'] = json_decode($vendor_pro_id[0]['json']);

						if(isset($l['brands']->Brands)){
							$l['brands'] = (array)$l['brands']->Brands;
						}else{
							$l['brands'] = (array)$l['brands']->Brand;
						}
						
						$vendor_order_data[] = $l;
					}
				}
				
				if(!empty($store_order_data))
				{
					$k=0;
					$v_product_id = array();
					foreach($store_order_data as $vod)
					{
							if($k==0)
							{
								$total = $vod['total'];
								$subtotal = $vod['subtotal'];
								$quantity = $vod['quantity'];
								$v_product_id = array("product_id"=>$vod['variation_id'],"quantity"=>$vod['quantity']);
								$d2[$k] = array("total"=>$total,"subtotal"=>$subtotal,"quantity"=>$quantity,"product_id"=>$v_product_id);
							}else{
								$total = $total+$vod['total'];
								$subtotal = $subtotal+$vod['subtotal'];
								$quantity = $quantity+$vod['quantity'];
								$v_pro_id[0] = $v_product_id;
								unset($v_product_id);
								$v_pro_id[$k] = array("product_id"=>$vod['variation_id'],"quantity"=>$vod['quantity']);
								$d2[0] = array("total"=>$total,"subtotal"=>$subtotal,"quantity"=>$quantity,"product_id"=>$v_pro_id);
							}
							$k++;
					}
					foreach($d2 as $v){
						if(count($d2)!=1 || empty($v['product_id'][0])){
							$vendor_id = pro_vendor_id($v['product_id']['product_id']);
							$v['pro_id'][] = $v['product_id'];
							unset($v['product_id']);
							$v['product_id'] = $v['pro_id'];
							unset($v['pro_id']);
						}
						
						foreach($order_products as $op){
								$i=0;
								if($i<count($d2)){
									if($op[$i] !="" && isset($op[$i]) && !empty($op[$i])){
										$store_data[] = array("order"=>array(	
											"status"=>$op[$i]['status'],
											"currency"=>$op[$i]['currency'],
											"total"=>$v['total'],
											"subtotal"=>$v['subtotal'],
											"total_line_items_quantity"=>$v['quantity'],
											"total_tax"=>$op[$i]['total_tax'],
											"total_shipping"=>$op[$i]['total_shipping'],
											"cart_tax"=>$op[$i]['cart_tax'],
											"shipping_tax"=>$op[$i]['shipping_tax'],
											"total_discount"=>$op[$i]['total_discount'],
											"shipping_methods"=>$op[$i]['shipping_methods'],
											"billing_address"=>$op[$i]['billing_address'],
											"shipping_address"=>$op[$i]['shipping_address'],
											"note"=>$op[$i]['note'],
											"customer_ip"=>$op[$i]['customer_ip'],
											"customer_user_agent"=>$op[$i]['customer_user_agent'],
											"customer_id"=>$op[$i]['customer_id'],
											"view_order_url"=>$op[$i]['view_order_url'],
											"line_items"=>$v['product_id'],
											"customer"=>$op[$i]['customer']
										));
									}	
									$i++;
								}
						}
					}
					foreach($store_data as $v){
						$product_api = wvpsrsinfo_db_woocommerce_api_keys();
						$client1=wvpsrsinfo_client_api($product_api['url'],$product_api['consumer_key'],$product_api['secret_key'],$options);
						$response = $client1->orders->create(array("order"=>$v['order']));
					}
				}
				if(!empty($vendor_order_data))
				{
					$k=0;
					$c=1;
					$v_product_id = array();
					foreach($vendor_order_data as $vod)
					{
							$vendor_id = wvpsrsinfo_pro_vendor_id($vod['main_product_id']);
							
							if(in_array($vendor_id[0]['vendor_id'],$d))
							{
								$total = $total+$vod['total'];
								$subtotal = $subtotal+$vod['subtotal'];
								$quantity = $quantity+$vod['quantity'];
								$v_pro_id = $v_product_id;
								unset($v_product_id);

								$v_pro_id[$k] = array("product_id"=>$vod['product_id'],"quantity"=>$vod['quantity'],"meta"=>$vod['meta_value_order']);

								$vendor_brands_details = $wpdb->get_results($wpdb->prepare("SELECT brand_json FROM wp_product_brands_details WHERE vendor_id= %s",$vendor_id[0]['vendor_id']));
								$brands_db = wvpsrsinfo_get_brandwise_code($vod['brands'],$vendor_brands_details);

								$brands_code[0] = $brands_debtor_code[0];
								unset($brands_debtor_code);
								foreach($vod['meta'] as $vmeta){
									$brands_code[0][$vmeta['label']." ".$c] = $vmeta['value'];
								}
								$newbrandfound = array();
								foreach($brands_db as $brd=>$vld){
									foreach($brands_code as $brd1=>$vld1){
										if($brd != $brd1){
											$newbrandfound[$k] = array($brd=>$vld);
											$brands_code[$k] = $newbrandfound[$k];
										}
									}
								}
								$d1[0] = array("total"=>$total,"subtotal"=>$subtotal,"quantity"=>$quantity,"product_id"=>$v_pro_id,"brands_debtor_code"=>$brands_code,"variation_meta"=>$vod['meta'],"main_vendor_id"=>$vendor_id[0]['vendor_id']);
							}else{
								$d[] = $vendor_id[0]['vendor_id'];
								$total = $vod['total'];
								$subtotal = $vod['subtotal'];
								$quantity = $vod['quantity'];
								$v_product_id[0] = array("product_id"=>$vod['product_id'],"quantity"=>$vod['quantity'],"meta"=>$vod['meta_value_order']);
								
								
								$vendor_brands_details = $wpdb->get_results($wpdb->prepare("SELECT brand_json FROM wp_product_brands_details WHERE vendor_id= %s",$vendor_id[0]['vendor_id']));
								$brands_db = wvpsrsinfo_get_brandwise_code($vod['brands'],$vendor_brands_details);

								$brands_debtor_code[$k]=$brands_db;
								foreach($vod['meta'] as $vmeta){
									$brands_debtor_code[$k][$vmeta['label'].$c] = $vmeta['value'];
								}
								$d1[$k]['main_vendor_product_id'] =  $vendor_id[0]['vendor_id'];
								$d1[$k] = array("total"=>$total,"subtotal"=>$subtotal,"quantity"=>$quantity,"product_id"=>$v_product_id,"brands_debtor_code"=>$brands_debtor_code,"variation_meta"=>$vod['meta'],"main_vendor_id"=>$vendor_id[0]['vendor_id']);
								$d1[$k]['testvendorid'] =  $vendor_id[0]['vendor_id'];
							}
							$k++;
							$c++;
					}
					
					$order_custom_meta = array();
					$getvendorid=  array();
					foreach($d1 as $u){
						foreach($u['brands_debtor_code'] as $vbdc){
							$order_custom_meta[] = $vbdc;
						}
					}
					
					$t=0;
					foreach($d1 as $v){
						foreach($order_products as $op)
						{
							$i=0;
							if($i<count($d1))
							{
								if($op[$i] !="" && isset($op[$i]) && !empty($op[$i]))
								{
									$data[] = array("vendor_id"=>$v['main_vendor_id'],
										"order"=>array(	
										"status"=>$op[$i]['status'],
										"currency"=>$op[$i]['currency'],
										"total"=>$v['total'],
										"subtotal"=>$v['subtotal'],
										"total_line_items_quantity"=>$v['quantity'],
										"total_tax"=>$op[$i]['total_tax'],
										"total_shipping"=>$op[$i]['total_shipping'],
										"cart_tax"=>$op[$i]['cart_tax'],
										"shipping_tax"=>$op[$i]['shipping_tax'],
										"total_discount"=>$op[$i]['total_discount'],
										"shipping_methods"=>$op[$i]['shipping_methods'],
										"billing_address"=>$op[$i]['billing_address'],
										"shipping_address"=>$op[$i]['shipping_address'],
										"note"=>$op[$i]['note'],
										"customer_ip"=>$op[$i]['customer_ip'],
										"customer_user_agent"=>$op[$i]['customer_user_agent'],
										"view_order_url"=>$op[$i]['view_order_url'],
										"line_items"=>$v['product_id'],
										"customer"=>$op[$i]['customer'],
										"order_meta"=>$order_custom_meta[$t]
									));
								}	
								$i++;
							}
						}
						$t++;
					}
					
					foreach($data as $v){
						$product_api = wvpsrsinfo_pro_vendors_info($v['vendor_id']);
						$client1=wvpsrsinfo_client_api($product_api[0],$product_api[1],$product_api[2],$options);
						$response = $client1->orders->create(array("order"=>$v['order']));
					}
				}
			}
			}
			if (!function_exists('wvpsrsinfo_get_brandwise_code')) 
			{
			function wvpsrsinfo_get_brandwise_code($vendor_brands,$vendor_brands_details){
				$vendor_brands_details = wvpsrsinfo_cvf_convert_object_to_array($vendor_brands_details);
				$vendor_brands_details = $vendor_brands_details[0]['brand_json'];
				$vendor_brands_details = wvpsrsinfo_cvf_convert_object_to_array(json_decode($vendor_brands_details));
				
				$brands_code = array();
				foreach($vendor_brands as $vb){
					foreach($vendor_brands_details as $k=>$vbd){
						if($vb == $k){
							$brands_code[$k] = $vbd;
						}
					}
				}
				return $brands_code;
			}
			}
			if (!function_exists('wvpsrsinfo_check_stock_for_variation_product')) 
			{
			function wvpsrsinfo_check_stock_for_variation_product($post_id,$quantity){
				$order=array();
				global $current_user;
				get_currentuserinfo();

				$total_stock = get_post_meta($post_id,'_stock',$single = false );
				$update_total_stock = floatval($total_stock[0]) - floatval($quantity);

				$dealer_stock = get_post_meta($post_id,'_variation_dealer_stock',$single = false );

				if(floatval($quantity) <= floatval($dealer_stock[0])){
					
					$order['dealer_order'] = array('product_id'=>$post_id,'quantity'=>$quantity);
					$update_dealer_stock = floatval($dealer_stock[0]) - floatval($quantity);
					update_post_meta($post_id,"_variation_dealer_stock",$update_dealer_stock,$prev_value='');
					
					$message = "";
					$message .="Hi,\r\n\n\n\n\n\n";
					$message .= "Your received an order for the product:".$post_id."\r\n";
					$message .= "You have ".$quantity." product of own stock, you can sent this products to the customer. \r\n\n\n\n\n\n\n";
					$message .="Sincerely,\r\n\n\n\n";
					$message .= "service@retailertoday.com";
					$headers = 'From: RETAILER TODAY GROUP' . "\r\n" .
					'Reply-To: service@retailertoday.com '. "\r\n" .
					'X-Mailer: PHP/' . phpversion();
					$headers .= "Content-type: text/plain; charset=\"UTF-8\"; format=flowed \r\n";
					mail( $current_user->user_email, "Order Note", $message , $headers , $attachments = '');
				}
				else{
					if($dealer_stock[0]==0){
						$order['dealer_order'] = array('product_id'=>$post_id,'quantity'=>0);
					}else{
						$order['dealer_order'] = array('product_id'=>$post_id,'quantity'=>$dealer_stock[0]);
					}
					$rem_quantity = floatval($quantity) - floatval($dealer_stock[0]);
					$order['vendor_order'] = array('product_id'=>$post_id,'quantity'=>$rem_quantity);
					update_post_meta($post_id,"_variation_dealer_stock",0,$prev_value='');
					
					$var_vendor_stock = get_post_meta($post_id,'_variation_vendor_stock',true );
					$rm_stock = floatval($var_vendor_stock)-floatval($rem_quantity);

					update_post_meta($post_id,"_variation_vendor_stock",$rm_stock,$prev_value='');
					
					
					$message = "";
					$message .="Hi,\r\n\n\n\n\n\n";
					$message .= "Your received an order for the product:".$post_id."\r\n";
					$message .= "You have ".$dealer_stock[0]." product of own stock, you can sent this products to the customer. \r\n";
					$message .= "The remaining ".$rem_quantity." product(s) are sent from the warehouse of the supplier. \r\n\n\n\n\n\n\n";
					$message .="Sincerely,\r\n\n\n\n";
					$message .= "service@retailertoday.com";
				   $headers = 'From: RETAILER TODAY GROUP' . "\r\n" .
					'Reply-To: service@retailertoday.com '. "\r\n" .
					'X-Mailer: PHP/' . phpversion();
					$headers .= "Content-type: text/plain; charset=\"UTF-8\"; format=flowed \r\n";
					mail( $current_user->user_email, "Order Note", $message , $headers , $attachments = '');
				}
				
				return $order;
			}
			}
			if (!function_exists('wvpsrsinfo_check_stock_for_product')) 
			{
			function wvpsrsinfo_check_stock_for_product($post_id,$quantity){
				$order=array();
				global $current_user;
				get_currentuserinfo();

				$total_stock = get_post_meta($post_id,'_stock',$single = false );
				$update_total_stock = floatval($total_stock[0]) - floatval($quantity);

				$dealer_stock = get_post_meta($post_id,'dealer_stock',$single = false );
				if(floatval($quantity) <= floatval($dealer_stock[0])){
					$order['dealer_order'] = array('product_id'=>$post_id,'quantity'=>$quantity);
					$update_dealer_stock = floatval($dealer_stock[0]) - floatval($quantity);
					update_post_meta($post_id,"dealer_stock",$update_dealer_stock,$prev_value='');

					$message = "";
					$message .="Hi,\r\n\n\n\n\n\n";
					$message .= "Your received an order for the product:".$post_id."\r\n";
					$message .= "You have ".$quantity." product of own stock, you can sent this products to the customer. \r\n\n\n\n\n\n\n";
					$message .="Sincerely,\r\n\n\n\n";
					$message .= "service@retailertoday.com";
					$headers = 'From: RETAILER TODAY GROUP' . "\r\n" .
					'Reply-To: service@retailertoday.com '. "\r\n" .
					'X-Mailer: PHP/' . phpversion();
					$headers .= "Content-type: text/plain; charset=\"UTF-8\"; format=flowed \r\n";
					mail( $current_user->user_email, "Order Note", $message , $headers , $attachments = '');
				}
				else{
					if($dealer_stock[0]==0){
						$order['dealer_order'] = array('product_id'=>$post_id,'quantity'=>0);
					}else{
						$order['dealer_order'] = array('product_id'=>$post_id,'quantity'=>$dealer_stock[0]);
					}
					$rem_quantity = floatval($quantity) - floatval($dealer_stock[0]);
					$order['vendor_order'] = array('product_id'=>$post_id,'quantity'=>$rem_quantity);

					update_post_meta($post_id,"dealer_stock",0,$prev_value='');
					$m_vendor_stock = get_post_meta($post_id,'vendor_stock',true );
					$rm_stock = floatval($m_vendor_stock)-floatval($rem_quantity);

					update_post_meta($post_id,"vendor_stock",$rm_stock,$prev_value='');

					$message = "";
					$message .="Hi,\r\n\n\n\n\n\n";
					$message .= "Your received an order for the product:".$post_id."\r\n";
					$message .= "You have ".$dealer_stock[0]." product of own stock, you can sent this products to the customer. \r\n";
					$message .= "The remaining ".$rem_quantity." product(s) are sent from the warehouse of the supplier. \r\n\n\n\n\n\n\n";
					$message .="Sincerely,\r\n\n\n\n";
					$message .= "service@retailertoday.com";
					$headers = 'From: RETAILER TODAY GROUP' . "\r\n" .
					'Reply-To: service@retailertoday.com '. "\r\n" .
					'X-Mailer: PHP/' . phpversion();
					$headers .= "Content-type: text/plain; charset=\"UTF-8\"; format=flowed \r\n";
					mail( $current_user->user_email, "Order Note", $message , $headers , $attachments = '');
				}
				
				return $order;
			}
			}
			if (!function_exists('wvpsrsinfo_check_own_store')) 
			{
			function wvpsrsinfo_check_own_store($product_id,$quantity)
			{
				global $wpdb;
							
				$total_vendor_records = $wpdb->get_results($wpdb->prepare("SELECT meta_value FROM wp_postmeta WHERE meta_key =%s AND post_id = %d",'product_from', $product_id));
				$total_vendor_records = json_encode($total_vendor_records);
				$total_vendor_records = json_decode($total_vendor_records,TRUE);
				return $total_vendor_records;
			}
			}
			if (!function_exists('wvpsrsinfo_get_order_setting')) 
			{
			function wvpsrsinfo_get_order_setting()
			{
				global $wpdb;
			
					
				$order_setting = $wpdb->get_results("SELECT active_preference FROM wp_product_vendor_setting");
				
				return $order_setting[0]->active_preference;
			}
			}
			if (!function_exists('wvpsrsinfo_pro_vendor_id')) 
			{
			function wvpsrsinfo_pro_vendor_id($vendor_product_id)
			{
				global $wpdb;

				$total_vendor_records = $wpdb->get_results($wpdb->prepare("SELECT vendor_id FROM wp_product_vendors_data WHERE vendor_product_id = %d",$vendor_product_id ));
				
				$total_vendor_records = json_encode($total_vendor_records);
				$total_vendor_records = json_decode($total_vendor_records,TRUE);
				return $total_vendor_records;
			}
			
			}
			if (!function_exists('wvpsrsinfo_pro_vendor_store_id')) 
			{
			function wvpsrsinfo_pro_vendor_store_id($product_id)
			{
				global $wpdb;
				
				$total_vendor_records = $wpdb->get_results($wpdb->prepare("SELECT vendor_product_id,json FROM wp_product_vendors_data WHERE store_product_id = %d", $product_id));
				
				$total_vendor_records = json_encode($total_vendor_records);
				$total_vendor_records = json_decode($total_vendor_records,TRUE);
				
				return $total_vendor_records;
			}
			
			}
			
			if (!function_exists('wvpsrsinfo_pro_vendors_info')) 
			{
			function wvpsrsinfo_pro_vendors_info($vid)
			{
				global $wpdb;
				
				
				$consumerkey = $wpdb->get_results($wpdb->prepare("SELECT meta_value FROM wp_postmeta WHERE meta_key =%s AND post_id=%d" ,'wpcf-vendor-consumer-key',$vid));
				$secret_key = $wpdb->get_results($wpdb->prepare("SELECT meta_value FROM wp_postmeta WHERE meta_key =%s AND post_id= %d" ,'wpcf-vendor-secret-key',$vid));
				$url = $wpdb->get_results($wpdb->prepare("SELECT meta_value FROM wp_postmeta WHERE post_id=%d AND meta_key =%s",$vid,'wpcf-vendor-url'));

				if(isset($consumerkey[0]->meta_value) && isset($secret_key[0]->meta_value) && isset($url[0]->meta_value))
				{
					$url = $url[0]->meta_value;
					$consumerkey = $consumerkey[0]->meta_value;
					$secret_key = $secret_key[0]->meta_value;
					$v_keys = array($url,$consumerkey,$secret_key);
					return $v_keys;
				}
			}
			}
			
			if (!function_exists('wvpsrsinfo_pro_owner')) 
			{
			function wvpsrsinfo_pro_owner($product_id)
			{
				global $wpdb;
				$store_products = $wpdb->get_results($wpdb->prepare("SELECT ID FROM wp_posts WHERE NOT EXISTS (SELECT * FROM wp_product_vendors_data WHERE wp_product_vendors_data.store_product_id = %d) AND post_type=%s AND ID=%d",wp_posts.ID,'product',$product_id));
				$total_vendor_records = json_encode($store_products);
				$total_vendor_records = json_decode($total_vendor_records,TRUE);
				return $total_vendor_records;
			}
			}
			
			if (!function_exists('wvpsrsinfo_product_brands_setting')) 
			{
			function  wvpsrsinfo_product_brands_setting(){
			global $wpdb;
			
			$dealer_url = wvpsrsinfo_cvf_convert_object_to_array($wpdb->get_results($wpdb->prepare("SELECT option_value FROM `wp_options` WHERE option_name=%s",'siteurl')));
				$dealer = $dealer_url[0]["option_value"];	
			$total_db_records = $wpdb->get_results($wpdb->prepare("SELECT DISTINCT wp.ID,wp.post_title FROM wp_posts AS wp WHERE wp.post_status =%s AND wp.post_type = %s",'publish','vendor-store'));
				
				$vendorsInfo = array();
				$i=1;
				
				$total_db_records = json_encode($total_db_records);
				$total_db_records = json_decode($total_db_records,TRUE);
				echo "<h2>Vendor-wise Brands</h2>";
				echo "<table class='table'>
				<thead>
				<th>Sr.No.</th>
				<th>Vendor Id</th>
				<th>Vendor Name</th>
				<th></th>
				</thead>";
				foreach($total_db_records as $v)
				{
					echo "<tr>";
					echo "<td>".$i."</td>";
					echo "<td>".$v["ID"]."</td>";
					echo "<td>".$v["post_title"]."</td>";
					echo '<td><a style="width:150px;font-size:18px" href="'.admin_url('admin.php?page=vendorproducts&brandsID='.$v['ID']).'">
			<input type="submit" class="btn btn-success" value="Brand Details"></a></div></td>';
					echo "</tr>";
					$i++;
				}
			}
			}
			
			
			//Product Setting display
			if (!function_exists('wvpsrsinfo_product_setting')) 
			{
			function wvpsrsinfo_product_setting(){
			global $wpdb;
			$dealer_url = wvpsrsinfo_cvf_convert_object_to_array($wpdb->get_results($wpdb->prepare("SELECT option_value FROM `wp_options` WHERE option_name=%s",'siteurl')));
			$dealer = $dealer_url[0]["option_value"];

			global $wpdb;
			$user_id = get_current_user_id();
			$setting_pref = $wpdb->get_results("SELECT `active_preference` FROM `wp_product_vendor_setting`");
			
			
			
			$setting_pref = json_encode($setting_pref);$setting_pref=json_decode($setting_pref,TRUE);
			$setting_id = $setting_pref[0]['active_preference'];
			 echo '<br><br><form method="post" action="'.admin_url('admin.php?page=vendorproducts&success=1').'"><div style="text-align:left;font-size:20px;">
			 <div class="radio alert alert-success" style="width:500px">
			  <label><input type="radio" name="optradio" value="1" ';if($setting_id==1){ echo 'checked';}echo '>USE VENDOR STOCK FOR THE SHOP</label>
			</div>
			<div class="radio alert alert-success" style="width:500px">
			  <label><input type="radio" name="optradio" value="2" ';if($setting_id==2){ echo 'checked';}echo '>USE YOUR OWN STOCK</label>
			</div>
			<div class="radio alert alert-success" style="width:500px">
			  <label><input type="radio" name="optradio" value="3" ';if($setting_id==3){ echo 'checked';}echo '>USE COMBINATION OF STOCKS</label>
			</div>
			<div><a style="width:150px;font-size:18px" href="'.admin_url('admin.php?page=vendorproducts&success=1').'">
			<input type="submit" class="btn btn-primary" value="Save Settings"></a></div></form</div>';
			}

			}
			//Extract all vendors data from database and passed to vendor_init
			if (!function_exists('wvpsrsinfo_vendor_db')) 
			{
			function wvpsrsinfo_vendor_db()
			{
				$order_id = wvpsrsinfo_get_order_setting();
				get_currentuserinfo();
				if($order_id == ""){
					echo '<br><br><div class="alert alert-danger" style="width:700px">
					<strong>Please Select Order Setting First.</strong>
					</div>';
					echo "<script language='javascript' type='text/javascript'>
							$('#loading').hide();
							</script>";

					$recepients = $current_user->user_email;
					$subject = 'Urgent Notification';
					$message = "";
					$message .="Hi,\r\n\n\n\n\n\n";
					$message .= "Product Extraction from vendors not working"."\r\n";
					$message .= "Plaes Choose Order Setting Now,then further processing has been done. \r\n\n\n\n";
					$message .= "Thank You \r\n\n\n\n\n\n\n";
					$message .="Sincerely,\r\n\n\n\n";
					$message .= "service@retailertoday.com";
					$headers = 'From: retailertoday.com' . "\r\n" .
						'Reply-To: service@retailertoday.com' . "\r\n" .
						'X-Mailer: PHP/' . phpversion();
						$headers .= "Content-type: text/plain; charset=\"UTF-8\"; format=flowed \r\n";
					mail($recepients, $subject, $message,$headers ,$attachments = '');

					exit;
				}
				global $wpdb;
				echo "<h2>Vendor-wise Products</h2>";
				
				$total_db_records = $wpdb->get_results($wpdb->prepare("SELECT DISTINCT wp.ID FROM wp_posts AS wp WHERE wp.post_status =%s AND wp.post_type =%s",'publish','vendor-store'));
				$vendorsInfo = array();
				$i=0;
				$total_db_records = json_encode($total_db_records);
				$total_db_records = json_decode($total_db_records,TRUE);
				if(count($total_db_records)>0){

					
					foreach($total_db_records as $v)
					{
				$consumerkey = $wpdb->get_results($wpdb->prepare("SELECT meta_value FROM wp_postmeta WHERE meta_key =%s AND post_id= %d",'wpcf-vendor-consumer-key',$v["ID"]));

				$secret_key = $wpdb->get_results($wpdb->prepare("SELECT meta_value FROM wp_postmeta WHERE meta_key =%s AND post_id=%d",'wpcf-vendor-secret-key',$v["ID"]));
				$url = $wpdb->get_results($wpdb->prepare("SELECT meta_value FROM wp_postmeta WHERE post_id= %d AND meta_key = %s",$v["ID"],'wpcf-vendor-url'));

						if(isset($consumerkey[0]->meta_value) && isset($secret_key[0]->meta_value) && isset($url[0]->meta_value) && isset($v["ID"]))
						{
						$url = $url[0]->meta_value;
							
							wvpsrsinfo_vendor_init($v["ID"],$url,$consumerkey[0]->meta_value,$secret_key[0]->meta_value);
						}
					}

				}
				else{
					echo '<br><br><div class="alert alert-danger" style="width:700px">
					<strong>No Vendors Found! </strong> Please Save Vendors Details into Vendor-Stores Menu.
					</div>';
				}
				
			}
			}
			
			if (!function_exists('wvpsrsinfo_cvf_convert_object_to_array')) 
			{
			function wvpsrsinfo_cvf_convert_object_to_array($data) {

				if (is_object($data)) {
					$data = get_object_vars($data);
				}

				if (is_array($data)) {
					return array_map(__FUNCTION__, $data);
				}
				else {
					return $data;
				}
			}
			}

			//For storing all vendors data into store
			
			if (!function_exists('wvpsrsinfo_vendor_init')) 
			{
			function wvpsrsinfo_vendor_init($vendor_id,$url,$consumer_key,$secret_key){

				global $wpdb;
				$dealer =get_option( 'siteurl' );
				$all_product = array();
				$all_brands = array();
				$new_products = array();
				$vendor_brands_details = array();
				$brans_as_attr = array();
				$all_prices = array();
				$all_regular_prices= array();
				$all_sale_prices = array();
				$json_attr = "";
				$options = array(
					'debug'           => true,
					'return_as_array' => false,
					'validate_url'    => false,
					'timeout'         => 60,
					'ssl_verify'      => false,
				);
				try {
				   
					$client = wvpsrsinfo_client_api( $url,$consumer_key,$secret_key, $options );
					$all_products[]= $client->products->get(null,array('filter[meta]' => 'true','filter[limit]' => 500));
					$all_products = json_encode($all_products[0]->products);$all_products = json_decode($all_products);
				   
					//New Code Start
					
				   $brand_data = $wpdb->get_results($wpdb->prepare("SELECT meta_value FROM wp_postmeta WHERE post_id= %d",$vendor_id));
				  
					if(count($brand_data)!=0)
					{
						$brand_data = wvpsrsinfo_cvf_convert_object_to_array($brand_data);
						
						foreach($brand_data as $bd)
						{
							$data = @unserialize($bd['meta_value']);
							if ($data !== false) {
							
							foreach($data as $bd){
									$all_brands[] = $bd[0];
								}
							 }
						}
					}
					
					if(empty($all_brands)){
						echo '<br><br><div class="alert alert-danger" style="width:700px">
							<strong>No Brands Found! </strong> Please Save Brands First.
							</div>';
						echo "<script language='javascript' type='text/javascript'>
							$('#loading').hide();
							</script>";
						return;
					}
					
					foreach($all_products as $v){
						if(!empty($v->attributes)){
							foreach($v->attributes as $attr){
								
								if($attr->name == "Brands"||$attr->name == "Brand"||$attr->name == "brands"||$attr->name == "brand")
								{
									$brans_as_attr[] = "Brands";
									$a = json_decode(json_encode($attr->options),TRUE);
									if(array_intersect($all_brands,$a)){
										$new_products[] =$v ;
									}else{
										$vendor_brands_details[] = $a;
									}
								}
							}
						}
					}

					if(empty($brans_as_attr)){
						echo '<br><br><div class="alert alert-danger" style="width:700px">
						<strong>No Product having attribute "Brands" on vendor site. </strong> Please Contact Vendor 
						</div>';
						echo "<script language='javascript' type='text/javascript'>
							$('#loading').hide();
						</script>";
						return;
					}

					if(empty($new_products)){
						echo '<br><br><div class="alert alert-danger" style="width:700px">
						<strong>No Brands  of Vendor ('.$url.') are found on your site! </strong></div> ';
				
						'</div>';
					
						echo "<script language='javascript' type='text/javascript'>
								$('#loading').hide();
							</script>";
						return;
					}
					$all_products = $new_products;
					
				  $i=1;
				  
				  echo "<br><br><div id='output'>
				  <table class='table'>
				  <tr>
					  <th>Vendor Id</th>
					  <th>Vendor Name</th>
					  <th>Total Products</th>
					  <th>Updated</th>
					  <th></th>
				 </tr>";   
				 echo "<tr>
					<td>".$vendor_id."</td>
					<td>".$url."</td>
					<td>".count($all_products)."</td>
					<td>YES</td>
					<td><a href='".admin_url('admin.php?page=vendorproducts&productvendorid='.$vendor_id)."'><button type='button' class='btn btn-success'>View All Products</button></a></td>
					<tr>
				  </table></div>";
					
					$products_json = json_encode(array("vendor_id"=>$vendor_id ,values=>$all_products));
					//Save Product History
					$db_history = wvpsrsinfo_db_product_history($vendor_id,$products_json);
					if(isset($all_products)){
					foreach($all_products as $v)
					{
						$json_attr = array();
						$id = $v->id;
						$attribute = json_encode($v->attributes);
						$newAttr ="null";	
						if($attribute != "[]"){
							if(isset($v->attributes)){
								foreach($v->attributes as $r){
									
									$json_attr = array_merge($json_attr, array($r->name=>$r->options));
									
								}
							}
							
							$json_attr = json_encode($json_attr);
							$newAttr = $json_attr;
					}
					
					$attribute_json = json_encode(array("dimensions"=>$v->dimensions,"attribute"=>$newAttr,"date"=>$v->created_at));
					//Save Product attribute
					
					$db_attr = wvpsrsinfo_db_product_attribute($vendor_id,$v->id,$attribute_json,$v->created_at);
					
					// //Save All Vendors Data
					$total_db_records = $wpdb->get_results($wpdb->prepare("SELECT *  FROM `wp_product_vendors_data` WHERE `vendor_id` = %s AND `vendor_product_id` =%d"  , $vendor_id,$id));
					if(count($total_db_records) == 0)
					{
							$wpdb->insert('wp_product_vendors_data',
							array('vendor_id' => $vendor_id,'vendor_product_id' => $v->id,
							'store_product_id' => 0, 'json'=>$newAttr,'product_image'=>json_encode($v->images),'created_date'=>$v->created_at,'updated_date'=>$v->updated_at),array('%d','%d','%d','%s','%s','%s','%s'));
						   $lastid = $wpdb->insert_id;
						 if($lastid !="")
						 {
								$store_product_id = wvpsrsinfo_SavePostData($v->type,$vendor_id,$id,$v->title,$v->type,$v->status,$v->price,$v->regular_price,$v->sale_price,$v->managing_stock,$v->stock_quantity,$v->in_stock,$v->description,$v->attributes, $v->sku,$v->short_description,$v->categories,$v->product_meta->fifu_image_url,$v->product_meta->fifu_image_alt,$v->featured_src,$v->variations);
								if($store_product_id!="")
								{
									
									
									
									$sql =$wpdb->prepare("UPDATE `wp_product_vendors_data` SET `store_product_id` = %d WHERE `id` = %d",$store_product_id,$lastid);
									$res = $wpdb->query($sql);
								
									wvpsrsinfo_save_vendor_product_variations($id,$store_product_id,$v->variations);

								}
						}
					}
					else
					{
						$sql =$wpdb->prepare("UPDATE `wp_product_vendors_data`
							SET 
							`json` = %s,
							`product_image`=%s,
							`updated_date` = %s
						WHERE  `vendor_product_id` = %d AND `vendor_id` = %d",$newAttr,json_encode($v->images),$v->updated_at,$id,$vendor_id);
						
						
						
						$res = $wpdb->query($sql);

						$store_post_id = $wpdb->get_results($wpdb->prepare("SELECT `store_product_id` FROM wp_product_vendors_data WHERE `vendor_product_id` =%d  AND `vendor_id` = %s"  ,$id,$vendor_id));
						
						$store_UpdatedProduct_id =wvpsrsinfo_UpdatePostData($v->type,$vendor_id,$id,$store_post_id[0]->store_product_id,$v->title,$v->type,$v->status,$v->price,$v->regular_price,$v->sale_price,$v->managing_stock,$v->stock_quantity,$v->in_stock,$v->description,$v->attributes,$v->sku,$v->featured_src,$v->short_description,$v->categories,$v->product_meta->fifu_image_url,$v->product_meta->fifu_image_alt,$v->variations);

						
						wvpsrsinfo_update_vendor_product_variations($id,$store_post_id[0]->store_product_id,$v->variations,$v->price_html);
						
						wvpsrsinfo_product_img($id,$store_post_id[0]->store_product_id,$v->featured_src);
						
						
					}
					}
					}
				} catch ( WC_API_Client_Exception $e ) {
				
					echo $e->getMessage() . PHP_EOL;
					echo $e->getCode() . PHP_EOL;
				
					if ( $e instanceof WC_API_Client_HTTP_Exception ) {
					   echo $e->get_response() ;
					   echo "<script language='javascript' type='text/javascript'>
						$('#loading').hide();
						</script>";
					}
				}
			}
			}
			
			if (!function_exists('wvpsrsinfo_product_img')) 
			{
			function wvpsrsinfo_product_img($id,$post_id,$featuresrc)
			{
				if(!empty($featuresrc))
				{
					$filename = basename($featuresrc);
					$file = $id.$filename;
					$imgUploaded = wvpsrsinfo_grab_image($featuresrc,WP_CONTENT_URL.'/uploads/vendorproduts/'.$file);
					$imgData = wvpsrsinfo_generate_featured_image(WP_CONTENT_URL.'/uploads/vendorproduts/'.$file,$post_id );
				}
			}
			}
			
			
			if (!function_exists('wvpsrsinfo_db_woocommerce_api_keys')) 
			{
			function wvpsrsinfo_db_woocommerce_api_keys(){
				global $wpdb;
				$store_url = wvpsrsinfo_cvf_convert_object_to_array($wpdb->get_results($wpdb->prepare("SELECT option_value FROM `wp_options` WHERE option_name=%s",'siteurl')));
				$store["url"] = $store_url[0]["option_value"];
				$store_api_keys = wvpsrsinfo_cvf_convert_object_to_array($wpdb->get_results("SELECT store_consumer_key,store_secret_key FROM wp_store_own_api_keys"));
				$store["consumer_key"] = $store_api_keys[0]["store_consumer_key"];
				$store["secret_key"] = $store_api_keys[0]["store_secret_key"];
				return $store;
			}
			}
			
			
			if (!function_exists('wvpsrsinfo_client_api')) 
			{
			function wvpsrsinfo_client_api($url,$consumer_key,$secret_key,$options){
				if (class_exists('WC_API_Client')) {
				$client = new WC_API_Client( $url,$consumer_key,$secret_key, $options );
				}
				return $client;
				
			}
			}
			if (!function_exists('wvpsrsinfo_grab_image')) 
			{
			function wvpsrsinfo_grab_image($url,$saveto){
				$ch = curl_init ($url);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
				$raw=curl_exec($ch);
				curl_close ($ch);
				
				if(file_exists($saveto)){
					unlink($saveto);
				}
				$fp = fopen($saveto,'x');
				fwrite($fp, $raw);
				fclose($fp);
			}
			}
			
			if (!function_exists('wvpsrsinfo_generate_featured_image')) 
			{
			function wvpsrsinfo_generate_featured_image( $image_url, $post_id  ){
				
				$upload_dir = wp_upload_dir();
				$image_data = file_get_contents($image_url);
				$filename = basename($image_url);
				if(wp_mkdir_p($upload_dir['path']))     $file = $upload_dir['path'] . '/' . $filename;
				else                                    $file = $upload_dir['basedir'] . '/' . $filename;
				file_put_contents($file, $image_data);

				$wp_filetype = wp_check_filetype($filename, null );
				$attachment = array(
					'post_mime_type' => $wp_filetype['type'],
					'post_title' => sanitize_file_name($filename),
					'post_content' => '',
					'post_status' => 'inherit'
				);
				$attach_id = wp_insert_attachment( $attachment, $file, $post_id );
				$wvpsrsinfo_url=admin_url('includes/image.php');
				
				require_once( ABSPATH . 'wp-admin/includes/image.php');
				$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
				$res1= wp_update_attachment_metadata( $attach_id, $attach_data );
				$res2= set_post_thumbnail( $post_id, $attach_id );
			}
			}
			if (!function_exists('wvpsrsinfo_SavePostData')) 
			{
			function wvpsrsinfo_SavePostData($vproducttype,$vendor_id,$id,$title,$type,$status,$price,$regular_price,$sale_price,$manage_stock,$stock,$in_stock,$desc,$vattributes,$sku,$short_desc,$categories,$fifu_image_url,$fifu_image_alt,$featured_img,$variations){
				$product_attributes = array();
				$l = 0;
				
				foreach ($vattributes as $name => $value) {
					$option_string= "";
					if(count($vattributes[$l]->options)>1)
					{
						foreach($vattributes[$l]->options as $val){
							$option_string .= $val."|";
						}
						$option_string = trim($option_string, "|");
					}else{
						$option_string = $vattributes[$l]->options[0];
					}
					
					$atr = array('name' => htmlspecialchars( stripslashes($vattributes[$l]->name) ), 
							'value' => $option_string, // set attribute value
							'position' => 1,
							'is_visible' => 1,
							'is_variation' => $value->variation,
							'is_taxonomy' => 0);
					
					$product_attributes[$vattributes[$l]->name] = $atr;
						$l++;
				}
				
				global $wpdb;
				$api_keys = wvpsrsinfo_db_woocommerce_api_keys();
				$new_post = array(
							'post_title' => $title,
							'post_content' =>$desc,
							'post_status' => 'publish',
							'post_type' => 'product'
						);

				$product_data->product->id = wp_insert_post($new_post);
				$result = wp_set_object_terms( $product_data->product->id, $vproducttype, 'product_type' );
				if($in_stock == "1"){
					$stock_sta = 'instock';
				}else{
					$stock_sta = 'outofstock';
				}
				update_post_meta($product_data->product->id, "_manage_stock", 'yes',$prev_value='');
				update_post_meta($product_data->product->id, "_sku", $sku,$prev_value='');
				update_post_meta($product_data->product->id, "_sale_price", $sale_price,$prev_value='');
				update_post_meta($product_data->product->id, "_regular_price", $regular_price,$prev_value='');
				update_post_meta($product_data->product->id, "_stock_status", $stock_sta,$prev_value='');
				update_post_meta($product_data->product->id, "product_from", "vendor",$prev_value='');
				if($price!=""){
					update_post_meta($product_data->product->id, "_price", $price,$prev_value='');
				}else{
					if($sale_price=="" && $regular_price!=""){
					update_post_meta($product_data->product->id, "_price", $regular_price,$prev_value='');
					}
					if($regular_price =="" && $sale_price!=""){
						update_post_meta($product_data->product->id, "_price", $sale_price,$prev_value='');
					}
					if($regular_price !="" && $sale_price!=""){
						update_post_meta($product_data->product->id, "_price", $sale_price,$prev_value='');
					}
				}
				$my_post = array(
				  'ID'           => $product_data->product->id,
				  'post_excerpt' => $short_desc,
				);
				wp_update_post( $my_post );
				foreach($categories as $c){
					wp_set_object_terms($product_data->product->id, $c, 'product_cat', $append = false );
				}
				add_post_meta($product_data->product->id, '_product_attributes',$product_attributes);
				update_post_meta($product_data->product->id, '_product_attributes',$product_attributes, $prev_value='');
				
				wvpsrsinfo_product_img($id,$product_data->product->id,$featured_img);
				update_post_meta($product_data->product->id, 'fifu_image_url',$fifu_image_url,$prev_value='');
				update_post_meta($product_data->product->id, 'fifu_image_alt',$fifu_image_alt,$prev_value='');
				update_post_meta($product_data->product->id, 'stock_quantity',$stock,$prev_value='');
				update_post_meta($product_data->product->id, 'vendor_stock',$stock,$prev_value='');
				update_post_meta($product_data->product->id, 'dealer_stock',0,$prev_value='');

				$order_id =  wvpsrsinfo_get_order_setting();
				if($order_id == "1"){
					update_post_meta($product_data->product->id, "_stock", $stock,$prev_value='');
					update_post_meta($product_data->product->id, 'stock_quantity',$stock, $prev_value='');
				}else if($order_id == "2"){
					update_post_meta($product_data->product->id, '_stock',0, $prev_value='');
					update_post_meta($product_data->product->id, 'stock_quantity',$stock, $prev_value='');
				}else if($order_id == "3"){
					$main_stock = $stock;
					update_post_meta($product_data->product->id, '_stock',$main_stock, $prev_value='');
					update_post_meta($product_data->product->id, 'stock_quantity',$main_stock, $prev_value='');
				}
				return $product_data->product->id;
			}
			}
			if (!function_exists('wvpsrsinfo_UpdatePostData')) 
			{
			function wvpsrsinfo_UpdatePostData($vproducttype,$vendor_id,$id,$post_id,$title,$type,$status,$price,$regular_price,$sale_price,$manage_stock,$stock,$in_stock,$desc,$vattributes,$sku,$featured_img,$short_desc,$categories,$fifu_image_url,$fifu_image_alt,$variations){

				$dealers11_stock = get_post_meta($post_id, 'dealer_stock', $single = false );
				global $wpdb;
				$api_keys = wvpsrsinfo_db_woocommerce_api_keys();
				$client_info = wvpsrsinfo_client_api($api_keys['url'],$api_keys['consumer_key'],$api_keys['secret_key'], $options );
				$sql_str = "";
				$product_attributes = array();

				$total_post_rec = $wpdb->get_results($wpdb->prepare("SELECT *  FROM `wp_posts` WHERE ID =%d AND post_status =%s", $post_id,'publish'));
			if(count($total_post_rec)==0)
			{
				$store_id = wvpsrsinfo_SavePostData($vproducttype,$vendor_id,$id,$title,$type,$status,$price,$regular_price,$sale_price,$manage_stock,$stock,$in_stock,$desc,$vattributes,$sku,$short_desc,$categories,$fifu_image_url,$fifu_image_alt,$featured_img,$variations);
				
				$sqlupd1 =$wpdb->prepare("UPDATE `wp_product_vendors_data` SET `store_product_id` = %s WHERE  `vendor_id` = %s AND `vendor_product_id`=%s",$store_id,$vendor_id,$id);
				$res2 = $wpdb->query($sqlupd1);
				wvpsrsinfo_save_vendor_product_variations($id,$store_id,$variations);

			}else{

				$my_post = array(
					  'ID'           => $post_id,
					  'post_title'   => $title,
					  'post_content' => $desc,
					  'post_excerpt' => $short_desc,
				);
				wp_update_post( $my_post );
				if(count($categories)==1){
					foreach($categories as $c){
						wp_set_object_terms($post_id, $c, 'product_cat', $append = false );
					}
				}
				else
				{
					foreach($categories as $c){
						wp_set_object_terms($post_id, $c, 'product_cat', $append = true );
					}
				}
				
				$result = wp_update_term( $post_id, $vproducttype, 'product_type' );
				$l = 0;
				foreach ($vattributes as $name => $value) {
					$option_string= "";
					if(count($vattributes[$l]->options)>1)
					{
						foreach($vattributes[$l]->options as $val){
							$option_string .= $val."|";
						}
						$option_string = trim($option_string, "|");
					}else{
						$option_string = $vattributes[$l]->options[0];
					}
					
					$atr = array('name' => htmlspecialchars( stripslashes($vattributes[$l]->name) ), 
							'value' => $option_string, // set attribute value
							'position' => 1,
							'is_visible' => 1,
							'is_variation' => $value->variation,
							'is_taxonomy' => 0);
					
					$product_attributes[$vattributes[$l]->name] = $atr;
						$l++;
				}

				$prod_atttribute = serialize($product_attributes);
				update_post_meta($post_id, "_regular_price", $regular_price, $prev_value='');
				update_post_meta($post_id, "_sale_price", $sale_price, $prev_value='');
				if($price!=""){
					update_post_meta($post_id, "_price", $price,$prev_value='');
				}else{
					if($sale_price=="" && $regular_price!=""){
					update_post_meta($post_id, "_price", $regular_price,$prev_value='');
					}
					if($regular_price =="" && $sale_price!=""){
						update_post_meta($post_id, "_price", $sale_price,$prev_value='');
					}
					if($regular_price !="" && $sale_price!=""){
						update_post_meta($post_id, "_price", $sale_price,$prev_value='');
					}
				}
				update_post_meta($post_id, "_manage_stock", 'yes', $prev_value='');
				update_post_meta($post_id, "_sku", $sku, $prev_value='');
				update_post_meta($post_id, "_product_attributes",$product_attributes, $prev_value='');

				if($in_stock == "1"){
					$stock_sta = 'instock';
				}else{
					$stock_sta = 'outofstock';
				}
				update_post_meta($post_id, "_stock_status", $stock_sta, $prev_value='');
				update_post_meta($post_id, "product_from", "vendor", $prev_value='');
				update_post_meta($post_id, 'fifu_image_url', $fifu_image_url, $prev_value='');
				update_post_meta($post_id, 'fifu_image_alt', $fifu_image_alt, $prev_value='');

				update_post_meta($post_id, 'vendor_stock',$stock, $prev_value='');
				update_post_meta($post_id, 'dealer_stock',$dealers11_stock[0], $prev_value='');
				
				$order_id = wvpsrsinfo_get_order_setting();
				if($order_id == "1"){
					update_post_meta($post_id, '_stock',$stock, $prev_value='');
					update_post_meta($post_id, 'stock_quantity',$stock, $prev_value='');
				}else if($order_id == "2"){
					$dealers1_stock = get_post_meta($post_id, 'dealer_stock', $single = false );
					if(!isset($dealers1_stock[0])){
						$dealers1_stock[0] = 0;
						$stock_sta = 'outofstock';
						update_post_meta($post_id, "_stock_status", $stock_sta, $prev_value='');
					}
					update_post_meta($post_id, '_stock',$dealers1_stock[0], $prev_value='');

				}else if($order_id == "3"){
					$dealers1_stock = get_post_meta($post_id, 'dealer_stock', $single = false );
					$main_stock = floatval($dealers1_stock[0])+floatval($stock);
					update_post_meta($post_id, '_stock',$main_stock, $prev_value='');
					update_post_meta($post_id, 'stock_quantity',$main_stock, $prev_value='');
				}
				return true;
			}
					
			}
			
		}
		if (!function_exists('wvpsrsinfo_variation_settings_fields')) 
			{
			add_action( 'woocommerce_product_after_variable_attributes', 'wvpsrsinfo_variation_settings_fields', 10, 3 );
			
			function wvpsrsinfo_variation_settings_fields( $loop, $variation_data, $variation ) {
				// Text Field
				woocommerce_wp_text_input( 
					array( 
						'id'          => '_variation_dealer_stock[' . $variation->ID . ']', 
						'label'       => __( 'Custom Dealer Stock', 'woocommerce' ), 
						'placeholder' => 'Enter Custom Dealer Stock',
						'desc_tip'    => 'true',
						'description' => __( 'Enter Custom Dealer Stock for this Variaition.', 'woocommerce' ),
						'style'		  => "width:450px",
						'value'       => get_post_meta( $variation->ID, '_variation_dealer_stock', true )
					)
				);
				woocommerce_wp_text_input( 
					array( 
						'id'          => '_custom_image_url[' . $variation->ID . ']', 
						'label'       => __( 'Custom Field for Image URL', 'woocommerce' ), 
						'placeholder' => 'http://',
						'desc_tip'    => 'true',
						'description' => __( 'Enter the Image URL.', 'woocommerce' ),
						'style'		  => "width:450px",
						'value'       => get_post_meta( $variation->ID, '_custom_image_url', true )
					)
				);
				$imgsrc = get_post_meta( $variation->ID, '_custom_image_url', true );
				echo '<img src="'.$imgsrc.'" alt="" width="100" height="100" />';
			}
		}
			
			
			if (!function_exists('wvpsrsinfo_save_variation_settings_fields')) 
			{
			add_action( 'woocommerce_save_product_variation', 'wvpsrsinfo_save_variation_settings_fields', 10, 2 );
			
			function wvpsrsinfo_save_variation_settings_fields( $post_id ) {

				$custom_stock = $_POST['_variation_dealer_stock'][ $post_id ];
				if( ! empty( $custom_stock ) ) {
					$var_dealer_stock = get_post_meta($post_id,'_variation_dealer_stock',true);
					
					$c_stock = $custom_stock;
					$variation_stock = get_post_meta($post_id,'_variation_vendor_stock',true);
					
					
					$order_id = wvpsrsinfo_get_order_setting();
					
					if($order_id == "3"){
						$total_stock = floatval($variation_stock)+floatval($custom_stock);
						update_post_meta( $post_id, '_stock',$total_stock,$prev_value='');
						update_post_meta( $post_id, '_variation_dealer_stock', $c_stock,$prev_value='');
					}
					if($order_id == "2"){
						update_post_meta( $post_id, '_variation_dealer_stock', $c_stock,$prev_value='');
						update_post_meta( $post_id, '_stock',$c_stock,$prev_value='');
					}
					if($order_id == "1"){
						update_post_meta( $post_id, '_variation_dealer_stock', $c_stock,$prev_value='');
					}
					
				}else{
					if($order_id == "3"){
						
						update_post_meta( $post_id, '_variation_dealer_stock', 0,$prev_value='');
					}
					if($order_id == "2"){
						update_post_meta( $post_id, '_variation_dealer_stock', 0,$prev_value='');
						update_post_meta( $post_id, '_stock',0,$prev_value='');
					}
					if($order_id == "1"){
						update_post_meta( $post_id, '_variation_dealer_stock', 0,$prev_value='');
					}
				}


				$text_field = sanitize_text_field($_POST['_custom_image_url'][ $post_id ]);
				if( ! empty( $text_field ) ) {
					$upload_dir = wp_upload_dir();
					$image_data = file_get_contents($text_field);
					$filename = basename($text_field);
					if(wp_mkdir_p($upload_dir['path']))     $file = $upload_dir['path'] . '/' . $filename;
					else                                    $file = $upload_dir['basedir'] . '/' . $filename;
					file_put_contents($file, $image_data);

					$wp_filetype = wp_check_filetype($filename, null );
					$attachment = array(
						'post_mime_type' => $wp_filetype['type'],
						'post_title' => sanitize_file_name($filename),
						'post_content' => '',
						'post_status' => 'inherit'
					);
					$attach_id = wp_insert_attachment( $attachment, $file, $post_id );
					 $wvpsrsinfo_url=admin_url('includes/image.php');
					
					require_once(ABSPATH . 'wp-admin/includes/image.php');
					$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
					$res1= wp_update_attachment_metadata( $attach_id, $attach_data );
					update_post_meta( $post_id, '_custom_image_url', $text_field );
					update_post_meta( $post_id, '_custom_variation_image_id', $attach_id );
				}
			}
			}
			
			
			if (!function_exists('wvpsrsinfo_save_vendor_product_variations')) 
			{
			function wvpsrsinfo_save_vendor_product_variations($id,$post_id,$variations){
				$current_user = wp_get_current_user();
				$all_prices = array();
				$all_regular_prices = array();
				$all_sale_prices = array();
				$counter=1;
				$value_stock_qty = "";
				foreach ($variations as $key => $value) {
					
					$postname = "";
					if($counter == 1){
						$postname .= 'product-'.$post_id.'-variation';
						$counter++;
						
					}else{
						$postname .= 'product-'.$post_id.'-variation'.$counter;
						$counter++;
					}
					
					$postarr = array('post_author'=>$current_user->ID,
									 'post_date'=>$value->created_at,
									 'post_status'=>'publish',
									 'post_type'=>'product_variation',
									 'post_name'=>$postname,
									 'post_modified'=>$value->updated_at,
									 'post_parent'=>$post_id,
									 'guid'=>get_site_url()."/product_variation/".$postname);
					global $wpdb;
					$wpdb->insert('wp_posts',$postarr,array('%d','%s','%s','%s','%s','%s','%s','%d','%s'));
					$lastid = $wpdb->insert_id;
					$title = get_the_title( $post_id );
					$my_post = array(
						'ID'           => $lastid,
						'post_title'   => 'Variation #'.$lastid.' of '.$title
					);
					wp_update_post( $my_post );
					
					foreach($value->image as $vimage){
						if($vimage->title != "Placeholder" && $vimage->alt != "Placeholder"){
							wvpsrsinfo_product_img($id,$lastid,$vimage->src);
						}
						
					}

					if($value->in_stock == "1"){
						$stock_sta = 'instock';
					}else{
						$stock_sta = 'outofstock';
					}

					$order_id = wvpsrsinfo_get_order_setting();
						
					if($order_id == "3"){
						$value_stock_qty = $value->stock_quantity;
					}
					if($order_id == "2"){
						$value_stock_qty = 0;
					}
					if($order_id == "1"){
						$value_stock_qty = $value->stock_quantity;
					}
					
					$variationAttrName = array('_stock','_manage_stock','_regular_price','_sale_price','_price','_sku','_stock_status','attribute_'.$value->attributes[0]->name,'_height','_width','_length','_weight');
					$variationAttrValue = array($value_stock_qty,'yes',$value->regular_price,$value->sale_price,$value->price,$value->sku,$stock_sta,$value->attributes[0]->option);
					for($i=0;$i<count($variationAttrName);$i++)
					{
						update_post_meta($lastid, $variationAttrName[$i], $variationAttrValue[$i], $prev_value='');
					}

					update_post_meta($lastid,"vendor_attribute_id",$value->id,$prev_value='');
					
					
						
					update_post_meta($lastid,"_variation_vendor_stock",$value->stock_quantity,$prev_value='');
					update_post_meta($lastid,"_variation_dealer_stock",0,$prev_value='');
					$all_prices[] = array($lir=>$value->price);
					$all_regular_prices[] = array($lir=>$value->regular_price);
					$all_sale_prices[] = array($lir=>$value->sale_price);
				}
				wvpsrsinfo_set_variation_postmeta($post_id,$all_prices,$all_regular_prices,$all_sale_prices);
				return true;
			}
			
			}
			
			if (!function_exists('wvpsrsinfo_wpa83367_price_html')) 
			{
			add_filter( 'woocommerce_get_price_html', 'wvpsrsinfo_wpa83367_price_html', 100, 2 );
			
			function wvpsrsinfo_wpa83367_price_html( $price, $product ){
				global  $woocommerce;
				$symbol = get_woocommerce_currency_symbol();
				if($product->product_type == 'variable'){
					$min_price = get_post_meta($product->id,"_min_variation_sale_price",true);
					$max_price = get_post_meta($product->id,"_max_variation_sale_price",true);
					$min_rg_price = get_post_meta($product->id,"_min_variation_regular_price",true);
					$max_rg_price = get_post_meta($product->id,"_max_variation_regular_price",true);
					if(isset($min_price) && isset($max_price)){
						if(isset($min_rg_price) && isset($max_rg_price)){
							return '<del>'. $symbol.$min_rg_price ."-".$symbol.$max_rg_price.'</del> '. $symbol.$min_price."-".$symbol.$max_price;
						}else{
							return $symbol.$min_price."-".$symbol.$max_price;
						}
					}else{
						$min_price = get_post_meta($product->id,"_min_variation_price",true);
						$max_price = get_post_meta($product->id,"_max_variation_price",true);
						if(isset($min_price)&& isset($max_price)){
							return $symbol.$min_price."-".$symbol.$max_price;
						}else{
							$min_price = get_post_meta($product->id,"_price",true);
							return $symbol.$min_price;
						}
					}
				}else{
					$r_price = get_post_meta($product->id,"_regular_price",true);
					$s_price = get_post_meta($product->id,"_sale_price",true);
					if(isset($r_price) && isset($s_price)){
						return '<del>'. $symbol.$r_price .'</del> '. $symbol.$s_price;
					}else{
						$min_price = get_post_meta($product->id,"_price",true);
						return $symbol.$min_price;
					}
				}
			}
			}
			
			if (!function_exists('wvpsrsinfo_update_vendor_product_variations')) 
			{
			function wvpsrsinfo_update_vendor_product_variations($id,$post_id,$variations,$pricehtml){
				
				$current_user = wp_get_current_user();
				$counter = "first";
				$all_prices = array();
				$all_regular_prices = array();
				$all_sale_prices = array();
				$counter=1;
				$k=0;
				$value_stock_qty = "";
				global $wpdb;
				foreach ($variations as $key => $value) {
					
					$postname = "";
					if($counter == 1){
						$postname .= 'product-'.$post_id.'-variation';
						$counter++;
						
					}else{
						$postname .= 'product-'.$post_id.'-variation'.$counter;
						$counter++;
					}
					
					$recentattrid = $wpdb->get_results($wpdb->prepare("SELECT * FROM wp_posts as wp,wp_postmeta as wpm WHERE wp.ID = wpm.post_id AND wp.post_type =%s AND wp.post_parent =%d AND wpm.meta_key=%s AND wpm.meta_value= %d",'product_variation',$post_id,'vendor_attribute_id',$value->id));
					
					if(count($recentattrid)!=0){
						$title = "";
						$guid = "";
						$title .=get_the_title( $recentattrid[0]->post_id );
						$guid = get_site_url()."/product_variation/".$postname;
						$postarr = array('post_author'=>$current_user->ID,
										 'post_title'=>$title,
										 'post_date'=>$value->created_at,
										 'post_status'=>'publish',
										 'post_type'=>'product_variation',
										 'post_name'=>$postname,
										 'post_modified'=>$value->updated_at,
										 'post_parent'=>$post_id,
										 'guid'=>$guid);
						
						$wpdb->update('wp_posts',$postarr,array('ID'=>$recentattrid[0]->post_id),array('%d','%s','%s','%s','%s','%s','%s','%d','%s'),array('%d'));
						
						foreach($value->image as $vimage){
							if($vimage->title != "Placeholder" && $vimage->alt != "Placeholder"){
								wvpsrsinfo_product_img($id,$recentattrid[0]->post_id,$vimage->src);
							}
						}

						if($value->in_stock == "1"){
							$stock_sta = 'instock';
						}else{
							$stock_sta = 'outofstock';
						}
						$variaiton_dealer_stock =get_post_meta($recentattrid[0]->post_id,'_variation_dealer_stock',true);
						
						$order_id = wvpsrsinfo_get_order_setting();
						
						if($order_id == "3"){
							if($variaiton_dealer_stock !="" || $variaiton_dealer_stock!=0){
							$value_stock_qty = floatval($variaiton_dealer_stock)+floatval($value->stock_quantity);
							}else{
								$value_stock_qty = $value->stock_quantity;
								update_post_meta($recentattrid[0]->post_id,'_variation_dealer_stock',0,$prev_value='');
							}
						}
						if($order_id == "2"){
							if($variaiton_dealer_stock !="" || $variaiton_dealer_stock!=0){
								$value_stock_qty = $variaiton_dealer_stock;
							}else{
								$value_stock_qty = 0;
							}
						}
						if($order_id == "1"){
							$value_stock_qty = $value->stock_quantity;
						}
						
						$variationAttrName = array('_stock','_manage_stock','_regular_price','_sale_price','_price','_sku','_stock_status','attribute_'.$value->attributes[0]->name,'_height','_width','_length','_weight');
						$variationAttrValue = array($value_stock_qty,'yes',$value->regular_price,$value->sale_price,$value->price,$value->sku,$stock_sta,$value->attributes[0]->option);
						for($i=0;$i<count($variationAttrName);$i++)
						{
							update_post_meta($recentattrid[0]->post_id, $variationAttrName[$i], $variationAttrValue[$i], $prev_value='');
						}
						update_post_meta($recentattrid[0]->post_id,"_variation_vendor_stock",$value->stock_quantity,$prev_value='');
						$all_prices[] = array($lastid=>$value->price);
						$all_regular_prices[] = array($lastid=>$value->regular_price);
						$all_sale_prices[] = array($lastid=>$value->sale_price);
						$k=1;
					}else{
						
						wvpsrsinfo_save_vendor_product_variations($id,$post_id,$variations);
					}
				}
				if($k==1){
					wvpsrsinfo_set_variation_postmeta($post_id,$all_prices,$all_regular_prices,$all_sale_prices);
				}
			}
			}
			
			if (!function_exists('wvpsrsinfo_set_variation_postmeta')) 
			{
			function wvpsrsinfo_set_variation_postmeta($post_id,$all_prices,$all_regular_prices,$all_sale_prices){
				
				if(!empty($all_prices)){
					delete_post_meta( $post_id, '_price' );
					delete_post_meta( $post_id, '_max_variation_price' );
					delete_post_meta( $post_id, '_max_price_variation_id' );
					delete_post_meta( $post_id, '_min_variation_price' );
					delete_post_meta( $post_id, '_min_price_variation_id' );
					$max_var_price = MAX($all_prices);
					$min_var_price = MIN($all_prices);
					
					foreach($max_var_price as $key=>$vv){
						add_post_meta($post_id,"_price",$vv);
						add_post_meta($post_id, '_max_variation_price',$vv);
						add_post_meta($post_id, '_max_price_variation_id',$key);
					}
					foreach($min_var_price as $key=>$vv ){
						add_post_meta($post_id,"_price",$vv);
						add_post_meta($post_id, '_min_variation_price',$vv);
						add_post_meta($post_id, '_min_price_variation_id',$key);
					}
				}
				if(!empty($all_regular_prices)){
					delete_post_meta( $post_id, '_regular_price' );
					delete_post_meta( $post_id, '_max_variation_regular_price' );
					delete_post_meta( $post_id, '_min_variation_regular_price' );
					delete_post_meta( $post_id, '_max_regular_price_variation_id' );
					delete_post_meta( $post_id, '_min_regular_price_variation_id' );
					$max_reg_price = MAX($all_regular_prices);
					$min_reg_price = MIN($all_regular_prices);

					foreach($max_reg_price as $key=>$vv){
						add_post_meta($post_id, '_max_variation_regular_price',$vv);
						add_post_meta($post_id, '_max_regular_price_variation_id',$key);
					}
					foreach($min_reg_price as $key=>$vv ){
						add_post_meta($post_id, '_min_variation_regular_price',$vv);
						add_post_meta($post_id, '_min_regular_price_variation_id',$key);
					}
				}
				if(!empty($all_sale_prices)){
					delete_post_meta( $post_id, '_sale_price' );
					delete_post_meta( $post_id, '_max_variation_sale_price' );
					delete_post_meta( $post_id, '_min_variation_sale_price' );
					delete_post_meta( $post_id, '_max_sale_price_variation_id' );
					delete_post_meta( $post_id, '_min_sale_price_variation_id' );
					$max_sale_price = MAX($all_sale_prices);
					$min_sale_price = MIN($all_sale_prices);

					foreach($max_sale_price as $key=>$vv){
						add_post_meta($post_id, '_max_variation_sale_price',$vv);
						add_post_meta($post_id, '_max_sale_price_variation_id',$key);
					}
					foreach($min_sale_price as $key=>$vv ){
						add_post_meta($post_id, '_min_variation_sale_price',$vv);
						add_post_meta($post_id, '_min_sale_price_variation_id',$key);
					}
				}
			}
			}
			
			if (!function_exists('wvpsrsinfo_db_product_history')) 
			{
			function wvpsrsinfo_db_product_history($vendor_id,$products_json){
				global $wpdb;
				$total_history_data = $wpdb->get_results($wpdb->prepare("SELECT *  FROM `wp_product_history` WHERE `vendor_id` = %s",$vendor_id));
				if(count($total_history_data) == 0){
					$wpdb->insert(
					'wp_product_history',
						array(
							'vendor_id' => $vendor_id,
							'product_json' => $products_json,
							'flag'=>"A",
							'date'=>date('Y-m-d H:i:s')
						),
						array(
							'%d',
							'%s',
							'%s',
							'%s'
						)
					);
					$lastid = $wpdb->insert_id;
						 if($lastid !=""){
						 return TRUE;
						 }
					
				}else{
					$wpdb->insert(
					'wp_product_history',
						array('vendor_id' => $vendor_id,'product_json' => $products_json,'flag'=>"U",'date'=>date('Y-m-d H:i:s')),
						array('%d','%s','%s','%s')
					);
					$lastid = $wpdb->insert_id;
						 if($lastid !=""){
						 return TRUE;
						 }
				}
			}
		    }
			
			
			if (!function_exists('wvpsrsinfo_db_product_attribute')) 
			{
			function wvpsrsinfo_db_product_attribute($vendor_id,$v_id,$attribute_json,$v_created_at){

				global $wpdb;
				$total_attribute_data = $wpdb->get_results($wpdb->prepare("SELECT *  FROM `wp_product_attribute` WHERE `vendor_id` = %d AND `vendor_product_id`=%s", $vendor_id,$v_id));
				
						if(count($total_attribute_data) == 0){
							$wpdb->insert(
								'wp_product_attribute',
									array(
										'vendor_id' => $vendor_id,
										'vendor_product_id' => $v_id,
										'attribute_json' => $attribute_json,
										'date'=>$v_created_at
									),
									array('%d',
										'%d',
										'%s',
										'%s')
							);
							
						}else{
							$sql =$wpdb->prepare("UPDATE `wp_product_attribute`
								SET 
								`attribute_json` = %s,
								`date` = %s
							WHERE  `vendor_product_id` = %s AND `vendor_id` = %s",$attribute_json,date('Y-m-d H:i:s'),$v_id,$vendor_id);
							$res = $wpdb->query($sql);
							
						}
						return TRUE;
			}
			}
?>
