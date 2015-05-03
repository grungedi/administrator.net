<?php

define('DB_NAME', 'xxxxx');

define('DB_USER', 'xxxxx');

define('DB_PASSWORD', 'xxxxx');

define('DB_HOST', 'zxxxxxx');

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
