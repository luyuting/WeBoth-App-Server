<!DOCTYPE html>
<html>
	<head>
		<title>Image Editor</title>
		<meta charset = "utf-8" />
		<script src = "js/jquery-1.11.1.min.js"></script>
		<script>
			$(function() {
				$("input[type = 'file']").bind("change", function() {
					var file = this.files[0];
					
					var index = $(this).parent().prevAll().length;
					var img = $("#pic").find("img").eq(index).hide()[0];
					img.file = file;
					  
					var reader = new FileReader();  
					reader.onload = (function(aImg){  
						return function(e){  
							aImg.src = e.target.result;  
						};  
					})(img);  
					reader.readAsDataURL(file);  
					$(img).fadeIn(1000);
				});
				
			});
		</script>
		<style>
			* {
				font-family: 'Consolas', 'Microsoft YaHei';
				text-align: center;
			}
			body {
				background: #555;
			}
			h2 {
				color: #fff;
				text-shadow: 1px 1px 0 #000;
			}
			form {
				background: #fbfbfb;
				margin: 0 auto;
				padding: 30px 30px 10px;
				border-radius: 7px;
				width: 500px;
				border: 1px solid #eee;
				box-shadow: 5px 5px 0 0 #aaa;
			}
			form div:first-child{
				border-top: 1px dashed #c0c0c0;
			}
			form div {
				border-bottom: 1px dashed #c0c0c0;
				padding: 5px 0;
			}
			button {
				padding: 4px 12px;
				width: 80%;
				margin-top: 10px;
			}
			#pic {
				width: 80%;
				margin: 20px auto;
			}
			#pic img{
				width: calc(25% - 10px);
				margin: 0 5px;
				border-radius: 10px;
			}
		</style>
	</head>
	<body>
		<h2>WeBoth Carousel Figure</h2>
		<form action = "admin_action/PageImageAction.php" method = "post" enctype="multipart/form-data">
			<div>
				<input type = "file" name = "img_a"/>
				<input type = "text" name = "describe[]" placeholder = "put url here"/>
			</div>
			<div>
				<input type = "file" name = "img_b"/>
				<input type = "text" name = "describe[]" placeholder = "put url here"/>
			</div>
			<div>
				<input type = "file" name = "img_c"/>
				<input type = "text" name = "describe[]" placeholder = "put url here"/>
			</div>
			<div>
				<input type = "file" name = "img_d"/>
				<input type = "text" name = "describe[]" placeholder = "put url here"/>
			</div>
			<button class = 'add' type = "submit" >提交</button>
		</form>
		<div id = "pic">
			<img /><img /><img /><img />
		</div>
	</body>
</html>