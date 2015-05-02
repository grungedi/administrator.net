<?php 
	//update_option('twitterInitialised', '0');
	//SETS DEFAULT OPTIONS
	if(get_option('twitterInitialised') != '1'){
		update_option('newpost-created-update', '0');
		update_option('newpost-created-text', 'Escrevendo um novo post no blog!');
		
		update_option('newpost-edited-update', '0');
		update_option('newpost-edited-text', 'Ainda escrevendo um novo post ...');

		update_option('newpost-published-update', '1');
		update_option('newpost-published-text', 'Novo post: #title#');
		update_option('newpost-published-showlink', '1');

		update_option('oldpost-edited-update', '1');
		update_option('oldpost-edited-text', 'Update no post: #title#');
		update_option('oldpost-edited-showlink', '1');

		update_option('miniurl-to-use', 'migreme');
		update_option('txt-pos-url', '?utm_source=twitter&utm_medium=wpplugin&utm_campaign=twittai');

		update_option('twitterInitialised', '1');
	}

	if($_POST['submit-type'] == 'options') {
		//UPDATE OPTIONS
		update_option('newpost-created-update', $_POST['newpost-created-update']);
		update_option('newpost-created-text', $_POST['newpost-created-text']);
		
		update_option('newpost-edited-update', $_POST['newpost-edited-update']);
		update_option('newpost-edited-text', $_POST['newpost-edited-text']);

		update_option('newpost-published-update', $_POST['newpost-published-update']);
		update_option('newpost-published-text', $_POST['newpost-published-text']);
		update_option('newpost-published-showlink', $_POST['newpost-published-showlink']);

		update_option('oldpost-edited-update', $_POST['oldpost-edited-update']);
		update_option('oldpost-edited-text', $_POST['oldpost-edited-text']);
		update_option('oldpost-edited-showlink', $_POST['oldpost-edited-showlink']);
		update_option('miniurl-to-use', $_POST['miniurl-to-use']);
		update_option('txt-pos-url', $_POST['txt-pos-url']);

	} else if ($_POST['submit-type'] == 'login'){
		//UPDATE LOGIN
		if (($_POST['twitterlogin'] != '') AND ($_POST['twitterpw'] != '')){
			update_option('twitterlogin', $_POST['twitterlogin']);
			update_option('twitterlogin_encrypted', base64_encode($_POST['twitterlogin'].':'.$_POST['twitterpw']));

		} else {
			echo("<div style='border:1px solid red; padding:20px; margin:20px; color:red;'>Você precisa fornecer seu login e senha do Twitter!</div>");
		}
	}

	// FUNCTION to see if checkboxes should be checked
	function Tw_checkCheckbox($theFieldname){
		if (get_option($theFieldname) == '1'){
			echo ('checked="true"');
		}
	}
?>
<style type="text/css">
	fieldset{margin:20px 0; 
	border:1px solid #cecece;
	padding:15px;
	}
</style>
<div class="wrap">
	<h2>Suas configurações do Twittaí</h2>

	<form method="post">
	<div>
		<fieldset>
			<legend>Ao começar a escrever um novo post</legend>
			<p>
				<input type="checkbox" name="newpost-created-update" id="newpost-created-update" value="1" <?php Tw_checkCheckbox('newpost-created-update')?> />
				<label for="newpost-created-update">Atualizar o Twitter sempre que um novo post (rascunho) é criado (salvo, mas <b>não publicado</b>)</label>
			</p>
			<p>
				<label for="newpost-created-text">Texto para esse update ( use #title# para o título do post )</label><br />
				<input type="text" name="newpost-created-text" id="newpost-created-text" size="60" maxlength="146" value="<?php echo(get_option('newpost-created-text')) ?>" />
			</p>
		</fieldset>

		<fieldset>
			<legend>Ao editar um post rascunho</legend>
			<p>
				<input type="checkbox" name="newpost-edited-update" id="newpost-edited-update" value="1" <?php Tw_checkCheckbox('newpost-edited-update')?> />
				<label for="newpost-edited-update">Atualizar o Twitter sempre que um  post rascunho é editado e salvo (<b>não publicado</b>)</label>
			</p>
			<p>
				<label for="newpost-edited-text">Texto para esse update ( use #title# para o título do post )</label><br />
				<input type="text" name="newpost-edited-text" id="newpost-edited-text" size="60" maxlength="146" value="<?php echo(get_option('newpost-edited-text')) ?>" />
			</p>
		</fieldset>
		
		<fieldset>
			<legend>Ao publicar um novo post</legend>
			<p>
				<input type="checkbox" name="newpost-published-update" id="newpost-published-update" value="1" <?php Tw_checkCheckbox('newpost-published-update')?> />
				<label for="newpost-published-update">Atualizar o Twitter sempre que um novo post é <b>publicado</b></label>
			</p>
			<p>
				<label for="newpost-published-text">Texto para esse update ( use #title# para o título do post )</label><br />
				<input type="text" name="newpost-published-text" id="newpost-published-text" size="60" maxlength="146" value="<?php echo(get_option('newpost-published-text')) ?>" />
				&nbsp;&nbsp;
				<input type="checkbox" name="newpost-published-showlink" id="newpost-published-showlink" value="1" <?php Tw_checkCheckbox('newpost-published-showlink')?> />
				<label for="newpost-published-showlink">Linka o post?</label>
			</p>
		</fieldset>
		
		<fieldset>
			<legend>Ao editar um post existente e publicado (update)			</legend>
			<p>
		    <input type="checkbox" name="oldpost-edited-update" id="oldpost-edited-update" value="1" <?php Tw_checkCheckbox('oldpost-edited-update')?> />
				<label for="oldpost-edited-update">Atualiza o Twitter sempre que um post <b>publicado</b> sofre um <b>update</b></label>
			</p>
			<p>
				<label for="oldpost-edited-text">Texto para esse update ( use #title# para o título do post )</label><br />
				<input type="text" name="oldpost-edited-text" id="oldpost-edited-text" size="60" maxlength="146" value="<?php echo(get_option('oldpost-edited-text')) ?>" />
				&nbsp;&nbsp;
				<input type="checkbox" name="oldpost-edited-showlink" id="oldpost-edited-showlink" value="1" <?php Tw_checkCheckbox('oldpost-edited-showlink')?> />
				<label for="oldpost-edited-showlink">Linka o post?</label>
			</p>
		</fieldset>

		<fieldset>
			<legend>Serviço redutor de URLs</legend>
			<p>
				<label for="miniurl-to-use">Escolha o serviço a ser utilizado para reduzir URLs (default: Migre.me)</label><br />
                <select id="miniurl-to-use" name="miniurl-to-use">
                	<option value="migreme" <?php if (get_option('miniurl-to-use')=="migreme") echo "selected=\"selected\""; ?> >Migre.me</option>
                    <option value="isgd" <?php if (get_option('miniurl-to-use')=="isgd") echo "selected=\"selected\""; ?> >IS.gd</option>
                    <option value="tinyurl" <?php if (get_option('miniurl-to-use')=="tinyurl") echo "selected=\"selected\""; ?> >TinyURL</option>
                </select>
            </p>
			<p>
				<label for="txt-pos-url">Variáveis adicionais da URL (opcional. Ex: variáveis utm para tracking)</label><br />
				<input type="text" name="txt-pos-url" id="txt-pos-url" size="60" maxlength="250" value="<?php echo(get_option('txt-pos-url')) ?>" />
            </p>

		</fieldset>

		<input type="hidden" name="submit-type" value="options">
		<input type="submit" name="submit" value="save options" />
	</div>
	</form>
</div>

<div class="wrap">
	<h2>Suas configurações do Twitter</h2>
	
	<form method="post" >
	<div>
		<p>
		<label for="twitterlogin">Seu e-mail cadastrado no Twitter:</label>
		<input type="text" name="twitterlogin" id="twitterlogin" value="<?php echo(get_option('twitterlogin')) ?>" />
		</p>
		<p>
		<label for="twitterpw">Sua senha do Twitter:</label>
		<input type="password" name="twitterpw" id="twitterpw" value="" />
		</p>
		<input type="hidden" name="submit-type" value="login">
		<p><input type="submit" name="submit" value="save login" />
		&nbsp; ( <strong>Não tem uma conta no Twitter? <a href="http://www.twitter.com">Crie uma grátis</a></strong> )</p>
	</div>
	</form>
	
</div>

<div class="wrap">
	<h2>Precisa de ajuda?</h2>
	<p>Visite a <a href="http://tecnocracia.com.br/twittai/">página oficial</a> do plugin.</p>
</div>