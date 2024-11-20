<?php

namespace App\Livewire;

use App\Livewire\Forms\CountryForm;
use App\Models\Country;
use Livewire\Component;

class CountryList extends Component
{
    public CountryForm $form;
    public $openCountryModal = false;
    public $isEditMode = false;
    public function render()
    {
        return view('livewire.countries.country-list', [
            'countries' => Country::select('id', 'code', 'name', 'language_code')->orderby('code', 'asc')->get(),
        ]);
    }

    public function openModal(?int $countryId = null): void
    {
        if ($countryId) {
            $this->form->setCountry(Country::findOrFail($countryId));
            $this->isEditMode = true;
        } else {
            $this->isEditMode = false;
        }
        $this->openCountryModal = true;
    }


    public function save()
    {
        if ($this->isEditMode) {
            $this->form->update();
            session()->flash('success', 'Country Updated Successfully!!');
        } else {
            $this->form->store();
            session()->flash('success', 'Country Created Successfully!!');
        }

        $this->openCountryModal = false;
    }

    public function cancel()
    {
        $this->openCountryModal = false;
        $this->form->reset();
    }

    public function archive()
    {
        //
    }

    public function delete(?Country $country = null)
    {
        $country?->delete();
        session()->flash('success', 'Country Deleted Successfully!!');
    }
}
