<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">
        <?php foreach ($cats as $modifier => $category_name): ?>
            <li class="promo__item promo__item--<?= $modifier; ?>">
                <a class="promo__link" href="pages/all-lots.html"><?= htmlspecialchars($category_name); ?></a>
            </li>
        <?php endforeach; ?><!--заполните этот список из массива категорий-->
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
        <?php foreach ($items as $item): ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?= htmlspecialchars($item['img_url']); ?>" width="350" height="260" alt="<?= htmlspecialchars($item['name']); ?>">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?= htmlspecialchars($item['cat']); ?></span>
                    <h3 class="lot__title"><a class="text-link" href="pages/lot.html"><?= htmlspecialchars($item['name']); ?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?= htmlspecialchars(getCost($item['cost'])); ?></span>
                        </div>
                        <? if (getTimeInHours($item['date'])['hours'] <= 1) : ?> {
                            <div class="lot__timer timer timer--finishing">
                                <?= implode(': ', getTimeInHours($item['date'])); ?>
                            </div>
                        <?php else: ?>
                            <div class="lot__timer timer">
                                <?= implode(': ', getTimeInHours($item['date'])); ?>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
