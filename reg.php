<?php
    session_start();
 
    require_once "db.php";
    require_once "user.php";
 
    if(isset($_POST['submit'])) {
        
        $login = trim(strip_tags($_POST['login']));     
        $password = trim(strip_tags($_POST['password']));   
        $password_two = trim(strip_tags($_POST['password_two']));
 
        if (!empty($login) && !empty($password) && !empty($password_two)) {
        
        
            
                if($password == $password_two) { // проверка совпадения паролей
                    
                    $user = new user($login, $password);
                    
                    $dbc = DB::getInstance();
                    $result = $dbc->getQuery("SELECT `login` FROM `users` WHERE `login` = '$login'");
                    $row = $result->fetch_object();
                    
                    if(empty($row->login)) { //проверка нет ли уже такого пользователя
                        
                        $result = $dbc->getQuery("INSERT INTO `users`(`id`, `login`, `password`)
                        VALUES(0, '{$user->getLogin()}', '{$user->getPassword()}');
                        
                        if($result) {
                            $letter = "<p class='green'>Пользователь {$user->getLogin()} успешно зарегистрирован</p>";
                        } else $letter = "<p class='error'>Пользователь не зарегистрирован, попробуйте ещё раз</p>"; 
                        
                    } else $letter = "<p class='error'>Такой пользователь существует!</p>";
                    
                } else $letter = "<p class='error'>Пароли не совпадают!</p>";
                session_destroy();       
    
    }
    
?>
 
<!DOCTUPE>
<html>
    <body>
        <?php echo "<div class='letter'>".$letter."</div>" ?>
        <h2>Регистрация пользователя</h2>
        <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" class="registration">
            <label for="reg_login">Логин</label>
            <input type="text" name="login" id="reg_login" value="<?php echo $login; ?>">
            <br />
            <label for="reg_name">Имя</label>
            <input type="text" name="name" id="reg_name" value="<?php echo $name; ?>">
            <br />
            <label for="reg_password">Пароль</label>
            <input type="password" name="password" id="reg_password">
            <br />
            <label for="reg_password_two">Повтор пароля</label>
            <input type="password" name="password_two" id="reg_password_two">
            <br />
            <input type="submit" value="Зарегистрироваться" name="submit">
        </form>
    </body>
</html>