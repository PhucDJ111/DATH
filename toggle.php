
<?php
require_once 'config/database.php';

// Lấy ID công việc từ form
$id = $_POST['id'] ?? 0;

// Kiểm tra ID hợp lệ
if (!filter_var($id, FILTER_VALIDATE_INT) || $id <= 0) {
    exit('ID công việc không hợp lệ!');
}

// Lấy trạng thái hiện tại của công việc
$sql = "SELECT status FROM tasks WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    'id' => $id
]);

$task = $stmt->fetch(PDO::FETCH_ASSOC);

// Kiểm tra công việc có tồn tại không
if (!$task) {
    exit('Không tìm thấy công việc!');
}

// Đảo ngược trạng thái công việc
$new_status = $task['status'] == 0 ? 1 : 0;

// Cập nhật trạng thái trong database
$sql = "UPDATE tasks SET status = :status WHERE id = :id";
$stmt = $pdo->prepare($sql);

$stmt->execute([
    'status' => $new_status,
    'id' => $id
]);

// Quay lại trang danh sách
header('Location: index.php');
exit;
?>
