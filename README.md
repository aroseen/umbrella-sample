## Sample
Приложение для укорачивания ссылок. Написано с помощью фреймворда Laravel 5.6

## Как работать с приложением
1. На главной странице выбрать "Register" и создать нового пользователя.
2. В блоке "Создание ссылок" ввести оригинальную ссылку и (опционально) короткую. Если короткая ссылка не была введена, то она будет сгенерирована автоматически.
3. После создания ссылки она появится в блоке "Ссылки" в таблице "Ваши ссылки"
4. Ссылки, которые вы расшариваете видны в таблице "Расшаренные Вами ссылки", а расшаренные для Вас - в таблице "Расшаренные Вам ссылки"
5. Короткая ссылка доступна владельцу (создателю) ссылки, а также другим пользователям, которым она расшарена.
6. По умолчанию расшариванием отключено. Чтобы его включить нужно в блоке "Настройки" переключить флаг "Включить возможность расшаривания ссылок"
7. После включения этой опции можно будет расшаривать собственные ссылки для пользователей с помощью кнопок "Расшарить" в таблице "Ваши ссылки". Далее в модальном окне нужно выбрать пользователя и подтвердить расшаривание.
8. Отменить расшаривание с помощью кнопки "Прервать" в таблице "Расшаренные Вами ссылки". После этого ссылка будет недоступна для того пользователя, которому она была расшарена.

## Старые ссылки
Приложением имеет возможность автоматически удалять ссылки, которые были созданы более 15 (по умолчанию) дней назад. Количество дней регулируется в config/application.php

Для запуска данного функционала необходимо добавить в crontab следующую запись:
``` 
* * * * * php ~/path-to-project/artisan schedule:run >> /dev/null 2>&1 
```
Проверка происходит ежедневно в полночь.

## Логирование
Приложение логирует такие события как регистрация пользователя, вход / выход пользователя из системы, создание новых ссылок, расшаривание / прекращение расшаривания ссылок, а также включение опции расшаривания.
