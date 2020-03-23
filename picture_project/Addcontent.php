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
     $x= $_POST["idphoto"];
     $num_ph=$_POST["idphoto"];
   
             

  
    if (isset($_POST["command"])&& $_POST["command"]=="save_comment")
    {
      $name=  $_SESSION["firstlast"];
      

          $comment=trim(filter_input(INPUT_POST,"ntex",FILTER_SANITIZE_SPECIAL_CHARS));
         $FK_id_user=  $_SESSION["id_user"];
        
      
     $rc=addcomment($comment,$FK_id_user,$num_ph);
     
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
            <div class="noprint">
              <?php include 'top.php';
                                   
              ?>
                <div id="main">
                <div id="userdetail">
                    <h1> הוספת תגובות </h1>


                </div>
                </div></div><div class="printing">
        <?php     $src="images/".$x.".jpg";
          echo "<img src=$src height='80px'/>";
  $tbl=getcontent($x);
  ?>
            <table style="margin-left: auto;margin-right: auto" border="1" class="printing">
            
            <thead>
                <tr><th>תאריך כתיבת הערה</th><th>כותב ההערה</th><th>תוכן</th></tr>
                
            </thead>
            <tbody>
            <form method="post">
        <?php

      


          if (!$tbl)
                echo "<tr><td colspan=2>אין נתונים להצגה</td></tr>";
 else {
        foreach ($tbl as $tb ){    
      
            echo "<tr><td>".$tb["date"]."</td><td>".$tb["owner"]."</td><td>".$tb["Description"]."</td></tr>";}
  
        }

          
             ?>
                    </form>
                </tbody>
     </table>  
           </div> 
            <div class="noprint" >
                
            <form method="post">
                <br>
            <h> הוסף הערה חדשה</h><br>
            <textarea name="ntex" value="tex"></textarea><br>
            <button type="submit" name="command" value="save_comment">שמור הערה </button>
            <input type="hidden" value="<?= $num_ph?>" name="idphoto">
        </form>  
                <a href="javascript:window.print()" style="text-decoration: none"><img src="print/print.gif" id="print">                
               </div>     
                </div>
    </body>
    </html>