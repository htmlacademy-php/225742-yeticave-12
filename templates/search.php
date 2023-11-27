<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $key => $val): ?>
            <li class="nav__item">
                <a href="all-lots.html"><?=$val["name"]?></a>
            </li>
        <?php endforeach;?>
    </ul>
</nav>
<div class="container">
    <section class="lots">
        <?php if (isset($search_value) && strlen($search_value) > 0) :?>
            <h2>Результаты поиска по запросу «<span><?=$search_value?></span>»</h2>
        <?php else:?>
            <h2>Введен пустой поисковой запрос</h2>
        <?php endif;?>
        <?php if(isset($lots)) :?>

        <ul class="lots__list">
            <?php
            foreach ($lots as $key => $value):?>
              <li class="lots__item lot">
                  <div class="lot__image">
                      <img src="<?=$value['image_url']?>" width="350" height="260" alt="<?=$value['title']?>">
                  </div>
                  <div class="lot__info">
                      <span class="lot__category"><?=$value['name']?></span>
                      <h3 class="lot__title">
                          <a class="text-link" href="lot.php?id=<?=$value['id']?>">
                              <?=$value['title']?>
                          </a>
                      </h3>
                      <div class="lot__state">
                          <div class="lot__rate">
                              <span class="lot__amount">7 ставок</span>
                              <span class="lot__cost"><?=$value['initial_cost']?><b class="rub">р</b></span>
                          </div>
                          <div class="lot__timer timer">
                              10:54:12
                          </div>
                      </div>
                  </div>
              </li>
            <?php endforeach;?>
        </ul>
        <?php else:?>
            <h2>По вашему запросу ничего не найдено.</h2>
        <?php endif;?>
    </section>
    <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
        <li class="pagination-item pagination-item-active"><a>1</a></li>
        <li class="pagination-item"><a href="#">2</a></li>
        <li class="pagination-item"><a href="#">3</a></li>
        <li class="pagination-item"><a href="#">4</a></li>
        <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
    </ul>
</div>
