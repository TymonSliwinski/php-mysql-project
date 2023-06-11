<?php
if (isset($_SESSION['user']) && isset($_SESSION['company'])) {
    echo '<form action="/offers" method="POST">';
    echo '<input type="submit" name="addOffer" value="Add Offer">';
    echo '</form>';
}
echo '<h1>Offers</h1>';
foreach($offers as $offer) {
    echo '<div class="row">';
    echo '<div class="col-12">';
    echo '<div class="card">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">' . $offer['title'] . '</h5>';
    echo '<div class="card-content">';
    echo '<p>' . $offer['description'] . '</p>';
    echo '<p>' . $offer['requirements'] . '</p>';
    echo '<p>' . $offer['location'] . '</p>';
    echo '<p>' . $offer['salaryLower'] . '</p>';
    echo '<p>' . $offer['salaryUpper'] . '</p>';
    echo '</div>';
    if (isset($_SESSION['user']) && isset($_SESSION['candidate'])) {
        echo '<form action="/applications" method="GET">';
        echo '<input type="hidden" name="offerId" value="' . $offer['id'] . '">';
        echo '<input type="submit" name="apply" value="Apply">';
        echo '</form>';
    }
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
?>