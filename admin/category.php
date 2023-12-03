<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "btth01_cse485";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['delete_id'])) {
        $deleteId = $_GET['delete_id'];

        $deleteBaivietQuery = "DELETE FROM baiviet WHERE ma_tloai = :deleteId";
        $stmt = $conn->prepare($deleteBaivietQuery);
        $stmt->bindParam(':deleteId', $deleteId);
        $stmt->execute();

        $deleteQuery = "DELETE FROM theloai WHERE ma_tloai = :deleteId";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bindParam(':deleteId', $deleteId);

        if ($stmt->execute()) {
            header("Location: category.php");
            exit();
        } else {
            echo "Lỗi khi xóa: " . $stmt->errorInfo()[2];
        }
    }

    $sql = "SELECT * FROM theloai ORDER BY ma_tloai";
    $result = $conn->query($sql);

} catch (PDOException $e) {
    die("Kết nối đến cơ sở dữ liệu thất bại: " . $e->getMessage());
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
    <main class="container mt-5 mb-5">
        <h3 class="text-center text-uppercase fw-bold">Danh sách Thể loại</h3>
        <a href="add_category.php" class="btn btn-primary mb-3">Thêm mới</a>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên thể loại</th>
                    <th>Sửa</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody>
            <?php
                if ($result->rowCount() > 0) {
                foreach ($result as $row) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['ma_tloai']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['ten_tloai']) . "</td>";
                    echo "<td><a href='edit_category.php?id=" . htmlspecialchars($row['ma_tloai']) . "'><i class='fa fa-edit'></i></a></td>";
                    echo "<td><a href='#' class='delete-category' data-id='" . htmlspecialchars($row['ma_tloai']) . "'><i class='fa fa-trash'></i></a></td>";
                    echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Không có dữ liệu</td></tr>";
                }
                ?>
            </tbody>
            </table>
    </main>
    <footer class="bg-white d-flex justify-content-center align-items-center border-top border-secondary  border-2" style="height:80px">
        <h4 class="text-center text-uppercase fw-bold">TLU's music garden</h4>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

        var deleteLinks = document.querySelectorAll('.delete-category');
        deleteLinks.forEach(function(link) {
            link.addEventListener('click', function(event) {
                event.preventDefault(); 

                var categoryId = this.getAttribute('data-id');

                if (confirm('Bạn có chắc chắn muốn xóa?')) {
                window.location.href = 'category.php?delete_id=' + categoryId;
                }
            });
        });
    });
    </script>
    <?php
    $conn = null;
    ?>
</body>
</html>
