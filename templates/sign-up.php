<?php
    $invalid_class = isset($errors) ? 'form--invalid' : '';
?>
<form class="form container <?=$invalid_class?>" action="sign-up.php" method="post" autocomplete="off">
    <!-- form--invalid -->
    <h2>Регистрация нового аккаунта</h2>
    <?php
        $extra_class = (isset($errors['email'])) ? 'form__item--invalid' : '';
    ?>

    <div class="form__item <?=$extra_class?>">
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail">
        <span class="form__error"><?=$errors['email'] ?? ''?></span>
    </div>

    <?php $extra_class = (isset($errors['password'])) ? 'form__item--invalid' : '';?>

    <div class="form__item <?=$extra_class?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль">
        <span class="form__error"><?=$errors['password'] ?? ''?></span>
    </div>

    <?php $extra_class = (isset($errors['name'])) ? 'form__item--invalid' : '';?>

    <div class="form__item <?=$extra_class?>">
        <label for="name">Имя <sup>*</sup></label>
        <input id="name" type="text" name="name" placeholder="Введите имя">
        <span class="form__error"><?=$errors['name'] ?? ''?></span>
    </div>
    <?php $extra_class = (isset($errors['message'])) ? 'form__item--invalid' : '';?>

    <div class="form__item <?=$extra_class?>">
        <label for="message">Контактные данные <sup>*</sup></label>
        <textarea id="message" name="message" placeholder="Напишите как с вами связаться"></textarea>
        <span class="form__error"><?=$errors['message'] ?? ''?></span>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="login.php">Уже есть аккаунт</a>
</form>
