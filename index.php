<?php print( '<?xml version = "1.0" encoding = "utf-8"?>' ) ?>
<html>
   <head>
      <title>Registration Form</title>
      <style type = "text/css">
         body        { font-size: 16pt; }
         td          { padding-top: 2px;
                       padding-bottom: 2px;
                       padding-left: 10px;
                       padding-right: 10px }
         div         { text-align: center }
         div div     { font-size: larger }
         .error      { color: red; }
      </style>
   </head>
   <body>
      <?php
         extract( $_POST );
         $error = false;

         $books = array( "Internet and WWW How to Program",
            "C++ How to Program", "Java How to Program",
            "Visual Basic 2005 How to Program" );

         $os = array( "Windows", 
            "Mac OS X", "Linux", "Other");

         $info = array( "fname" => "First Name",
            "lname" => "Last Name", "email" => "Email",
            "phone" => "Phone" );

         if ( isset ( $submit ) )
         {
            if ( $fname == "" )                   
            {
               $formerrors[ "fnameerror" ] = true;
               $error = true;                   
            }

            if ( $lname == "" ) 
            {
               $formerrors[ "lnameerror" ] = true;
               $error = true;
            }

            if ( $email == "" ) 
            {
               $formerrors[ "emailerror" ] = true;
               $error = true;
            }		

            if ( !preg_match( "/^\([0-9]{3}\)[0-9]{3}-[0-9]{4}$/", $phone ) ) 
            {
               $formerrors[ "phoneerror" ] = true;
               $error = true;
            }
            
            if ( !$error )  
            {
               $query = "INSERT INTO contacts " .
                  "( LastName, FirstName, Email, Phone, Book, OS ) " .
                  "VALUES ( '$lname', '$fname', '$email', " . 
                  "'" . quotemeta( $phone ) . "', '$book', '$os' )";

               if ( !( $database = pg_connect( "host=35.193.104.165 port=5432 dbname=hip-myth-365520:postgre user=EthanLukeJohnston@gmail.com password=postgre" ) ) )

                  die( "Could not connect to database" );
             
               if ( !( $result = pg_query( $database, $query ) ) ) 
               {
                  print( "Could not execute query! <br />" );
                  die( pg_last_error() );
               }

               pg_close( $database );

               print( "<p>Hi<span class = 'prompt'>
                  <strong>$fname</strong></span>.
                  Thank you for completing the survey.<br />

                  You have been added to the 
                  <span class = 'prompt'>
                  <strong>$book</strong></span>
                  mailing list.</p>
                  <strong>The following information has been saved 
                  in our database:</strong><br />

                  <table><tr>
                  <td class = 'name'>Name </td>
                  <td class = 'email'>Email</td>
                  <td class = 'phone'>Phone</td>
                  <td class = 'os'>OS</td>
                  </tr><tr>

                  <!-- print each form field's value -->
                  <td>$fname $lname</td>
                  <td>$email</td>
                  <td>$phone</td>
                  <td>$os</td>
                  </tr></table>

                  <br /><br /><br />
                  <div><div>
                  <a href = 'database.php'>
                  Click here to view entire database.</a>
                  </div>This is only a sample form. 
                  You have not been added to a mailing list. 
                  </div></body></html>" );
               die();
            } 
         }

         print( "<h1>Sample Registration Form.</h1>
            <p>Please fill in all fields and click Register.</p>");
     
         if ( $error )                                              
         {                                                            
            print( "<br /><span class = 'largeerror'>                 
               Fields with * need to be filled in properly.</span>" );
         }

         print( "<!-- post form data to form.php -->
            <form method = 'post' action = 'dynamicForm.php'>
            <h2>User Information</h2>

            <!-- create four text boxes for user input -->" );
         foreach ( $info as $inputname => $inputalt )
         {
            $inputtext = $inputvalues[ $inputname ];
          
            print( "<label>$inputalt</label>                 
               <input type = 'text'                
               name = '$inputname' value = '" . $$inputname . "' />" );
            
            if ( $formerrors[ ( $inputname )."error" ] == true ) 
               print( "<span class = 'error'>*</span>" );        
            
            print( "<br />" );
         }

         if ( $formerrors[ "phoneerror" ] ) 
            print( "<span class = 'error'>" );
         else
            print("<span class = 'smalltext'>");
          
         print( "
           <h2>Publications</h2>

            <span class = 'prompt'>
            Which book would you like information about?
            </span>

            <!-- create drop-down list containing book names -->
            <select name = 'book'>" );
               
         foreach ( $books as $currbook ) 
         {
            print( "<option" );
          
            if ( ( $currbook == $book ) )    
               print( " selected = 'true'" );
            
            print( ">$currbook</option>" );
         }
                     
         print( "</select>
            <h2>Operating System</h2>
            <br /><span class = 'prompt'>
            Which operating system do you use?
            <br /></span>

            <!-- create five radio buttons -->" );

         $counter = 0;
        
         foreach ( $os as $current ) 
         {
            print( "<input type = 'radio' name = 'os' 
               value = '$current'" );

            if ( $current == $os )        
                  print( "checked = 'checked'" );
            elseif ( !$os && $counter == 0 )            
               print( "checked = 'checked'" );

            print( " />$current" );
            ++$counter;
         }

         print( "<!-- create a submit button -->
            <br /><input type = 'submit' name = 'submit'
            value = 'Register' /></form></body></html>" );
   ?>