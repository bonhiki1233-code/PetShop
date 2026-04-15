<?php
function petshop_product_image(array $product): string
{
    $category = strtolower((string) ($product['category'] ?? ''));
    $name = strtolower((string) ($product['product_name'] ?? ''));
    $combined = $category . ' ' . $name;

    if (strpos($combined, 'cat') !== false || strpos($combined, 'meo') !== false) {
        return '/PetShop/assets/images/cat-food.svg';
    }

    if (strpos($combined, 'access') !== false || strpos($combined, 'day') !== false || strpos($combined, 'toy') !== false) {
        return '/PetShop/assets/images/accessories.svg';
    }

    if (strpos($combined, 'hygiene') !== false || strpos($combined, 've sinh') !== false || strpos($combined, 'sand') !== false) {
        return '/PetShop/assets/images/hygiene.svg';
    }

    return '/PetShop/assets/images/dog-food.svg';
}

function petshop_product_alt(array $product): string
{
    return (string) ($product['product_name'] ?? 'PetShop product');
}
?>
