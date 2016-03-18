<?php
/* * **********************************************************************************************
 * Program History :
 *
 * Project Name     : OAS
 * Client Name      : 
 * Program Id       : 
 * Program Name     : Common Helper
 * Description      :
 * Environment      : PHP 5.4.19
 * Author           : Bili
 * Version          : 01.00.00
 * Creation Date    : Wed, Aug 13 2014
 *
 * Update history     Re-fix date       Person in charge      Description
 * 
 * 
 * Copyright(C) 2014- [?]
 * *********************************************************************************************** */

	// main url of this application
	function main_url() {
			// return base_url() . "index.php/";
			return base_url() . "";
		}

	// assets folder for store some files related to application's layout and functionality
	function asset_url() {
			return base_url() . "assets/";
		}

	//css folder
	function css_url() {
		return asset_url() . "css/";
	}

	//javascript folder
	function js_url() {
		return asset_url() . "js/";
	}

	//image folder
	function img_url() {
		return asset_url() . "img/";
	}

	//fonts folder
	function fonts_url() {
		return asset_url() . "fonts/";
	}

	//less folder
	function less_url() {
		return asset_url() . "less/";
	}

	function printz($arg) {
		echo "<br /><pre>";
		if(is_string($arg)) echo $arg;
		else print_r($arg);
		echo "</pre>";
		die();
	}

	function fetchArray($sql, $return="all", $mode="std") {
		$output = null;
		$CI 	=& get_instance();
		$query	= $CI->db->query($sql);
		if($query === false) {
			show_error('Error: error_db<br> UtilityHelper->FecthArray : '.$sql, 500, 'KESALAHAN MENGOLAH DATA', 'error_db');
		}
		else {
			$fields = $query->list_fields();
			$meta	= null; //$query->field_data();
			$rows	= $query->num_rows();
			$data	= $query->result_array();
			$query->free_result();

			if($rows>0) {
				switch ($return) {
					case "one":
						$keys	= array_keys($data[0]);
						$output	= $data[0][$keys[0]];
						break;
					case "row":
						$output = $data[0];
						break;
					case "all":
						$output = $data;
						break;
				}
				unset($data);
			}
			switch ($mode) {
				case "std":
					return $output;
					break;
				case "num_total":
					return $rows;
					break;
				case "all":
					return array('rows'=>$output, 'nrows'=>$rows, 'fields'=>$fields, 'meta'=>$meta);
					break;
				case 'sql':
					printz($sql);
					break;
				case "out":
					printz($output);
					break;
			}
		}
	}