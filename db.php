<?php
/*
 *  rating - Rating: an example LTI tool provider
 *  Copyright (C) 2015  Stephen P Vickers
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License along
 *  with this program; if not, write to the Free Software Foundation, Inc.,
 *  51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 *
 *  Contact: stephen@spvsoftwareproducts.com
 *
 *  Version history:
 *    1.0.00   2-Jan-13  Initial release
 *    1.0.01  17-Jan-13  Minor update
 *    1.1.00   5-Jun-13  Added Outcomes service option
 *    1.2.00  20-May-15  Changed to use class method overrides for handling LTI requests
 *                       Added support for Content-Item message
*/

/*
 * This page provides functions for accessing the database.
 */

  require_once('config.php');
  require_once(dirname(__FILE__) . '/' . LTI_FOLDER . 'LTI_Tool_Provider.php');


###
###  Return a connection to the database, return FALSE if an error occurs
###
  function open_db() {

    try {

      $db = new PDO(DB_NAME, DB_USERNAME, DB_PASSWORD);
    } catch(PDOException $e) {
      $db = FALSE;
      $_SESSION['error_message'] = "Database error {$e->getCode()}: {$e->getMessage()}";
    }
    return $db;
  }

    function check_db($db)
    {
        $db_type = '';
        $pos = strpos(DB_NAME, ':');
        $dbExisted = true;
        $prefix = DB_TABLENAME_PREFIX;
        if ($pos !== FALSE) {
            $db_type = strtolower(substr(DB_NAME, 0, $pos));
        }
        if (($db_type == 'mysql') || ($db_type == 'sqlite')) {
            if (!table_exists($db, $prefix . LTI_Data_Connector::CONSUMER_TABLE_NAME)) {
                $dbExisted = false;
            } else if (!table_exists($db, $prefix . LTI_Data_Connector::RESOURCE_LINK_TABLE_NAME)) {
                $dbExisted = false;
            }
        }
        return $dbExisted;
    }


###
###  Check if a table exists
###
  function table_exists($db, $name) {

    $sql = "select 1 from {$name}";
    $query = $db->prepare($sql);
    return $query->execute() !== FALSE;

  }

?>
