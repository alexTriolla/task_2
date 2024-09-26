<?php

class SaveOrderService
{
    private $orderFile;

    public function __construct($orderFile)
    {
        $this->orderFile = $orderFile;
        $this->createFileIfNotExists();
    }

    public function saveOrder(array $order)
    {
        $data = json_encode($order, JSON_PRETTY_PRINT);
        if (file_put_contents($this->orderFile, $data) === false) {
            throw new Exception("Unable to save order to file: " . $this->orderFile);
        }
    }

    private function createFileIfNotExists()
    {
        $dir = dirname($this->orderFile);

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        if (!file_exists($this->orderFile)) {
            file_put_contents($this->orderFile, json_encode([])); 
            chmod($this->orderFile, 0666); 
        }
    }

    public function loadOrder()
    {
        if (!file_exists($this->orderFile)) {
            throw new Exception("Order file not found: " . $this->orderFile);
        }

        $data = file_get_contents($this->orderFile);
        return json_decode($data, true);
    }
}
