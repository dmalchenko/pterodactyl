<?php

return [
	'class' => 'yii\db\Connection',
	'dsn' => 'pgsql:host=10.252.17.244;dbname=ptd',
	'username' => 'postgres',
	'password' => 'postgres',
	'charset' => 'utf8',
	'schemaMap' => [
		'pgsql' => [
			'class' => 'yii\db\pgsql\Schema',
			'defaultSchema' => 'public' //specify your schema here
		]
	],
];
