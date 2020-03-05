<?php

	function lang_selector ($parse_lang, $lang_switcher){

		if ( isset ( $_GET["lang"] ) and in_array ( $_GET["lang"], array ( 'ru', 'eng' ) ) )
		{
			$_SESSION["lang"] = $_GET["lang"];
		}
 
//- Предпочтительный язык пользователя
	preg_match('/^\w{2}/',$_SERVER['HTTP_ACCEPT_LANGUAGE'], $matches);
	switch ( strtolower( $matches[0] ) )
	{
//- Русский
	case "ru":
	$accept_lang = "ru";
	break;
 
//- English
	case "eng":
	$accept_lang = "eng";
	break;
 
//- По дефолту
	default:
	$accept_lang = "ru";
	break;
	}
 
//- Ранее определенный язык сайта из $_SERVER['HTTP_ACCEPT_LANGUAGE']
	$lang = $accept_lang;
 
//- Данные о выборе языка есть в сессии
	if ( isset( $_SESSION["lang"] ) )
	{
		$lang = $_SESSION["lang"];
	}
	return ($lang);
	}
?>