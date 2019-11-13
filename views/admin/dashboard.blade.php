<?php
$html = file_get_contents(public_path('/vendor/fast_dog/frontend/index.html'));

$html = str_replace(['/css/', '/js/', '{csrf_token}', '{YMAP_KEY}'],
    ['/vendor/fast_dog/frontend/css/', '/vendor/fast_dog/frontend/js/', csrf_token(), env('YMAP_KEY')], $html);

echo $html;
