<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/header.php"; ?>
<?
$arBlogs = $BLOG->getList();

if (isset($_GET['detail'])) {
    $isDetailPage = true;
    $totalBlogs = 1;
    $arBlogs = $BLOG->getList($_GET['detail']);
}

// Пагинация
if (!$isDetailPage) {
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $perPage = PAGINATION_PER_PAGE;
    $totalBlogs = count($arBlogs);
    $totalPages = ceil($totalBlogs / $perPage);
    $offset = ($page - 1) * $perPage;
    $arBlogs = array_slice($arBlogs, $offset, $perPage);
}

if ($USER->isAuthorized()) {
   // echo '<pre>';
    //print_r($arBlogs);
   // echo '</pre>';
}
?>

<!-- Content -->
<main class="content">


    <!-- Main -->
    <section class="main">
        <div class="main__body">
            <div class="main__image">
                <picture>
                    <source media="(min-width: 47.99875em)" srcset="/img/page-articles/background.jpg">
                    <source media="(max-width: 47.99875em) and (min-width: 23.75em)"
                        srcset="/img/page-articles/background-tablet.jpg">
                    <source media="(max-width: 23.75em)" srcset="/img/page-articles/background-mobile.jpg">
                    <img src="/img/page-articles/background.jpg" alt="фоновое изображение">
                </picture>
            </div>
        </div>
    </section>


    <!-- Articles -->
    <div class="page-articles _border-light">
        <div class="page-articles__body">
            <div class="page-articles__container">
                <div class="page-articles__title">
                    <h1>X-mngmnt Articles</h1>
                </div>
                <div class="page-articles__top top-articles">
                    <div class="top-articles__body">
                        <div class="top-articles__lines _lines">
                            <span></span>
                        </div>
                        <div class="top-articles__button">
                            <button class="_button _button-dark">Подписывайся и читай нас в telegram</button>
                        </div>
                        <div class="top-articles__lines _lines">
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Articles -->
            <div class="page-articles__items">
                <? if (!$arBlogs): ?>
                    <div class="page-articles__title">
                        <h1>Статья не найдена</h1>
                    </div>
                <? endif ?>
                <? if (is_array($arBlogs)): ?>
                    <? foreach ($arBlogs as $blog): ?>
                        <? // $BLOG->deleteLikeByBlogID($blog['ID']) ?>
                        <div class="page-articles__item item-article _border-light" data-id="<?= $blog['ID'] ?>"
                            data-scroll-id="article-<?= $blog['ID'] ?>" id="article-<?= $blog['ID'] ?>">
                            <div class="item-article__container">
                                <div class="item-article__body" data-showmore="items" data-showmore-speed="500">
                                    <div class="item-article__main" data-showmore-content>
                                        <div class="item-article__info showmore__column">
                                            <div class="item-article__top">
                                                <div class="item-article__category">
                                                    <img src="/img/articles/category.svg" alt="логотип компании">
                                                    <p>
                                                        <span class="_category">
                                                            <?= $blog['CATEGORY'] ?>
                                                        </span>
                                                        <span class="_country">
                                                            <?= $blog['COUNTRY'] ?>
                                                        </span>
                                                    </p>
                                                </div>
                                                <div class="item-article__date">
                                                    <?= $blog['DATE_CREATE'] ?>
                                                </div>
                                                <? if ($USER->isAuthorized()): ?>
                                                    <a href="/admin/blogs/?edit=<?= $blog['ID'] ?>" style="color: blue">Изменить</a>
                                                <? endif; ?>
                                                <button class="item-article__share" data-share
                                                    <?= (!$BLOG->checkUserShareByBlogID($blog['ID'])) ? 'data-add-statistic' : '' ?>
                                                    data-link="https://<?= $_SERVER['HTTP_HOST'] ?>/articles/?detail=<?= $blog['ID'] ?>">
                                                    <span>Поделиться</span>
                                                    <img aria-hidden="true" src="/img/svg-icons/share.svg"
                                                        alt="иконка поделиться">
                                                </button>
                                            </div>
                                            <div class="item-article__title">
                                                <h3>
                                                    <?= $blog['TITLE'] ?>
                                                </h3>
                                            </div>
                                            <div class="item-article__text">
                                                <? // var_dump(html_entity_decode($blog['FIRST_PARAGRAPH'])); ?>
                                                <?= $blog['FIRST_PARAGRAPH'] ?>
                                                <br>
                                                <br>
                                                <?= $blog['SECOND_PARAGRAPH'] ?>
                                            </div>
                                            <div class="item-article__image">
                                                <picture>
                                                    <source media="(min-width: 767.98px)" srcset="<?= $blog['MAIN_IMAGE'] ?>">
                                                    <source media="(max-width: 767.98px)" srcset="<?= $blog['MAIN_IMAGE'] ?>">
                                                    <img src="<?= $blog['MAIN_IMAGE'] ?>" alt="<?= $blog['TITLE'] ?>">
                                                </picture>
                                            </div>
                                        </div>
                                        <div class="item-article__info showmore__column">
                                            <div class="item-article__text">
                                                <?= $blog['MAIN_TEXT'] ?>
                                            </div>
                                            <div class="item-article__statistic">
                                                <div>
                                                    <button
                                                        class="<?= ($BLOG->checkUserVotedRatingByBlogID($blog['ID'])) ? 'active' : ''; ?>">
                                                        <svg aria-hidden="true" viewBox="0 0 24 24"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path class="like-icon"
                                                                d="M23 10C23 9.46957 22.7893 8.96086 22.4142 8.58579C22.0391 8.21071 21.5304 8 21 8H14.68L15.64 3.43C15.66 3.33 15.67 3.22 15.67 3.11C15.67 2.7 15.5 2.32 15.23 2.05L14.17 1L7.59 7.58C7.22 7.95 7 8.45 7 9V19C7 19.5304 7.21071 20.0391 7.58579 20.4142C7.96086 20.7893 8.46957 21 9 21H18C18.83 21 19.54 20.5 19.84 19.78L22.86 12.73C22.95 12.5 23 12.26 23 12V10ZM1 21H5V9H1V21Z"
                                                                fill="#9D9D9D" />
                                                        </svg>
                                                    </button>
                                                    <!-- <img aria-hidden="true" src="img/svg-icons/like.svg" alt="иконка лайки"> -->
                                                    <span
                                                        data-action="<?= ($BLOG->checkUserVotedRatingByBlogID($blog['ID'])) ? 'delete' : 'add'; ?>"
                                                        data-vote-id="<?= $blog['ID'] ?>">
                                                        <?= $BLOG->getRatingByBlogID($blog['ID']) ?>
                                                    </span>
                                                </div>
                                                <div>
                                                    <img aria-hidden="true" src="/img/svg-icons/share.svg"
                                                        alt="иконка поделиться">
                                                    <span class="share__counter">
                                                        <?= $BLOG->getShareByBlogID($blog['ID']) ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item-article__button">
                                        <button class="_button" data-showmore-button="Свернуть статью">Читать полностью</button>
                                    </div>
                                </div>
                            </div>
                            <? if ($totalBlogs === 1): ?>
                                <div class="articles__container detail-article-page">
                                    <div class="articles__lines _lines">
                                        <span></span>
                                    </div>
                                    <div class="articles__button">
                                        <a href="/articles/#" target="_blank" class="_button _button-big _button-dark">Читать все
                                            статьи от X-MNGMNT</a>
                                    </div>
                                    <div class="articles__lines _lines">
                                        <span></span>
                                    </div>
                                </div>
                            <? endif ?>
                        </div>
                    <? endforeach; ?>
                <? endif ?>
                <? /*
          <nav aria-label="Page navigation">
              <ul class="pagination justify-content-center">
                  <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                      <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                          <a class="page-link" href="?page=<?= $i ?>">
                              <?= $i ?>
                          </a>
                      </li>
                  <?php endfor; ?>
              </ul>
          </nav> */?>
            </div>
            <? if ($totalPages > 1): ?>
                <div id="showmore-triger" style="display:none">
                    <img src="/img/articles/ajax-loader.gif" alt="">
                </div>
            <? endif; ?>
        </div>
    </div>

    <section class="contacts">
        <div class="contacts__image-bottom">
            <img aria-hidden="true" src="/img/page-articles/image-bottom.jpg" alt="изображение">
        </div>
        <div class="contacts__container">
            <div class="contacts__body">
                <div class="contacts__row">
                    <div class="contacts__column">
                        <div class="contacts__title">
                            <h2 class="_title">Остались вопросы?</h2>
                        </div>
                        <div class="contacts__text">
                            <p>Выберите подходящий способ обратной связи и напишите свой вопрос:</p>
                        </div>

                        <!-- Social List -->
                        <div class="contacts__social social-contacts">
                            <ul class="social-contacts__list">
                                <li>
                                    <button class="active" data-social="whatsapp" title="whatsapp">
                                        <svg width="70" height="70" viewBox="0 0 70 70" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path class="icon-social"
                                                d="M60.6113 18.8211L61.1362 19.6349C69.0794 33.7951 64.8297 51.6738 51.2259 60.5217C46.3666 63.5306 40.7293 65.0376 35.0877 65.0376C29.8519 65.0376 24.5584 63.537 19.6812 60.9075L18.5613 60.1753L18.3744 60.0531L18.1587 60.1108L7.53144 62.9501L10.3708 52.3229L10.4284 52.1071L10.3062 51.9202L9.56375 50.7847C9.56353 50.7843 9.5633 50.784 9.56308 50.7836C0.575786 36.8929 5.04665 18.0443 18.9433 9.39477C33.196 0.741461 51.617 4.8777 60.6113 18.8211ZM46.9002 52.7376H46.9369L46.9732 52.7322C49.7293 52.3256 51.7253 50.7746 53.2886 48.5376H53.3747L53.5238 48.3222C54.427 47.0176 54.4086 45.309 53.979 44.0678L53.9413 43.9591L53.86 43.8778C53.609 43.6268 53.2589 43.4124 52.9156 43.2242C52.7195 43.1166 52.4933 43.001 52.2707 42.8872C52.1131 42.8067 51.9573 42.7271 51.8154 42.6519L51.8155 42.6518L51.8051 42.6466L45.6801 39.5841L45.6699 39.579L45.6595 39.5744C45.2557 39.3949 44.841 39.2492 44.3939 39.3251C43.9458 39.4012 43.5688 39.6807 43.1779 40.0715C42.7819 40.4675 42.1091 41.1513 41.4844 41.8313C41.1722 42.1711 40.8686 42.5137 40.6164 42.821C40.371 43.1201 40.151 43.4133 40.0271 43.6474L40.027 43.6473L40.0218 43.6577C39.8936 43.914 39.7333 44.002 39.5659 44.0263C39.3684 44.055 39.0951 44.0011 38.7779 43.8332L38.7593 43.8233L38.74 43.8151C36.1338 42.7042 33.8623 41.2078 31.6225 39.3149C29.7729 37.4203 27.8823 35.1426 26.3771 32.9106C26.2913 32.7365 26.2604 32.6476 26.2507 32.5941C26.2455 32.5658 26.2459 32.5572 26.2603 32.5264C26.2866 32.4701 26.3465 32.3819 26.49 32.214C26.5697 32.1209 26.6586 32.0217 26.7646 31.9033C26.8475 31.8108 26.9409 31.7065 27.0486 31.5843C28.0089 30.6634 28.5207 29.419 28.746 28.3734C28.86 27.8445 28.9048 27.3481 28.8917 26.9454C28.8851 26.7449 28.8638 26.5554 28.8238 26.391C28.7998 26.2924 28.7615 26.1697 28.6937 26.0548C28.6894 26.0357 28.6851 26.0187 28.6815 26.0046C28.6636 25.9346 28.639 25.8531 28.6105 25.7649C28.5531 25.5877 28.4721 25.3606 28.3752 25.1002C28.1809 24.5782 27.9152 23.9023 27.6279 23.1826C27.4103 22.6376 27.1805 22.068 26.9588 21.5183C26.5976 20.6229 26.2578 19.7805 26.0269 19.1839C25.8102 18.3608 25.4597 17.8417 24.9648 17.5623C24.5097 17.3054 24.0108 17.3059 23.6633 17.3063C23.6504 17.3063 23.6377 17.3063 23.6252 17.3063H21.7002C20.7771 17.3063 19.8699 17.792 19.0717 18.5903C17.0497 20.6122 15.8627 23.4096 15.8627 26.6001V26.6253L15.8653 26.6504C16.2217 30.17 17.4247 33.7209 19.7689 36.4827C23.6187 42.2705 29.0606 47.3132 35.6177 50.4146L35.6322 50.4214L35.6472 50.4274C39.4774 51.9462 41.9059 52.5305 43.5878 52.7287C44.7834 52.8696 45.6391 52.8112 46.2697 52.7682C46.5106 52.7518 46.7186 52.7376 46.9002 52.7376Z"
                                                fill="white" />
                                            <defs>
                                                <linearGradient id="stroke-1" x1="65.6213" y1="34.6078" x2="4.39892"
                                                    y2="34.6078" gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="white" stop-opacity="0.1" />
                                                    <stop offset="0.497093" stop-color="white" />
                                                    <stop offset="1" stop-color="white" stop-opacity="0.14" />
                                                </linearGradient>
                                            </defs>
                                        </svg>
                                    </button>
                                </li>
                                <li>
                                    <button data-social="telegram" title="telegram">
                                        <svg width="72" height="72" viewBox="-0.6 -0.6 72 72" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path class="icon-social"
                                                d="M34.8367 9.52779e-05C25.5824 0.0432822 16.7219 3.74983 10.1934 10.3089C3.66496 16.868 -0.000100768 25.7457 2.07794e-09 35.0001C2.07795e-09 44.2827 3.68749 53.1851 10.2513 59.7488C16.815 66.3126 25.7174 70.0001 35 70.0001C44.2826 70.0001 53.185 66.3126 59.7487 59.7488C66.3125 53.1851 70 44.2827 70 35.0001C70 25.7175 66.3125 16.8151 59.7487 10.2514C53.185 3.68758 44.2826 9.52779e-05 35 9.52779e-05C34.9456 -3.17593e-05 34.8911 -3.17593e-05 34.8367 9.52779e-05ZM49.3092 21.0701C49.6008 21.0643 50.2454 21.1372 50.6654 21.4784C50.9445 21.7208 51.1225 22.0591 51.1642 22.4263C51.2108 22.6976 51.2692 23.3188 51.2225 23.803C50.6975 29.3388 48.4167 42.7672 47.2558 48.9651C46.7658 51.5901 45.8004 52.468 44.8642 52.5526C42.8342 52.7422 41.2913 51.2109 39.3225 49.9218C36.2425 47.9005 34.5013 46.6434 31.5117 44.6718C28.0554 42.3968 30.2954 41.1426 32.2642 39.1009C32.7804 38.5643 41.7346 30.418 41.9096 29.6801C41.93 29.5868 41.9504 29.2426 41.7463 29.0618C41.5421 28.8809 41.2388 28.9422 41.02 28.9918C40.7108 29.0618 35.7904 32.3168 26.2588 38.748C24.8588 39.7105 23.5958 40.1772 22.4613 40.148C21.2129 40.1247 18.8096 39.4451 17.0217 38.8647C14.8283 38.1501 13.0871 37.7738 13.2388 36.5634C13.3175 35.9334 14.1867 35.2888 15.8433 34.6297C26.0458 30.1847 32.8475 27.2534 36.2542 25.8388C45.9725 21.7963 47.9938 21.0934 49.3092 21.0701Z"
                                                fill="white" />
                                            <defs>
                                                <linearGradient id="stroke-1" x1="65.6213" y1="34.6078" x2="4.39892"
                                                    y2="34.6078" gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="white" stop-opacity="0.1" />
                                                    <stop offset="0.497093" stop-color="white" />
                                                    <stop offset="1" stop-color="white" stop-opacity="0.14" />
                                                </linearGradient>
                                            </defs>
                                        </svg>
                                    </button>
                                </li>
                                <li>
                                    <button data-social="mail" title="mail">
                                        <svg width="70" height="70" viewBox="0 0 70 70" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path class="icon-social"
                                                d="M8.74984 61.25C7.14568 61.25 5.77193 60.6783 4.62859 59.535C3.48526 58.3917 2.91456 57.0189 2.91651 55.4167V18.9583H8.74984V55.4167H56.8748V61.25H8.74984ZM20.4165 49.5833C18.8123 49.5833 17.4386 49.0117 16.2953 47.8683C15.1519 46.725 14.5812 45.3522 14.5832 43.75V14.5833C14.5832 12.9792 15.1548 11.6054 16.2982 10.4621C17.4415 9.31875 18.8143 8.74806 20.4165 8.75H61.2498C62.854 8.75 64.2278 9.32167 65.3711 10.465C66.5144 11.6083 67.0851 12.9811 67.0832 14.5833V43.75C67.0832 45.3542 66.5115 46.7279 65.3682 47.8713C64.2248 49.0146 62.8521 49.5853 61.2498 49.5833H20.4165ZM40.8332 35.875L61.2498 21.6563V14.5833L40.8332 28.7292L20.4165 14.5833V21.6563L40.8332 35.875Z"
                                                fill="white" />
                                            <defs>
                                                <linearGradient id="stroke-1" x1="65.6213" y1="34.6078" x2="4.39892"
                                                    y2="34.6078" gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="white" stop-opacity="0.1" />
                                                    <stop offset="0.497093" stop-color="white" />
                                                    <stop offset="1" stop-color="white" stop-opacity="0.14" />
                                                </linearGradient>
                                            </defs>
                                        </svg>
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <!-- Form -->
                        <form action="#" class="contacts__form form-contacts" data-form="whatsapp"
                            enctype="multipart/form-data">
                            <div class="form-contacts__item">
                                <input id="form-contact" data-social-input autocomplete="off" type="text"
                                    name="form-contact" data-required tabindex="0" />
                                <label for="form-contact" data-social-label>Ваш номер в WhatsApp</label>
                                <button type="button" title="Вставить">
                                    <img aria-hidden="true" src="/img/svg-icons/insert.svg"
                                        alt="иконка кнопки 'вставить'">
                                </button>
                                <div class="error" hidden>
                                    <span>Некорректный номер</span>
                                </div>
                            </div>
                            <div class="form-contacts__item">
                                <textarea name="form-question" placeholder="Напишите свой вопрос" maxlength="1000"
                                    tabindex="0" spellcheck="false"></textarea>
                                <div data-value-length>
                                    <span></span>
                                </div>
                            </div>
                            <div class="form-contacts__item form-file">
                                <div class="form-file__button" role="button" title="Добавить изображение">
                                    <input accept=".jpg, .png, .gif" type="file" name="form-image">
                                    <img aria-hidden="true" src="/img/svg-icons/image-plus.svg"
                                        alt="иконка кнопки 'добавить изображение'">
                                </div>
                                <div class="form-file__preview" id="form-contacts-preview"></div>
                            </div>
                            <div class="form-contacts__item form-submit">
                                <button type="submit" title="Отправить форму">
                                    <img aria-hidden="true" src="/img/svg-icons/send.svg"
                                        alt="иконка кнопки отправить форму">
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Feedback -->
                    <div class="contacts__feedback feedback-contacts _border-light">
                        <div class="feedback-contacts__body">
                            <div class="feedback-contacts__image">
                                <img src="/img/contacts/background.jpg" alt="фоновое изображение">
                                <img src="/img/contacts/background.jpg" alt="фоновое изображение">
                            </div>
                            <div class="feedback-contacts__action" data-da=".contacts__column,47.99875,last">
                                <div class="feedback-contacts__label">Либо пишите напрямую в наш telegram:</div>
                                <div class="feedback-contacts__link">
                                    <a href="https://t.me/@Safetytrade">@Safetytrade</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>



<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/footer.php"; ?>

<? /*<script>
var block_show = false;

function scrollMore() {

  var $target = $('#showmore-triger');


  if (block_show && $target.hasClass('on__load')) {
      return false;
  }

  var wt = $(window).scrollTop();
  var wh = $(window).height();
  //try {
      var et = $target.offset().top;
  //} catch {var et = 0;}
  var eh = $target.outerHeight();
  var dh = $(document).height();

  if (wt + wh >= et) { // || wh + wt == dh || eh + et < wh
      var page = $target.attr('data-page');
      $target.addClass('on__load');
      page++;
      block_show = true;

      $.ajax({
          url: './ajax.php?page=' + page,
          dataType: 'html',
          success: function(data) {
              $('.page-articles__items').append(data);
              console.log('Подгружаем ещё...')
              block_show = false;
              if (document.querySelector(".page-articles__items")) {
                  const articles = document.querySelectorAll(".item-article__body");
                  articles.forEach(article => {
                      new ShowMore(article, {
                          visibleContent: 0,
                          columns: 1
                      });
                  });
              }
              $target.removeClass('on__load');
          }
      });

      $target.attr('data-page', page);
      if (page == $target.attr('data-max')) {
          $target.remove();
      }
  }
}

$(window).scroll(function() {
  scrollMore();
});

$(document).ready(function() {
  scrollMore();
});
</script> */?>
<script>
    $(document).ready(function () {

        /* Переменная-флаг для отслеживания того, происходит ли в данный момент ajax-запрос. В самом начале даем ей значение false, т.е. запрос не в процессе выполнения */
        var inProgress = false;
        /* С какой статьи надо делать выборку из базы при ajax-запросе */
        var startFrom = <?= PAGINATION_PER_PAGE ?>;

        /* Используйте вариант $('#more').click(function() для того, чтобы дать пользователю возможность управлять процессом, кликая по кнопке "Дальше" под блоком статей (см. файл index.php) */
        $(window).scroll(function () {
            /* Если высота окна + высота прокрутки больше или равны высоте всего документа и ajax-запрос в настоящий момент не выполняется, то запускаем ajax-запрос */
            if ($(window).scrollTop() + $(window).height() >= $(".page-articles__body").height() && !inProgress && <?= $totalBlogs ?> > startFrom) {
                console.log('отправили ajax-запрос')
                $.ajax({
                    /* адрес файла-обработчика запроса */
                    url: './ajax.php',
                    /* метод отправки данных */
                    method: 'POST',
                    /* данные, которые мы передаем в файл-обработчик */
                    data: {
                        "startFrom": startFrom
                    },
                    /* что нужно сделать до отправки запрса */
                    beforeSend: function () {
                        /* меняем значение флага на true, т.е. запрос сейчас в процессе выполнения */
                        inProgress = true;
                        $('#showmore-triger').show();
                    }
                    /* что нужно сделать по факту выполнения запроса */
                }).done(function (data) {

                    $(".page-articles__items").append(data);
                    inProgress = false;
                    $('#showmore-triger').hide();
                    // Увеличиваем на 10 порядковый номер статьи, с которой надо начинать выборку из базы
                    startFrom += <?= PAGINATION_PER_PAGE ?>;
                    if (document.querySelector(".page-articles__items")) {
                        const articles = document.querySelectorAll(".item-article__body");
                        articles.forEach(article => {
                            new ShowMore(article, {
                                visibleContent: 1,
                                columns: 1
                            });
                        });
                    }
                });
            }
        });
    });
</script>
<? if ($totalBlogs === 1): ?>
    <script>
        localStorage.removeItem("current-card");
        $('html, body').animate({
            scrollTop: $(".page-articles__container").offset().top
        }, 1000);
        $('.item-article__button ._button').click();
    </script>
<? endif ?>
<!-- Contacts -->
<!-- <div data-showmore="items" class="showmore showmore_one">
                <div class="showmore__title">
                    <h2>Showmore. Content</h2>
                </div>
                <div data-showmore-content class="showmore__columns">
                    <div class="showmore__column">1</div>
                </div>
                <div class="showmore__all">
                    <button data-showmore-button="Скрыть контент" class="_button-all">Показать ещё</button>
                </div>
            </div> -->