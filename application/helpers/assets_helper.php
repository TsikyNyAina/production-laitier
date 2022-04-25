<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	if(!function_exists('img_loader'))
	{
		function img_loader($name)
		{
			return site_url()."/assets/img/".$name;
		}
	}

	if(!function_exists('css_loader'))
	{
		function css_loader($name)
		{
			return site_url()."/assets/css/".$name.".css";
		}
	}

	if(!function_exists('js_loader'))
	{
		function js_loader($name)
		{
			return site_url()."/assets/js/".$name.".js";
		}
	}
	
	if(!function_exists('font_loader'))
	{
		function font_loader($name)
		{
			return site_url()."/assets/fonts/ionicons/css/".$name.".css";
		}
	}

	if(!function_exists('icon_loader'))
	{
		function icon_loader($name)
		{
			return site_url()."/assets/icon/css/".$name.".css";
		}
	}
	
	if(!function_exists('tools_loader'))
	{
		function tools_loader($name)
		{
			return site_url()."/assets/'tools/".$name;
		}
	}
?>