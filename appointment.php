<?php

//dashboard.php



include('class/Appointment.php');

$object = new Appointment;

include('header.php');

?>

<div class="container-fluid">
	<?php
	include('navbar.php');
	?>
	<br />
	<div class="card">
		<span id="message"></span>
		<div class="card-header"><h4>Mi Lista de Citas</h4></div>
			<div class="card-body">
				<div class="table-responsive">
		      		<table class="table table-striped table-bordered" id="appointment_list_table">
		      			<thead>
			      			<tr>
			      				<th>Cita No.</th>
			      				<th>Nombre del Doctor</th>
			      				<th>Fecha de la Cita</th>
			      				<th>Horario de la Cita</th>
			      				<th>Día de la Cita</th>
			      				<th>Estado de la Cita</th>
			      				<th>Descargar</th>
			      				<th>Cancelar</th>
			      			</tr>
			      		</thead>
			      		<tbody></tbody>
			      	</table>
			    </div>
			</div>
		</div>
	</div>

</div>

<?php

include('footer.php');

?>


<script>

$(document).ready(function(){

	var dataTable = $('#appointment_list_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"action.php",
			type:"POST",
			data:{action:'fetch_appointment'}
		},
		"columnDefs":[
			{
                "targets":[6, 7],				
				"orderable":false,
			},
		],
	});

	$(document).on('click', '.cancel_appointment', function(){
		var appointment_id = $(this).data('id');
		if(confirm("¿Estás seguro que desea cancelar esta cita?"))
		{
			$.ajax({
				url:"action.php",
				method:"POST",
				data:{appointment_id:appointment_id, action:'cancel_appointment'},
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