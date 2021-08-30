<form class="form form--add-lot container<?php if ($errors) :?> form--invalid <?php endif;?>" action="add.php" method="POST" enctype="multipart/form-data">
      <h2>Добавление лота</h2>
      <div class="form__container-two">
        <div class="form__item <?php if ($errors['lot-name']) : ?> form__item--invalid <?php endif;?>">
          <label for="lot-name">Наименование <sup>*</sup></label>
          <input id="lot-name" type="text" name="lot-name" value="<?=get_post_val('lot-name'); ?>" placeholder="Введите наименование лота" require>
          <span class="form__error"><?php echo $errors['lot-name']?></span>
        </div>
        <div class="form__item <?php if ($errors['category']) : ?> form__item--invalid <?php endif;?>">
          <label for="category">Категория <sup>*</sup></label>
          <select id="category" name="category" require>
            <option disabled>Выберите категорию</option>
            <?php if ($cats == null) : ?>
                <p>Данные не получены</p>
            <?php else :?>
                <?php foreach($cats as $cat) :?>
                    <option value="<?=$cat['id'];?>"><?=$cat['category'];?></option>
                <?php endforeach;?>
            <?php endif;?>
          </select>
          <span class="form__error"><?php if ($errors['category']) : ?><?php echo $errors['category'] ?></span>
            <?php endif; ?>
        </div>
      </div>
      <div class="form__item form__item--wide <?php if ($errors['message']) : ?> form__item--invalid <?php endif;?>">
        <label for="message">Описание <sup>*</sup></label>
        <textarea id="message" name="message" placeholder="Напишите описание лота" require></textarea>
        <span class="form__error"><?php if ($errors['message']) : ?><?php echo $errors['message'] ?></span>
            <?php endif; ?>
      </div>
      <div class="form__item form__item--file <?php if ($errors['lot-image']) : ?> form__item--invalid <?php endif;?>">
        <label>Изображение <sup>*</sup></label>
        <div class="form__input-file">
          <input class="visually-hidden" type="file" name="lot-image" id="lot-img" value="" require>
          <label for="lot-img">
            Добавить
          </label>
          <span class="form__error form__error--image"><?php if ($errors['lot-image']) : ?><?php echo $errors['lot-image'] ?></span>
            <?php endif; ?>
        </div>
      </div>
      <div class="form__container-three">
        <div class="form__item form__item--small <?php if ($errors['lot-rate']) : ?> form__item--invalid <?php endif;?>">
          <label for="lot-rate">Начальная цена <sup>*</sup></label>
          <input id="lot-rate" type="text" name="lot-rate" value="<?=get_post_val('lot-rate'); ?>" placeholder="0" require>
          <span class="form__error"><?php if ($errors['lot-rate']) : ?><?php echo $errors['lot-rate'] ?></span>
            <?php endif; ?>
        </div>
        <div class="form__item form__item--small <?php if ($errors['lot-step']) : ?> form__item--invalid <?php endif;?>">
          <label for="lot-step">Шаг ставки <sup>*</sup></label>
          <input id="lot-step" type="text" name="lot-step" value="<?=get_post_val('lot-step'); ?>" placeholder="0" require>
          <span class="form__error"><?php if ($errors['lot-step']) : ?><?php echo $errors['lot-step'] ?></span>
            <?php endif; ?>
        </div>
        <div class="form__item <?php if ($errors['lot-date']) : ?> form__item--invalid <?php endif;?>">
          <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
          <input class="form__input-date" id="lot-date" type="text" name="lot-date" value="<?=get_post_val('lot-date'); ?>" placeholder="Введите дату в формате ГГГГ-ММ-ДД" require>
          <span class="form__error"><?php if ($errors['lot-date']) : ?><?php echo $errors['lot-date'] ?></span>
            <?php endif; ?>
        </div>
      </div>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <button type="submit" class="button">Добавить лот</button>
    </form>
