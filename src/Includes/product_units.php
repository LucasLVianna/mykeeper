<?php

$productUnitOptions = [
    ['value' => 'kg', 'label' => 'Quilograma (kg)'],
    ['value' => 'g', 'label' => 'Grama (g)'],
    ['value' => 'L', 'label' => 'Litro (L)'],
    ['value' => 'ml', 'label' => 'Mililitro (ml)'],
];

if (!function_exists('renderProductUnitOptions')) {
    function renderProductUnitOptions(string $selectedValue = ''): string
    {
        global $productUnitOptions;

        $html = '<option value="">Selecione a unidade de medida</option>';

        foreach ($productUnitOptions as $option) {
            $selected = $selectedValue === $option['value'] ? ' selected' : '';
            $value = htmlspecialchars($option['value'], ENT_QUOTES, 'UTF-8');
            $label = htmlspecialchars($option['label'], ENT_QUOTES, 'UTF-8');
            $html .= "<option value=\"{$value}\"{$selected}>{$label}</option>";
        }

        return $html;
    }
}

if (!function_exists('productUnitValues')) {
    function productUnitValues(): array
    {
        global $productUnitOptions;

        return array_column($productUnitOptions, 'value');
    }
}
