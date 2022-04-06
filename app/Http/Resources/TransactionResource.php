<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'payer' => $this->customer->name,
            'category' => $this->category->name,
            'sub_category' => $this->category->name,
            'amount' => $this->amount,
            'due_on' => $this->due,
        ];
    }
}
