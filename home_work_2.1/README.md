Доброго времени суток! Перед вами решение домашнего задания ко второму уроку курса "Разработка Highload-проекта".
В данном решении используется проект курса PHP-базовый (4 урок). Увы нет красивого фронтэнда (почти), но код PHP присутствует. 
Практически все изменения были внесены в файл index.php, и одно в файл config.php. В проект были установлены компонент Monolog 
(для организации логирования), так же на сервере был установлен и настроен согласно методичке XDebug (включена трассировка).  
 
Задание №1. 
Расширил функциональность логирования используемой памяти. Для показа изменения в используемой памяти между разными 
шагами логирования несколько раз вызываю функцию memory_get_usage в разных частях кода, присваиваю ее значение переменным 
и отображаю разницу в логе. К первому заданию относятся используемые уровни логирования Debug и Info. Так же отмечаю, что они 
не привязаны к константе XDEBUG.

Задание №2.
Согласно задания подключил опциональное логирование - ввел в конфиг константу XDEBUG. Второе задание полностью зависит от 
данной константы. Уровень логирования второго задания Notice, что бы в логе легче отличать сообщения первого задания от второго. 
Собрана информация о времени начала и окончания герерации страницы, выведены в лог значения переменных, а так же количество 
используемой памяти.