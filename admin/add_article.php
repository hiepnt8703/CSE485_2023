<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "btth01_cse485btth_ex";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST['btnAdd'])) {

            $tieude = $_POST['txtTieuDe'];
            $ten_bhat = $_POST['txtTenBHat'];
            $ma_tloai = $_POST['txtMaTLoai'];
            $tomtat = $_POST['txtTomTat'];
            $noidung = $_POST['txtNoiDung'];
            $ma_tgia = $_POST['txtMaTgia'];
            $ngayviet = $_POST['txtNgayViet'];

            $sql_max_id = "SELECT MAX(ma_bviet) AS max_id FROM baiviet";
            $stmt_max_id = $conn->query($sql_max_id);

            if ($stmt_max_id->rowCount() > 0) {
                $row = $stmt_max_id->fetch(PDO::FETCH_ASSOC);
                $max_id = $row['max_id'];
                $ma_bviet_new = $max_id + 1;
            } else {
                $ma_bviet_new = 1;
            }

            // Truy vấn SQL để thêm bài viết mới
            $sql_add_article = "INSERT INTO baiviet (ma_bviet, tieude, ten_bhat, ma_tloai, tomtat, noidung, ma_tgia, ngayviet) VALUES (:ma_bviet, :tieude, :ten_bhat, :ma_tloai, :tomtat, :noidung, :ma_tgia, :ngayviet)";
            $stmt_add_article = $conn->prepare($sql_add_article);
            $stmt_add_article->bindParam(':ma_bviet', $ma_bviet_new);
            $stmt_add_article->bindParam(':tieude', $tieude);
            $stmt_add_article->bindParam(':ten_bhat', $ten_bhat);
            $stmt_add_article->bindParam(':ma_tloai', $ma_tloai);
            $stmt_add_article->bindParam(':tomtat', $tomtat);
            $stmt_add_article->bindParam(':noidung', $noidung);
            $stmt_add_article->bindParam(':ma_tgia', $ma_tgia);
            $stmt_add_article->bindParam(':ngayviet', $ngayviet);

            if ($stmt_add_article->execute()) {
                header("Location: article.php");
            } else {
                echo "Lỗi thêm dữ liệu: " . $stmt_add_article->errorInfo()[2];
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
                        <a class="nav-link active fw-bold" href="category.php">Thể loại</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="author.php">Tác giả</a>
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
        <h3 class="text-center text-uppercase fw-bold">Thêm mới bài viết</h3>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="mb-3">
                <label for="txtTieuDe" class="form-label">Tiêu đề</label>
                <input type="text" class="form-control" id="txtTieuDe" name="txtTieuDe" required>
            </div>
            <div class="mb-3">
                <label for="txtTenBHat" class="form-label">Tên bài hát</label>
                <input type="text" class="form-control" id="txtTenBHat" name="txtTenBHat" required>
            </div>
            <div class="mb-3">
                <label for="txtMaTLoai" class="form-label">Mã thể loại</label>
                <input type="text" class="form-control" id="txtMaTLoai" name="txtMaTLoai" required>
            </div>
            <div class="mb-3">
                <label for="txtTomTat" class="form-label">Tóm tắt</label>
                <textarea class="form-control" id="txtTomTat" name="txtTomTat" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="txtNoiDung" class="form-label">Nội dung</label>
                <textarea class="form-control" id="txtNoiDung" name="txtNoiDung" rows="5" required></textarea>
            </div>
            <div class="mb-3">
                <label for="txtMaTgia" class="form-label">Mã tác giả</label>
                <input type="text" class="form-control" id="txtMaTgia" name="txtMaTgia" required>
            </div>
            <div class="mb-3">
                <label for="txtNgayViet" class="form-label">Ngày viết</label>
                <input type="date" class="form-control" id="txtNgayViet" name="txtNgayViet" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Thêm" name="btnAdd" class="btn btn-success">
                <a href="article.php" class="btn btn-warning">Quay lại</a>
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
