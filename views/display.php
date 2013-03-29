<?php 
error_reporting(E_ALL);

global $kayako2wordpress;
$tickets = $kayako2wordpress->getTickets();
$kayakourl = $kayako2wordpress->getFrontendURLFromSettings();
$tag = $kayako2wordpress->getTagFromSettings();
$newtag = $kayako2wordpress->getNewTagFromSettings();

global $current_user;
get_currentuserinfo();
?>
<div class="wrap">
	<div id="icon-tools" class="icon32"></div>
	<h2>Kayako2Wordpress tickets</h2>
	<p>&nbsp;</p>
<? if(array_key_exists('remove_id', $_GET)) {
	if(!$kayako2wordpress->removeTicket($_GET['remove_id'], $current_user->display_name) ) {
		?><div class="error"><p><strong><?php _e('Could not remove the ticket'); ?></strong></p></div><?
	} else {
		?><div class="updated"><p><strong><?php _e('Ticket removed'); ?> #<?=$_GET['remove_id']?></strong></p></div><?
	}
 } ?>
<? if(array_key_exists('ticket_id', $_GET)) { ?>
	<form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		<div class="tool-box">
		<h3 class="title">Edit ticket: <strong><?=$_GET['ticket_id']?></strong> </h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<label for="kayako_url"><?=__( 'Add Note to ticket' )?> <span> *</span></label>
				</th>
				<td>
<textarea rows="7" cols="40" name="kayako_note"><?=$current_user->display_name?> made a knowledgebase article from this ticket, you can find it at: 
<?php query_posts('posts_per_page=1'); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php the_title(); ?>

<?php the_permalink(); ?>
<?php endwhile; else: ?>
<?php _e('Sorry, no posts matched your criteria.'); ?>
<?php endif; ?>
</textarea>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="kayako_key"><?= __( 'Remove tag from ticket' )?>: <strong><?=$tag?></strong></label>
				</th>
				<td>
					<input type="checkbox" name="kayako_key" id="kayako_key" value="<?php echo $kayako2wordpress_key?>" checked />
				</td>
			</tr>
			<? if(!empty($newtag)){ ?>
			<tr valign="top">
				<th scope="row">
					<label for="kayako_key"><?= __( 'Add new tag from ticket' )?>: <strong><?=$newtag?></strong></label>
				</th>
				<td>
					<input type="checkbox" name="kayako_key" id="kayako_key" value="<?php echo $kayako2wordpress_key?>" checked />
				</td>
			</tr>
			<? } ?>
			<tr valign="top">
				<th scope="row" colspan="2">
					<input type="submit" name="Submit" value="<?php _e('Update ticket', 'save' ) ?>" class="button-primary"/>
				</th>
			</tr>
		</table>

	</form>
	<p>&nbsp;</p>
	<hr>
	<p>&nbsp;</p>
<? } ?>
	<form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		<div class="tool-box">
			<h3 class="title"><?= __( 'Showing all tickets from Kayako with tag' )?>: <strong><?=$tag?></strong> </h3>
			<p>&nbsp;</p>
			<table class="widefat">
				<thead>
				<tr>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
					<th>TicketId</th>
					<th><?= __( 'Subject' )?></th>
					<th><?= __( 'Department' )?></th>
					<th><?= __( 'Status' )?></th>
					<th><?= __( 'Priority' )?></th>
					<th><?= __( 'Creation' )?> <?= __( 'Time' )?></th>
					<th><?= __( 'Last' )?> <?= __( 'Replier' )?></th>
					<th><?= __( 'Last' )?> <?= __( 'Activity' )?></th>
				</tr>
				</thead>
				<? foreach ($tickets as $t) { ?>
				<tbody>
				<tr>
					<td><a href="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>&ticket_id=<?=$t->getDisplayId(); ?>">Done</a></td>
					<td><span class="trash"><a  href="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>&remove_id=<?=$t->getDisplayId(); ?>" onclick="return confirm('<?= __( 'Are you sure?' )?> <?= __( 'This action will remove the tag' );?>:<?=$tag?> <?= __( 'from this ticket');?>');">Remove</a></span></td>
					<td><?=$t->getDisplayId(); ?></td>
					<td><a href="<?=$kayakourl?><?=$t->getDisplayId();?>" target="_blank"><?=$t->getSubject()?></a></td>
					<td><?=$t->getDepartment()->title;?></td>
					<td><?=$t->getStatus()->title?></td>
					<td><?=$t->getPriority()->title?></td>
					<td><?=$t->getCreationTime()?></td>
					<td><?=$t->getLastReplier()?></td>
					<td><?=$t->getLastActivity()?></td>
				</tr>
				</tbody>
				<? } ?>
				<tfoot>
				<tr>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
					<th>TicketId</th>
					<th><?= __( 'Subject' )?></th>
					<th><?= __( 'Department' )?></th>
					<th><?= __( 'Status' )?></th>
					<th><?= __( 'Priority' )?></th>
					<th><?= __( 'Creation' )?> <?= __( 'Time' )?></th>
					<th><?= __( 'Last' )?> <?= __( 'Replier' )?></th>
					<th><?= __( 'Last' )?> <?= __( 'Activity' )?></th>
				</tr>
				</tfoot>
			</table>
		</div>
	</form>
</div>