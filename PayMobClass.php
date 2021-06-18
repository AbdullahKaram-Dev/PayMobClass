<?php
declare(strict_types=1);

namespace Pay;

class PayMobClass
{
    public string $orderDetails;
    public array $response;
    public string $token;
    public string $payment_key;
    public int $orderId;
    public $connect;

    public function prepareConnect(string $urlToConnect): void
    {
        $this->connect = curl_init();
        curl_setopt($this->connect, CURLOPT_URL, $urlToConnect);
        curl_setopt($this->connect, CURLOPT_RETURNTRANSFER, true);
    }

    public function setHeaders(array $headers): void
    {
        curl_setopt($this->connect, CURLOPT_HTTPHEADER, $headers);
    }

    public function sendRequestPostToGetToken(array $api_key): void
    {
        curl_setopt($this->connect, CURLOPT_POST, true);
        curl_setopt($this->connect, CURLOPT_POSTFIELDS, json_encode($api_key));
    }

    public function sendRequestPostToGetPaymentKey(array $data): void
    {
        curl_setopt($this->connect, CURLOPT_POST, true);
        curl_setopt($this->connect, CURLOPT_POSTFIELDS, json_encode($data));
    }

    public function getAllResponse(): array
    {
        return $this->response = json_decode(curl_exec($this->connect), true);
    }

    public function closeCurlConnect(): void
    {
        curl_close($this->connect);
    }

    public function getToken(): string
    {
        return $this->token = $this->getAllResponse()['token'];
    }

    public function setOrderDetails(array $orderDetails): void
    {
        $this->orderDetails = json_encode($orderDetails);
    }

    public function sendOrderDetails(): void
    {
        curl_setopt($this->connect, CURLOPT_POST, true);
        curl_setopt($this->connect, CURLOPT_POSTFIELDS, $this->orderDetails);
    }

    public function getOrderID(): int
    {
        return $this->getAllResponse()['id'];
    }

    public function getPaymentKey(): string
    {
        return $this->payment_key = $this->getAllResponse()['token'];
    }


}