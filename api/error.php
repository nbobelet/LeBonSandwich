<?php 
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

return [
	'notFoundHandler' => function($c) {
		return function (  $req,  $resp) {
			$tab = array('type' => "error" ,"error" => 400, "Message :" => "Votre requête ne marche pas" );
			$resp = $resp->withHeader('Content-Type','application/json');
			 $resp->withStatus(400)->getBody()->write(json_encode($tab));
			 return $resp;
		};
	},
	'notAllowedHandler' => function($c) {
		return function (  $req,  $resp,$methods) {
			$tab = array('type' => "error" ,"error" => 405, "Message :" => "La Methode n'est pas autorisée" );
						$resp = $resp->withHeader('Content-Type','application/json');
			 $resp->withStatus(405)->getBody()->write(json_encode($tab));
			 return $resp;
		};
	}
]
?>