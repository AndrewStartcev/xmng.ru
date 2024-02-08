<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/Classes/autoload_classes.php"; ?>
<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/.config.php";

$BLOG = new Blog;
$USER = new User;
// Кол-во элементов
$limit = PAGINATION_PER_PAGE;

// Получение записей для текущей страницы
//$page = intval(@$_GET['page']);
//$page = (empty($page)) ? 1 : $page;
//$start = ($page != 1) ? $page * $limit - $limit : 0;
$start = $_POST['startFrom'];
$arBlogs = $BLOG->getListLimit($start, $limit);
?>
<? foreach ($arBlogs as $blog) : ?>
    <div class="page-articles__item item-article _border-light" data-scroll-id="article-<?= $blog['ID'] ?>" id="article-<?= $blog['ID'] ?>">
        <div class="item-article__container">
            <div class="item-article__body" data-showmore="items" data-showmore-speed="500">
                <div class="item-article__main" data-showmore-content>
                    <div class="item-article__info showmore__column">
                        <div class="item-article__top">
                            <div class="item-article__category">
                                <img src="/img/articles/category.svg" alt="логотип компании">
                                <p>
                                    <span class="_category"><?= $blog['CATEGORY'] ?></span>
                                    <span class="_country"><?= $blog['COUNTRY'] ?></span>
                                </p>
                            </div>
                            <div class="item-article__date">
                                <?= $blog['DATE_CREATE'] ?>
                            </div>
                            <? if ($USER->isAuthorized()) : ?>
                                <a href="/admin/blogs/?edit=<?= $blog['ID'] ?>" style="color: blue">Изменить</a>
                            <? endif; ?>
                            <button class="item-article__share" data-share data-link="article-<?= $blog['ID'] ?>">
                                <span>Поделиться</span>
                                <img aria-hidden="true" src="/img/svg-icons/share.svg" alt="иконка поделиться">
                            </button>
                        </div>
                        <div class="item-article__title">
                            <h3><?= $blog['TITLE'] ?></h3>
                        </div>
                        <div class="item-article__text">
                            <?= $blog['FIRST_PARAGRAPH'] ?>
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
                                <button>
                                    <svg aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path class="like-icon" d="M23 10C23 9.46957 22.7893 8.96086 22.4142 8.58579C22.0391 8.21071 21.5304 8 21 8H14.68L15.64 3.43C15.66 3.33 15.67 3.22 15.67 3.11C15.67 2.7 15.5 2.32 15.23 2.05L14.17 1L7.59 7.58C7.22 7.95 7 8.45 7 9V19C7 19.5304 7.21071 20.0391 7.58579 20.4142C7.96086 20.7893 8.46957 21 9 21H18C18.83 21 19.54 20.5 19.84 19.78L22.86 12.73C22.95 12.5 23 12.26 23 12V10ZM1 21H5V9H1V21Z" fill="#9D9D9D" />
                                    </svg>
                                </button>
                                <!-- <img aria-hidden="true" src="img/svg-icons/like.svg" alt="иконка лайки"> -->
                                <span>12</span>
                            </div>
                            <div>
                                <img aria-hidden="true" src="/img/svg-icons/share.svg" alt="иконка поделиться">
                                <span>23</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item-article__button">
                    <button class="_button" data-showmore-button="Свернуть статью">Читать полностью</button>
                </div>
            </div>
        </div>
    </div>
<? endforeach; ?>