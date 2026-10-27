
<?php
require_once 'config/database.php';

// Lấy danh sách công việc từ database
$sql = "SELECT * FROM tasks ORDER BY id DESC";
$stmt = $pdo->query($sql);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List - Quản lý công việc</title>

    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

    <div class="container">

        <header class="page-header">
            <h1>Todo List</h1>
            <p>Quản lý công việc hằng ngày của bạn</p>
        </header>

        <!-- Form thêm công việc -->
        <section class="add-task">
            <h2>Thêm công việc mới</h2>

            <form action="add.php" method="POST">
                <div class="form-group">
                    <label for="title">Tên công việc</label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        placeholder="Nhập tên công việc..."
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="description">Mô tả</label>
                    <textarea
                        id="description"
                        name="description"
                        placeholder="Nhập mô tả công việc..."
                        rows="3"
                    ></textarea>
                </div>

                <div class="form-group">
                    <label for="due_date">Hạn chót</label>
                    <input
                        type="date"
                        id="due_date"
                        name="due_date"
                        min="<?php echo date('Y-m-d'); ?>"
>   
                </div>

                <button type="submit" class="btn btn-primary">
                    + Thêm công việc
                </button>
            </form>
        </section>

        <!-- Danh sách công việc -->
        <section class="task-section">
            <h2>Danh sách công việc</h2>

            <?php if (count($tasks) > 0): ?>

                <div class="task-list">

                    <?php foreach ($tasks as $task): ?>

                        <div class="task-card
                            <?php echo $task['status'] == 1 ? 'completed' : ''; ?>">

                            <div class="task-info">
                                <h3>
                                    <?php
                                    echo htmlspecialchars($task['title']);
                                    ?>
                                </h3>

                                <?php if (!empty($task['description'])): ?>
                                    <p class="task-description">
                                        <?php
                                        echo nl2br(
                                            htmlspecialchars($task['description'])
                                        );
                                        ?>
                                    </p>
                                <?php endif; ?>

                                <p class="task-date">
                                    Hạn chót:
                                    <?php
                                    echo !empty($task['due_date'])
                                        ? htmlspecialchars($task['due_date'])
                                        : 'Chưa đặt';
                                    ?>
                                </p>

                                <span class="status
                                    <?php echo $task['status'] == 1
                                        ? 'status-done'
                                        : 'status-pending'; ?>">

                                    <?php echo $task['status'] == 1
                                        ? 'Đã hoàn thành'
                                        : 'Chưa hoàn thành'; ?>

                                </span>
                            </div>

                            <div class="task-actions">

                                <form action="toggle.php" method="POST">
                                    <input
                                        type="hidden"
                                        name="id"
                                        value="<?php echo (int) $task['id']; ?>"
                                    >

                                    <button type="submit" class="btn btn-success">
                                        <?php echo $task['status'] == 1
                                            ? 'Chưa xong'
                                            : 'Hoàn thành'; ?>
                                    </button>
                                </form>

                                <a
                                    href="edit.php?id=<?php echo (int) $task['id']; ?>"
                                    class="btn btn-warning"
                                >
                                    Sửa
                                </a>

                                <form
                                    action="delete.php"
                                    method="POST"
                                    onsubmit="return confirm('Bạn có chắc muốn xóa công việc này không?');"
                                >
                                    <input
                                        type="hidden"
                                        name="id"
                                        value="<?php echo (int) $task['id']; ?>"
                                    >

                                    <button type="submit" class="btn btn-danger">
                                        Xóa
                                    </button>
                                </form>

                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>

            <?php else: ?>

                <div class="empty-message">
                    <p>Chưa có công việc nào.</p>
                    <p>Hãy thêm công việc đầu tiên của bạn nhé!</p>
                </div>

            <?php endif; ?>

        </section>

    </div>

</body>
</html>
