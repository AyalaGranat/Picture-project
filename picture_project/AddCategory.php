<?php
$firstname="";
$lastname="";
require_once 'dbfuncs.php';
$err="";
$allowedinput="style='display:block'";
$atrb="";
$btnvlu="";
$cmdnm="addit";
$cptn="הוסף";

  $category="הוסף";
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{

     $category=trim(filter_input(INPUT_POST,"cate",FILTER_SANITIZE_SPECIAL_CHARS));
  
    if ( empty($category))
    {
        $err="<script>alert('יש לוודא שכל השדות מולאו כראוי')</script>";
    }
        if (userexist($category))
        {
            $err="<script>alert('שם הקטגוריה כבר תפוס');$('#cate').focus();</script>"; 
        }
       else
       {
     
          
            $rc=newcategory($category);
            
           if ($rc==0)
            {
               $err="<script>alert('בעיה בהוספת קטגוריה')</script>";   
            }
            else 
            {
                $err="<script>alert('הוספת הקטגוריה הצליחה')</script>";
       $rc2=false;}}
                
}

?>
 <html lang="he" dir="rtl">
     <head>
        <meta charset="UTF-8">
        <title>מאגר התמונות שלי</title>
        <link rel="stylesheet" href="style.css"/>
        <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
            <script>
            $(document).ready(function () {
                var rqst;
                $("#cate").blur(function () {
                    if (rqst)
                        rqst.abort();
                    var x = $("#cate").val().trim();
                    if (x === "")
                    {
                        $("#statuscate").html("<bold>User Id</bold> couldn't be Empty");
                        setTimeout(function () {                                  
                            $("#cate").focus();
                                }, 100);
                                
                    }
                    else
                    {
                        rqst = $.ajax({url: 'emailajax.php', type: "POST", data: "email=" + x}).done(function (rslt) { // what to do on scuess
                            if (rslt !== "Free")
                            {
                                $("#statuscate").html("<bold>User Id</bold> alredy taken by other");                              setTimeout(function () { $("#cate").focus(); }, 100);
                             rqst = null;
                            }
                            else
                                $("#statuscate").html("");
                        }).fail(function (jqXHR, textStatus) {
                            alert("בעיה בקריאה לשירות ajax".textStatus);// what to do on failure

                        });//ajax calling
                        
                    }
                });//blur

            });//ready
        </script>
    </head>
    <body>
        <div id="wrapper">
              <?php include 'top.php';                         
              ?>
          
                <div id="main">
                <div id="userdetail">
                    <h1>הוספת קטגוריה </h1>


<form action="AddCategory.php" method="post"  enctype="multipart/form-data">
              שם קטגוריה:
               <input type="text" name="cate" id=cate maxlength="20" value=""/><span id="statuscate" style="color:red"></span><br/>
               <input type="reset" value="reset"/>
            <button type="submit" name="command" value="">הוספה</button>
        </form>
        <?= $err ?>
                </div>
            </div>
            </body>