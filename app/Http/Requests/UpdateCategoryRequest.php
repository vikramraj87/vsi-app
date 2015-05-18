<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateCategoryRequest extends Request {

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
            'category.unique_with' => 'The category already exists',
            'category.required'    => 'Please provide a category name'
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
            'category'  => 'required|string|unique_with:categories,parent_id,' . $this->request->get('id'),
            'id'        => 'required|integer|exists:categories,id'
		];
	}

}
