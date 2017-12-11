<table>
<tr><th colspan="2">DOMAIN &amp; FILE INFO</th></tr>
<tr><td>SERVER_NAME</td>     <td><?php echo $_SERVER['SERVER_NAME']; ?>     </td></tr>
<tr><td>PHP_SELF</td>        <td><?php echo $_SERVER['PHP_SELF']; ?>        </td></tr>
<tr><td>SCRIPT_NAME</td>     <td><?php echo $_SERVER['SCRIPT_NAME']; ?>     </td></tr>
<tr><td>SCRIPT_FILENAME</td> <td><?php echo $_SERVER['SCRIPT_FILENAME']; ?> </td></tr>
<tr><td>REQUEST_URI</td>     <td><?php echo $_SERVER['REQUEST_URI']; ?>     </td></tr>
<tr><th colspan="2">USER INFO</th></tr>
<tr><td>IP address</td>       <td><?php echo $_SERVER['REMOTE_ADDR']; ?>    </td></tr>
<tr><td>Browser</td>          <td><?php echo $_SERVER['HTTP_USER_AGENT']; ?></td></tr>
<tr><td>Referring page</td>   <td>
<?php echo (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'Unknown'); ?>
</td></tr>
</table>