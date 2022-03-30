<?php
namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'sometimes|exists:categories,id',
            'amount' => 'required|numeric|gt:-1',
            'customer_id' => 'sometimes|exists:users,id',
            'due' => 'required|date|date_format:Y-m-d',
            'vat' => 'required|numeric|gt:-1',
            'is_vat_inclusive' => 'required',
        ];
    }
}
