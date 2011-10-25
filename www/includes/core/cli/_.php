<?php

include_once 'cli_setup.php';

mysql_connect(_DB_HOST, _DB_USER, _DB_PASS) or die('Could not connect to MySQL');
mysql_select_db(_DB_NAME) or die('Could not select database: ' . _DB_NAME);


$res = mysql_query("SELECT * FROM pending_products WHERE pending_product_status = '0' ORDER BY pending_product_id ASC");
if(mysql_num_rows($res) == 0) {
	die("There are no new products to parse");
} else {

	while($row = mysql_fetch_assoc($res)) {

		// Set status to 1 (In progress)
		mysql_query("UPDATE pending_products SET pending_product_status = '1' WHERE pending_product_id = '" . mysql_real_escape_string($row['pending_product_id']) . "' LIMIT 1");

		$res2 = mysql_query("SELECT * FROM topics WHERE topic_id = '" . mysql_real_escape_string($row['topic_id']) . "' LIMIT 1");
		if(mysql_num_rows($res2) == 0) {
			echo "Invalid Topic ID"; flush();
			continue;
		} else {
			$row2 = mysql_fetch_assoc($res2);

			include_once '../../lib/simplehtmldom/simple_html_dom.php';

			$url = $row['pending_product_amazon_url'];

			echo 'Fetching ' . $url . "... "; flush();

			$html = file_get_html($url);

			echo "Got\n"; flush();






			$name = $html->find('span[id=btAsinTitle]', 0);
			$name = (isset($name)) ? $name->plaintext : 'Not found';

			$image = $html->find('img[id=prodImage]', 0);
			if((!isset($image)) || (empty($image))) {
	
			//	$image = $html->find('img[class=prod_image_selector]', 0);
				$image = $html->find('div[id=prodImageCell]', 0);
				if((!isset($image)) || (empty($image))) {
					$image = 'Not found';
				} else {
					$image = trim($image->first_child()->first_child()->src);
				}

			} else {
				$image = trim($image->src);
			}

			$brand = $html->find('div[class=buying] > span > a', 0);
			$brand = (isset($brand)) ? trim($brand->plaintext) : 'Not found';

			$technical_details = 'Not found';
			$technical_details_ul_innertext = '';
			foreach($html->find('h2') as $h2_technical_details) {
	
				if(@$h2_technical_details->plaintext == 'Technical Details') {

					if(@$h2_technical_details->next_sibling()->class == 'content') {
						$technical_details_content = $h2_technical_details->next_sibling();
						$technical_details_ul = $technical_details_content->find('ul', 0);
						$technical_details_ul_innertext = utf8_encode(strip_tags(trim($technical_details_ul->innertext)));
					} else {
		
						if(@$h2_technical_details->next_sibling()->next_sibling()->class == 'content') {
							$technical_details_content = $h2_technical_details->next_sibling()->next_sibling();
							$technical_details_ul = $technical_details_content->find('ul', 0);
							$technical_details_ul_innertext = utf8_encode(strip_tags(trim($technical_details_ul->innertext)));
						}
					}
				}
			}

			$technical_details_array = explode("\n", $technical_details_ul_innertext);
			$technical_details = '';
			foreach($technical_details_array as $tda) {
				$technical_details .= trim($tda) . "\n";
			}


			$product_details = 'Not found';
			foreach($html->find('h2') as $h2_product_details) {

				if(@$h2_product_details->plaintext == 'Product Details') {
	
					if(@$h2_product_details->next_sibling()->class == 'content') {
						$product_details_content = $h2_product_details->next_sibling();
					} else {
						if(@$h2_product_details->next_sibling()->next_sibling()->class == 'content') {
							$product_details_content = $h2_product_details->next_sibling()->next_sibling();
						}
					}

					foreach(@$product_details_content->find('li') as $title) {
						preg_match('/<b>([^<]+)/im', $title->innertext, $title_matches);
						if(@trim(@strip_tags($title_matches[0])) == 'Product Dimensions:') {
							$dimensions = trim(strip_tags(preg_replace('/<b>([^<]+)/im', '', $title->innertext)));
						}

						preg_match('/<b>([^<]+)/im', $title->innertext, $title_matches);
						if(@trim(@strip_tags($title_matches[0])) == 'ASIN:') {
							$asin = trim(strip_tags(preg_replace('/<b>([^<]+)/im', '', $title->innertext)));
						}

						preg_match('/<b>([^<]+)/im', $title->innertext, $title_matches);
						if(@trim(@strip_tags($title_matches[0])) == 'Item model number:') {
							$model = trim(strip_tags(preg_replace('/<b>([^<]+)/im', '', $title->innertext)));
						}
					}
				}
			}

			$dimensions = (isset($dimensions)) ? trim($dimensions) : 'Not found';
			$asin       = (isset($asin)) ? trim($asin) : 'Not found';
			$model      = (isset($model)) ? trim($model) : 'Not found';

			$price = $html->find('b[class=priceLarge]', 0);
			$price = (isset($price)) ? trim($price->plaintext) : 'Not found';

			$list_price = $html->find('span[class=listprice]', 0);
			$list_price = (isset($list_price)) ? trim($list_price->plaintext) : 'Not found';



			// Brand test
			$res3 = mysql_query("select * from brands where brand_name = '" . mysql_real_escape_string($brand) . "' limit 1");
			if(mysql_num_rows($res3) == 0) {
				$res3 = mysql_query("insert into brands values('0', '" . mysql_real_escape_string($brand) . "', '" . mysql_real_escape_string(make_slug($brand)) . "', '" . mysql_real_escape_string(time()) . "')");
				$brand_id = mysql_insert_id($res3);
			} else {
				while($row3 = mysql_fetch_assoc($res3)) {
					$brand_id = $row3['brand_id'];
				}
			}
			
			
			
			
			// Update the table
			mysql_query("update pending_products set brand_id = '" . mysql_real_escape_string($brand_id) . "', pending_product_status = '2',	pending_product_name = '" . mysql_real_escape_string($name) . "', pending_product_long_name = '" . mysql_real_escape_string($name) . "', pending_product_image_original_url = '" . mysql_real_escape_string($image) . "', pending_product_technical_details = '" . mysql_real_escape_string($technical_details) . "', pending_product_dimensions = '" . mysql_real_escape_string($dimensions) . "', pending_product_model = '" . mysql_real_escape_string($model) . "', pending_product_asin = '" . mysql_real_escape_string($asin) . "', pending_product_amazon_price = '" . mysql_real_escape_string($price) . "', pending_product_amazon_list_price = '" . mysql_real_escape_string($list_price) . "', pending_product_timestamp_updated = '" . mysql_real_escape_string(time()) . "' where pending_product_id = '" . mysql_real_escape_string($row['pending_product_id']) . "' limit 1") or die(mysql_error());
			
			echo "... DONE [" . $row['pending_product_id'] . "]";

		}
		
		echo "\n\n\n"; flush();
		sleep(rand(2,4));		
		$html->clear();
		echo "MEMORY USAGE: " . memory_get_usage() . " bytes\n\n"; flush();

	}

}

function make_slug($string) {

	$slug = preg_replace('/[^a-zA-Z0-9 ]/', '', $string);
	$slug = str_replace(' ', '-', $slug);
	$slug = str_replace('--', '-', $slug);
	
	return $slug;

}