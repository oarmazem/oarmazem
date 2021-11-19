<?php

$exif = exif_read_data('../uploads/3002-000.jpg', 0, true);

echo "3002-000.jpg:<br />\n";
foreach ($exif as $key => $section) {

    foreach ($section as $name => $val) {

        echo "$key.$name: $val<br />\n";

    }
}

?>







