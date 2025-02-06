<?php

namespace App\Dto;

class ResponseJSON implements \JsonSerializable
{
    public int $status;
    public string $message;
    public $data;

    public function __construct($status, $message, $data=null)
    {
        $this->status = $status;
        $this->data = $data;
        $this->message = $message;
    }

    #[ReturnTypeWillChange] public function jsonSerialize()
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data,
        ];
    }
}
