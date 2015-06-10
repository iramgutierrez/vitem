<?php 

header('Content-Type: application/json');

if( !isset($_GET['event_id']) || 
	!isset($_GET['assistant']) || 
	!isset($_GET['email']) || 
	!isset($_GET['phone']) 
)
{
	$return = [
		'success' => false,
		'message' => 'No se recibieron todos los datos correctos.'

	];
}
else
{
	$event_id = $_GET['event_id'];

	$event = get_post($event_id);

	$return = [];

	if(!$event){

		$return = [
			'success' => false,
			'message' => 'El evento especificado no existe o no esta disponible.'

		];

	}else
	{
		$assistants = get_post_meta( $event_id, 'assistants', true );

		$assistant = [
			'name' => $_GET['assistant'],
			'email' => $_GET['email'],
			'phone' => $_GET['phone']
		];

		if(!$assistants)
		{
			$assistants = [
				$assistant
			];

		}else
		{
			$assistants = json_decode($assistants , true);

			$assistants[] = $assistant;

		}

		$assistants = json_encode($assistants);

		update_post_meta($event_id , 'assistants' , $assistants );

		$return = [
			'success' => true,
			'message' => 'Se ha realizado correctamente la reservación.'

		];

		$adminEmail = get_option('admin_email');

		$headers  = 'From: Admin contacto@blancoyoga.com'. "\r\n";
		$headers .= 'Reply-To: contacto@blancoyoga.com' . "\r\n" ;
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$headers .= 'X-Mailer: PHP/' . phpversion();
		$para      =  $assistant['email'];
		$titulo    = 'Confirmación de reservación';
		$tituloAdmin    = 'Nueva reservación';
		$messageUser = 'Se ha recibido su reservación para '.$event->post_title;

		$messageAdmin = 'Se ha recibido una nueva reservación para '.$event->post_title. '<br>';
		$messageAdmin .= 'Los datos del contacto son: <br>';
		$messageAdmin .= 'Nombre: '.$assistant['name']. '<br>';
		$messageAdmin .= 'Email: '.$assistant['email']. '<br>';
		$messageAdmin .= 'Teléfono: '.$assistant['phone']. '<br>';

		$mail1 = mail( $para, $titulo, $messageUser, $headers );

		$mail2 = mail( $adminEmail, $tituloAdmin, $messageAdmin, $headers );

		if($mail1)
			$return['mail1'] = true;
		else
			$return['mail1'] = false;

		if($mail2)
			$return['mail2'] = true;
		else
			$return['mail2'] = false;	

	}

}

echo json_encode($return);

exit();



