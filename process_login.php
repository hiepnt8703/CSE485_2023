<?php
if(isset($_POST['user']) && isset($_POST['pass'])){
    $username = $_POST['user'];
    $password = $_POST['pass'];
    // ket noi CSDL
    try{
        $host = '127.0.0.1';
        $db = 'btth01_cse485';
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,];
        $pdo = new PDO($dsn, $user, $pass,$options);
        
        
        // truy vấn dữ liệu
        $sql = "SELECT * FROM `users` WHERE (username = '$username')";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        

        // kiem tra mat khau co trong database hay không
        if($stm->rowCount() > 0){
            $row = $stm->fetch();
            $pass_saved = $row['password'];
            if($password == $pass_saved){
                header("Location:admin/index.php");
            }else{
                $error = "Password invalid";
                header("Location:login.php?error=$error");
            }
        }else{
            $error = "Username invalid";
            header("Location:login.php?error=$error");
        }
        
        
    }catch(\PDOException $e){
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}



?>