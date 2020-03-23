<?php


require_once 'dbfuncs.php';
session_start();
$err="";

$title="";
$description="";
$show="";
$date="";
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{

   
    $title=trim(filter_input(INPUT_POST,"title",FILTER_SANITIZE_SPECIAL_CHARS));
    $description=trim(filter_input(INPUT_POST,"description",FILTER_SANITIZE_SPECIAL_CHARS));
    
      $id_user=$_SESSION["id_user"];
      $category="1";
    if ( empty($title)|| empty($description))
    {
       $err="<script>alert('יש לוודא שכל השדות מולאו כראוי')</script>";
     }
              else {
            $hvfile = false;
            if (isset($_FILES['imgupldr'])) {
                $type = $_FILES["imgupldr"]["type"];
                $size = $_FILES["imgupldr"]["size"];
                $tempnm = $_FILES["imgupldr"]["tmp_name"];
                $orgname=$_FILES["imgupldr"]["name"];
                $error = $_FILES["imgupldr"]["error"];
                if (isset($error) && $error > 0) {
                    $err = "Error uploading file! ";
                } else {
                    if ($type != "image/jpeg" || $size >= 10000000) {
                        $err = "uploaded file Format or file size too big!";
                    } else {
                        $hvfile = true;
                        echo 'תמונה התוספה בהצלחה';
                    }
                }
            } 
            $rc=addphoto($title,$orgname.",".$description,$show,$id_user,$category,$date,$hvfile);
                if ($hvfile) {
                    $target = getcwd() . "/images/" . $rc . ".jpg";
                    $rc2 = move_uploaded_file($tempnm, $target);
                    if (!$rc2) {
                        $err.=" בלי תמונתו!";
                    }
                }
             
                
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

                    <h1> העלאת תמונה חדשה   </h1>

     <form action="addphoto.php" method="post"  enctype="multipart/form-data">
            כותרת:
            <input type="text" name="title" maxlength="8" size="14"  value="<?php echo isset($_POST['title']) ? $_POST['title'] : '' ?>" /><br/>
            תיאור:
            <input type="text" name="description" maxlength="256" size="40" value="<?php echo isset($_POST['description']) ? $_POST['description'] : '' ?>"/><br/>
           תמונה:
           <input type="file" name="imgupldr" accept="image/jpeg"  />
            שתף תמונה:
            <input type="checkbox" name="check" /><br/>
            בחר קטגוריה <br>
            <select name="category">
                <?php 
                $rslt= getcategory() ;
                
                foreach ($rslt as $rs){
                    echo '<option value='.$rs['num_cate'].'>'.$rs['name_cate'].'</option>';
                }
                
                
                
                ?>
            </select><br><br>
            <input type="reset" value="reset"/>
            
            <button type="submit" onclick="window.location.href='addphoto.php'" >הוסף תמונה</button>
            <?= $err ?>

        </form>
        
                </div>
            </div>
        </div>

            