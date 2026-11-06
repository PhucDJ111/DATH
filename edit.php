
<?php
require_once 'config/database.php';

// Lấy ID công việc từ URL
$id = $_GET['id'] ?? 0;

// Kiểm tra ID hợp lệ
if (!filter_var($id, FILTER_VALIDATE_INT) || $id <= 0) {
    exit('ID công việc không hợp lệ!');
}

// Lấy dữ liệu công việc cũ
$sql = "SELECT * FROM tasks WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);

$task = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$task) {
    exit('Không tìm thấy công việc!');
}

// Xử lý khi người dùng nhấn nút cập nhật
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $due_date = $_POST['due_date'] ?? '';

    // Kiểm tra tên công việc
    if ($title === '') {
        exit('Vui lòng nhập tên công việc!');
    }

    // Kiểm tra hạn chót
    if ($due_date !== '' && $due_date < date('Y-m-d')) {
        exit('Hạn chót không được trong quá khứ!');
    }

    // Cập nhật dữ liệu
    $sql = "UPDATE tasks
            SET title = :title,
                description = :description,
                due_date = :due_date
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        'title' => $title,
        'description' => $description,
        'due_date' => $due_date !== '' ? $due_date : null,
        'id' => $id
    ]);

    // Quay lại trang danh sách
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa công việc</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">

    <section class="add-task">
        <h2>Sửa công việc</h2>

        <form action="edit.php?id=<?php echo $id; ?>" method="POST">

            <div class="form-group">
                <label>Tên công việc</label>
                <input
                    type="text"
                    name="title"
                    value="<?php echo htmlspecialchars($task['title']); ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label>Mô tả</label>
                <textarea name="description" rows="3"><?php
                    echo htmlspecialchars($task['description'] ?? '');
                ?></textarea>
            </div>

            <div class="form-group">
                <label>Hạn chót</label>
                <input
                    type="date"
                    name="due_date"
                    value="<?php echo htmlspecialchars($task['due_date'] ?? ''); ?>"
                    min="<?php echo date('Y-m-d'); ?>"
                >
            </div>

            <button type="submit" class="btn btn-primary">
                Cập nhật
            </button>

            <a href="index.php" class="btn btn-danger">
                Quay lại
            </a>

        </form>
    </section>

</div>

</body>
</html>
