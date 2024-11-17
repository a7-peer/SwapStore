<?php
include("conn.php");
//function for error

function showError($error)
{
    if (isset($error)) {
        echo '<div class="alert alert-danger" role="alert">';
        echo htmlspecialchars($error); // Ensure safe output
        echo '</div>';
    }
}
