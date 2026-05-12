<?php
function petshop_base_url(): string
{
    return '/PetShop';
}

function petshop_image_root(): string
{
    return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images';
}

function petshop_public_image_url(string $relativePath, string $baseUrl = '/PetShop'): string
{
    return $baseUrl . '/assets/images/' . str_replace('\\', '/', ltrim($relativePath, '/\\'));
}

function petshop_image_exists(string $relativePath): bool
{
    $fullPath = petshop_image_root() . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $relativePath);
    return is_file($fullPath);
}

function petshop_fallback_image(array $product, string $baseUrl = '/PetShop'): string
{
    $categoryId = (int) ($product['category_id'] ?? 0);
    $name = strtolower((string) ($product['product_name'] ?? ''));

    if ($categoryId === 2 || strpos($name, 'meo') !== false) {
        return petshop_public_image_url('cat_litter/000001.jpg', $baseUrl);
    }

    if ($categoryId === 3 || strpos($name, 'sua tam') !== false || strpos($name, 've sinh') !== false) {
        return petshop_public_image_url('bird_food/000001.jpg', $baseUrl);
    }

    return petshop_public_image_url('dog_food/000001.jpg', $baseUrl);
}

function getProductImage(?string $imageUrl, string $baseUrl = '/PetShop', array $product = []): string
{
    $imageUrl = trim((string) $imageUrl);

    if ($imageUrl !== '') {
        if (preg_match('#^https?://#i', $imageUrl)) {
            return $imageUrl;
        }

        if (strpos($imageUrl, $baseUrl . '/') === 0) {
            return $imageUrl;
        }

        if (strpos($imageUrl, '/assets/') === 0) {
            return $baseUrl . $imageUrl;
        }

        if (strpos($imageUrl, 'assets/') === 0) {
            $relativeAssetPath = preg_replace('#^assets/#', '', $imageUrl);
            if ($relativeAssetPath !== null && petshop_image_exists($relativeAssetPath)) {
                return $baseUrl . '/' . ltrim($imageUrl, '/');
            }
        }

        if (petshop_image_exists($imageUrl)) {
            return petshop_public_image_url($imageUrl, $baseUrl);
        }

        if (petshop_image_exists('dog_food/' . $imageUrl)) {
            return petshop_public_image_url('dog_food/' . $imageUrl, $baseUrl);
        }

        if (petshop_image_exists('cat_litter/' . $imageUrl)) {
            return petshop_public_image_url('cat_litter/' . $imageUrl, $baseUrl);
        }

        if (petshop_image_exists('bird_food/' . $imageUrl)) {
            return petshop_public_image_url('bird_food/' . $imageUrl, $baseUrl);
        }
    }

    return petshop_fallback_image($product, $baseUrl);
}

function petshop_product_image(array $product): string
{
    return getProductImage($product['image_url'] ?? '', petshop_base_url(), $product);
}

function petshop_product_alt(array $product): string
{
    return (string) ($product['product_name'] ?? 'PetShop product');
}

function petshop_product_category_label(array $product): string
{
    if (!empty($product['category_name'])) {
        return (string) ($product['category_name']);
    }

    $categoryId = (int) ($product['category_id'] ?? 0);
    if ($categoryId === 1) {
        return 'Thu cung';
    }

    if ($categoryId === 2) {
        return 'Thuc an';
    }

    if ($categoryId === 3) {
        return 'Phu kien';
    }

    return 'Pet care';
}
?>
