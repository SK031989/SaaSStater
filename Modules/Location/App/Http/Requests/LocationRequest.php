<?php

namespace Modules\Location\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tenant_id'      => 'nullable|exists:tenants,id',
            'name'           => 'required|string|max:255',
            'code'           => 'nullable|string|max:50',
            'country'        => 'required|string|max:100',
            'state'          => 'nullable|string|max:100',
            'city'           => 'required|string|max:100',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'postal_code'    => 'nullable|string|max:30',
            'phone'          => 'nullable|string|max:50',
            'email'          => 'nullable|email|max:150',
            'is_primary'     => 'nullable|boolean',
            'status'         => 'required|in:active,inactive',
            'notes'          => 'nullable|string|max:1000',
        ];
    }
}
