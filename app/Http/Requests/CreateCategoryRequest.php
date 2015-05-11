<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateCategoryRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

    public function messages()
    {
        return [
            'category.unique_with' => 'Category already exists'
        ];
    }
    /**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'parent_id' => 'required|integer',
            'category'  => 'required|string|unique_with:categories,parent_id'
		];
	}

}
