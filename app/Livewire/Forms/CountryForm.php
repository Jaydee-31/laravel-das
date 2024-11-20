<?php

namespace App\Livewire\Forms;

use App\Models\Country;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CountryForm extends Form
{
    public ?Country $country;
    public $name = '';
    public $code = '';
    public $language_code = '';

    public function setCountry(Country $country)
    {
        $this->country = $country;

        $this->name = $country->name;
        $this->code = $country->code;
        $this->language_code = $country->language_code;
    }

    public function store(): void
    {
        $this->validate();

        Country::create([
            'name' => $this->name,
            'code' => $this->code,
            'language_code' => $this->language_code,
        ]);

        $this->reset();
    }

    public function update()
    {
        $this->validate();

        $this->country->update([
            'name' => $this->name,
            'code' => $this->code,
            'language_code' => $this->language_code
        ]);

        $this->reset();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|integer|unique:countries,code,{$this->country->id},id',
            'language_code' => 'required|string',
        ];
    }
}
