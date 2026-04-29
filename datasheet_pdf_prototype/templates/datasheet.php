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

<!-- Page 1 v11: rigid mPDF layout, only tables and inline styles -->
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="width:180mm;border-collapse:collapse;table-layout:fixed;">
<tr>
<td width="55mm" valign="top" style="width:55mm;vertical-align:top;padding:0;">
<table width="55mm" cellpadding="0" cellspacing="0" border="0" style="width:55mm;border-collapse:collapse;margin-top:9mm;">
<tr><td style="height:10mm;background:#e60000;font-size:1px;line-height:1px;">&nbsp;</td></tr>
<tr><td style="height:22mm;background:#ffffff;color:#e60000;text-align:center;vertical-align:middle;font-size:17pt;font-weight:bold;font-family:Arial, Helvetica, sans-serif;">Features</td></tr>
<tr>
<td style="height:166mm;background:#e60000;color:#ffffff;vertical-align:top;padding:10mm 5mm 4mm 8mm;font-family:Arial, Helvetica, sans-serif;font-size:9.3pt;line-height:1.45;">
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;color:#ffffff;font-size:9.3pt;line-height:1.45;">
<?php $features = array_slice(section_rows($specs, 'Features'), 0, 5); ?>
<?php foreach ($features as $feature): ?>
<tr>
<td width="5mm" valign="top" style="width:5mm;color:#ffffff;padding:0 0 2.2mm 0;font-size:12pt;line-height:1;">&bull;</td>
<td valign="top" style="color:#ffffff;padding:0 0 2.2mm 0;line-height:1.45;"><?= h($feature['valore'] ?: $feature['attributo']) ?></td>
</tr>
<?php endforeach; ?>
<?php for ($i = count($features); $i < 5; $i++): ?>
<tr>
<td width="5mm" valign="top" style="width:5mm;color:#ffffff;padding:0 0 2.2mm 0;font-size:12pt;line-height:1;">&bull;</td>
<td valign="top" style="color:#ffffff;padding:0 0 2.2mm 0;line-height:1.45;">&nbsp;</td>
</tr>
<?php endfor; ?>
</table>
</td>
</tr>
</table>
</td>
<td width="10mm" style="width:10mm;padding:0;">&nbsp;</td>
<td width="115mm" valign="top" style="width:115mm;vertical-align:top;padding:0;text-align:center;padding-top:38mm;font-family:Arial, Helvetica, sans-serif;">
<table width="115mm" cellpadding="0" cellspacing="0" border="0" style="width:115mm;border-collapse:collapse;">
<tr><td style="text-align:center;color:#111111;font-size:16pt;font-weight:bold;padding:0 0 6mm 0;"><?= h($product['family_name']) ?></td></tr>
<tr><td style="text-align:center;color:#666666;font-size:11pt;font-weight:bold;padding:0 0 8mm 0;">RS Stock No.: <?= h($product['rs_stock_no']) ?></td></tr>
<tr>
<td align="center" style="padding:0;">
<table width="112mm" height="98mm" cellpadding="0" cellspacing="0" border="0" style="width:112mm;height:98mm;border-collapse:collapse;margin-left:auto;margin-right:auto;">
<tr>
<td width="112mm" height="98mm" valign="middle" align="center" style="width:112mm;height:98mm;border:0.35mm solid #333333;text-align:center;vertical-align:middle;color:#d0d0d0;font-size:25pt;line-height:98mm;">
<?php if ($productImagePath && file_exists($productImagePath)): ?>
<img src="<?= h($productImagePath) ?>" style="max-width:107mm;max-height:93mm;vertical-align:middle;" alt="Product image">
<?php else: ?>
Image
<?php endif; ?>
</td>
</tr>
</table>
</td>
</tr>
<tr><td style="padding-top:36mm;text-align:justify;color:#666666;font-size:8.8pt;line-height:1.42;"><strong>RS Professionally Approved Products</strong> bring to you professional quality parts across all product categories. Our product range has been tested by engineers and provides a comparable quality to the leading brands without paying a premium price.</td></tr>
</table>
</td>
</tr>
</table>

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
