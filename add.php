
<?php
require_once 'config/database.php';

// Lấy dữ liệu từ form
$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$due_date = $_POST['due_date'] ?? '';

// Kiểm tra tên công việc rỗng
if ($title === '') {
    exit('Vui lòng nhập tên công việc!');
}

// Kiểm tra hạn chót không được trong quá khứ
if ($due_date !== '' && $due_date < date('Y-m-d')) {
    exit('Hạn chót không được trong quá khứ!');
}

// Câu lệnh thêm dữ liệu
$sql = "INSERT INTO tasks (title, description, due_date)
        VALUES (:title, :description, :due_date)";

// Chuẩn bị và thực thi câu lệnh SQL
$stmt = $pdo->prepare($sql);

$stmt->execute([
    'title' => $title,
    'description' => $description,
    'due_date' => $due_date !== '' ? $due_date : null
]);

// Quay lại trang danh sách
header('Location: index.php');
exit;
?>
