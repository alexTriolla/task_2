<?php
require_once '../Services/SaveOrderService.php';
require_once '../Services/LoggerService.php';

$imageDir = 'images'; 
$orderFile = '../Storage/order.json';

$saveOrderService = new SaveOrderService($orderFile);
$logger = new LoggerService('../Logs/error.log', '../Logs/info.log');

$order = [];
try {
    $order = $saveOrderService->loadOrder();
    $logger->logInfo('Order loaded successfully.');
} catch (Exception $e) {
    $logger->logError('Failed to load order: ' . $e->getMessage());
}

$images = scandir($imageDir);
$images = array_filter($images, function ($image) {
    return $image !== '.' && $image !== '..';
});

if (!empty($order)) {
    $images = array_filter($images, function ($image) use ($order) {
        return in_array($image, $order);
    });
    usort($images, function ($a, $b) use ($order) {
        return array_search($a, $order) - array_search($b, $order);
    });
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sortable Logos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css"> 
</head>
<body>
    <div class="container">
        <h1 class="text-center my-4">Sortable Logos</h1>
        <div id="logoContainer" class="logo-container">
            <?php foreach ($images as $image): ?>
                <div class="logo-item list-group-item" data-id="<?php echo htmlspecialchars($image); ?>">
                    <img src="<?php echo $imageDir . '/' . htmlspecialchars($image); ?>" class="img-fluid" alt="Logo">
                </div>
            <?php endforeach; ?>
        </div>
        <button id="saveOrder" class="btn btn-primary mt-3">Save Order</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script src="js/script.js"></script> 
</body>
</html>
