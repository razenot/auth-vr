<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Регистрация</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container mt-5" style="width: 760px;">
		<h1>Форма регистрации</h1>
		<form id="vrForm" class="mt-5">
			<div class="row">
				<div class="col-md-12">
					<ul class="errors"></ul>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="name">Имя</label>
					<input type="text" class="form-control" name="name" minlength="2" maxlength="128" pattern="^[а-яА-ЯёЁa-zA-Z0-9\s]+$" required="required" />
				</div>
				<div class="form-group col-md-6">
					<label for="login">Логин</label>
					<input type="text" class="form-control" name="login" minlength="2" maxlength="64" placeholder="Login" pattern="^[a-zA-Z0-9]+$" required="required">
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="email">Email</label>
					<input type="email" class="form-control" name="email" maxlength="128" placeholder="Email" required="required">
				</div>
				<div class="form-group col-md-6">
					<label for="address">Адрес</label>
					<input type="text" class="form-control" name="address" maxlength="256">
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="password">Пароль</label>
					<input type="password" class="form-control" name="password" maxlength="64" placeholder="не менее 8 символов" pattern="(?=^\S.{7,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).\S*$" required="required">
				</div>
				<div class="form-group col-md-6">
					<label for="confirm-password">Подтвердите пароль</label>
					<input type="password" class="form-control" name="confirm-password" minlength="8" maxlength="64" required="required">
				</div>
			</div>
			<div class="form-group">
				<div class="form-check">
					<input class="form-check-input" type="checkbox" name="check"  required="required">
					<label class="form-check-label" for="check">Согласие на обработку данных</label>
				</div>
			</div>
			<button type="submit" class="btn btn-primary vrForm__send">Регистрация</button>
		</form>
	</div>
</body>
</html>


<script>
	var error = []; // Набор сообщений об ошибках
	error["name"] = "Имя может состоять из цифр, латиницы и кириллицы";
	error["login"] = "Логин может состоять из цифр и латинских букв";
	error["password"] = "Пароль должен состоять из строчных и прописных латинских букв и цифр (могут использоваться спецсимволы). Минимум 8 символов";

	$('body').on('click', '.vrForm__send', function(e) { // Обработка кнопки "Регистрация"
		e.preventDefault();
		stopSubmit = false;

		$("ul.errors").empty(); // Чистим блок от возможных сообщений об ошибках
		$(this).closest('#vrForm').find('input').each(function(i, input) { // Прогоняем все инпуты формы через цикл для определения валидности данных
			if (input.validity.valid === false) {
				if(input.validity.patternMismatch){
					input.setCustomValidity(error[input.name]); // Кастомизируем текст ошибки если данные не валидны и не сопоставимы с регулярным выражением
				}else{
					input.setCustomValidity("");
				}
				if (input.validationMessage) {
					$("ul.errors").append('<li class="error">'+ $(input).siblings('label').text()+ ' - ' +input.validationMessage +'</li>'); // Выводим ошибку определенного инпута
					stopSubmit = true;
				}
			}
		});

		if ($.trim($('#vrForm input[name="password"]').val()) != $.trim($('#vrForm input[name="confirm-password"]').val())){ // Проверяем совпадение паролей
			$("ul.errors").append('<li class="error">Пароли не совпадают</li>');
			stopSubmit = true;
		}

		if (!stopSubmit) {
			sendData();
		}
	});

	function sendData() {
		$.ajax({
			url: "ajax/RegistrationAjax.php",
			type: "POST",
			dataType: "json",
			data: $("#vrForm").serialize(),
			success: function(response) {
				if(response == "ok"){
					$(".container").html('<h1>Регистрация завершена!</h1><br><a href="/">На главную</a>');
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
