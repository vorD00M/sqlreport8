# SQLReport — minimal working module for vtigerCRM 8.x

## Установка
1. Установите модуль через Admin → Module Manager → Import Module from Zip.
2. После установки таблицы создаются автоматически.

## Подключение CodeMirror (ОБЯЗАТЕЛЬНО)
В архиве **нет самих файлов CodeMirror**, только подготовленная структура каталогов.

### Рекомендуемая версия
CodeMirror **5.65.x** (ветка 5).

### Что скачать
Из репозитория CodeMirror возьмите файлы:

- lib/codemirror.js
- lib/codemirror.css
- mode/sql/sql.js

### Куда положить
Скопировать файлы в директорию модуля:

modules/SQLReport/resources/js/codemirror/lib/codemirror.js  
modules/SQLReport/resources/js/codemirror/lib/codemirror.css  
modules/SQLReport/resources/js/codemirror/mode/sql/sql.js  

Структура:
modules/SQLReport/resources/js/codemirror/
 ├─ lib/
 │   ├─ codemirror.js
 │   └─ codemirror.css
 └─ mode/sql/sql.js

После подстановки файлов SQL-редактор с подсветкой и номерами строк заработает автоматически.

## Безопасность
Перед PROD рекомендуется:
- ролевые проверки доступа;
- усиленная server-side валидация SQL;
- лимиты по времени выполнения/памяти;
- аудит выполнения запросов.
