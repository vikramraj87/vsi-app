<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateCaseRequest extends Request {

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
     * @return array
     */
    public function messages()
    {
        $messages = [];

        foreach($this->request->get('url') as $key => $val) {
            $messages['url.' . $key . '.required'] = 'Please provide a virtual slide url';
            $messages['url.' . $key . '.url']      = 'Please provide a valid url';
        }

        foreach($this->request->get('stain') as $key => $val) {
            $messages['stain.' . $key . '.required'] = 'Please provide the stain used';
        }

        return $messages;
    }

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = [
			'virtual_slide_provider_id' => 'required|integer|exists:virtual_slide_providers,id',
            'clinical_data'             => 'string',
            'category_id'               => 'required|integer|exists:categories,id'
		];

        foreach($this->request->get('url') as $key => $val) {
            $rules['url.' . $key] = 'required|url|unique:virtual_slides,url';
        }

        foreach($this->request->get('stain') as $key => $val) {
            $rules['stain.' . $key] = 'required';
        }

        return $rules;
	}

}
