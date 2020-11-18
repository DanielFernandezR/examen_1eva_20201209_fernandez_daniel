<?php
    echo "<ul class='pagination pull-left margin-zero mt0'>";
    // Crea el botón para ir hacia la página anterior si la hay
    if($page>1){
        $prev_page = $page - 1;
        echo "<li>";
            echo "<a href='{$page_url}page={$prev_page}'>";
                echo "<span style='margin:0 .5em;'>«</span>";
            echo "</a>";
        echo "</li>";
    }
    // Encontramos el total de páginas que tendremos
    $total_pages = ceil($total_rows / $records_per_page);
    // Cantidad de botones de páginas que mostraremos en la paginación
    $range = 1; 
    // Enseñamos los enlaces a las páginas dependiendo de en que página estamos.
    $initial_num = $page - $range;
    $condition_limit_num = ($page + $range)  + 1;
    for ($x=$initial_num; $x<$condition_limit_num; $x++) {
        if (($x > 0) && ($x <= $total_pages)) {
            // Página actual (no se puede clickar)
            if ($x == $page) {
                echo "<li class='active'>";
                    echo "<a href='javascript::void();'>{$x}</a>";
                echo "</li>";
            }
            // No es la página actual (se puede clickar)
            else {
                echo "<li>";
                    echo " <a href='{$page_url}page={$x}'>{$x}</a> ";
                echo "</li>";
            }
        }
    }
    // Muestra el botón para ir a la siguiente página si la hay
    if($page<$total_pages){
        $next_page = $page + 1;
        echo "<li>";
            echo "<a href='{$page_url}page={$next_page}'>";
                echo "<span style='margin:0 .5em;'>»</span>";
            echo "</a>";
        echo "</li>";
    }
    echo "</ul>";
?>