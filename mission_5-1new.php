<!DOCTYPE html>
 <html lang="ja">
     <head>
         <meta charset="utf-8">
         <title>mission_5-1new</title>
     </head>
     <body> 
     <h1>入力フォーム</h1>
         <form action=""method="POST" >
             <input type="text"  placeholder="名前" name="name" >
            <br>
             <input type="text" placeholder="コメント" name="comment" >
             <input type="submit" name="submit" value="送信">
            <br>
             <input type="text" placeholder="パスワード" name="pass1">
         </form>
     <h1>削除フォーム</h1>
         <form action=""method="POST" >
             <input type="number" placeholder="削除対象番号" name="delete" >
             <input type="submit" name="submit" value = "削除">
            <br>
             <input type="text" placeholder="パスワード" name="pass2">
         </form>
　　　<h1>編集フォーム</h1>
         <form action="" method="POST">
             <input type="number" placeholder="編集対象番号" name="editnumber" >
             <br>
             <input type="text" placeholder="名前" name="editname">
            <br>
             <input type="text" placeholder="コメント" name="editcomment">
             <input type="submit" name="edit" value="送信"> 
            <br>
             <input type="text" placeholder="パスワード" name="pass3">
             </form>          
      
        
  <?php 
   $dsn = 'データベース名';
   $user = 'ユーザー名';
   $password = 'パスワード';
   $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

 //データベース作成
 
   $sql = "CREATE TABLE IF NOT EXISTS tbtest"
      ." ("
      . "id INT AUTO_INCREMENT PRIMARY KEY,"
      . "name char(32),"
      . "comment TEXT"
      .");";
      $stmt = $pdo->query($sql);

 //テーブル作成
     
       if(!empty($_POST["name"]) && !empty($_POST["comment"])&& !empty($_POST["pass1"])){
          $sql = $pdo -> prepare("INSERT INTO tbtest2 (name, comment, created, password) VALUES (:name, :comment, :created, :password)");
          $sql -> bindParam(':name', $name, PDO::PARAM_STR);
          $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
          $sql -> bindParam(':created', $date, PDO::PARAM_STR);
          $sql -> bindParam(':password', $pass, PDO::PARAM_STR);
          $name = $_POST["name"];
          $comment = $_POST["comment"];
          $date=date("Y/m/d H:i:s");
          $pass=$_POST["pass1"];
          $sql -> execute();
       }
     //新規投稿　テーブルにデータを登録

       if(!empty($_POST["editnumber"])&& !empty($_POST["editname"])&& !empty($_POST["editcomment"])){
          $id = $_POST["editnumber"] ;//変更する投稿番号
          $name = $_POST["editname"];
          $comment = $_POST["editcomment"]; //変更したい名前、変更したいコメントは自分で決めること
          $date=date("Y/m/d H:i:s");
          $edipass=$_POST["pass3"];
          
          $sql = 'SELECT * FROM tbtest2';
          $stmt = $pdo->query($sql);
          $results = $stmt->fetchAll();
           foreach ($results as $row){
               if($row['password']==$edipass){
                  $sql = 'UPDATE tbtest2 SET name=:name,comment=:comment,created=:created WHERE id=:id';
                  $stmt = $pdo->prepare($sql);
                  $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                  $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                  $stmt->bindParam(':created', $date, PDO::PARAM_STR);
                  $stmt->execute();  
               }
               else{
                   
               }
           }
       }
     //編集機能　テーブルに登録されたデータを編集
     
       if(!empty($_POST["delete"])){
          $id = $_POST["delete"];
          $delpass=$_POST["pass2"];
         
          $sql = 'SELECT * FROM tbtest2';
          $stmt = $pdo->query($sql);
          $results = $stmt->fetchAll();
           foreach ($results as $row){
              if($row['password']==$delpass){
                 $sql = 'delete from tbtest2 where id=:id';
                 $stmt = $pdo->prepare($sql);
                 $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                 $stmt->execute(); 
              }
          
              else{
                  
              }
           }
       }
     //削除機能　テーブルに登録されたデータを削除
      
       $sql = 'SELECT * FROM tbtest2';
       $stmt = $pdo->query($sql);
       $results = $stmt->fetchAll();
       foreach ($results as $row){
         //$rowの中にはテーブルのカラム名が入る
           echo $row['id'].',';
           echo $row['name'].',';
           echo $row['comment'].',';
           echo $row['created'].',';
          
           echo $row['password'].'<br>';
       echo "<hr>";
       }
     //テーブルの登録されたデータを所得し、表示 
    

     
     
  ?>

         
      
     </body> 
 </html>
