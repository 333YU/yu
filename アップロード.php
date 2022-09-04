<?php
    $date = date("Y/m/d/ H:i:s");
    // DB接続設定
    $dsn="データベース名";
    $user="ユーザー名";
    $password="パスワード";
    $pdo = new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    /*array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));はデータベース操作で
    エラーが発生した場合に警告（Warning: ）として表示するために設定するオプション*/
    
    //テーブル作成
    $sql = "CREATE TABLE IF NOT EXISTS mission51"
        ." ("
        ."id INT AUTO_INCREMENT PRIMARY KEY,"
        ."name char(32),"
        ."comment TEXT,"
        ."time TEXT,"
        ."pass char(32)"
        .");";
        $stmt = $pdo->query($sql);

        //編集機能
if(!empty($_POST["name"])&& !empty($_POST["comment"]) && !empty($_POST["pass"])&&!empty($_POST["upda"])){
    $id = $_POST["upda"];
    $name = $_POST["name"];
    $comment = $_POST["comment"];
    $pass = $_POST["pass"];
    $time = $date;
    $sql = 'UPDATE mission51 SET name =:name,comment=:comment,time=:time, pass=:pass WHERE id=:id';
    $stmt = $pdo->prepare($sql);
            
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':time', $time, PDO::PARAM_STR);
    $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    }
    
    //投稿機能
else if(!empty($_POST["name"])&& !empty($_POST["comment"]) && !empty($_POST["pass"])){
    $name1 = $_POST["name"];
    $com1 = $_POST["comment"];
    $pas = $_POST["pass"];
            
    $sql = $pdo -> prepare("INSERT INTO mission51 (name, comment,time,pass) VALUES (:name, :comment, :time, :pass)");
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
    $sql -> bindParam(':time', $time, PDO::PARAM_STR);
    $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
        
    $name = $name1;
    $comment = $com1;
    $time = $date;
    $pass = $pas;
    $sql -> execute();
        }

    //編集の調査
if( !empty($_POST["edi"]) &&  !empty($_POST["pass2"])){
    $update = $_POST["edi"];
    $pass = $_POST["pass2"];
    $name2="";
    $comment2="";
    $id2 = "";

    $sql = 'SELECT * FROM mission51';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
    if($update == $row['id']){
        if($pass == $row['pass']){
            $name2=$row['name'];
            $comment2=$row['comment'];
            $id2 = $row['id'];
        }
    }
}

}
        
    //削除機能
if(!empty($_POST["cut"]) && !empty($_POST["pass1"])){
    $id = $_POST["cut"];
    $pass = $_POST["pass1"];
    
    $sql = 'delete from mission51 where id=:id && pass=:pass';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
    $stmt->execute();
        }
    
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission5-1</title>
</head>
<body>
    
    <h1>掲示板</h1>
    <form action="" method="post">
        名前：<input type="text" name="name"  value="<?php if(!empty($_POST["edi"])){echo $name2;}?>">
        <br>
        コメント：<input type="text" name="comment"  value="<?php if(!empty($_POST["edi"])){echo $comment2;}?>">
        <br>
        パスワード：<input type="text" name="pass" >
        <input type="hidden" name="upda" value="<?php if (!empty($_POST["edi"])) { echo $id2;} ?>" />
        
        <input type="submit" value="送信"><br>
    </form>
   <br>
    <form action="" method="post">
        削除したい番号：<input type="number" name="cut" ><br>
        パスワード：<input type="text" name="pass1" >
        <input type="submit" value="削除"><br>
    </form>
    <br>
    <form action="" method="post">
        編集したい番号：<input type="number" name="edi"><br>
        パスワード：<input type="text" name="pass2">
        <input type="submit" value="編集"><br>
    </form>
   <p>----------------------------------------------------------------------------------------</p>
   <br>
    
    
<?php
    $sql = 'SELECT * FROM mission51';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        echo $row['id'].':';
        echo $row['name'].'「';
        echo $row['comment'].'」';
        echo $row['time'].'<br>';
        echo "<hr>";
        }
?>
</body>
</html>