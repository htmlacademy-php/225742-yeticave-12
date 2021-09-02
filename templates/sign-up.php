<main>
    <nav class="nav">
      <ul class="nav__list container">
        <?php if ($cats == null) :?>
            <p> Данные не получены</p>
        <?php else :?>
            <?php foreach ($cats as $cat) :?>
        <li class="nav__item">
          <a href="all-lots.html"><?php echo $cat['category']; ?></a>
        </li>
            <?php endforeach;?>
        <?php endif ?>
      </ul>
    </nav>
    <form class="form container <?php if ($errors) :?> form--invalid <?php endif;?>" action="sign_up_controller.php" method="POST" autocomplete="off">
      <h2>Регистрация нового аккаунта</h2>
      <div class="form__item <?php if ($errors['email']) :?> form__item--invalid <?php endif;?>">
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail">
        <span class="form__error"><?php echo $errors['email']?></span>
      </div>
      <div class="form__item <?php if ($errors['password']) :?> form__item--invalid <?php endif;?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль">
        <span class="form__error"><?php echo $errors['password']?></span>
      </div>
      <div class="form__item <?php if ($errors['name']) :?> form__item--invalid <?php endif;?>">
        <label for="name">Имя <sup>*</sup></label>
        <input id="name" type="text" name="name" placeholder="Введите имя">
        <span class="form__error"><?php echo $errors['name']?></span>
      </div>
      <div class="form__item <?php if ($errors['message']) :?> form__item--invalid <?php endif;?>">
        <label for="message">Контактные данные <sup>*</sup></label>
        <textarea id="message" name="message" placeholder="Напишите как с вами связаться"></textarea>
        <span class="form__error"><?php echo $errors['message']?></span>
      </div>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <button type="submit" class="button">Зарегистрироваться</button>
      <a class="text-link" href="#">Уже есть аккаунт</a>
    </form>
</main>
