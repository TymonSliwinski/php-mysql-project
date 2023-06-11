<?php
echo '<h1>Applications</h1>';
foreach ($applications as $application) {
    echo '<div class="card">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">' . $application['offerTitle'] . ' at ' . $application['companyName'] . '</h5>';
    echo '<p class="card-text">' . $application['description'] . '</p>';
    echo '<p class="card-text">Applied on: ' . date('Y-m-d', strtotime($application['date'])) . '</p>';
    echo '</div>';
    echo '</div>';
}
?>