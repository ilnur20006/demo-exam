<?php
session_start();
require_once("db.php");

$error = "";
$success = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $status = $_POST['status'] ?? "";
    $id = $_POST['id'] ?? "";
    $commit = $_POST['commit'] ?? "";

    if(empty($status) || empty($id)){
        $error = "Заполните все поля";
    } else {
        $sql = "UPDATE user_1 SET status = '$status', commit = '$commit' WHERE id = '$id'";
        if($conn->query($sql) == TRUE){
            $success = "Заявка обновлена";
        } else {
            $error = "Ошибка: " . $conn->error;
        }
    }
}

$sql = "SELECT u1.*, u.fio_name, u.login, u.email, u.telphone 
        FROM user_1 u1 
        LEFT JOIN user u ON u1.user_id = u.id 
        ORDER BY u1.id DESC";
$result = $conn->query($sql);

if(!$result){
    die("Ошибка: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
    <style>
        .success { color: green; background: #e8f5e9; padding: 10px; margin: 10px 0; }
        .error { color: red; background: #ffebee; padding: 10px; margin: 10px 0; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #4CAF50; color: white; }
        textarea { width: 100%; padding: 5px; }
    </style>
</head>
<body>
    <?php if(!empty($success)): ?>
        <div class="success"><?php echo $success; ?></div>
    <?php endif; ?>
    <?php if(!empty($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="" method="post">
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ФИО</th>
                    <th>Логин</th>
                    <th>Email</th>
                    <th>Телефон</th>
                    <th>Адрес дома</th>
                    <th>Дата и время</th>
                    <th>Услуги</th>
                    <th>Оплата</th>
                    <th>Иная услуга</th>
                    <th>Статус</th>
                    <th>Причина отмены</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <form method="post" style="display: contents;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['fio_name'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($row['login'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($row['email'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($row['telephone'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($row['email_a'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($row['datetime'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($row['service'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($row['type'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($row['dlock'] ?? ''); ?></td>
                            <td>
                                <select name="status">
                                    <option value="">Выберите статус</option>
                                    <option value="в работе" <?php echo ($row['status'] == 'в работе') ? 'selected' : ''; ?>>в работе</option>
                                    <option value="выполнено" <?php echo ($row['status'] == 'выполнено') ? 'selected' : ''; ?>>выполнено</option>
                                    <option value="отменено" <?php echo ($row['status'] == 'отменено') ? 'selected' : ''; ?>>отменено</option>
                                </select>
                            </td>
                            <td>
                                <textarea name="commit" placeholder="Причина отмены"><?php echo htmlspecialchars($row['commit_admin'] ?? ''); ?></textarea>
                            </td>
                            <td>
                                <button type="submit">Обновить</button>
                            </td>
                        </form>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </form>
</body>
</html>