<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Главная страница</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container mt-5" style="width: 760px;">
		<h1>Авторизация</h1>
		<div class="auth col-md-6 mt-5">
			<form id="vrForm">
				<div class="row">
					<div class="col-md-12">
						<ul class="errors"></ul>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-12">
						<label for="login">Логин</label>
						<input type="text" class="form-control" name="login" required="required">
					</div>
					<div class="form-group col-md-12">
						<label for="password">Пароль</label>
						<input type="password" class="form-control" name="password" required="required">
					</div>
				</div>
				<button type="submit" class="btn btn-primary vrForm__send">Вход</button>
				<div class="text-center mt-3">
					<a href="/registration.php">Регистрация</a>
				</div>
			</form>
		</div>
	</div>
</body>
</html>

<script>
	$('body').on('click', '.vrForm__send', function(e) { // Обработка кнопки "Вход"
		e.preventDefault();
		stopSubmit = false;

		$("ul.errors").empty();
		$(this).closest('#vrForm').find('input').each(function(i, input) {
			if (input.validity.valid === false) {
				if (input.validationMessage) {
					$("ul.errors").append('<li class="error">'+ $(input).siblings('label').text()+ ' - ' +input.validationMessage +'</li>');
					stopSubmit = true;
				}
			}
		});

		if (!stopSubmit) {
			sendData();
		}
	});

	function sendData() {
		$.ajax({
			url: "ajax/LoginAjax.php",
			type: "POST",
			dataType: "json",
			data: $("#vrForm").serialize(),
			success: function(response) {
				if(response == "ok"){
					window.location.href = 'home.php';
				}else{
					$.each(response, function() {
						$("ul.errors").append('<li class="error">'+ this.input+" - "+this.message +'</li>');
					});
				}
			},
			error: function(response) {
				console.log(response);
			}
		});
	}
</script>