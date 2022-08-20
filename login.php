<?php

@include 'config.php';

session_start();

if(isset($_POST['submit'])){

   /*  isset PHP is used to determine whether a variable is set or not. 
   isset(($_POST['submit'])) method in PHP to test the form is submitted
    successfully or not. 

   $_POST is a PHP super global variable which is used to collect (FORM data) after 
   submitting an HTML form with method="post". 
   $_POST is also widely used to pass variables.

   FILTER_SANITIZE_STRING filter removes tags 
   and remove special characters from a string.
   */

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = md5($_POST['pass']); //password
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $sql = "SELECT * FROM `users` WHERE email = ? AND password = ?";  //db check
   $stmt = $conn->prepare($sql); //used to sql stmt for execution.
   $stmt->execute([$email, $pass]);
   $rowCount = $stmt->rowCount();  
   //  PDO::query($sql)-is to issue a SELECT COUNT(*) statement with the same predicates
   //  as your intended SELECT statement, then use
   //  PDOStatement::fetchColumn() to retrieve the number of matching rows.
   
   //  rowCount() returns the number of rows affected by the last DELETE, INSERT, or
   // UPDATE statement executed by the corresponding PDOStatement object.


   $row = $stmt->fetch(PDO::FETCH_ASSOC);  //fetching / accesing data

   if($rowCount > 0){                        //condn / used to search match in db.

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_id'] = $row['id'];
         header('location:admin_page.php');

      }elseif($row['user_type'] == 'user'){

         $_SESSION['user_id'] = $row['id'];
         header('location:home.php');

      }else{
         $message[] = 'no user found!';
      }

   }else{
      $message[] = 'incorrect email or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">  <!-- Metadata is data (information) about data.-->
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>
 
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/components.css">

</head>
<body>

<?php

if(isset($message)){  //
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

?>
   
<section class="form-container"> <!--login form-->

   <form action="" method="POST">
      <h3>decor den</h3>
      <input type="email" name="email" class="box" placeholder="enter your email" required>
      <input type="password" name="pass" class="box" placeholder="enter your password" required>
      <input type="submit" value="login now" class="btn" name="submit">
      <p>don't have an account? <a href="register.php">register now</a></p>
   </form>

</section>


</body>
</html>

<!-- The GET Method- GET is used to REQUEST data from a specified resource.
get is showed in url

POST Method-- POST is used to SEND data to a server to create/update a resource.

The data sent to the server with POST is stored in the request body of the HTTP request:
POST /test/demo_form.php HTTP/1.1