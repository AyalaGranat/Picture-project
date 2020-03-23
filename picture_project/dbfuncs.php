<?php

try
{
    $db=new PDO("mysql:host=localhost;dbname=picture_project","root","");
     $db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    // השורה הבאה הוכנסה כדי למנוע במצבים מסוימם שיבוש בפלט של תווים בעברית
    $db->exec("set NAMES utf8");
} 
catch (PDOException $ex) 
{
    echo "db Connection problem".$ex->GetMessage();
    exit;
}

function credentialOk($email,$pwd)
{
    try
    {
        global $db;
        $cmd="select email,id_user,last_name,first_name,manager from users where email=:email and password=:pwd";
        $qry=$db->prepare($cmd);
        $qry->bindValue(':email',$email);
        $qry->bindValue(':pwd',$pwd);
        $qry->execute();
        $result=$qry->fetch();
        return $result;
    }
    catch (PDOException $ex)
    {
        echo "db single user select credentional problem".$ex->GetMessage();
        exit;
    }
}


// --הצגת תמונות--
function getphotos($id_user)
{
    try
    {
        
        global $db;
        $cmd="select potos.*,'myphotos' as owner from potos where FK_id_user=:id_user union select potos.* ,CONCAT( users.first_name, users.last_name) as owner from potos, users where FK_id_user=id_user AND FK_id_user !=:id_user AND visible = 1 AND isupdate = 1";
        $qry=$db->prepare($cmd);
        $qry->bindValue(':id_user',$id_user);      
        $qry->execute();
        $result=$qry->fetchAll();
        return $result;
    }

    catch (PDOException $ex)
    {
        echo "db single user select credentional problem".$ex->GetMessage();
        exit;
    }
}


function getcategory()
{
    try
    {
        
        global $db;
        $cmd="select category.*,'mycategory' as owner from category";
        $qry=$db->prepare($cmd);    
        $qry->execute();
        $result=$qry->fetchAll();
        return $result;
    }

    catch (PDOException $ex)
    {
        echo "db single user select credentional problem".$ex->GetMessage();
        exit;
    }
}




function getnotmeusers($email)
{
    try 
    {
        global $db;
        $cmd="select last_name,id_user from users where email=:email";
        $qry=$db->prepare($cmd);
        $qry->bindValue(':email',$email);
        $qry->execute();
        $result=$qry->fetchAll();
        return $result;
    } 
    catch (PDOException $ex)
    {
        echo "db multi user select problem".$ex->GetMessage();
        exit;
    }
}

function dltusrbyid($usrnum)
{
    try 
    {
        global $db;
        $cmd="delete from users where usrnum=:num";
        $qry=$db->prepare($cmd);
        $qry->bindValue(':num',$usrnum);
        $qry->execute();
        $rowcount=$qry->rowCount();
        return $rowcount;
    } 
    catch (PDOException $ex)
    {
        echo "db delete user problem".$ex->GetMessage();
        exit;
    }
}
function userexist($rqstdusrid)
{
     try
    {
        global $db;
        $cmd="select count(*) from users where email=:email";
        $qry=$db->prepare($cmd);
        $qry->bindValue(':email',$rqstdusrid);
        $qry->execute();
        $result=$qry->fetch();
        return $result[0]!=0;
    }
    catch (PDOException $ex)
    {
        echo "db exist user select problem".$ex->GetMessage();
        exit;
    }
}
function newuser($pwd,$lastname,$firstname,$email)
{
    echo $pwd.$lastname.$firstname.$email;
    try 
    {
         global $db;
        $cmd="insert into users (first_name,password,last_name,email) values (:firstname,:pwd,:lastname,:email)";
        $qry=$db->prepare($cmd);
        //$qry->bindValue(':uid',$uid);
        $qry->bindValue(':pwd',$pwd);
        $qry->bindValue(':firstname',$firstname);
        $qry->bindValue(':lastname',$lastname);
         $qry->bindValue(':email',$email);
        $qry->execute();
        $rowcount=$qry->rowCount();
        return ($rowcount==0)?0:$db->lastInsertId();
    } 
    catch (PDOException $ex)
    {
        echo "db add user problem".$ex->GetMessage();
        exit;
    }
}

//function newuser($pwd,$lastname,$firstname,$email)
//{
//    echo $pwd.$lastname.$firstname.$email;
//    try 
//    {
//         global $db;
//        $cmd="insert into users (first_name,password,last_name,email) values (:firstname,:pwd,:lastname,:email)";
//        $qry=$db->prepare($cmd);
//        //$qry->bindValue(':uid',$uid);
//        $qry->bindValue(':pwd',$pwd);
//        $qry->bindValue(':firstname',$firstname);
//        $qry->bindValue(':lastname',$lastname);
//         $qry->bindValue(':email',$email);
//        $qry->execute();
//        $rowcount=$qry->rowCount();
//        return ($rowcount==0)?0:$db->lastInsertId();
//    } 
//    catch (PDOException $ex)
//    {
//        echo "db add user problem".$ex->GetMessage();
//        exit;
//    }
//}
function newcategory($category)
{
    
    try 
    {
         global $db;
        $cmd="insert into category (name_cate) values (:name_cate)";
        $qry=$db->prepare($cmd);
        $qry->bindValue(':name_cate',$category);
        $qry->execute();
        $rowcount=$qry->rowCount();
        return ($rowcount==0)?0:$db->lastInsertId();
    } 
    catch (PDOException $ex)
    {
        echo "db upd user problem".$ex->GetMessage();
        exit;
    }
    
}
function addphoto($title,$description,$visible,$id_user,$category,$date)
{
    echo $category;
    
    try 
    {
         global $db;
        $cmd="insert into potos (title,description,visible,FK_id_user,FK_id_cat,date_up) "
                    . "values (:title,:description,:visible,:id_user,:category,CURRENT_DATE)";
        $qry=$db->prepare($cmd);
       // $qry->bindValue(':date',$date);
        $qry->bindValue(':visible',$visible);
        $qry->bindValue(':title',$title);
         $qry->bindValue(':description',$description);
         $qry->bindValue(':category',$category);
         $qry->bindValue(':id_user',$id_user);
         $qry->execute();
        $rowcount=$qry->rowCount();
        return ($rowcount==0)?0:$db->lastInsertId();
    } 
    catch (PDOException $ex)
    {
        echo "db add user problem".$ex->GetMessage();
        exit;
    }
}

function addcomment($Description,$FK_id_user,$FK_id_photo)
{    
        try 
    {
         global $db;
        $cmd="insert into comments (Description,FK_id_user,FK_id_photo,date) "
                    . "values (:Description,:FK_id_user,:FK_id_photo,CURRENT_DATE)";
        $qry=$db->prepare($cmd);
       // $qry->bindValue(':date',$date);
        $qry->bindValue(':Description',$Description);
        $qry->bindValue(':FK_id_user',$FK_id_user);
         $qry->bindValue(':FK_id_photo',$FK_id_photo);
                  $qry->execute();
        $rowcount=$qry->rowCount();
        return ($rowcount==0)?0:$db->lastInsertId();
    } 
    catch (PDOException $ex)
    {
        echo "db add user problem".$ex->GetMessage();
        exit;
    }
}



function getcontent($idphoto)
{
    try
    {
        
        global $db;
        $cmd='select date,Description,CONCAT( users.first_name," ",users.last_name)as owner from comments,users where FK_id_photo=:id_photo AND comments.FK_id_user=users.id_user';
        $qry=$db->prepare($cmd);
        $qry->bindValue(':id_photo',$idphoto);      
        $qry->execute();
        $result=$qry->fetchAll();
        return $result;
} catch (PDOException $ex)
    {
        echo "db getcontent problem".$ex->GetMessage();
        exit;
    }
}


function updtusrdtls($email,$lastname,$firstname,$password) 
{

    global $db;
    $query = 'UPDATE users
              SET last_name = :lastname,
                  first_name = :firstname,
                  password = :password
              WHERE
                  email    = :email';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email); 
        $statement->bindValue(':password', $password);
        $statement->bindValue(':lastname', $lastname);
        $statement->bindValue(':firstname', $firstname); 
        $statement->execute();
        $row_count = $statement->rowCount();
        $statement->closeCursor();
        return $row_count; // should be 1 if product was updated
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include 'database_error.php';
}}

function deletecate($num_cate){
    
    try 
    {
         global $db;
        $cmd="DELETE FROM category WHERE num_cate = :num_cate AND num_cate NOT IN(SELECT num_cate FROM potos WHERE  FK_id_cat = :num_cate)";
        $qry=$db->prepare($cmd);
        $qry->bindValue(':num_cate',$num_cate);
        $qry->bindValue(':FK_id_cat',$num_cate);
        $qry->execute();
        $rowcount=$qry->rowCount();
        return ($rowcount==0)?-1:0;
    } 
    catch (PDOException $ex)
    {
        echo "db upd user problem".$ex->GetMessage();
        exit;
}
}
