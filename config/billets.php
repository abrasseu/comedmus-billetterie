<?php

return [
	// Stocks
	'stock' => [
		540,
		540,
		540
	],
	'seances' => [
		'Jeudi 14 Décembre 2017',
		'Vendredi 15 Décembre 2017',
		'Samedi 16 Décembre 2017'
	],

	// Tarifs
	'tarifsArr' => [
		'cotisant',
		'plein',
		'etudiant',
		'mineur'
	],
	'tarifs' => [
		'cotisant' 	=> 'Cotisant BDE UTC',
		'plein' 	=> 'Plein tarif',
		'etudiant' 	=> 'Étudiant SU',
		'mineur' 	=> 'Mineur'
	],
	'prix' => [
		'cotisant' 	=> 9.00,
		'plein' 	=> 14.00,
		'etudiant' 	=> 11.00,
		'mineur' 	=> 9.00
	],

	// Tarifs étudiant
	'mails_etu'	=> [
		'@utc.fr',
		'@etu.utc.fr',
		'@paris-sorbonne.fr',
		'@etu.upmc.fr',
		'@edu.mnhn.fr',
		'@insead.edu'
	], 

	// Payutc
	'payutc' => [
		'app_key' 	=> env('PAYUTC_KEY', ''),
		'fun_id' 	=> 41,
		'prod' 		=> false,		// Si le serveur est en https : true
		'viaUTC'	=> false,		// Si le serveur passe par le VPN ou le réseau de l'UTC : true
		'trans_url' => 'https://payutc.nemopay.net/validation?tra_id=',
		'productsID_vrai' 	=> [
			'cotisant' 	=> 11418,
			'plein' 	=> 11420,
			'etudiant' 	=> 11417,
			'mineur' 	=> 11419
		],
		// TEST
		'productsID' => [
			'cotisant' 	=> 11084,
			'plein' 	=> 11082,
			'etudiant' 	=> 11244,
			'mineur' 	=> 11083
		]
	],
	'cas' => [
		'login'		=> 'https://cas.utc.fr/cas/login?service=',
		'logout'	=> 'https://cas.utc.fr/cas/logout?service='
	],
	'ginger_key' 	=> env('GINGER_KEY', ''),
	'qr_api_key'	=> env('QR_API_KEY', '')
];
/*
	Ordre des tarifs :
	- cotisant			 	 9€
	- mineur			 	 9€
	- étudiant		 		11€
	- plein tarif			14€
*/
