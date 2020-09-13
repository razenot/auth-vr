<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<table class="mt-5">
			<tr>
				<td>id:</td>
				<td><?=$user_data["id"]?></td>
			</tr>
			<tr>
				<td>Имя:</td>
				<td><?=$user_data["name"]?></td>
			</tr>
			<tr>
				<td>Логин:</td>
				<td><?=$user_data["login"]?></td>
			</tr>
			<?if($user_data["address"]){?>
				<tr>
					<td>Адрес:</td>
					<td><?=$user_data["address"]?></td>
				</tr>
			<?}?>
		</table>
		<div id="logout" class="mt-5">Выйти из учетной записи</div>
	</div>
</body>
</html>

<script>
	$('body').on('click', '#logout', function(e) {
		$.ajax({
			url: "ajax/LogoutAjax.php",
			type: "POST",
			success: function(response) {
				window.location.href = 'index.php';
			}
		});
	});
</script>