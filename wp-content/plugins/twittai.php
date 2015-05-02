<?php
/*
Plugin Name: Twittaí
Plugin URI: http://tecnocracia.com.br/twittai
Description: Atualiza o Twitter sempre que um post é criado ou atualizado, usando Migre.me, is.gd ou TinyURL (baseado no Twitter Updater).
Version: 1.1.1
Author: Manoel Netto
Author URI: http://tecnocracia.com.br/
*/

// cURL query contributed by Thor Erik (http://thorerik.net)
function getfilefromurl($url) {
	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_HEADER, 0 );
	curl_setopt( $ch, CURLOPT_VERBOSE, 0 );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt( $ch, CURLOPT_URL, $url );
	$output = curl_exec( $ch );
	curl_close( $ch );
	return $output;
}

function Tw_is_future_post() {
	$P = $_POST;
	$nowdate = $P['cur_aa'] . $P['cur_mm'] . $P['cur_jj'] . $P['cur_hh'] . $P['cur_mn'];
	$postdate = $P['aa'] . $P['mm'] . $P['jj'] . $P['hh'] . $P['mn'];
	if ($postdate>$nowdate) return true;
	else return false;
}

function Tw_APIPost($twit, $twitterURI) {
	global $DEBUG, $_POST, $already_twitted;
	$thisLoginDetails = get_option('twitterlogin_encrypted');
	if (!$thisLoginDetails) return true;
	
	$host = 'twitter.com';
	$port = 80;
	$fp = fsockopen($host, $port, $err_num, $err_msg, 10);

	if ($fp) {
		fputs($fp, "POST $twitterURI HTTP/1.1\r\n");
		fputs($fp, "Authorization: Basic ".$thisLoginDetails."\r\n");
		fputs($fp, "User-Agent: ".$agent."\n");
		fputs($fp, "Host: $host\n");
		fputs($fp, "Content-type: application/x-www-form-urlencoded\n");
		fputs($fp, "Content-length: ".strlen($twit)."\n");
		fputs($fp, "Connection: close\n\n");
		fputs($fp, $twit);
		for ($i = 1; $i < 10; $i++){$reply = fgets($fp, 256);}
		fclose($fp);
	}
	$already_twitted = true;
	return $response;
}

function Tw_doLink($thisLink) {
	$miniurl = get_option('miniurl-to-use');
	if ($miniurl == 'migreme') {
		$tinyurl = getfilefromurl("http://migre.me/api.xml?url=".urlencode($thisLink));
		$matchi = preg_match('"(<migre>)(.+)(<\/migre>)"', $tinyurl, $mma);
		$tinyurl = $mma[2];
	} elseif ($miniurl == 'isgd') {
		$tinyurl = getfilefromurl("http://is.gd/api.php?longurl=".$thisLink);
	} else {
		$tinyurl = getfilefromurl("http://tinyurl.com/api-create.php?url=".$thisLink);
	}
	return $tinyurl;
}

function Tw_twit ($post_ID, $act_method)  {
	global $already_twitted, $DEBUG, $_POST;
	if ($_POST['action'] == 'autosave' || $_POST['visibility']!="public" || Tw_is_future_post() || $already_twitted) return true; // avoid unwanted twitts

	$post_ID = ($_POST['post_ID'] && $_POST['post_ID']!=$post_ID)?$_POST['post_ID']:$post_ID;
	$twitterURI = "/statuses/update.xml";
	$thisposttitle = $_POST['post_title'];
	$txtposurl = get_option('txt-pos-url');
	$doLink = get_permalink($post_ID) . $txtposurl;
	$sentence = '';

	if ($_POST['original_post_status'] == 'draft') {
		if ($_POST['post_status'] == 'publish') { // Publishing a NEW post
			if (get_option('newpost-published-update') == '1'){
				$sentence = get_option('newpost-published-text');
				if(get_option('newpost-published-showlink') == '1') {
					$thisposttitle = $thisposttitle . ' -> ' . Tw_doLink($doLink);
				}
				$sentence = str_replace ( '#title#', $thisposttitle, $sentence);
			}
		} elseif ($_POST['originalaction'] == 'post') { // Creating a new post and saving as a draft
			if (get_option('newpost-created-update') == '1') {
				$sentence = get_option('newpost-created-text');
				$sentence = str_replace ( '#title#', $thisposttitle, $sentence);
			}
		} else { // Editing a new post but it's still a draft 
			if(get_option('newpost-edited-update') == '1') {
				$sentence = get_option('newpost-edited-text');
				$sentence = str_replace ( '#title#', $thisposttitle, $sentence);
			}
		}
	} elseif ($_POST['post_status'] == 'publish') {
		if (get_option('oldpost-edited-update') == '1') {
			$sentence = get_option('oldpost-edited-text');
			if (get_option('oldpost-edited-showlink') == '1') {
				$thisposttitle = $thisposttitle . ' -> ' . Tw_doLink($doLink);
			}
			$sentence = str_replace ( '#title#', $thisposttitle, $sentence);
		}
	}
	if ($sentence != '') {
		$sendToTwitter = Tw_APIPost('status='.$sentence, $twitterURI);
		return $post_ID;
	}
	return true;
}

function Tw_save($id) {
	Tw_twit($id, "save");
}

function Tw_publish($post) {
	global $_POST;
	$_POST['post_ID'] = $post->ID;
	$_POST['post_title'] = $post->post_title;
	$_POST['original_post_status'] = 'draft';
	$_POST['post_status'] = 'publish';
	$_POST['visibility']="public";
	Tw_twit($post->ID, "auto-publish");
}

// ADMIN PANEL - under Manage menu
function Tw_addAdminPages() {
    if (function_exists('add_management_page')) {
		 add_management_page('Twittaí', 'Twittaí', 8, __FILE__, 'Twittai_manage_page');
    }
 }

function Twittai_manage_page() {
    include(dirname(__FILE__).'/twittai_manage.php');
}

// HOOKS
add_action ('save_post', 'Tw_save');
add_action ('xmlrpc_publish_post', 'Tw_save');
add_action ('future_to_publish', 'Tw_publish');
add_action ('private_to_publish', 'Tw_publish');
add_action ('pending_to_publish', 'Tw_publish');
add_action ('admin_menu', 'Tw_addAdminPages');
?>