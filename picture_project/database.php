<?php
$dsn = 'mysql:host=localhost;dbname=picture_project';
// $username = 'student602';
// $password = 'student602';
// עקב בעיית תאימות בין גרסאות שרת מסד הנתונים
// וכדי שהיישום יעבוד בכל המחשבים היישום יורץ עם זיהוי של המשתמש
// הראשי שהוא בעל הרשאות מלאות וללא סיסמה
$username = 'root';
$password = '';
 
try {
    $db = new PDO($dsn, $username, $password);
    // הפקודה הבאה הוספה כדי שדיווח שגיאות והודעות אזהרה יהיה מלא ככל הניתן
    // בסיום פיתוח פרוקייט יש לשים שורה זו בהערה
    $db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    // השורה הבאה הוכנסה כדי למנוע במצבים מסוימם שיבוש בפלט של תווים בעברית
    $db->exec("set NAMES utf8"); // this prevent the ?????? on the output
} catch (PDOException $e) {
    echo $e->getMessage();
    exit();
}