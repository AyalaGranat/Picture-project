<?php
$rslt="";
require_once 'dbfuncs.php';
session_start();
$err="";

if (!isset($_SESSION["email"]))
{
    header("Location:login.php");
}
 if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $recky = substr($_POST["command"],10);
       if (deletecate($recky) == 0)
       {
                     $err="<script>alert('קטגוריה נמחקה בהצלחה')</script>";
          }
        else
       {
                       $err="<script>alert('בעיה במחיקת קטגוריה')</script>";

       } 
    }
    
?>
 <html lang="he" dir="rtl">
      <head>
        <meta charset="UTF-8">
        <title>מאגר התמונות שלי</title>
        <link rel="stylesheet" href="style.css"/>
        <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>    
    </head>
    <body>
        <div id="wrapper">
              <?php include 'top.php';
                                   
              ?>
                <div id="main">
                <div id="userdetail">
                    <h1> מאגר קטגוריות</h1>


                </div>
            </div>
        <table style="margin-left: auto;margin-right: auto" border="1">
            
            <thead>
                <tr><th>מספר קטגוריה</th><th>שם הקטגוריה</th></tr>
            </thead>
            <tbody>
            <form method="post">
        <?php 
    $rslt= getcategory() ;

          if (!$rslt){
          echo "<tr><td colspan=2>אין נתונים להצגה</td></tr>";
          
          }
           else {
        foreach ($rslt as $rs ){    
           
            echo "<tr><td>".$rs["num_cate"]."</td><td>".$rs["name_cate"]."</td><td><button name=command type=submit value=deletecate".$rs["num_cate"].">מחק אותי</button></td></tr>";
         }
            }

          
             ?>
                    </form>
                </tbody>
     </table>                  
                     
                <?= $err ?>        
                
                </div>
    </body>
    </html>


