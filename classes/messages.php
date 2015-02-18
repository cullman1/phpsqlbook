<?php
/**
 * Messages model
 */
class Messages {
/**
 * Messages constructor
 * @param Registry $registry
 * @return void
 */
public function __construct( Registry $registry )
{
   $this->registry = $registry;
}
/**
 * Get a users inbox
 * @param int $user the user
 * @return int the cache of messages
 */
public function getInbox( $user )
{
  $sql = "SELECT IF(m.read=0,'unread','read') as read_style,
   m.subject, m.ID, m.sender, m.recipient, DATE_FORMAT(m.sent, '%D
   %M %Y') as sent_friendly, psender.name as sender_name FROM
   messages m, profile psender WHERE psender.user_id=m.sender AND
   m.recipient=" . $user . " ORDER BY m.ID DESC";
  $cache = $this->registry->getObject('db')->cacheQuery( $sql );
  return $cache;
  }
}

/**
 * View a message
 * @param int $message the ID of the message
 * @return void
 */
private function viewMessage( $message )
{
   require_once( FRAMEWORK_PATH . 'models/message.php' );
   $message = new Message( $this->registry, $message );
   if( $message->getRecipient() == $this->registry-
     >getObject('authenticate')->getUser()->getUserID() )
   {
      $this->registry->getObject('template')-
       >buildFromTemplates('header.tpl.php', 'messages/view.tpl.php',
       'footer.tpl.php');
      $message->toTags( 'inbox_' );
   }
   else
   {
      $this->registry->errorPage( 'Access denied', 'Sorry, you are not
         allowed to view that message');
   }
}
?>