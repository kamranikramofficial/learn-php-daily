
<?php 
    // PHP key point 
         // In PHP, keywords (e.g. if, else, while, echo, etc.), classes, functions, and user-defined functions are not case-sensitive
         // but However; all variable names are case-sensitive!

    // Basic PHP Syntax 
       //   this is also use direct  in html than use this 
       //  <?php 

    // Basic output tag 
        #echo is tha tag whic 
       //  echo "Hello World!"; 
    

    # Comment in php
        # There are three type of comment in php
        // This is a single-line comment
        # This is also a single-line comment
        /* This is a
        multi-line comment */


    // Creating (Declaring) PHP Variables
        // When you assign a text value to a variable, put quotes around the value.
        // Unlike other programming languages, PHP has no command for declaring a variable. It is created the moment you first assign a value to it.
 

    // Rules for PHP variables:

       // A variable starts with the $ sign, followed by the name of the variable
       // A variable name must start with a letter or the underscore character
       // A variable name cannot start with a number
       // A variable name can only contain alpha-numeric characters and underscores (A-z, 0-9, and _ )
       // Variable names are case-sensitive ($age and $AGE are two different variables)
    // Example
        // $txt = "W3Schools.com";
        // echo "I love " . $txt . "!"; 
  
    // PHP supports the following data types:
        // String
        // Integer
        // Float (floating point numbers - also called double)
        // Boolean
        // Array
        // Object
        // NULL
        // Resource
    
    // Get the Type
         // To get the data type of a variable, use the var_dump() function.
    
    
    //  PHP Variables Scope
         //In PHP, variables can be declared anywhere in the script.
         //The scope of a variable is the part of the script where the variable can be referenced/used.
         //PHP has three different variable scopes:
         //local
         //global
         //static

    //  Global Scope 
        //  A variable declared outside a function has a GLOBAL SCOPE and can only be accessed outside a function: 
         // Example
            // $x = 5; // global scope
            // function myTest() {
            //   // using x inside this function will generate an error
            //   echo "<p>Variable x inside function is: $x</p>";
            // }
            // myTest();
            // echo "<p>Variable x outside function is: $x</p>";     
    // Local Scope   
         // A variable declared within a function has a LOCAL SCOPE and can only be accessed within that function:
        //  You can have local variables with the same name in different functions, because local variables are only recognized by the function in which they are declared.   
         // Example
                // function myTest() {
                //     $x = 5; // local scope
                //     echo "<p>Variable x inside function is: $x</p>";
                //   }
                //   myTest();  
                //   // using x outside the function will generate an error
                //   echo "<p>Variable x outside function is: $x</p>";
    
    // PHP The global Keyword
        // The global keyword is used to access a global variable from within a function.
        // To do this, use the global keyword before the variables (inside the function):
                // Example
                    // $x = 5;
                    // $y = 10;
                    // function myTest() {
                    //   global $x, $y;
                    //   $y = $x + $y;
                    // }
                    // myTest();
                    // echo $y; // outputs 15

    // PHP The static Keyword
        // The static keyword in PHP is used to define static properties and methods in a class, or to define static variables inside a function that retain their value between function calls.
               // Example
                   // function visitCounter() {
                   //  static $visits = 0;
                   //  $visits++;
                   //  echo "This function was called $visits times.\n";
                   //  }
                   //  visitCounter(); // 1
                   //  visitCounter(); // 2
                   //  visitCounter(); // 3
            
                   
   ?>