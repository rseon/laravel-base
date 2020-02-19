<?php

if(!function_exists('date_i18n')) {

	/**
     * Get date format according to current language.
     *
     * @param  Carbon  $date
     * @param  string  $format
     * @return string
     */
	function date_i18n($date, $format = null)
	{
		if(!$format) {
			switch(app()->getLocale()) {
	            case 'fr':
	                $format = 'd/m/Y H:i:s';
	                break;
	            default:
	            	$format = 'm/d/Y H:i:s';
	            	break;
	        }
        }

        return $date->format($format);
	}
}