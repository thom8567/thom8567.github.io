<?php

require __DIR__.'/includes/mysqli_connect.php';
require_once __DIR__.'/vendor/autoload.php';

ini_set('display_errors', 1);

error_reporting(E_ALL);

function getNumberOfItems($pdo, $table){
    $query = sprintf('SELECT COUNT(*) FROM %s', $table);
    return $pdo -> query($query) -> fetchColumn();
}

function calculateNumberOfPages($total, $limit){
    return ceil($total/$limit);
}

function getCurrentPage($pages){
    return min( $pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
        'options' => array (
            'default'   => 1,
            'min_range' => 1,
        ),
    )));
}

try {

    $limit = 50;

    //Find out how many items are in the table
    $total = getNumberOfItems($pdo, 'quiz_data');

    //Calculating how many pages there are going to be
    $pages = calculateNumberOfPages($total, $limit);

    //Determine the current page
    $page = getCurrentPage($pages);

    //Calculate the offset for the query
    $offset = ($page - 1) * $limit;

    //Info to display to the user
    $start = $offset + 1;
    $end = min(($offset + $limit), $total);

    // Prepare the paged query
    $stmt = $pdo -> prepare('SELECT * FROM quiz_data ORDER BY `id` LIMIT :limit OFFSET :offset');

    // Bind the query params
    $stmt -> bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt -> bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt -> execute();

    // Do we have any results?
    if ($stmt -> rowCount() > 0) {
        // Define how we want to fetch the results
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        $iterator = new IteratorIterator($stmt);

        // Display the results
        foreach ($iterator as $row) {
            echo '<p>', $row['id'], '</p>';
        }

    } else {
        echo '<p>No results could be displayed.</p>';
    }

    // The "back" link
    $prevLink = ($page > 1) ? '<a href="?page=1" title="First page">&laquo;</a> <a href="?page=' . ($page - 1) . '" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';

    // The "forward" link
    $nextLink = ($page < $pages) ? '<a href="?page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a href="?page=' . $pages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';

    // Display the paging information
    echo '<div id="paging"><p>', $prevLink, ' Page ', $page, ' of ', $pages, ' pages. Displaying ', $start, '-', $end, ' of ', $total, ' results ', $nextLink, ' </p></div>';


} catch (Exception $e){
    echo '<p>', $e -> getMessage(), '</p>';
};
