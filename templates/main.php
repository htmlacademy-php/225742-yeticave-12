<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">
        <?php foreach ($cats as $cat) : ?>
            <li class="promo__item promo__item--<?= $cat['code']; ?>">
                <a class="promo__link" href="pages/all-lots.html"><?= htmlspecialchars($cat['category']); ?></a>
            </li>
        <?php endforeach; ?>
        <!--заполните этот список из массива категорий-->
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
        <?php foreach ($lots as $lot) : ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?= htmlspecialchars($lot['img_link']); ?>" width="350" height="260" alt="<?= htmlspecialchars($lot['name']); ?>">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?= htmlspecialchars($lot['category']); ?></span>
                    <h3 class="lot__title"><a class="text-link" href="pages/lot.html"><?= htmlspecialchars($lot['name']); ?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?= htmlspecialchars(get_cost($lot['start_cost'])); ?></span>
                        </div>
                        <? if (get_time_in_hours($lot['termination_date'])['hours'] <= 1) : ?>
                            <div class="lot__timer timer timer--finishing">
                                <?= implode(': ', get_time_in_hours($lot['termination_date'])); ?>
                            </div>
                        <?php else : ?>
                            <div class="lot__timer timer">
                                <?= implode(': ', get_time_in_hours($lot['termination_date'])); ?>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
