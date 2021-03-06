<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
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
            'starting_date' => 'required|date|date_format:Y-m-d',
            'ending_date' => 'required|date|date_format:Y-m-d|after_or_equal:starting_date',
            'period' => 'nullable,in:year,month'
        ];
    }
}
