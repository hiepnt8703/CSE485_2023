<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "btth01_cse485";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['btnAdd'])) {
            $ten_tgia_new = $_POST['txtAuthorName'];

            $sql_max_id = "SELECT MAX(ma_tgia) AS max_id FROM tacgia";
            $stmt_max_id = $conn->query($sql_max_id);

            if ($stmt_max_id->rowCount() > 0) {
                $row = $stmt_max_id->fetch(PDO::FETCH_ASSOC);
                $max_id = $row['max_id'];
                $ma_tgia_new = $max_id + 1;
            } else {
                $ma_tgia_new = 1;
            }

            $sql_add_author = "INSERT INTO tacgia (ma_tgia, ten_tgia) VALUES (:ma_tgia, :ten_tgia)";
            $stmt_add_author = $conn->prepare($sql_add_author);
            $stmt_add_author->bindParam(':ma_tgia', $ma_tgia_new);
            $stmt_add_author->bindParam(':ten_tgia', $ten_tgia_new);

            if ($stmt_add_author->execute()) {
                header("Location: author.php");
            } else {
                echo "Lỗi thêm dữ liệu: " . $stmt_add_author->errorInfo()[2];
            }
        }
    }
} catch (PDOException $e) {
    die("Kết nối đến cơ sở dữ liệu thất bại: " . $e->getMessage());
} finally {
    $conn = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music for Life</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style_login.css">

</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow p-3 bg-white rounded">
            <div class="container-fluid">
                <div class="h3">
                    <a class="navbar-brand" href="#">Administration</a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="./">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Trang ngoài</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="category.php">Thể loại</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" href="author.php">Tác giả</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="article.php">Bài viết</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>

    </header>
    <div class="container mt-5">
        <h3 class="text-center text-uppercase fw-bold">Thêm mới tác giả</h3>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="input-group mt-3 mb-3">
                <span class="input-group-text" id="lblAuthorName">Tên tác giả</span>
                <input type="text" class="form-control" name="txtAuthorName">
            </div>
            <div class="form-group">
                <input type="submit" value="Thêm" name="btnAdd" class="btn btn-success">
                <a href="author.php" class="btn btn-warning">Quay lại</a>
            </div>
        </form>
    </div>
    <br>
    <br>
    <footer class="bg-white d-flex justify-content-center align-items-center border-top border-secondary  border-2" style="height:80px">
        <h4 class="text-center text-uppercase fw-bold">TLU's music garden</h4>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

</body>
</html>
