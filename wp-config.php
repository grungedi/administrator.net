<?php

define('DB_NAME', 'Wp9807');

define('DB_USER', 'Wp9807');

define('DB_PASSWORD', 'eqT4?D?OL4');

define('DB_HOST', 'mysql02.redehost.com.br');

define('DB_CHARSET', 'utf8');

define('DB_COLLATE', '');

define('AUTH_KEY',         'coloque sua frase unica aqui');
define('SECURE_AUTH_KEY',  'coloque sua frase unica aqui');
define('LOGGED_IN_KEY',    'coloque sua frase unica aqui');
define('NONCE_KEY',        'coloque sua frase unica aqui');
define('AUTH_SALT',        'coloque sua frase unica aqui');
define('SECURE_AUTH_SALT', 'coloque sua frase unica aqui');
define('LOGGED_IN_SALT',   'coloque sua frase unica aqui');
define('NONCE_SALT',       'coloque sua frase unica aqui');

$table_prefix  = 'wp_';

define ('WPLANG', 'pt_BR');

define('WP_DEBUG', false);

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
	
require_once(ABSPATH . 'wp-settings.php');
