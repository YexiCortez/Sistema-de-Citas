<?php

//doctor.php

include('../class/Appointment.php');

$object = new Appointment;

if(!$object->is_login())
{
    header("location:".$object->base_url."admin");
}

if($_SESSION['type'] != 'Admin')
{
    header("location:".$object->base_url."");
}

include('header.php');

?>

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Gestión de Docotres</h1>

                    <!-- DataTales Example -->
                    <span id="message"></span>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                        	<div class="row">
                            	<div class="col">
                            		<h6 class="m-0 font-weight-bold text-primary">Lista de Doctores</h6>
                            	</div>
                            	<div class="col" align="right">
                            		<button type="button" name="add_doctor" id="add_doctor" class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                            	</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="doctor_table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Imágen de Perfil</th>
                                            <th>Correo</th>
                                            <th>Contraseña</th>
                                            <th>Nombre</th>
                                            <th>Número de teléfono</th>
                                            <th>Especialidad</th>
                                            <th>Estado</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                <?php
                include('footer.php');
                ?>

<div id="doctorModal" class="modal fade">
  	<div class="modal-dialog">
    	<form method="post" id="doctor_form">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title">Añadir Doctor</h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
        			<span id="form_message"></span>
		          	<div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Correo <span class="text-danger">*</span></label>
                                <input type="text" name="doctor_email_address" id="doctor_email_address" class="form-control" required data-parsley-type="email" data-parsley-trigger="keyup" />
                            </div>
                            <div class="col-md-6">
                                <label>Contraseña <span class="text-danger">*</span></label>
                                <input type="password" name="doctor_password" id="doctor_password" class="form-control" required  data-parsley-trigger="keyup" />
                            </div>
		          		</div>
		          	</div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Nombre <span class="text-danger">*</span></label>
                                <input type="text" name="doctor_name" id="doctor_name" class="form-control" required data-parsley-trigger="keyup" />
                            </div>
                            <div class="col-md-6">
                                <label>Número de teléfono <span class="text-danger">*</span></label>
                                <input type="text" name="doctor_phone_no" id="doctor_phone_no" class="form-control" required  data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Dirección </label>
                                <input type="text" name="doctor_address" id="doctor_address" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                <label>Fecha de nacimiento</label>
                                <input type="text" name="doctor_date_of_birth" id="doctor_date_of_birth" readonly class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Estudios <span class="text-danger">*</span></label>
                                <input type="text" name="doctor_degree" id="doctor_degree" class="form-control" required data-parsley-trigger="keyup" />
                            </div>
                            <div class="col-md-6">
                                <label>Especialidad <span class="text-danger">*</span></label>
                                <input type="text" name="doctor_expert_in" id="doctor_expert_in" class="form-control" required  data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Imagen de perfil <span class="text-danger">*</span></label>
                        <br />
                        <input type="file" name="doctor_profile_image" id="doctor_profile_image" />
                        <div id="uploaded_image"></div>
                        <input type="hidden" name="hidden_doctor_profile_image" id="hidden_doctor_profile_image" />
                    </div>
        		</div>
        		<div class="modal-footer">
          			<input type="hidden" name="hidden_id" id="hidden_id" />
          			<input type="hidden" name="action" id="action" value="Añadir" />
          			<input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Añadir" />
          			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        		</div>
      		</div>
    	</form>
  	</div>
</div>

<div id="viewModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal_title">Observar información del Doctor</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="doctor_details">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){

	var dataTable = $('#doctor_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"doctor_action.php",
			type:"POST",
			data:{action:'fetch'}
		},
		"columnDefs":[
			{
				"targets":[0, 1, 2, 4, 5, 6, 7],
				"orderable":false,
			},
		],
	});

    $('#doctor_date_of_birth').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true
    });

	$('#add_doctor').click(function(){
		
		$('#doctor_form')[0].reset();

		$('#doctor_form').parsley().reset();

    	$('#modal_title').text('Agregar Doctor');

    	$('#action').val('Agregar');

    	$('#submit_button').val('Agregar');

    	$('#doctorModal').modal('show');

    	$('#form_message').html('');

	});

	$('#doctor_form').parsley();

	$('#doctor_form').on('submit', function(event){
		event.preventDefault();
		if($('#doctor_form').parsley().isValid())
		{		
			$.ajax({
				url:"doctor_action.php",
				method:"POST",
				data: new FormData(this),
				dataType:'json',
                contentType: false,
                cache: false,
                processData:false,
				beforeSend:function()
				{
					$('#submit_button').attr('disabled', 'disabled');
					$('#submit_button').val('wait...');
				},
				success:function(data)
				{
					$('#submit_button').attr('disabled', false);
					if(data.error != '')
					{
						$('#form_message').html(data.error);
						$('#submit_button').val('Add');
					}
					else
					{
						$('#doctorModal').modal('hide');
						$('#message').html(data.success);
						dataTable.ajax.reload();

						setTimeout(function(){

				            $('#message').html('');

				        }, 5000);
					}
				}
			})
		}
	});

	$(document).on('click', '.edit_button', function(){

		var doctor_id = $(this).data('id');

		$('#doctor_form').parsley().reset();

		$('#form_message').html('');

		$.ajax({

	      	url:"doctor_action.php",

	      	method:"POST",

	      	data:{doctor_id:doctor_id, action:'fetch_single'},

	      	dataType:'JSON',

	      	success:function(data)
	      	{

	        	$('#doctor_email_address').val(data.doctor_email_address);

                $('#doctor_email_address').val(data.doctor_email_address);
                $('#doctor_password').val(data.doctor_password);
                $('#doctor_name').val(data.doctor_name);
                $('#uploaded_image').html('<img src="'+data.doctor_profile_image+'" class="img-fluid img-thumbnail" width="150" />')
                $('#hidden_doctor_profile_image').val(data.doctor_profile_image);
                $('#doctor_phone_no').val(data.doctor_phone_no);
                $('#doctor_address').val(data.doctor_address);
                $('#doctor_date_of_birth').val(data.doctor_date_of_birth);
                $('#doctor_degree').val(data.doctor_degree);
                $('#doctor_expert_in').val(data.doctor_expert_in);

	        	$('#modal_title').text('Editar Doctor');

	        	$('#action').val('Edit');

	        	$('#submit_button').val('Edit');

	        	$('#doctorModal').modal('show');

	        	$('#hidden_id').val(doctor_id);

	      	}

	    })

	});

	$(document).on('click', '.status_button', function(){
		var id = $(this).data('id');
    	var status = $(this).data('status');
		var next_status = 'Active';
		if(status == 'Active')
		{
			next_status = 'Inactive';
		}
		if(confirm("Estás seguro que quieres "+next_status+"?"))
    	{

      		$.ajax({

        		url:"doctor_action.php",

        		method:"POST",

        		data:{id:id, action:'change_status', status:status, next_status:next_status},

        		success:function(data)
        		{

          			$('#message').html(data);

          			dataTable.ajax.reload();

          			setTimeout(function(){

            			$('#message').html('');

          			}, 5000);

        		}

      		})

    	}
	});

    $(document).on('click', '.view_button', function(){
        var doctor_id = $(this).data('id');

        $.ajax({

            url:"doctor_action.php",

            method:"POST",

            data:{doctor_id:doctor_id, action:'fetch_single'},

            dataType:'JSON',

            success:function(data)
            {
                var html = '<div class="table-responsive">';
                html += '<table class="table">';

                html += '<tr><td colspan="2" class="text-center"><img src="'+data.doctor_profile_image+'" class="img-fluid img-thumbnail" width="150" /></td></tr>';

                html += '<tr><th width="40%" class="text-right">Correo Electrónico</th><td width="60%">'+data.doctor_email_address+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Contraseña</th><td width="60%">'+data.doctor_password+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Nombre</th><td width="60%">'+data.doctor_name+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Número de celular</th><td width="60%">'+data.doctor_phone_no+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Dirección</th><td width="60%">'+data.doctor_address+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Fecha de Nacimiento</th><td width="60%">'+data.doctor_date_of_birth+'</td></tr>';
                html += '<tr><th width="40%" class="text-right">Educación</th><td width="60%">'+data.doctor_degree+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Especialidad</th><td width="60%">'+data.doctor_expert_in+'</td></tr>';

                html += '</table></div>';

                $('#viewModal').modal('show');

                $('#doctor_details').html(html);

            }

        })
    });

	$(document).on('click', '.delete_button', function(){

    	var id = $(this).data('id');

    	if(confirm("¿Estás seguro que deseas elimiarlo?"))
    	{

      		$.ajax({

        		url:"doctor_action.php",

        		method:"POST",

        		data:{id:id, action:'delete'},

        		success:function(data)
        		{

          			$('#message').html(data);

          			dataTable.ajax.reload();

          			setTimeout(function(){

            			$('#message').html('');

          			}, 5000);

        		}

      		})

    	}

  	});



});
</script>