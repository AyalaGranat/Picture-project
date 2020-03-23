 <?php
session_start();
 $err="";
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    if ($_POST["command"]=="login")
    {
        if (empty($_POST["email"]) || empty($_POST["pwd"]))
        {
            $err="<script>alert('שם המשתמש או הסיסמא ריקים')</script>";
        }
        else //  user typ data
        {
            $usrdata=array();
             require_once 'dbfuncs.php';
             if (!($usrdata=credentialOk($_POST["email"],$_POST["pwd"])))
             {
                $err="<script>alert('שם המשתמש או הסיסמא או הצירוף שגוי')</script>";
             }
             else //ok credetional
             {
              
                 session_start();
                 $_SESSION["email"]=$usrdata["email"];
                 $_SESSION["firstlast"]=$usrdata["first_name"]." ".$usrdata["last_name"];
                 
                 
                 $_SESSION["firstname"]=$usrdata["first_name"];
                 $_SESSION["lastname"]=$usrdata["last_name"];
                 $_SESSION["id_user"]=$usrdata["id_user"];
                 $_SESSION["manager"]=$usrdata["manager"];
                 
                 header("Location:myphotos.php");
             }
        }
    }// command is: add  
    
    else
    {
         header("Location:newuser.php");
    }
}
 ?>

<!DOCTYPE html>

<html lang="he" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <title>מאגר התמונות שלי</title>
        <link rel="stylesheet" href="style.css"/>
        <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>    
    </head>
    <body>
        <div id="wrapper">
        <?php include 'logintop.php'; ?>
            <div id="main">
                <div id="userdetail">
           <h1>הזן נתונים:</h1>
            <form method="post">
              <label>אימייל</label> <input type="text" name="email">
              <br><br>
               <label> סיסמא</label> <input type="password" name="pwd">
              <br><br>
            <form method="post">
            
            <button type="submit" name="command" value="login">התחבר</button>
            <button type="submit" name="command" value="add">צור משתמש חדש</button>
            <input type="reset" value="reset"/>
        </form>
        <?= $err ?>
                 </div>
            </div>
            <?php include 'footer.php'; ?>
        </div>
    </body>
</html>
