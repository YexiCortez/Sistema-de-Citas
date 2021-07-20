<?php

//login.php

include('header.php');

?>

<div class="container">
	<div class="row justify-content-md-center">
		<div class="col col-md-6">
			<span id="message"></span>
			<div class="card">
				<div class="card-header">Registro</div>
				<div class="card-body">
					<form method="post" id="patient_register_form">
						<div class="form-group">
							<label>Correo Electrónico<span class="text-danger">*</span></label>
							<input type="text" name="patient_email_address" id="patient_email_address" class="form-control" required autofocus data-parsley-type="email" data-parsley-trigger="keyup" />
						</div>
						<div class="form-group">
							<label>Contraseña<span class="text-danger">*</span></label>
							<input type="password" name="patient_password" id="patient_password" class="form-control" required  data-parsley-trigger="keyup" />
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Nombre<span class="text-danger">*</span></label>
									<input type="text" name="patient_first_name" id="patient_first_name" class="form-control" required  data-parsley-trigger="keyup" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Apellido<span class="text-danger">*</span></label>
									<input type="text" name="patient_last_name" id="patient_last_name" class="form-control" required  data-parsley-trigger="keyup" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Fecha de nacimiento<span class="text-danger">*</span></label>
									<input type="text" name="patient_date_of_birth" id="patient_date_of_birth" class="form-control" required  data-parsley-trigger="keyup" readonly />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Género<span class="text-danger">*</span></label>
									<select name="patient_gender" id="patient_gender" class="form-control">
										<option value="Male">Masculino</option>
										<option value="Female">Femenino</option>
										<option value="Other">Otro</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Número de celular<span class="text-danger">*</span></label>
									<input type="text" name="patient_phone_no" id="patient_phone_no" class="form-control" required  data-parsley-trigger="keyup" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Estado Civil<span class="text-danger">*</span></label>
									<select name="patient_maritial_status" id="patient_maritial_status" class="form-control">
										<option value="Single">Soltero</option>
										<option value="Married">Casado</option>
										<option value="Seperated">Separado</option>
										<option value="Divorced">Divorciado</option>
										<option value="Widowed">Viudo</option>
									</select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label>Dirección<span class="text-danger">*</span></label>
							<textarea name="patient_address" id="patient_address" class="form-control" required data-parsley-trigger="keyup"></textarea>
						</div>
						<div class="form-group text-center">
							<input type="hidden" name="action" value="patient_register" />
							<input type="submit" name="patient_register_button" id="patient_register_button" class="btn btn-primary" value="Registrarse" />
						</div>

						<div class="form-group text-center">
							<p><a href="login.php">Iniciar Sesión</a></p>
						</div>
					</form>
				</div>
			</div>
			<br />
			<br />
		</div>
	</div>
</div>

<?php

include('footer.php');

?>

<script>

$(document).ready(function(){

	$('#patient_date_of_birth').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true
    });

	$('#patient_register_form').parsley();

	$('#patient_register_form').on('submit', function(event){

		event.preventDefault();

		if($('#patient_register_form').parsley().isValid())
		{
			$.ajax({
				url:"action.php",
				method:"POST",
				data:$(this).serialize(),
				dataType:'json',
				beforeSend:function(){
					$('#patient_register_button').attr('disabled', 'disabled');
				},
				success:function(data)
				{
					$('#patient_register_button').attr('disabled', false);
					$('#patient_register_form')[0].reset();
					if(data.error !== '')
					{
						$('#message').html(data.error);
					}
					if(data.success != '')
					{
						$('#message').html(data.success);
					}
				}
			});
		}

	});

});

</script>