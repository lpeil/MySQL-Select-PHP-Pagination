<?php 
//Opções da Paginação
$pagina = $_GET['pagina'];
if($pagina == null) { //Verifica se tem um pagina selecionada
    $pagina = 1;
}
$max_linhas = 10; //O número de linhas numa página
$comeco = $pagina * $max_linhas - $max_linhas; //Onde começa a busca no sql

//CONECTION
$tabela = "suaTabela"; //Troque para o nome de sua tabela
$mysqli = mysqli_connect('localhost', 'usuario', 'senha', 'tabela_base'); // Troque pelo seus dados
$busca = mysqli_query($mysqli, "SELECT * FROM `$tabela` LIMIT $comeco, $max_linhas"); //Seleciona no MySQL

//TABELA
echo '<table>';
    echo '<thead>';
        echo '<tr>';
            echo '<th>ID</th>'; // Troque pelo seu cabeçalho
            echo '<th>Name</th>'; // Troque pelo seu cabeçalho
            echo '<th>Number</th>'; // Troque pelo seu cabeçalho
        echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
        //ITENS DA TABELA
        while($itens = mysqli_fetch_array($busca)) {
            echo '<tr>';
                echo '<td>'.$itens[0].'</td>'; 
                echo '<td>'.$itens[1].'</td>';
                echo '<td>'.$itens[2].'</td>';
            echo '</tr>';
        }
    echo '</tbody>';
echo '</table>';

$contagem = mysqli_query($mysqli, "SELECT COUNT(`id`) AS resulatado FROM `$tabela`"); //Troque o id, pelo seu dado primário
$linhas = mysqli_fetch_assoc($contagem);

$num_paginas = $linhas['resultado'] / $max_linhas; //conta o número de páginas

if(is_int($num_paginas) == false) {
    $num_paginas =  intval($num_paginas + 1); //Tranforma num_paginas em um número interio
}

// PAGINAÇÃO
if($pagina == 1) {  
    echo ' <a href="#">&laquo;</a> ';
} else {
    echo ' <a href="?pagina='.($pagina - 1).'">&laquo;</a> '; //Página antes
}
if($pagina - 3 > 0) {
    echo ' <a href="?pagina=1">1</a> '; //First Page
    echo ' <span>...</span> ';
}
if($pagina - 2 > 0) {
    echo ' <a href="?pagina='.($pagina - 2).'">'.($pagina - 2).'</a> '; //2 páginas antes
}
if($pagina - 1 > 0) {
    echo ' <a href="?pagina='.($pagina - 1).'">'.($pagina - 1).'</a> '; //Página antes
}

echo ' <a href="#">'.$pagina.'</a> '; //Current Page

if($pagina + 1 <= $num_paginas) {
    echo ' <a href="?pagina='.($pagina + 1).'">'.($pagina + 1).'</a> '; //Próxima página
}
if($pagina + 2 <= $num_paginas) {
    echo ' <a href="?pagina='.($pagina + 2).'">'.($pagina + 2).'</a> '; //Duas páginas depois
}
if($pagina + 3 <= $num_paginas) {
    echo ' <a href="?pagina='.($pagina + 3).'">'.($pagina + 3).'</a> '; //Três páginas depois
}
if($pagina + 4 <= $num_paginas) {
    echo '<span>...</span> ';
    echo ' <a href="?pagina='.($num_paginas).'">'.$num_paginas.'</a> '; //Última página
}
if($pagina > $num_paginas) {
    echo ' <a href="#">&raquo;</a> ';
} else {
    echo ' <a href="?pagina='.($pagina + 1).'">&raquo;</a> '; //Próxima Página
}
