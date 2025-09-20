<?php

namespace App\Application\Response;


class CEAResponse
{
    private array $gasto;

    public function __construct(array $gasto)
    {
        $this->gasto = $gasto;
    }

    public function toArray(): array
    {
        return $this->gasto;
    }
}

class CEAListResponse
{
    public array $gastos;
    public int $total;
    public int $page;
    public int $limit;
    public int $totalPages;

    public function __construct(array $gastos, int $total, int $page, int $limit)
    {
        $this->gastos = $gastos;
        $this->total = $total;
        $this->page = $page;
        $this->limit = $limit;
        $this->totalPages = $limit > 0 ? ceil($total / $limit) : 0;
    }

 
    public static function fromGastos(array $gastos, int $total, int $page, int $limit): self
    {
        $gastosResponse = [];
        foreach ($gastos as $gasto) {
            $gastosResponse[] = new CEAResponse($gasto);
        }

        return new self($gastosResponse, $total, $page, $limit);
    }

   
    public function toArray(): array
    {
        return [
            'data' => array_map(function ($gastoResponse) {
                return $gastoResponse->toArray();
            }, $this->gastos),
            'pagination' => [
                'total' => $this->total,
                'page' => $this->page,
                'limit' => $this->limit,
                'totalPages' => $this->totalPages
            ]
        ];
    }

  
    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }

 
    public function getGastos(): array
    {
        return $this->gastos;
    }


    public function getPagination(): array
    {
        return [
            'total' => $this->total,
            'page' => $this->page,
            'limit' => $this->limit,
            'totalPages' => $this->totalPages
        ];
    }
}
?>