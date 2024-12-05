<?php

$EM_CONF[$_EXTKEY] = [
	'title' => 'Steinlexikon',
	'description' => 'Steinlexikon von A-Z',
	'category' => 'plugin',
	'constraints'	=> [
		'depends'   => [
        ],
        'conflicts' => [
        ],
	],
	'autoload' => [
		'psr-4' => [
			'Simplesigns\\MlStonelexicon\\' => 'Classes'
		],
	],
    'state' => 'stable',
	'author' => 'simpel signs',
    'author_email' => 'page@simplesigns.de',
    'author_company' => 'simplesigns',
    'version' => '12.4.14',
];