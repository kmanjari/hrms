<?php

/*
 * Example PHP implementation used for the htmlTable.php example
 */

include( dirname( __FILE__ ) . "/lib/DataTables.php" );

$res = $db->select( 'browsers' );

while ( $row = $res->fetch() ) {
	echo <<<EOD
		<tr id="row_{$row['id']}">
			<td>{$row['browser']}</td>
			<td>{$row['engine']}</td>
			<td>{$row['platform']}</td>
			<td>{$row['version']}</td>
			<td>{$row['grade']}</td>
		</tr>
EOD;
}

