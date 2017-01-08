<?php
class ThemeOptions {
	private $data = array();
	
	public function __construct($template, $store, $skin) {
		if(file_exists(DIR_TEMPLATE.$template.'/skins/store_'.$store.'/'.$skin.'/settings.json')) {
			$template = json_decode(file_get_contents(DIR_TEMPLATE.$template.'/skins/store_'.$store.'/'.$skin.'/settings.json'), true);
			foreach ($template as $option => $value) { 
				$this->data[$option] = $value;
			}
		}
		$this->data['store'] = $store;
		$this->data['skin']  = $skin;
	}
	
  	public function get($key, $array1 = '', $array2 = '', $array3 = '') {
  		if($key == 'payment') {
  			if(isset($this->data[$key])) {
				usort($this->data[$key], "cmp_by_optionNumber");
	  			return $this->data[$key];
  			}
  			return null;
  		} else {
	  		if($array1 != '' && $array2 != '' && $array3 != '') {
	  			return (isset($this->data[$key][$array1][$array2][$array3]) ? $this->data[$key][$array1][$array2][$array3] : null);
	  		} elseif($array1 != '' && $array2 != '') {
	    		return (isset($this->data[$key][$array1][$array2]) ? $this->data[$key][$array1][$array2] : null);
	    	} elseif($array1 != '') {
	    		return (isset($this->data[$key][$array1]) ? $this->data[$key][$array1] : null);
	    	} else {
	    		return (isset($this->data[$key]) ? $this->data[$key] : null);
	    	}
    	}
  	}
  	
  	public function compressorCodeCss($template, $files, $compressor_status, $http_server) {
  		if($compressor_status == 1 && is_writable('catalog/view/theme/' . $template . '/css')) {
	  		$file_cache = 'catalog/view/theme/' . $template . '/css/cache_css.css';
	  		$cache_life = 3600;
	  		
	  		if(!file_exists($file_cache) or (time() - filemtime($file_cache) >= $cache_life)){
	  			$buffer = "";
	  			foreach($files as $file) {
	  				$buffer .= file_get_contents($http_server . $file);
	  			}
	  			
	  			$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
	  			$buffer = str_replace(': ', ':', $buffer);
	  			$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
	  			
	  			file_put_contents($file_cache, $buffer);  
	  		}
	  		  		
	  		return '<link rel="stylesheet" type="text/css" href="catalog/view/theme/' . $template . '/css/cache_css.css" media="screen" />';
  		} else {
  			$output = '';
  			foreach($files as $file) {
  				$output .= '<link rel="stylesheet" type="text/css" href="' . $file . '" />';
  				$output .= "\n";
  			}
  			
  			return $output;
  		}
  	}
  	
  	public function compressorCodeJs($template, $files, $compressor_status, $http_server) {
  		if($compressor_status == 1 && is_writable('catalog/view/theme/' . $template . '/js')) {
	  		$file_cache = 'catalog/view/theme/' . $template . '/js/cache_js.js';
	  		$cache_life = 3600;
	  		
	  		if(!file_exists($file_cache) or (time() - filemtime($file_cache) >= $cache_life)){
	  			$buffer = "";
	  			foreach($files as $file) {
	  				$buffer .= file_get_contents($http_server . $file);
	  			}
	  			
				$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
				$buffer = str_replace(': ', ':', $buffer);
	  			
	  			file_put_contents($file_cache, $buffer);  
	  		}
	  		  		
	  		return '<script type="text/javascript" src="catalog/view/theme/' . $template . '/js/cache_js.js"></script>';
  		} else {
  			$output = '';
  			foreach($files as $file) {
  				$output .= '<script type="text/javascript" src="' . $file . '"></script>';
  				$output .= "\n";
  			}
  			return $output;
  		}
  	}
  	
  	public function getDataProduct($product_id) {
  		global $registry;
  		
  		$output = array();
  		
  		$product = $registry->get('model_catalog_product');
  		
  		$result = $product->getProduct($product_id);
  		if($result) {
  			$output = array(
  				'description' => strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')),
  				'price' => $result['price'],
  				'special' => $result['special']
  			);
  		}	
  		
  		return $output;
  	}	
	

  	public function refineSearch() {
  		global $loader, $registry;
  		
  		$output = array();
  		
  		$loader->model('catalog/category');

  		$model = $registry->get('model_catalog_category');
  		$product = $registry->get('model_catalog_product');
  		$get = $registry->get('request');
  		$link = $registry->get('url');
  		$config = $registry->get('config');
  		
  		$parts = explode('_', (string)$get->get['path']);
  		$category_id = (int)array_pop($parts);
  		
  		$url = '';
  		if (isset($get->get['filter'])) {
  			$url .= '&filter=' . $get->get['filter'];
  		}	
  								
  		if (isset($get->get['sort'])) {
  			$url .= '&sort=' . $get->get['sort'];
  		}	
  		
  		if (isset($get->get['order'])) {
  			$url .= '&order=' . $get->get['order'];
  		}	
  					
  		if (isset($get->get['limit'])) {
  			$url .= '&limit=' . $get->get['limit'];
  		}

  		$results = $model->getCategories($category_id);
  		foreach ($results as $result) {
  			$data = array(
  				'filter_category_id'  => $result['category_id'],
  				'filter_sub_category' => true
  			);
  			
  			$product_total = $product->getTotalProducts($data);		
  			
  			$output[] = array(
  				'thumb' => $result['image'],
  				'name'  => $result['name'] . ($config->get('config_product_count') ? ' (' . $product_total . ')' : ''),
  				'href'  => $link->link('product/category', 'path=' . $get->get['path'] . '_' . $result['category_id'] . $url)
  			);
  		}
  		
  		return $output;
  	}
  	
  	
}

function cmp_by_optionNumber($a, $b) {
  return $a["sort"] - $b["sort"];
}

?>