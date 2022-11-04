<?php
print('<?xml version = "1.0" encoding = "utf-8"?>');
?>
<!DOCTYPE html>

<html">
   <head>
      <title>Database</title>
      <style type = "text/css">
         body  { font-size: 16pt; }
         table { background-color: #ADD8E6 }
         td    { padding-top: 2px;
                 padding-bottom: 2px;
                 padding-left: 4px;
                 padding-right: 4px;
                 border-width: 1px;
                 border-style: inset }
      </style>
   </head>
   <body>
      <?php
         extract( $_POST );

         $query = "SELECT * FROM contacts";
        
         if ( !( $database = pg_connect( "host=35.193.104.165 port=5432 dbname=hip-myth-365520:postgre user=EthanLukeJohnston@gmail.com password=postgre" ) ) )
            die( "Could not connect to database </body></html>" );

         if ( !( $result = pg_query( $database , $query) ) ) 
         {
            print( "Could not execute query! <br />" );
            die( pg_last_error() . "</body></html>" );
         }
      ?>

      <h3>Mailing List Contacts</h3>
      <table>
         <tr>
            <td>ID</td>
            <td>Last Name</td>
            <td>First Name</td>
            <td>E-mail Address</td>
            <td>Phone Number</td>
            <td>Book</td>
            <td>Operating System</td>
         </tr>
         <?php
            for ( $counter = 0; $row = pg_fetch_row( $result );
               $counter++ )
            {
               print( "<tr>" );

               foreach ( $row as $key => $value ) 
                  print( "<td>$value</td>" );

               print( "</tr>" );
            }

            pg_close( $database );
         ?>
      </table>
   </body>
</html>
