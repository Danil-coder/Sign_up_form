function getFileParam() { 			
	try { 				
		var file = document.getElementById('uploaded-file1').files[0];
		
			if (file) { 					
				var fileSize = 0; 					
				
				// Checking image size 
				if (file.size > 5242880) {
					
					// Displaying the notification. Only one of these elements exists (either #image_remark_ru, or #image_remark_eng, depending on the selected language)
					$('#image_remark_ru').text('Размер фото не должен превышать 5 Мбайт');
					$('#image_remark_eng').text('The photo size should not exceed 5 MB');
					
					return;
				}
				// Getting the image format:
				if (/\.(jpe?g|gif|png)$/i.test(file.name)) {
					
					// Creating the image preview:
					var elPreview = document.getElementById('preview1');
					elPreview.innerHTML = '';
					var newImg = document.createElement('img');
					newImg.className = "preview-img";
					$('#image_remark_ru').text('');
					$('#image_remark_eng').text('');
					
					if (typeof file.getAsDataURL=='function') {
						
						if (file.getAsDataURL().substr(0,11)=='data:image/') {
							
							newImg.onload=function() {
								document.getElementById('file-name1').innerHTML+=' ('+newImg.naturalWidth+'x'+newImg.naturalHeight+' px)';
							}
							newImg.setAttribute('src',file.getAsDataURL());
							elPreview.appendChild(newImg);								
						}
					}

					else {
						var reader = new FileReader();
						reader.onloadend = function(evt) {
							
							if (evt.target.readyState == FileReader.DONE) {
								newImg.onload=function() {
									document.getElementById('file-name1').innerHTML+=' ('+newImg.naturalWidth+'x'+newImg.naturalHeight+' px)';
								}
							
								newImg.setAttribute('src', evt.target.result);
								elPreview.appendChild(newImg);
							}
						};
						
						var blob;		
						if (file.slice) {
							blob = file.slice(0, file.size);
						}else if (file.webkitSlice) {
								blob = file.webkitSlice(0, file.size);
							}else if (file.mozSlice) {
								blob = file.mozSlice(0, file.size);
							}
						reader.readAsDataURL(blob);
					}
				}
			}
		}catch(e) {
			var file = document.getElementById('uploaded-file1').value;
			file = file.replace(/\\/g, "/").split('/').pop();
			document.getElementById('file-name1').innerHTML = 'Name: ' + file;
		}
	}