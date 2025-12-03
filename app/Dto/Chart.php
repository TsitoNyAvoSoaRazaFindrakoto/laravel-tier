<?php

namespace App\Dto;

use ReturnTypeWillChange;

class Chart implements \JsonSerializable
{
    public array $labels;
    public array $data;

    public function __construct($labels, $data)
    {
        $this->labels = $labels;
        $this->data = $data;
    }

    public static function createChart($listData){
        $labels = [];
        $data = [];
        foreach ($listData as $item){
            $date=new \DateTime($item->label);
            $labels[] = $date->format('H:i:s');
            $data[] = $item->data;
        }
        return new self($labels, $data);
    }

    #[ReturnTypeWillChange] public function jsonSerialize()
    {
        return [
            'labels' => $this->labels,
            'data' => $this->data,
        ];
    }
}
