<?php
    include("database.php");

    if($_SERVER["REQUEST_METHOD"]== "POST")
    {
        $username = $_POST["name"] ?? "";
        $password = $_POST["password"] ?? "";
        $email = $_POST["email"] ??"";

        if(!empty($username) && !empty($password) && !empty($email)){
            try{
                $query = "INSERT INTO users (name, email, password) VALUES (?,?,?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("sss", $username, $email, $password);
                if ($stmt->execute()) {
                    // После успешной регистрации перенаправляем пользователя
                    header("Location: " . $_SERVER['PHP_SELF']); // Перенаправление на ту же страницу
                    exit(); // Завершаем выполнение скрипта после перенаправления
                } else {
                    echo "Ошибка при регистрации пользователя: " . $stmt->error;
                }
            }  
            catch(mysqli_sql_exception $e){
                echo "Ошибка при добавлении данных:". $e->getMessage();
            }
        }else{
            echo "Пожалуйста заполните все поля";
        }
    }
    $users = [];
    try{
        $query = "SELECT id, name, email FROM users";
        $result = $conn ->query($query);
        while($row = $result -> fetch_assoc()){
            $users[] = $row;
        }
    }
    catch(mysqli_sql_exception $e)
    {
        echo "Ошибка при извлечении данных". $e->getMessage();
    }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тестовая таблица</title>
</head>
    <body>
    <script src="https://testcj/index.js" defer></script>

        <h2>Регистрация</h2>
        <form action="<?php echo htmlspecialchars( $_SERVER["PHP_SELF"]); ?>" method="post">
            <label>Логин</label><br>
            <input name = "name" type="text"><br>
            <label for="">Почта</label><br>
            <input name = "email" type="text"><br>
            <label>Пароль</label><br>
            <input name = "password" type="password"><br>
            <input type="submit" value="Зарегистрироваться"><br>
        </form>
        <h3>Список пользователей</h3>
        <table id="myTable" border = "1" cellpadding ="5" cellspacing ="0">
            <thead>
        <tr>
            <th onclick="sortTable(0)" >ID</th>
            <th onclick="sortTable(1)">Имя</th>
            <th onclick="sortTable(2)">Почта</th>
        </tr>
        </thead>
            <tbody>
                <?php if (!empty($users)):?>
                    <?php foreach ($users as $user ): ?>
                        <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo htmlspecialchars($user['name']);?></td>
                        <td><?php echo htmlspecialchars($user['email']);?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">Пользователи отсутствуют</td>
                            </tr>
                            <?php endif; ?>
            </tbody>
        </table>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <button type="submit" name="delete_all" onclick="return confirm('Вы уверены, что хотите удалить все данные?')">Удалить все данные</button>
                </form>
                    <?php 
                    if (isset($_POST['delete_all'])) {
                        try {
                            // Выполняем удаление всех записей из таблицы
                            $deleteQuery = "DELETE FROM users";
                            if ($conn->query($deleteQuery)) {
                                echo "Все данные были успешно удалены";
                                // После удаления можно обновить страницу
                                header("Location: " . $_SERVER['PHP_SELF']);
                                exit();
                            } else {
                                echo "Ошибка при удалении данных: " . $conn->error;
                            }
                        } 
                        catch (mysqli_sql_exception $e) 
                        {
                            echo "Ошибка при удалении данных: " . $e->getMessage();
                        }
                    }
                ?>
            

    </body>
</html>
<?php
$conn->close(); // Закрываем соединение
?>