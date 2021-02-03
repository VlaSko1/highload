<?php
// Файл с функциями нашего движка


//Функция возвращает текст шаблона $page с подстановкой переменных
//из массива $params, содержимое шаблона $page подставляется в
//переменную $content главного шаблона layout для всех страниц
function render($page, $params = []) {
    $layout = 'layout';
    if($page === 'gallery') {
        $layout = 'gallery__layout';
    }
    return renderTemplate(LAYOUTS_DIR . $layout, [
        'content' => renderTemplate($page, $params),
        'menu' => renderTemplate('menu')
    ]);
}

// Функция возвращает текст шаблона $page с подставленными переменными
// из массива $params, просто текст
function renderTemplate($page, $params = [])
{
    ob_start();

    if (!is_null($params))
        extract($params);

    $fileName = TEMPLATES_DIR . $page . ".php";

    if (file_exists($fileName)) {
        include $fileName;
    } else {
        Die("Страницы {$page} не существует.");
    }

    return ob_get_clean();
}