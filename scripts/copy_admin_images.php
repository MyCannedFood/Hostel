<?php
// Copy existing icons to create placeholder PNGs for all missing dashboard images
$projectRoot = dirname(__DIR__);
$srcIcon = $projectRoot . '/public/images/admin/img_icon.png';
$adminDir = $projectRoot . '/public/images/admin';
$imagesDir = $projectRoot . '/public/images';

$adminTargets = [
    'img_icon_gray_900.png',
    'img_icon_gray_900_20x18.png',
    'img_icon_gray_900_16x18.png',
    'img_icon_gray_900_20x20.png',
    'img_m_farhan.png',
    'img_icon_deep_orange_400.png',
    'img_button_trailing.png',
    'img_button_white_a700.png',
    'img_profile_margin.png',
    'img_icon_green_800.png',
    'img_icon_green_800_14x20.png',
    'img_icon_green_800_22x14.png',
    'img_icon_green_800_16x22.png'
];

$imageTargets = [
    'img_screen_removebg_preview.png',
    'img_margin.png',
    'img_icon_green_800_22x14.png',
    'img_icon_green_800_16x22.png',
    'img_arrow_right.png'
];

if (!file_exists($srcIcon)) {
    fwrite(STDERR, "Source icon not found: $srcIcon\n");
    exit(1);
}

if (!is_dir($adminDir)) {
    if (!mkdir($adminDir, 0755, true)) {
        fwrite(STDERR, "Failed to create admin directory: $adminDir\n");
        exit(1);
    }
}

if (!is_dir($imagesDir)) {
    if (!mkdir($imagesDir, 0755, true)) {
        fwrite(STDERR, "Failed to create images directory: $imagesDir\n");
        exit(1);
    }
}

echo "Creating admin image placeholders...\n";
foreach ($adminTargets as $t) {
    $dest = $adminDir . '/' . $t;
    if (file_exists($dest)) {
        echo "Exists: $t\n";
        continue;
    }
    if (copy($srcIcon, $dest)) {
        echo "Created: $t\n";
    } else {
        echo "Failed: $t\n";
    }
}

echo "\nCreating images placeholders...\n";
foreach ($imageTargets as $t) {
    $dest = $imagesDir . '/' . $t;
    if (file_exists($dest)) {
        echo "Exists: $t\n";
        continue;
    }
    if (copy($srcIcon, $dest)) {
        echo "Created: $t\n";
    } else {
        echo "Failed: $t\n";
    }
}

echo "\nDone.\n";
