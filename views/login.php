<?php
/**
 * Created by PhpStorm.
 * User: fabiuz
 * Date: 17/07/17
 * Time: 16:46
 */
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link href="<?php echo BASE_URL;?>/assets/css/login.css" rel="stylesheet"/>
    </head>
<body>
    <div class="loginarea">
        <form method="POST">
            <input type="email" name="email" placeholder="Digite seu email"/>
            <input type="password" name="password" placeholder="Digite sua senha"/>
            <input type="submit" value="Entrar" />

            <?php if(isset($error) && !empty($error)): ?>
                <div id="warning" class="warning">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>