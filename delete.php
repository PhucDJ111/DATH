
<?php
require_once 'config/database.php';

// Lấy ID công việc cần xóa
$id = $_POST['id'] ?? 0;

// Kiểm tra ID hợp lệ
if (!filter_var($id, FILTER_VALIDATE_INT) || $id <= 0) {
    exit('ID công việc không hợp lệ!');
}

// Câu lệnh xóa công việc
$sql = "DELETE FROM tasks WHERE id = :id";

$stmt = $pdo->prepare($sql);

// Thực hiện xóa
$stmt->execute([
    'id' => $id
]);

// Quay lại trang danh sách
header('Location: index.php');
exit;
?>
