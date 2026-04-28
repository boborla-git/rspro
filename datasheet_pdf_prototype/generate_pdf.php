<?php
error_reporting(E_ALL & ~E_WARNING & ~E_DEPRECATED & ~E_NOTICE);
ini_set('display_errors', '0');

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/src/DatasheetRepository.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

$dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";
$pdo = new PDO($dsn, $db_user, $db_pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

$repo = new DatasheetRepository($pdo);
$product = $repo->getProduct($id);

if (!$product) {
    http_response_code(404);
    exit('Prodotto non trovato: id=' . $id);
}

$specs = $repo->getSpecifications($id);
$similarProducts = $repo->getSimilarProducts($id);

function h(?string $value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function asset_path(string $relativePath): string
{
    $relativePath = ltrim(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $relativePath), DIRECTORY_SEPARATOR);
    return __DIR__ . DIRECTORY_SEPARATOR . $relativePath;
}

$logoPath = asset_path('assets/images/rspro-logo.jpeg');
$productImagePath = !empty($product['product_image']) ? asset_path($product['product_image']) : '';
$diagramImagePath = !empty($product['diagram_image']) ? asset_path($product['diagram_image']) : '';

$css = file_get_contents(__DIR__ . '/templates/datasheet.css');

$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
    'margin_left' => 15,
    'margin_right' => 15,
    'margin_top' => 24,
    'margin_bottom' => 18,
    'default_font' => 'arial',
    'shrink_tables_to_fit' => 1,
]);

$headerHtml = '
<table class="pdf-header" width="100%" cellspacing="0" cellpadding="0">
    <tr>
        <td class="pdf-header-title">' . h($product['family_name']) . '</td>
        <td class="pdf-header-logo-cell"><img class="pdf-header-logo" src="' . h($logoPath) . '"></td>
    </tr>
    <tr><td colspan="2" class="pdf-red-line"></td></tr>
</table>';

$footerHtml = '
<table class="pdf-footer" width="100%" cellspacing="0" cellpadding="0">
    <tr><td colspan="2" class="pdf-red-line"></td></tr>
    <tr>
        <td class="pdf-footer-url">Buy this product from https://uk.rs-online.com/</td>
        <td class="pdf-footer-page">Page {PAGENO} of {nbpg}</td>
    </tr>
</table>';

$mpdf->SetTitle('RS PRO Datasheet - ' . ($product['rs_stock_no'] ?? $id));
$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->SetHTMLHeader($headerHtml);
$mpdf->SetHTMLFooter($footerHtml);

for ($page = 1; $page <= 3; $page++) {
    if ($page > 1) {
        $mpdf->AddPage();
    }
    ob_start();
    $currentPage = $page;
    include __DIR__ . '/templates/datasheet.php';
    $html = ob_get_clean();
    $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
}

if (!is_dir($output_dir)) {
    mkdir($output_dir, 0777, true);
}

$file = $output_dir . DIRECTORY_SEPARATOR . 'datasheet_' . $id . '.pdf';
$mpdf->Output($file, \Mpdf\Output\Destination::FILE);

echo 'Creato: ' . $file;
