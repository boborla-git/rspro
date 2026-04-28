<?php
if (!function_exists('section_rows')) {
    function section_rows(array $specs, string $section): array
    {
        return $specs[$section] ?? [];
    }

    function render_two_col_table(array $rows, int $minRows = 1): void
    {
        $count = max($minRows, count($rows));
        echo '<table class="spec-table">';
        for ($i = 0; $i < $count; $i++) {
            $row = $rows[$i] ?? ['attributo' => '', 'valore' => ''];
            echo '<tr>';
            echo '<td class="spec-label">' . h($row['attributo'] ?? '') . '</td>';
            echo '<td class="spec-value">' . h($row['valore'] ?? '') . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }

    function render_section(string $title, array $rows, int $minRows = 1, bool $wide = false): void
    {
        echo '<div class="section">';
        echo '<div class="section-title' . ($wide ? ' section-title-wide' : '') . '">' . h($title) . '</div>';
        echo '<div class="section-rule"></div>';
        render_two_col_table($rows, $minRows);
        echo '</div>';
    }
}
?>

<?php if ($currentPage === 1): ?>
<div class="page page-1">
    <table class="p1-layout">
        <tr>
            <td class="p1-feature-col">
                <div class="p1-feature-cap"></div>
                <div class="p1-feature-panel">
                    <div class="p1-feature-title">Features</div>
                    <ul class="p1-feature-list">
                        <?php $features = array_slice(section_rows($specs, 'Features'), 0, 5); ?>
                        <?php foreach ($features as $feature): ?>
                            <li><?= h($feature['valore'] ?: $feature['attributo']) ?></li>
                        <?php endforeach; ?>
                        <?php for ($i = count($features); $i < 5; $i++): ?>
                            <li>&nbsp;</li>
                        <?php endfor; ?>
                    </ul>
                </div>
            </td>
            <td class="p1-gap"></td>
            <td class="p1-product-col">
                <div class="p1-title"><?= h($product['family_name']) ?></div>
                <div class="p1-stock">RS Stock No.: <?= h($product['rs_stock_no']) ?></div>
                <div class="p1-image-box">
                    <?php if ($productImagePath && file_exists($productImagePath)): ?>
                        <img src="<?= h($productImagePath) ?>" alt="Product image">
                    <?php else: ?>
                        Image
                    <?php endif; ?>
                </div>
                <div class="p1-approved">
                    <strong>RS Professionally Approved Products</strong> bring to you professional quality parts across all product categories. Our product range has been tested by engineers and provides a comparable quality to the leading brands without paying a premium price.
                </div>
            </td>
        </tr>
    </table>
</div>
<?php endif; ?>

<?php if ($currentPage === 2): ?>
<div class="page page-2">
    <div class="section">
        <div class="section-title section-title-wide">Product Description</div>
        <div class="section-rule"></div>
        <div class="description-box">
            <?php if (!empty($product['product_description'])): ?>
                <?= nl2br(h($product['product_description'])) ?>
            <?php else: ?>
                Please introduce the product with relevant details stating:<br>
                &bull; What are the products used for?<br>
                &bull; Applications they are most suited for or not suited for<br>
                &bull; What are they used with etc
            <?php endif; ?>
        </div>
    </div>

    <?php render_section('General Specifications', section_rows($specs, 'General Specifications'), 1); ?>
    <?php render_section('Mechanical Specifications', section_rows($specs, 'Mechanical Specifications'), 1); ?>
    <?php render_section('Electrical Specifications', section_rows($specs, 'Electrical Specifications'), 1); ?>
    <?php render_section('Protection Category', section_rows($specs, 'Protection Category'), 1); ?>
    <?php render_section('Classification', section_rows($specs, 'Classification'), 2); ?>
</div>
<?php endif; ?>

<?php if ($currentPage === 3): ?>
<div class="page page-3">
    <?php render_section('Approvals', section_rows($specs, 'Approvals'), 3); ?>

    <div class="section">
        <div class="section-title">Similar Products</div>
        <div class="section-rule"></div>
        <table class="similar-table">
            <thead>
                <tr>
                    <th>Stock No.</th>
                    <th>Brand</th>
                    <th>Product<br>Name</th>
                    <th>Attribute 1</th>
                    <th>Attribute 2</th>
                    <th>Attribute 3</th>
                </tr>
            </thead>
            <tbody>
                <?php $rowsToRender = max(2, count($similarProducts)); ?>
                <?php for ($i = 0; $i < $rowsToRender; $i++): $sp = $similarProducts[$i] ?? []; ?>
                    <tr>
                        <td><?= h($sp['stock_no'] ?? '') ?></td>
                        <td><?= h($sp['brand'] ?? '') ?></td>
                        <td><?= h($sp['product_name'] ?? '') ?></td>
                        <td><?= h($sp['attribute_1'] ?? '') ?></td>
                        <td><?= h($sp['attribute_2'] ?? '') ?></td>
                        <td><?= h($sp['attribute_3'] ?? '') ?></td>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>

    <div class="diagram-caption">Connection Diagrams / Assembly Diagrams / Illustrations / Accessories</div>
    <?php if ($diagramImagePath && file_exists($diagramImagePath)): ?>
        <div class="diagram-box"><img src="<?= h($diagramImagePath) ?>" alt="Diagram"></div>
    <?php endif; ?>
</div>
<?php endif; ?>
