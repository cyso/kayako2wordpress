<?php 

global $kayako2wordpress;

if(array_key_exists('kayako_url', $_POST)) {
	
	if($kayako2wordpress->saveSettings($_POST)) {
		if(!$kayako2wordpress->checkSettings()) {
			?><div class="error"><p><strong><?php _e('Not the right credentials'); ?></strong></p></div><?php
		} else {
			?><div class="updated"><p><strong><?php _e('Options saved successfully'); ?></strong></p></div><?php
		}
	} else {
		?><div class="updated"><p><strong><?php _e('Nothing to save'); ?></strong></p></div><?php
	}
}

$kayako2wordpress_url    		= '';
$kayako2wordpress_key   		= '';
$kayako2wordpress_secret 		= '';
$kayako2wordpress_tag 			= '';
$kayako2wordpress_new_tag 			= '';
$kayako2wordpress_frontend_url 	= '';

$settings = $kayako2wordpress->getSettings();

if($settings) {
	$kayako2wordpress_url	  		= $settings['kayako_url'];
	$kayako2wordpress_key	  		= $settings['kayako_key'];
	$kayako2wordpress_secret  		= $settings['kayako_secret'];
	$kayako2wordpress_tag  	  		= $settings['kayako_tag'];
	$kayako2wordpress_new_tag  	  	= $settings['kayako_new_tag'];
	$kayako2wordpress_frontend_url	= $settings['kayako_frontend_url'];
}

?>
<div class="wrap">
	<div id="icon-options-general" class="icon32"></div>
	<h2>Kayako2Wordpress plugin settings</h2>

	<form method="POST" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		<?php wp_nonce_field('update-options'); ?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<label for="kayako_url"><?=__( 'Kayako API URL' )?> <span> *</span></label>
				</th>
				<td>
					<input type="text" name="kayako_url" id="kayako_url" value="<?php echo $kayako2wordpress_url?>"/>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="kayako_key"><?= __( 'Kayako API Key' )?> <span> *</span></label>
				</th>
				<td>
					<input type="text" name="kayako_key" id="kayako_key" value="<?php echo $kayako2wordpress_key?>"/>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="kayako_secret"><?=__( 'Kayako API Secret' )?> <span> *</span></label>
				</th>
				<td>
					<input type="text" name="kayako_secret" id="kayako_secret" value="<?php echo $kayako2wordpress_secret?>"/>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="kayako_tag"><?=__( 'Search tag' )?>	<span> *</span></label>
				</th>
				<td>
					<input type="text" name="kayako_tag" id="kayako_tag" value="<?php echo $kayako2wordpress_tag?>"/>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="kayako_tag"><?=__( 'New tag' )?></label>
				</th>
				<td>
					<input type="text" name="kayako_new_tag" id="kayako_new_tag" value="<?php echo $kayako2wordpress_new_tag?>"/>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="kayako_frontend_url"><?=__( 'Frontend URL' )?></label>
				</th>
				<td>
					<input type="text" name="kayako_frontend_url" id="kayako_frontend_url" value="<?php echo $kayako2wordpress_frontend_url?>"/>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" colspan="2">
					<input type="submit" name="Submit" value="<?php _e('Save Options', 'save' ) ?>" class="button-primary"/>
				</th>
			</tr>
		</table>
	</form>
	
	<div class="tool-box">
	<br><br><br>
		<h3 class="title"><?=__( 'Documentation' )?></h3>
		
		<h4><?=__( 'Kayako API URL' )?>, <?= __( 'Kayako API Key' )?> and <?=__( 'Kayako API Secret' )?></h4>
        <p>These values can be obtained from your Kayako software or administrator. If you have trouble connecting to your Kayako instance, take a look at the <a href="http://wiki.kayako.com/display/DEV/Kayako+REST+API#KayakoRESTAPI-Response">documentation from Kayako</a>. If you still need help, you can ask your Kayako system administrator or a network specialist for working this out.</p>
        
        <h4><?=__( 'Search tag' )?></h4>
        <p>In Kayako, you can add tags to tickets. The search tag is used to filter tickets from Kayako. If, for example, you use the search tag 'kb' here, you'll see all Kayako tickets tagged 'kb' in the kayako2wordpress tools page.</p>
        
        <h4><?=__( 'New tag' )?></h4>
        <p>When you're done processing a ticket, you can remove the search tag supplied above to remove it from the list here. You can also add a new tag to flag tickets that have been processed by this plugin.</p>
        
        <h4><?=__( 'Frontend URL' )?></h4>
        <p>The <?=__( 'Frontend URL' )?> will be used for linking directly to Kayako tickets from the tools page of this plugin. If you leave it empty, no links will be placed.</p>

        <p>&nbsp;</p>
        <h3 class="title">Kayako PHP API</h3>
        <p>This plugin is based on the <a href="http://forge.kayako.com/projects/kayako-php-api-library">Kayako PHP API Library v.1.1.1</a>. The latest documentation can be found at <a href="http://wiki.kayako.com/display/DEV/PHP+API+Library">wiki.kayako.com</a>.</p>
		
	</div>
</div>