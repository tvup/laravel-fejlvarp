<?php

namespace Tvup\LaravelFejlvarp\Http\Requests;

class IncidentStoreRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string>
     */
    public function rules()
    {
        return [
            'hash' => 'required|string|max:255',
            'subject' => 'required|string',
            'data' => 'required|string',
        ];
    }
}
