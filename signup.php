<?php
	setlocale(LC_ALL, "ru_RU.UTF-8");
	require_once("db.php"); // Database connecting
	require_once("img_handling.php"); // Image handler
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
	
	$username_pattern = "/^[a-zA-Z0-9-_\.]{1,20}$/";
	$name_pattern = "/^[А-Яа-яЁёa-zA-Z]{1,20}$/u";
	$email_pattern = "/^[a-z0-9_-]+@[a-z0-9-]+\.[a-z]{2,6}$/i";
	$phone_pattern = "/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/";
	$password_pattern = "/^[0-9a-zA-Z!@#$%^&*]{6,40}/";
	
	// Access to the image handler:
	
	$image = image_handling();
	$data = $_POST;
	
	// Validation of form data:
	
	if (isset($data['do_signup']))
	{
		$errors = array();
		if (trim($data['username']) == '')
		{
			$errors[] = $parse_lang[$lang]['enter_username'];
		}
		if (preg_match($username_pattern, trim($data['username'])) !== 1)
		{
			$errors[] = $parse_lang[$lang]['incorrect_username'];
		}
		if ($data['first_name'] !== ""){
			if (preg_match($name_pattern, $data['first_name']) !== 1)
			{
				$errors[] = $parse_lang[$lang]['incorrect_first_name'];
			}
		}
		if ($data['last_name'] !== ""){
			if (preg_match($name_pattern, $data['last_name']) !== 1)
			{
				$errors[] = $parse_lang[$lang]['incorrect_last_name'];
			}
		}
		if (trim($data['email']) == '')
		{
			$errors[] = $parse_lang[$lang]['enter_email'];
		}
		if (preg_match($email_pattern, $data['email']) !== 1)
		{
			$errors[] = $parse_lang[$lang]['incorrect_email'];
		}
		if ($data['phone'] !== ""){
			if (preg_match($phone_pattern, $data['phone']) !== 1)
			{
				$errors[] = $parse_lang[$lang]['incorrect_phone'];
			}
		}
		if ($data['password'] == '')
		{
			$errors[] = $parse_lang[$lang]['enter_password'];
		}
		if (preg_match($password_pattern, $data['password']) !== 1)
		{
			$errors[] = $parse_lang[$lang]['incorrect_new_password'];
		}
		if ($data['password_2'] == '')
		{
			$errors[] = $parse_lang[$lang]['enter_password_2'];
		}
		if ($data['password_2'] != $data['password'])
		{
			$errors[] = $parse_lang[$lang]['repeat_password_mistake'];
		}
		if (preg_match($password_pattern, $data['password_2']) !== 1)
		{
			$errors[] = $parse_lang[$lang]['incorrect_password_2'];
		}
		
		$username = $data['username'];
		$email = $data['email'];
		
		// Checking whether the entered username is free:
		
		$stmt = $DBH->prepare('SELECT EXISTS(SELECT 1 FROM users WHERE username =:username LIMIT 1)');
		$stmt->bindParam(':username', $username);
		$stmt->execute();
		$login_chek = $stmt->fetch(PDO::FETCH_NUM);
		
		if ($login_chek[0] != 0)
		{
			$errors[] = $parse_lang[$lang]['username_already_taken'];
		}
		
		// Checking whether the entered email is free:
		
		$stmt = $DBH->prepare('SELECT EXISTS(SELECT 1 FROM users WHERE email =:email LIMIT 1)');
		$stmt->bindParam(':email', $email);
		$stmt->execute();
		$email_chek = $stmt->fetch(PDO::FETCH_NUM);
		
		if ($email_chek[0] != 0)
		{
			$errors[] = $parse_lang[$lang]['email_already_taken'];
		}
		
		// Preparing an array for the insert:
		
		$insert = array($data['username'], $data['email'], password_hash($data['password'], PASSWORD_DEFAULT), $data['first_name'], $data['last_name'], $data['phone'], $image);
		
		// Checking for errors:
		
		if (empty($errors))
		{
			if (empty($img_errors))
			{
			// Query for database insert:
			
			$STH = $DBH->prepare("INSERT INTO users (username, email, password, first_name, last_name, phone, image) values (?, ?, ?, ?, ?, ?, ?)");  
			$STH->execute($insert);
			
			// Start a user session and move to the personal profile:
			
			$_SESSION['logged_user'] = $data['username'];
			header ('Location: user_page.php'); exit;
			}else
			{	
		
		// Displaying notifications:
		
				echo '<div id="server_remark">' . array_shift($img_errors) . '</div>';
			}
		} else
		{
			echo '<div id="server_remark">' . array_shift($errors) . '</div>';
		}
	}
?>


<html>

	<head>
		<meta charset="UTF-8"/>
		<title><?=$parse_lang[$lang]['sign_up']?></title>
		<link href="signup_page.css" rel="stylesheet" type="text/css"/>
		<!--Connection function that displaying preview of uploded photo-->
		<script type="text/javascript" src="image_upload.js"></script>
		<!--Connecting to the jquery-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<!--Sets the width of the mobile device screen-->
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	
	<body>
	
		<!--Output of language switching links-->
		<?=$lang_switcher?>
		
		<div id="box" class="login_link_in">
	
			<span id="login_link">
				<!--Displaying links in the selected language-->
				<a href = "login.php"><?=$parse_lang[$lang]['log in']?></a>
			</span>
			<span  id="signup_link">
				<?=$parse_lang[$lang]['sign up']?>
			</span>
	
				<div class="left">
		
					<form action = "signup.php" id="signup" method = "POST" enctype="multipart/form-data" novalidate>
					
						<div id="username_group" class="group">      
							<input type="text" name="username" id="username" value = "<?php echo @$data['username']; ?>" required>
							<span id="username_valid" class="valid"></span><span class="bar"></span>
							<label id="username_label"><?=$parse_lang[$lang]['username']?><p class="asterisk">  *</p></label>
							
							<!--Generating the span element for displaying notifications on the client in selected language-->
							<?php if($lang == 'ru') echo "<span id='username_remark_ru' class='remark'></span>";
								if($lang == 'eng') echo "<span id='username_remark_eng' class='remark'></span>"; ?>
								
						</div>
		
						<div id="first_name_group" class="group">      
							<input type="text" name="first_name" id="first_name" value = "<?php echo @$data['first_name']; ?>" required>
							<span id="first_name_valid" class="valid"></span><span class="bar"></span>
							<label id="first_name_label"><?=$parse_lang[$lang]['first_name']?></label>
							<?php if($lang == 'ru') echo "<span id='first_name_remark_ru' class='remark'></span>";
								if($lang == 'eng') echo "<span id='first_name_remark_eng' class='remark'></span>"; ?>
						</div>
						
						<div id="last_name_group" class="group">      
							<input type="text" name="last_name" id="last_name" value = "<?php echo @$data['last_name']; ?>" required>
							<span id="last_name_valid" class="valid"></span><span class="bar"></span>
							<label id = "last_name_label"><?=$parse_lang[$lang]['last_name']?></p></label>
							<?php if($lang == 'ru') echo "<span id='last_name_remark_ru' class='remark'></span>";
								if($lang == 'eng') echo "<span id='last_name_remark_eng' class='remark'></span>"; ?>
						</div>
						
						<div id="email_group" class="group">
							<input type="text" name="email" id="email" value = "<?php echo @$data['email']; ?>" required>
							<span id="email_valid" class="valid"></span><span class="bar"></span>
							<label id="email_label"><?=$parse_lang[$lang]['email']?><p class="asterisk">  *</p></label>
							<?php if($lang == 'ru') echo "<span id='email_remark_ru' class='remark'></span>";
								if($lang == 'eng') echo "<span id='email_remark_eng' class='remark'></span>"; ?>
						</div>
		
						<div id="phone_group" class="group">      
							<input type="text" name="phone" id="phone" value = "<?php echo @$data['phone']; ?>"required>
							<span id="phone_valid" class="valid"></span><span class="bar"></span>
							<label id="phone_label"><?=$parse_lang[$lang]['phone']?></label>
							<?php if($lang == 'ru') echo "<span id='phone_remark_ru' class='remark'></span>";
								if($lang == 'eng') echo "<span id='phone_remark_eng' class='remark'></span>"; ?>
						</div>
						
			</div>
				
					<div class="right">
						<span class="file-form-wrap">
							<div id="preview1"><img src="def_images/defoult_photo.png" height="150px"></div>
						</span>
						
						<?php if($lang == 'ru') echo "<div id='image_remark_ru'></div>";
								if($lang == 'eng') echo "<div id='image_remark_eng'></div>"; ?>

						<div class="file-upload">
							<label>
								<input id="uploaded-file1" type="file" name="image" onchange="image_upload();" />
								<span><?=$parse_lang[$lang]['select_image']?></span><br />
							</label>
						</div>

						<div id="password_group" class = "right_group" >      
							<input type="password" name = "password" id = "password" required>
							<span id="password_valid" class="valid"></span><span class="bar"></span>
							<label id = "password_label"><?=$parse_lang[$lang]['password']?><p class="asterisk">  *</p></label>
							<?php if($lang == 'ru') echo "<span id='password_remark_ru' class='remark'></span>";
								if($lang == 'eng') echo "<span id='password_remark_eng' class='remark'></span>"; ?>
						</div>
		
						<div id="password_2_group" class = "right_group">      
							<input type="password" name = "password_2" id = "password_2" required>
							<span id="password_2_valid" class="valid"></span><span class="bar"></span>
							<label id = "password_2_label"><?=$parse_lang[$lang]['password_repeat']?><p class="asterisk">  *</p></label>
							<?php if($lang == 'ru') echo "<span id='password_2_remark_ru' class='remark'></span>";
								if($lang == 'eng') echo "<span id='password_2_remark_eng' class='remark'></span>"; ?>
						</div>
						
					</div>
				</form>


			<button type = "submit" name = "do_signup" form="signup" id = "button"><?=$parse_lang[$lang]['sign up']?></button>
			
		</div>
		
		<div id="log_in_redirect">
			<a href = "login.php"><?=$parse_lang[$lang]['login']?></a>
		</div>
		
		<script type="text/javascript" src="validation.js"></script>
	</body>
</html>

