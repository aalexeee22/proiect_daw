<?php
/*
 * basePath returneaza calea relativa a fisierelor
 * */
function basePath($path='')
{
    return __DIR__ . '/' . $path;
}

/*
 * loadView incarca direct fisierele de vizualizat
 * */
function loadView($name, $data = [])
{
    $viewPath=basePath("App/views/{$name}.view.php");
    if(file_exists($viewPath))
    {
        extract($data);
        require $viewPath;
    }
    else
    {
        echo "View $name not found";
    }
}

/*
 * loadPartial incarca direct fisierele partiale (partials)
 * */
function loadPartial($name)
{
    $partialPath=basePath("App/views/partials/{$name}.php");
    if(file_exists($partialPath))
    {
        require $partialPath;
    }
    else
    {
        echo "View $name not found";
    }
}
?>
