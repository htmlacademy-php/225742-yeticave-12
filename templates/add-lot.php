<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $key => $val): ?>
                <li class="nav__item">
                    <a href="all-lots.html"><?=$val['name']?></a>
                </li>
            <?php endforeach;?>
        </ul>
    </nav>
<!--    TODO: убрать категории в layout чтобы не запрашивать в каждом сценарии -->

    <form class="form form--add-lot container form--invalid" action="./add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
        <h2>Добавление лота</h2>
        <div class="form__container-two">
            <?php $error_class = isset($errors['lot-name']) ? 'form__item--invalid' : ''?>
            <div class="form__item <?=$error_class?>"> <!-- form__item--invalid -->
                <label for="lot-name">Наименование <sup>*</sup></label>
                <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота">
                <span class="form__error"><?=$errors['lot-name'] ?? ''?></span>
            </div>

            <?php $error_class = isset($errors['category']) ? 'form__item--invalid' : ''?>
            <div class="form__item <?=$error_class?>">
                <label for="category">Категория <sup>*</sup></label>
                <select id="category" name="category">
                    <?php foreach ($categories as $key => $val):?>
                        <option value="<?=$val['id']?>"><?=$val['name']?></option>
                    <?php endforeach;?>
                </select>
                <span class="form__error"><?=$errors['category'] ?? ''?></span>
            </div>
        </div>
        <?php $error_class = isset($errors['message']) ? 'form__item--invalid' : ''?>

        <div class="form__item <?=$error_class?> form__item--wide">

            <label for="message">Описание <sup>*</sup></label>
            <textarea id="message" name="message" placeholder="Напишите описание лота"></textarea>
            <span class="form__error"><?=$errors['message'] ?? ''?></span>
        </div>

        <span class="form__error"><?=$errors['message'] ?? ''?></span>

        <div class="form__item <?=$error_class?> form__item--file">
            <label>Изображение <sup>*</sup></label>
            <div class="form__input-file">
                <input class="visually-hidden" name="lot-img" type="file" id="lot-img" value="">
                <label for="lot-img">
                    Добавить
                </label>
                <span class="form__error"><?=$errors['img'] ?? ''?></span>
            </div>
        </div>
        <div class="form__container-three">
            <?php $error_class = isset($errors['lot-rate']) ? 'form__item--invalid' : ''?>

            <div class="form__item form__item--small <?=$error_class?>">
                <label for="lot-rate">Начальная цена <sup>*</sup></label>
                <input id="lot-rate" type="number" name="lot-rate" placeholder="0">
                <span class="form__error"><?=$errors['lot-rate'] ?? ''?></span>
            </div>

            <?php $error_class = isset($errors['lot-step']) ? 'form__item--invalid' : ''?>

            <div class="form__item <?=$error_class?> form__item--small">
                <label for="lot-step">Шаг ставки <sup>*</sup></label>
                <input id="lot-step" type="number" name="lot-step" placeholder="0">
                <span class="form__error"><?=$errors['lot-step'] ?? ''?></span>
            </div>
            <?php $error_class = isset($errors['lot-date']) ? 'form__item--invalid' : ''?>

            <div class="form__item <?=$error_class?>">
                <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
                <input class="form__input-date" id="lot-date" type="text" name="lot-date" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
                <span class="form__error"><?=$errors['lot-date'] ?? ''?></span>
            </div>
        </div>
        <?php if (!empty($errors)):?>
            <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <?php endif;?>
        <button type="submit" class="button">Добавить лот</button>
    </form>
</main>
