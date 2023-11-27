<?php $invalid_class = isset($errors) ? 'form--invalid' : '';?>

<form class="form container <?=$invalid_class?>" action="login.php" method="post"> <!-- form--invalid -->
    <h2>Вход</h2>

    <?php $invalid_class = (isset($errors) && isset($errors['email'])) ? 'form__item--invalid' : '';?>
    <div class="form__item <?=$invalid_class?>">
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail">
        <span class="form__error"><?= $errors['email'] ?? ''?></span>
    </div>
    <?php $invalid_class = (isset($errors) && isset($errors['password'])) ? 'form__item--invalid' : '';?>

    <div class="form__item form__item--last <?=$invalid_class?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль">
        <span class="form__error"><?=$errors['password'] ?? ''?></span>
    </div>

    <button type="submit" class="button">Войти</button>
    <?php if (isset($auth_success) && !$auth_success): ?>
        <span style="color: red;">Неверный логин или пароль. Попробуйте еще раз.</span>
    <?php endif;?>
</form>
