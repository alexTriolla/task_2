<?php
require_once '../Services/SaveOrderService.php';
require_once '../Services/LoggerService.php';

// Initialize services
$saveOrderService = new SaveOrderService('../Storage/order.json');
$logger = new LoggerService('../Logs/error.log', '../Logs/info.log');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['order'])) {
        try {
            $saveOrderService->saveOrder($data['order']);
            $logger->logInfo('Order saved successfully.');
            echo "Order saved successfully!";
        } catch (Exception $e) {
            $logger->logError('Failed to save order: ' . $e->getMessage());
            echo "Failed to save order.";
        }
    } else {
        $logger->logError('No order data received.');
        echo "No order data received.";
    }
}
?>
