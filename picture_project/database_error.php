<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
    <title>מאגר התמונת שלי</title>
    <link rel="stylesheet" href="style.css"/>
    <meta charset="utf-8" />
</head>
<body>
<div id="wrapper">
    <?php include 'top.php'; ?>
    <div id="main">
        <p>
            התגלתה שגיאה בעת ההתחברות למסד הנתונים או בעת שליפת נתונים מן המסד.<br>
            הודעת השגיאה שהתקבלה:      
        </p>
        <p dir=ltr><?php echo $error_message; ?></p>
    </div>
    <?php include 'bottom.php'; ?>
</div>
</body>
</html>