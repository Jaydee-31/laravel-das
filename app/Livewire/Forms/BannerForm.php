<?php

namespace App\Livewire\Forms;

use App\Models\Banner;
use Livewire\Attributes\Validate;
use Livewire\Form;

class BannerForm extends Form
{
    public ?Banner $banner;
    public $name = '';
    public $sizes = '';

    public function setBanner(Banner $banner)
    {
        $this->banner = $banner;
        $this->name = $banner->name;
        $this->sizes = $banner->sizes;
    }

    public function store(): void
    {
        $this->validate();

        $sizesArray = explode(',', $this->sizes);

        Banner::create([
            'name' => $this->name,
            'sizes' => $sizesArray,
        ]);
        // Banner::create($this->only(['name', 'sizes' => $sizesArray]));

        $this->reset();
    }

    public function update()
    {
        $this->validate();
        $sizesArray = explode(',', $this->sizes);
        $this->banner->update(['name' => $this->name, 'sizes' => $sizesArray]);

        $this->reset();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'sizes' => 'required|string',
        ];
    }
}
