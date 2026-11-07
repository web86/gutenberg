# Gutenberg с нуля — День 02: из каких файлов состоит собственный блок WordPress

**Дата:** 7 ноября 2026 · **Урок:** 2 из 30  
**SEO title:** Структура Gutenberg-блока: block.json, edit.js, save.js и PHP  
**Meta description:** Простыми словами разбираем файлы собственного блока Gutenberg и собираем второй учебный WordPress-плагин.  
**Slug:** gutenberg-block-files-lesson-2

В [первом уроке](../01-first-gutenberg-block/) мы создали блок с приветствием. Но почему для одной строчки текста понадобилось столько файлов? Сегодня разложим всё по полочкам.

Представь, что Gutenberg-блок — маленькое приложение внутри WordPress. У него есть **паспорт**, **экран редактирования**, **готовый результат** и **оформление**.

## Что мы сделаем

Создадим блок **Web86 File Map** — небольшую карточку, показывающую, как связаны файлы блока. Сегодня наша цель — понять устройство проекта, а не добавлять сложные функции.

## 1. Структура папок

```text
web86-file-map/
├── web86-file-map.php      ← WordPress подключает плагин
├── package.json            ← команды сборки
├── src/                    ← здесь пишем код
│   ├── block.json          ← паспорт блока
│   ├── index.js            ← регистрация
│   ├── edit.js             ← вид в редакторе
│   ├── save.js             ← HTML для сайта
│   ├── style.scss          ← общие стили
│   └── editor.scss         ← стили редактора
└── build/                  ← появляется после сборки
    ├── block.json
    ├── index.js
    ├── index.asset.php
    ├── index.css
    └── style-index.css
```

**Запомни:** меняем файлы в `src`, а `build` создаёт сборщик. Файлы в `build` не редактируем вручную.

## 2. block.json — паспорт блока

Здесь указываем уникальное имя `web86/file-map`, заголовок для редактора, иконку и пути к скриптам и стилям.

```json
{
  "apiVersion": 3,
  "name": "web86/file-map",
  "title": "Web86 File Map",
  "category": "widgets",
  "icon": "editor-code"
}
```

Это сокращённый пример. [Полный block.json](./web86-file-map/src/block.json) содержит ещё настройки и пути к собранным файлам. Поле `editorScript: "file:./index.js"` относится к **собранному** `build/index.js`, а не к исходному файлу.

`name` — технический идентификатор. Если переименовать блок, уже используемый на сайте, старые записи не узнают его автоматически. `title` можно менять свободнее: это подпись в интерфейсе.

## 3. index.js — точка входа

`src/index.js` импортирует описание блока и функции редактирования и сохранения, затем вызывает `registerBlockType()`.

`import './style.scss'` сообщает сборщику, что общие стили тоже нужно собрать.

## 4. edit.js — то, что видит автор страницы

`edit.js` возвращает JSX — синтаксис, похожий на HTML. Функция `useBlockProps()` добавляет необходимые свойства редактора и CSS-класс блока.

Пока текст фиксированный. **В третьем уроке** сделаем заголовок редактируемым через атрибуты.

## 5. save.js — то, что сохраняется

Наш блок статический. Функция `save()` формирует HTML, который WordPress сохраняет в содержимом записи. `useBlockProps.save()` добавляет правильные атрибуты обёртки.

Важно: изменение HTML в `save.js` после публикации может сделать старые экземпляры блока невалидными. Поэтому эксперименты лучше проводить на новых страницах.

## 6. style.scss и editor.scss — внешний вид

`style.scss` работает в редакторе и на сайте. `editor.scss` — только в редакторе. В нашем примере у блока голубой фон везде, а пунктирная рамка есть только в редакторе.

## 7. PHP — мост к WordPress

Файл `web86-file-map.php` регистрирует собранный блок:

```php
add_action( 'init', function () {
    register_block_type( __DIR__ . '/build' );
} );
```

WordPress читает метаданные из `build/block.json` и подключает нужные ресурсы. В PHP-файле также есть защита от прямого запуска вне WordPress.

## 8. package.json — команды сборки

Node.js нужен разработчику, чтобы собрать JavaScript и SCSS. На хостинге для работы этого статического блока Node.js не нужен.

```bash
npm install
npm start
npm run build
```

`npm install` устанавливает зависимости. `npm start` следит за изменениями исходников. `npm run build` создаёт финальную сборку.

## Практика: устанавливаем Web86 File Map

1. Скопируй папку [web86-file-map](./web86-file-map/) в локальную `wp-content/plugins/`.
2. В терминале открой эту папку.
3. Выполни `npm install`, затем `npm run build`.
4. В WordPress активируй плагин **Web86 File Map**.
5. Создай новую страницу и вставь блок **Web86 File Map**.
6. Сохрани страницу и сравни редактор с публичной страницей.

Ожидаемый результат: карточка с названием **Web86 File Map** и строкой `block.json → index.js → edit.js / save.js`. В редакторе видна пунктирная рамка, на сайте её нет.

## Если что-то не работает

- **Блок не появился:** проверь активацию плагина и наличие `build/block.json`.
- **Не видно стилей:** проверь импорт `style.scss` в `index.js` и пути к CSS в `block.json`.
- **PHP не находит build:** выполни `npm run build`.
- **Ошибка npm:** проверь установку Node.js и доступ к npm.

## Домашнее задание

Измени заголовок блока в `block.json` на «Моя карта файлов». Затем измени текст **одновременно** в `edit.js` и `save.js`, поменяй фон в `style.scss`, пересобери и вставь блок на **новую** страницу. Попробуй своими словами объяснить, зачем существуют отдельно `src` и `build`.

## Что будет завтра

**День 03 — редактируемый заголовок.** Научимся менять текст прямо в редакторе WordPress, не открывая исходники.

## Полный исходный код

Все файлы готового учебного плагина находятся в [web86-file-map](./web86-file-map/):

- [`web86-file-map.php`](./web86-file-map/web86-file-map.php) — подключение к WordPress
- [`package.json`](./web86-file-map/package.json) — зависимости и команды
- [`src/block.json`](./web86-file-map/src/block.json) — метаданные
- [`src/index.js`](./web86-file-map/src/index.js) — регистрация
- [`src/edit.js`](./web86-file-map/src/edit.js) — редактор
- [`src/save.js`](./web86-file-map/src/save.js) — сохранение
- [`src/style.scss`](./web86-file-map/src/style.scss) — общие стили
- [`src/editor.scss`](./web86-file-map/src/editor.scss) — стили редактора

**Примечание:** пример опубликован как исходный код. Реальную сборку и работу в WordPress необходимо проверить локально.

### Официальная документация

- [Block metadata — block.json](https://developer.wordpress.org/block-editor/reference-guides/block-api/block-metadata/)
- [Block registration](https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/)
- [@wordpress/scripts](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-scripts/)
- [create-block](https://developer.wordpress.org/block-editor/getting-started/devenv/get-started-with-create-block/)

Автор: [Web86](https://web86.site/) · [Блог](https://web86.site/blog/)
