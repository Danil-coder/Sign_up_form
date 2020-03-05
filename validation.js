$(document).ready(function(){

	var username_check = 0;
	var email_check = 0;
	var password_check = 0;
	var password_2_check = 0;
	
	// Unlocking the sign up button if all required fields are valid:
	
	function checksum(){
		var sum = username_check + email_check + password_check + password_2_check;
		
	// Unlock sign up button:
		if(sum == 4){
			$('#button').attr('class', 'none');
			$('#button').attr('type', 'submit');
			$('button').css("color", "#B6B6B6");
		}else{
			
	// Blocking sign up button:
			$('#button').attr('type', 'button');
			$('button').css("color","#B6B6B6");
			$('#button').attr('class', 'disable');	
		}
	}
	
	checksum();
	
	//checking all required fields if trying to click a button when it disabled:
	
	$('.disable').click(function(){
			if($('#username').val() == ''){
				$('#username_remark_ru').text('Пожалуйста, укажите логин');
				$('#username_remark_eng').text('Please enter your username');
				$('#username_valid').text('');
				$('#username').css( "border-bottom", "1px solid red" );
				$('#username_label').css( "color", "red" );
			}
			if($('#email').val() == ''){
				$('#email_remark_ru').text('Пожалуйста, укажите ваш e-mail');
				$('#email_remark_eng').text('Please enter your e-mail');
				$('#email_valid').text('');
				$('#email').css( "border-bottom", "1px solid red" );
				$('#email_label').css( "color", "red" );
			}
			if($('#password').val() == ''){
				$('#password_remark_ru').text('Пожалуйста, введите пароль');
				$('#password_remark_eng').text('Please enter your password');
				$('#password_valid').text('');
				$('#password').css( "border-bottom", "1px solid red" );
				$('#password_label').css( "color", "red" );
			}
			if($('#password_2').val() == ''){
				$('#password_2_remark_ru').text('Пожалуйста, ведите пароль повторно');
				$('#password_2_remark_eng').text('Please repeat your password');
				$('#password_2_valid').text('');
				$('#password_2').css( "border-bottom", "1px solid red" );
				$('#password_2_label').css( "color", "red" );
			}
	});
	
	// Username field validation:
		
	$('#username').blur(function(email_check, password_check, password_2_check){
		
		// Unset notifications:
		$('#username_remark_ru').text('');
		$('#username_remark_eng').text('');
		
		// Set styles for the field active state:
		$('#username').css( "border-bottom", "1px solid #ccc" );
		$('#username_label').css( "color", "#ccc" );
		
		// Regular expressions for username validation:
		var pattern = /^[a-zA-Z0-9-_\.]{1,20}$/;

		if($('#username').val() != ''){
			
			if($('#username').val().search(pattern) == 0){
				
				// Set styles for the field state when entered data is valid:
				$('#username_valid').text('✔');
				$('#username').css( "border-bottom", "1px solid #568052" );
				$('#username_label').css( "color", "#568052" );
				
				username_check = 1;

			}else{
				
				// Set styles for the field state when entered data is not valid:
				$('#username_group').css( "margin-top", "10px" );
				$('#first_name_group').css( "margin-top", "5px" );
				$('#username_remark_ru').text('Логин должен состоять из 2-20 символов (латинские буквы, цифры)');
				$('#username_remark_eng').text('Username must consist of 2-20 characters (Latin letters, numbers)');
				$('#username_valid').text('');
				$('#username').css( "border-bottom", "1px solid red" );
				$('#username_label').css( "color", "red" );
				
				 username_check = 0;
			}
			
		}else{
			
			// Set styles for the field state when it is empty:
			$('#username_remark_ru').text('Пожалуйста, укажите логин');
			$('#username_remark_eng').text('Please enter your username');
			$('#username_valid').text('');
			 username_check = 0;
		}
	
		checksum();
		return username_check;
	});
	
	$('#username').focus(function(){ 
		$('#username_label').css( "color", "#568052" );
	});
	    
// First name field validation:

	$('#first_name').blur(function(){
			
		$('#first_name_remark_ru').text('');
		$('#first_name_remark_eng').text('');
		$('#first_name').css( "border-bottom", "1px solid #ccc" );
		$('#first_name_label').css( "color", "#ccc" );
		var pattern = /^[а-яА-ЯёЁa-zA-Z]{1,20}$/;
		
		if($('#first_name').val() != ''){
			
			if($('#first_name').val().search(pattern) == 0){
				
				$('#first_name_valid').text('✔');
				$('#first_name').css( "border-bottom", "1px solid #568052" );
				$('#first_name_label').css( "color", "#568052" );
			
			}else{
				
				$('#last_name_group').css( "margin-top", "5px" );
				$('#first_name_remark_ru').text('Имя должно состоять из 2-20 символов (латинские или кириллические буквы)');
				$('#first_name_remark_eng').text('The first name must consist of 2-20 characters (Latin or Cyrillic letters)');
				$('#first_name_valid').text('');
				$('#first_name').css( "border-bottom", "1px solid red" );
				$('#first_name_label').css( "color", "red" );
			}
		}
	});
	
	$('#first_name').focus(function(){ 
		$('#first_name_label').css( "color", "#568052" );
	});
		
	// Last name field validation:

	$('#last_name').blur(function(){
			
		$('#last_name_remark_ru').text('');
		$('#last_name_remark_eng').text('');
		$('#last_name').css( "border-bottom", "1px solid #ccc" );
		$('#last_name_label').css( "color", "#ccc" );
		var pattern = /^[а-яА-ЯёЁa-zA-Z]{1,20}$/;
		
		if($('#last_name').val() != ''){
			
			if($('#last_name').val().search(pattern) == 0){
				
				$('#last_name_valid').text('✔');
				$('#last_name').css( "border-bottom", "1px solid #568052" );
				$('#last_name_label').css( "color", "#568052" );

			}else{
				
				$('#email_group').css( "margin-top", "5px" );
				$('#last_name_remark_ru').text('Фамилия должна состоять из 2-20 символов (латинские или кириллические буквы)');
				$('#last_name_remark_eng').text('The last name must consist of 2-20 characters (Latin or Cyrillic letters)');
				$('#last_name_valid').text('');
				$('#last_name').css( "border-bottom", "1px solid red" );
				$('#last_name_label').css( "color", "red" );
			}
		}
	});
	
	$('#last_name').focus(function(){ 
		$('#last_name_label').css( "color", "#568052" );	
	});
	    	
	// Email field validation:	
			
	$('#email').blur(function(username_check, password_check, password_2_check){
			
		var pattern = /^[a-z0-9_-]+@[a-z0-9-]+\.[a-z]{2,6}$/i;
		$('#email_remark_ru').text('');
		$('#email_remark_eng').text('');
		$('#email').css( "border-bottom", "1px solid #ccc" );
		$('#email_label').css( "color", "#ccc" );
		
		if($('#email').val() != ''){
			
			if($('#email').val().search(pattern) == 0){
				
				$('#email_valid').text('✔');
				$('#email').css( "border-bottom", "1px solid #568052" );
				$('#email_label').css( "color", "#568052" );

				email_check = 1;

			}else{
				
				$('#phone_group').css( "margin-top", "5px" );
				$('#email_remark_ru').text('Некорректый формат e-mail. Пожалуйста, убедитесь в правильности введённого e-mail');
				$('#email_remark_eng').text('Incorrect e-mail format. Please make sure that the entered e-mail address is correct');
				$('#email_valid').text('');
				$('#email').css( "border-bottom", "1px solid red" );
				$('#email_label').css( "color", "red" );
				email_check = 0;
			}
			
		}else{
			
			$('#email_remark_ru').text('Пожалуйста, укажите ваш e-mail');
			$('#email_remark_eng').text('Please enter your e-mail');

			$('#email_valid').text('');
			email_check = 0;
		}

	checksum();
	return email_check;
	});
	
	$('#email').focus(function(){ 
		$('#email_label').css( "color", "#568052" );
	});


// Phone field validation:

	$('#phone').blur(function(){
			
		$('#phone_remark_ru').text('');
		$('#phone_remark_eng').text('');
		$('#phone').css( "border-bottom", "1px solid #ccc" );
		$('#phone_label').css( "color", "#ccc" );
		var pattern = /^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/;
		
		if($('#phone').val() != ''){
			
			if($('#phone').val().search(pattern) == 0){
				
				$('#phone_valid').text('✔');
				$('#phone').css( "border-bottom", "1px solid #568052" );
				$('#phone_label').css( "color", "#568052" );
			}else{
				
				$('#phone_remark_ru').text('Некорректый формат номера телефона. Пожалуйста, введите номер в международном формате');
				$('#phone_remark_eng').text('Incorrect phone number format. Please enter the number in international format');
				$('#phone_valid').text('');
				$('#phone').css( "border-bottom", "1px solid red" );
				$('#phone_label').css( "color", "red" );
			}
		}
	});
	
	$('#phone').focus(function(){ 
		$('#phone_label').css( "color", "#568052" );
	});

	// Password field validation:

	$('#password').blur(function(email_check, username_check, password_2_check){
			
		$('#password_remark_ru').text('');
		$('#password_remark_eng').text('');
		$('#password').css( "border-bottom", "1px solid #ccc" );
		$('#password_label').css( "color", "#ccc" );
		var pattern = /^[0-9a-zA-Z!@#$%^&*]{6,40}/;
		
		if($('#password').val() != ''){
			
			if($('#password').val().search(pattern) == 0){
				
				$('#password_valid').text('✔');
				$('#password').css( "border-bottom", "1px solid #568052" );
				$('#password_label').css( "color", "#568052" );
				password_check = 1;

			}else{
				
				$('#password_group').css( "margin-bottom", "6px" );
				$('#password_remark_ru').text('Пароль должен состоять не менее чем из 6 символов (латинские буквы, цифры, спецсимволы)');
				$('#password_remark_eng').text('The password must consist of at least 6 characters (Latin letters, numbers, special characters)');
				$('#password_valid').text('');
				$('#password').css( "border-bottom", "1px solid red" );
				$('#password_label').css( "color", "red" );
				password_check = 0;
			}
			
		}else{
			
			$('#password_remark_ru').text('Пожалуйста, введите пароль');
			$('#password_remark_eng').text('Please enter your password');

			$('#password_valid').text('');
			password_check = 0;
			
		}

		checksum();
		return password_check;
	});
	
	$('#password').focus(function(){ 
		$('#password_label').css( "color", "#568052" );
		
	});
	
	// Password_2 field validation:

	$('#password_2').blur(function(email_check, username_check, password_check){
			
		$('#password_2_remark_ru').text('');
		$('#password_2_remark_eng').text('');
		$('#password_2').css( "border-bottom", "1px solid #ccc" );
		$('#password_2_label').css( "color", "#ccc" );
		var pattern = /(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*]{6,}/g;
		
		if($('#password_2').val() != ''){
			
			if($('#password_2').val() == $('#password').val()){
				
				$('#password_2_valid').text('✔');
				$('#password_2').css( "border-bottom", "1px solid #568052" );
				$('#password_2_label').css( "color", "#568052" );

				password_2_check = 1;

			}else{
				
				$('#password_2_remark_ru').text('Повторный пароль введён неверно');
				$('#password_2_remark_eng').text('Repeated password was entered incorrectly');

				$('#password_2_valid').text('');
				$('#password_2').css( "border-bottom", "1px solid red" );
				$('#password_2_label').css( "color", "red" );
				password_2_check = 0;
			}
			
		}else{
			
			$('#password_2_remark_ru').text('Пожалуйста, введите пароль повторно');
			$('#password_2_remark_eng').text('Please repeat your password');

			$('#password_2_valid').text('');
			password_2_check = 0;
		}
		
		checksum();
		return password_2_check;

	});
	
	$('#password_2').focus(function(){ 
		$('#password_2_label').css( "color", "#568052" );
		
	});
});
