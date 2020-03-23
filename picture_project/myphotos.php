<?php

require_once 'dbfuncs.php';
session_start();
$err="";
if (!isset($_SESSION["email"]))
{
    header("Location:login.php");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  if ($_POST["addphoto"]=="add_photo"){
        
       header("Location:AddPhoto.php"); 

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
                    <h1> ברוכים הבאים </h1>


                </div>
            </div>
        <table style="margin-left: auto;margin-right: auto" border="1">
            
            <thead>
                <tr><th>כותרת</th><th>תיאור</th><th>תמונה</th><th>משתמש</th><th>פרטים</th></tr>
                
            </thead>
            <tbody>
            <form method="post">
        <?php

      
    $rslt= getphotos($_SESSION['id_user']) ;
          if (!$rslt)
                echo "<tr><td colspan=2>אין נתונים להצגה</td></tr>";
 else {
        foreach ($rslt as $rs ){    
            $src="images/".$rs["id_photo"].".jpg"; 
            echo "<tr><td>".$rs["title"]."</td><td>".$rs["description"]."</td><td><img src='$src' height='80px'/></td><td>".$rs["FK_id_user"]."</td><td><button name=idphoto type=submit method='post' formaction='Addcontent.php' value='".$rs["id_photo"]."'/><img src='images/info.png' height='40px'/></button></td></tr>";}
            
        }

          
             ?>
                    </form>
                </tbody>
     </table>                  
                        
                        
            <form method="post">
            <button type="submit" name="addphoto" value="add_photo">הוספת תמונה</button>
        </form>                 
                    
                    
                    
  
                </div>
    </body>
    </html>


