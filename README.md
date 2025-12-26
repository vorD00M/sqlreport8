# SQLReport — module for vtigerCRM 8.x

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

## Возможности
- Выполнение произвольных SELECT/WITH запросов с автоматическим запретом команд INSERT, UPDATE, DELETE, TRUNCATE, CREATE, DROP, ALTER.
- Подсветка синтаксиса SQL и нумерация строк в редакторе.
- Подсветка потенциально опасных команд при сохранении/выполнении.
- Просмотр первых 1000 строк результата в таблице, полная выгрузка в CSV/XLS/XLSX без ограничения строк.

## Безопасность
Перед PROD рекомендуется:
- ролевые проверки доступа;
- усиленная server-side валидация SQL;
- лимиты по времени выполнения/памяти;
- аудит выполнения запросов.
