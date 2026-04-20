<?php
function petshop_product_image(array $product): string
{
    $category = strtolower((string) ($product['category'] ?? ''));
    $name = strtolower((string) ($product['product_name'] ?? ''));
    $combined = $category . ' ' . $name;

    if (
        strpos($combined, 'hamster') !== false
    ) {
        return '/PetShop/assets/photo/hamster.webp';
    }

    if (
        strpos($combined, 'rabbit') !== false ||
        strpos($combined, 'bunny') !== false ||
        strpos($combined, 'tho') !== false ||
        strpos($combined, 'rabit') !== false
    ) {
        return '/PetShop/assets/photo/rabit.png';
    }

    if (
        strpos($combined, 'lizard') !== false ||
        strpos($combined, 'reptile') !== false ||
        strpos($combined, 'bo sat') !== false ||
        strpos($combined, 'than lan') !== false
    ) {
        return '/PetShop/assets/photo/th%E1%BA%B1ng%20l%E1%BA%B1n.webp';
    }

    if (
        strpos($combined, 'cat') !== false ||
        strpos($combined, 'meo') !== false
    ) {
        return '/PetShop/assets/photo/cat.jpg';
    }

    if (
        strpos($combined, 'fish') !== false ||
        strpos($combined, 'ca') !== false
    ) {
        return '/PetShop/assets/photo/fish.jpg';
    }

    if (
        strpos($combined, 'bird') !== false ||
        strpos($combined, 'brid') !== false ||
        strpos($combined, 'chim') !== false
    ) {
        return '/PetShop/assets/photo/brid.jpg';
    }

    if (
        strpos($combined, 'hygiene') !== false ||
        strpos($combined, 've sinh') !== false ||
        strpos($combined, 'sand') !== false ||
        strpos($combined, 'groom') !== false
    ) {
        return '/PetShop/assets/photo/grooming.jpg';
    }

    if (
        strpos($combined, 'access') !== false ||
        strpos($combined, 'day') !== false ||
        strpos($combined, 'toy') !== false
    ) {
        return strpos($combined, 'toy') !== false
            ? '/PetShop/assets/photo/toy.jpg'
            : '/PetShop/assets/photo/grooming.jpg';
    }

    return '/PetShop/assets/photo/dog.jpg';
}

function petshop_product_alt(array $product): string
{
    return (string) ($product['product_name'] ?? 'PetShop product');
}
?>
