<?php

namespace Squirrel\Blog\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->input('id', null);
        return [
            'name' => 'required',
            'slug' => 'required|unique:casts' . (empty($id)?'':",slug,{$id},castable_id"),
            'title' => 'required|unique:pages' . (empty($id)?'':",title,{$id}"),
            'excerpt' => 'required',
            'body' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' =>  __('This is a required field.'),
            'slug.required' =>  __('This is a required field.'),
            'slug.unique' =>  __('Slug already exists.'),
            'title.required' =>  __('This is a required field.'),
            'title.unique' =>  __('Title already exists.'),
            'excerpt.required' =>  __('This is a required field.'),
            'body.required' =>  __('This is a required field.'),
        ];
    }

}