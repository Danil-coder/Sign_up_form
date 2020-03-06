<?php

	require_once("db.php"); // Database connecting
	require_once ("lang_selector.php"); // Language handler
	require_once ("wordlist.php"); // Dictionary of used english/russian phrases

	// Access to the language handler:

	$lang = lang_selector($parse_lang, $lang_switcher);
	
	// Generating language switching links:
	
	$lang_switcher = '
		<div>
			<a href="?lang=ru" style="text-decoration:'.($lang == 'ru' ? 'underline' : '' ).'">Русский</a>
			<a href="?lang=eng" style="text-decoration:'.($lang == 'eng' ? 'underline' : '' ).'">English</a>
		</div>
		';
	
	$data = $_POST;
	
	// Query for select user data from database:
	
	$STH = $DBH->query("SELECT * FROM users WHERE username = '" . $_SESSION['logged_user'] .  "'");
		$STH->setFetchMode(PDO::FETCH_ASSOC); 
		while($row = $STH->fetch()){
		$out[] = $row;
		}
	
	$user_data = array_shift($out);
	
	// Displaying the user photo
	
	if ($user_data['image'] !== null) $avatar = $user_data['image'];
	else ($avatar = "def_images/photo.jpg");
	
	
?>


<!DOCTYPE HTML>
<html>

	<head>
		<meta charset="UTF-8"/>
		<title><?=$parse_lang[$lang]['profile_title']?></title>
		<link href="user_page_style.css" rel="stylesheet" type="text/css"/>
		<!--Sets the width of the mobile device screen-->
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	
	<body>
	
		<div id="background">
			<div id = "lang_switcher">
			
			<!--Output of language switching links-->
				<?=$lang_switcher?>
				
			</div>
			<div id="welcome">
				<?=$parse_lang[$lang]['welcome']?>
			</div>
			<div id="avatar"><img src="<?=$avatar?>" alt="image" class="round"></div>
		</div>
		
		<div id = "full_name">
			<?=$user_data['first_name']?> <?=$user_data['last_name']?>
			<hr class="line">
		</div>
		
		<div id = "user_info">
			<div class = "info"><?=$parse_lang[$lang]['profile_username']?><?=$user_data['username']?></div>
			<div class = "info">E-mail: <?=$user_data['profile_email']?><?=$user_data['email']?></div>
			<div class = "info"><?=$parse_lang[$lang]['profile_phone']?><?=$user_data['phone']?></div>
		</div>

		
		<div id="logout_link">
			<a href = "logout.php" class="signout_link"><?=$parse_lang[$lang]['log_out']?></a>
		</div>
		
		
	</body>
</html>