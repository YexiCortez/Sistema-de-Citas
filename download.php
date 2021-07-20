<?php

//download.php

include('class/Appointment.php');

$object = new Appointment;

require_once('class/pdf.php');

if(isset($_GET["id"]))
{
	$html = '<table border="0" cellpadding="5" cellspacing="5" width="100%">';

	$object->query = "
	SELECT hospital_name, hospital_address, hospital_contact_no, hospital_logo 
	FROM admin_table
	";

	$hospital_data = $object->get_result();

	foreach($hospital_data as $hospital_row)
	{
		$html .= '<tr><td align="center">';
		if($hospital_row['hospital_logo'] != '')
		{
			$html .= '<img src="'.substr($hospital_row['hospital_logo'], 3).'" /><br />';
		}
		$html .= '<h2 align="center">'.$hospital_row['hospital_name'].'</h2> <br><br>
		<p align="center">'.$hospital_row['hospital_address'].'</p> <br><br>
		<p align="center"><b>Numero de Celular - </b>'.$hospital_row['hospital_contact_no'].'</p><br><br></td></tr>
		';
	}

	$html .= "
	<tr><td><hr /></td></tr>
	<tr><td>
	";

	$object->query = "
	SELECT * FROM appointment_table 
	WHERE appointment_id = '".$_GET["id"]."'
	";

	$appointment_data = $object->get_result();

	foreach($appointment_data as $appointment_row)
	{

		$object->query = "
		SELECT * FROM patient_table 
		WHERE patient_id = '".$appointment_row["patient_id"]."'
		";

		$patient_data = $object->get_result();

		$object->query = "
		SELECT * FROM doctor_schedule_table 
		INNER JOIN doctor_table 
		ON doctor_table.doctor_id = doctor_schedule_table.doctor_id 
		WHERE doctor_schedule_table.doctor_schedule_id = '".$appointment_row["doctor_schedule_id"]."'
		";

		$doctor_schedule_data = $object->get_result();
		
		$html .= '
		<h4 align="center">Detalles del paciente</h4><br><br>
		<table border="0" cellpadding="5" cellspacing="5" width="100%">';

		foreach($patient_data as $patient_row)
		{
			$html .= '<tr><th width="50%" align="right">Nombre</th><td>'.$patient_row["patient_first_name"].' '.$patient_row["patient_last_name"].'</td></tr>
			<tr><th width="50%" align="right">Número de celular</th><td>'.$patient_row["patient_phone_no"].'</td></tr>
			<tr><th width="50%" align="right">Dirección</th><td>'.$patient_row["patient_address"].'</td></tr>';
		}

		$html .= '</table><br /><hr />
		<h4 align="center">Detalles de la cita</h4><br>
		<table border="0" cellpadding="5" cellspacing="5" width="100%">
			<tr>
				<th width="50%" align="right">Cita No.</th>
				<td>'.$appointment_row["appointment_number"].'</td>
			</tr>
		';
		foreach($doctor_schedule_data as $doctor_schedule_row)
		{
			$html .= '
			<tr>
				<th width="50%" align="right">Nombre del doctor</th>
				<td>'.$doctor_schedule_row["doctor_name"].'</td>
			</tr>
			<tr>
				<th width="50%" align="right">Fecha de la cita</th>
				<td>'.$doctor_schedule_row["doctor_schedule_date"].'</td>
			</tr>
			<tr>
				<th width="50%" align="right">Día de la cita</th>
				<td>'.$doctor_schedule_row["doctor_schedule_day"].'</td>
			</tr>
				
			';
		}

		$html .= '
			<tr>
				<th width="50%" align="right">Hora de la cita</th>
				<td>'.$appointment_row["appointment_time"].'</td>
			</tr>
			<tr>
				<th width="50%" align="right">Razón de la cita</th>
				<td>'.$appointment_row["reason_for_appointment"].'</td>
			</tr>
			<tr>
				<th width="50%" align="right">Va a el hospital</th>
				<td>'.$appointment_row["patient_come_into_hospital"].'</td>
			</tr>
			<tr>
				<th width="50%" align="right">Comentario del Doctor</th>
				<td>'.$appointment_row["doctor_comment"].'</td>
			</tr>
		</table>
			';
	}

	$html .= '
			</td>
		</tr>
	</table>';

	echo $html;

	$pdf = new Pdf();

	$pdf->loadHtml($html, 'UTF-8');
	$pdf->render();
	ob_end_clean();
	//$pdf->stream($_GET["id"] . '.pdf', array( 'Attachment'=>1 ));
	$pdf->stream($_GET["id"] . '.pdf', array( 'Attachment'=>false ));
	exit(0);

}

?>