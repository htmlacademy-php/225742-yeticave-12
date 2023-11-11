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
    <form class="form container<?php if ($errors) :?> form--invalid <?php endif;?>" action="sign-in.php" method="post"> <!-- form--invalid -->
      <h2>Вход</h2>
      <div class="form__item <?php if ($errors['email']) :?> form__item--invalid  <?php endif;?> "> <!-- form__item--invalid -->
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" value="<?= htmlspecialchars(get_post_val('email')); ?>" placeholder="Введите e-mail">
        <span class="form__error"><?php echo $errors['email']['error']?></span>
      </div>
      <div class="form__item form__item--last <?php if ($errors['password']) :?> form__item--invalid <?php endif;?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль">
        <span class="form__error"><?php echo $errors['password']['error']?></span>
      </div>
      <button type="submit" class="button">Войти</button>
    </form>
  </main>
