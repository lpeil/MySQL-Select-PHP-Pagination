<?php 
//PAGINATION OPTIONS
$page = $_GET['page'];
if($page == null) { //Check if have some page selected
    $page = 1;
}
$max_rows = 10; //The number of rows in one page
$start = $page * $max_rows - $max_rows; //The start search in mysql

//CONECTION
$table = "tableName"; //Change for your table name
$mysqli = mysqli_connect('host', 'user', 'password', 'database'); // Change for your data
$select = mysqli_query($mysqli, "SELECT * FROM `$yourTable` LIMIT $start, $max_rows"); //Select in MySQL

//TABLE
echo '<table>';
    echo '<thead>';
        echo '<tr>';
            echo '<th>ID</th>'; // Change the head
            echo '<th>Name</th>'; // Change the head
            echo '<th>Number</th>'; // Change the head
        echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
        //ITEMS FROM DATABASE
        while($items = mysqli_fetch_array($select)) {
            echo '<tr>';
                echo '<td>'.$items[0].'</td>'; 
                echo '<td>'.$items[1].'</td>';
                echo '<td>'.$items[2].'</td>';
            echo '</tr>';
        }
    echo '</tbody>';
echo '</table>';

$count = mysqli_query($mysqli, "SELECT COUNT(`id`) AS result FROM `$table`"); //Can change `id` for another column
$rows = mysqli_fetch_assoc($count);

$pages_number = $rows['result'] / $max_rows; // count the number of pages

if(is_int($pages_number) == false) {
    $pages_number =  intval($pages_number + 1); //make $pages_number a int number
}

// PAGINATION
if($page == 1) {  
    echo ' <a href="#">&laquo;</a> ';
} else {
    echo ' <a href="?page='.($page - 1).'">&laquo;</a> '; // Previous Page
}
if($page - 3 > 0) {
    echo ' <a href="?page=1">1</a> '; //First Page
    echo ' <span>...</span> ';
}
if($page - 2 > 0) {
    echo ' <a href="?page='.($page - 2).'">'.($page - 2).'</a> '; //Two Pages Before
}
if($page - 1 > 0) {
    echo ' <a href="?page='.($page - 1).'">'.($page - 1).'</a> '; //Before Page
}

echo ' <a href="#">'.$page.'</a> '; //Current Page

if($page + 1 <= $pages_number) {
    echo ' <a href="?page='.($page + 1).'">'.($page + 1).'</a> '; //After Page
}
if($page + 2 <= $pages_number) {
    echo ' <a href="?page='.($page + 2).'">'.($page + 2).'</a> '; //Two Pages After
}
if($page + 3 <= $pages_number) {
    echo ' <a href="?page='.($page + 3).'">'.($page + 3).'</a> '; //Three Pages After
}
if($page + 4 <= $pages_number) {
    echo '<span>...</span> ';
    echo ' <a href="?page='.($pages_number).'">'.$pages_number.'</a> '; //Last Page
}
if($page > $pages_number) {
    echo ' <a href="#">&raquo;</a> ';
} else {
    echo ' <a href="?page='.($page + 1).'">&raquo;</a> '; //Next Page
}
