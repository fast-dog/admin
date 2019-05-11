<?php
$html = file_get_contents(public_path('/vendor/fast_dog/frontend/index.html'));

$html = str_replace(['/css/', '/js/'], ['/vendor/fast_dog/frontend/css/', '/vendor/fast_dog/frontend/js/'], $html);

echo $html;
