<?php

	require_once("db.php"); // Database connecting
	require_once ("lang_selector.php"); // Language handler
	require_once ("wordlist.php"); // Dictionary of used english/russian phrases
	
	// Access to the language handler:
	
	$lang = lang_selector($parse_lang, $lang_switcher);
	
	// Generating language switching links:
	
	$lang_switcher = '
		<div id="lang_switcher">
			<a href="?lang=ru" style="text-decoration:'.($lang == 'ru' ? 'underline' : '' ).'">Русский</a>
			<a href="?lang=eng" style="text-decoration:'.($lang == 'eng' ? 'underline' : '' ).'">English</a>
		</div>
		';
		
	// Regular expressions for validation:
	
	$password_pattern = "/(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*]{6,40}/";
	$username_pattern = "/^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$/";
	
	// Validation of form data:
	
	$data = $_POST;
	if (isset($data['do_login']))
	{		
		$errors = array();
		if (trim($data['username']) == '')
		{
			$errors[] = $parse_lang[$lang]['enter_username'];
		}
		
		if (preg_match($username_pattern, trim($data['username'])) !== 1)
		{
			$errors[] = $parse_lang[$lang]['user_not_found'];
		}
		
		if ($data['password'] == '')
		{
			$errors[] = $parse_lang[$lang]['enter_password'];
		}
				
		if (preg_match($password_pattern, $data['password']) !== 1)
		{
			$errors[] = $parse_lang[$lang]['incorrect_password'];
		}
		
		// Request data matches the entered username:
		
		$out = array();
		$STH = $DBH->query("SELECT username, password FROM users WHERE username = '" . $data['username'] . "'");
		$STH->setFetchMode(PDO::FETCH_ASSOC); 
		
		while($row = $STH->fetch()){
		$out[] = $row;
		}
		
		// Checking the user 's existence:
		// Password verification:
		
		if (! empty($out[0])){
			if (password_verify($data['password'], $out[0]["password"])){

				// Start a user session and move to the personal profile:
				
				$_SESSION['logged_user'] = $out[0]['username'];
				header ('Location: user_page.php'); exit;
			}
			else {
				$errors[] = $parse_lang[$lang]['incorrect_password'];
				}
		} else { 
			$errors[] = $parse_lang[$lang]['user_not_found'];
		}
		
		// Checking for errors:
		// Displaying notifications:
		if ( ! empty($errors)){		
			echo '<div id="server_remark">' . array_shift($errors) . '</div>';
		}
	}
?>


<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8"/>
		<title><?=$parse_lang[$lang]['title']?></title>
		<link href="login_page.css" rel="stylesheet" type="text/css"/>
		<!--Sets the width of the mobile device screen-->
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>

	<body>
	
	<!--Output of language switching links-->
	<?=$lang_switcher?>
	
	<div id="box" class="signup_link_in">
	<span id="login_link">
		<?=$parse_lang[$lang]['log in']?>
	</span>
	<span  id="signup_link">
		<a href = "signup.php"><?=$parse_lang[$lang]['sign up']?></a>
	</span>
	<form id="autorization" action = "login.php" method = "POST" novalidate>
		<div class="group">      
			<input type="text" name = "username" required>
			<span class="bar"></span>
			<label><?=$parse_lang[$lang]['username']?></label>
		</div>
		<div class="group">      
			<input type="password" name = "password" required>
			<span class="bar"></span>
			<label><?=$parse_lang[$lang]['password']?></label>
		</div>
	</form>
		<div id="but">
			<button type = "submit" form="autorization" name = "do_login" id = "button"><?=$parse_lang[$lang]['login_button']?></button>
		</div>
</div>

</body>
</html>

