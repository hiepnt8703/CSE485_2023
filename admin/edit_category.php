<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "btth01_cse485btth_ex";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['id'])) {
        $edit_id = $_GET['id'];

        $sql_select_category = "SELECT * FROM theloai WHERE ma_tloai = :edit_id";
        $stmt = $conn->prepare($sql_select_category);
        $stmt->bindParam(':edit_id', $edit_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() == 1) {
            $ma_tloai = $row['ma_tloai'];
            $ten_tloai = $row['ten_tloai'];
        } else {
            echo "Không tìm thấy thể loại!";
            exit;
        }
    } else {
        echo "Không có thông tin thể loại để sửa!";
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['btnSave'])) {
            $ten_tloai_new = $_POST['txtCatName'];

            $sql_update_category = "UPDATE theloai SET ten_tloai = :ten_tloai_new WHERE ma_tloai = :edit_id";
            $stmt = $conn->prepare($sql_update_category);
            $stmt->bindParam(':ten_tloai_new', $ten_tloai_new);
            $stmt->bindParam(':edit_id', $edit_id);

            if ($stmt->execute()) {
                header("Location: category.php");
                exit();
            } else {
                echo "Lỗi cập nhật dữ liệu: " . $stmt->errorInfo()[2];
            }
        }
    }
} catch (PDOException $e) {
    die("Kết nối đến cơ sở dữ liệu thất bại: " . $e->getMessage());
} finally {
    $conn = null; // Đóng kết nối
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <!-- Bootstrap CSS link và các link CSS khác nếu cần -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style_login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
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
        <h3 class="text-center text-uppercase fw-bold">Sửa thông tin thể loại</h3>
        <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $ma_tloai; ?>" method="post">
            <div class="input-group mt-3 mb-3">
            <span class="input-group-text" id="lblCatId">Mã thể loại</span>
            <input type="text" class="form-control" name="txtCatId" value="<?php echo $ma_tloai; ?>">
            </div>

            <div class="input-group mt-3 mb-3">
            <span class="input-group-text" id="lblCatName">Tên thể loại</span>
            <input type="text" class="form-control" name="txtCatName" value="<?php echo $ten_tloai; ?>">
            </div>

            <div class="form-group float-end">
                <input type="submit" value="Lưu lại" name="btnSave" class="btn btn-success">
                <a href="category.php" class="btn btn-warning">Quay lại</a>
            </div>
        </form>
    </div>
    <br>
    <br>
    <br>
    <br>
    <footer class="bg-white d-flex justify-content-center align-items-center border-top border-secondary  border-2" style="height:80px">
        <h4 class="text-center text-uppercase fw-bold">TLU's music garden</h4>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>
