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
     
       $pass=$_POST["pass1"];
       $delpass=$_POST["pass2"];
       $edipass=$_POST["pass3"];   
    
       if(isset($_POST["name"]) && isset($_POST["comment"])){
          $sql = $pdo -> prepare("INSERT INTO tbtest (name, comment) VALUES (:name, :comment)");
          $sql -> bindParam(':name', $name, PDO::PARAM_STR);
          $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
          $name = $_POST["name"];
          $comment = $_POST["comment"]; 
          $sql -> execute();
       }
     //新規投稿　テーブルにデータを登録

       if(isset($_POST["editnumber"])&&isset($_POST["editname"])&&isset($_POST["editcomment"])){
          $id = $_POST["editnumber"] ;//変更する投稿番号
          $name = $_POST["editname"];
          $comment = $_POST["editcomment"]; //変更したい名前、変更したいコメントは自分で決めること
          $sql = 'UPDATE tbtest SET name=:name,comment=:comment WHERE id=:id';
          $stmt = $pdo->prepare($sql);
          $stmt->bindParam(':name', $name, PDO::PARAM_STR);
          $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
          $stmt->bindParam(':id', $id, PDO::PARAM_INT);
          $stmt->execute(); 
       }
     //編集機能　テーブル人登録されたデータを編集
     
       if(isset($_POST["delete"])){
          $id = $_POST["delete"];
          $sql = 'delete from tbtest where id=:id';
          $stmt = $pdo->prepare($sql);
          $stmt->bindParam(':id', $id, PDO::PARAM_INT);
          $stmt->execute();
       }
     //削除機能　テーブルに登録されたデータを削除
      
       $sql = 'SELECT * FROM tbtest';
       $stmt = $pdo->query($sql);
       $results = $stmt->fetchAll();
       foreach ($results as $row){
         //$rowの中にはテーブルのカラム名が入る
           echo $row['id'].',';
           echo $row['name'].',';
           echo $row['comment'].'<br>';
       echo "<hr>";
       }
     //テーブルの登録されたデータを所得し、表示 
    

     
     
  ?>

         
      
     </body> 
 </html>