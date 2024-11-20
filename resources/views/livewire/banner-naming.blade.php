<?php

use App\Models\Banner;
use App\Models\Country;
use App\Models\Vendor;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
    public $searchVendor = "";
    public $countries = [];
    public $vendors = [];
    public $banners = [];
    public $sizes = [];
    public $prefix = NULL;

    // #[Validate('required', message: 'Please select at least one vendor.')]
    public $selectedVendors = [];
    public $selectedVendorNames = NULL;
    public $selectedSize = NULL;
    public $selectedBanner = NULL;
    public $campaign;
    public $campaign_id;
    public $calendarWeek;
    public $output = NULL;

    public function mount()
    {
        $year = date("y");
        $weekNumber = date('W',);

        $this->calendarWeek = "{$year}CW{$weekNumber}";
        $this->countries = Country::select('id', 'code', 'name', 'language_code')->orderby('id', 'asc')->get();
        $this->banners = Banner::select('name', 'sizes')->orderby('id', 'desc')->get();
        $this->vendors = Vendor::search($this->searchVendor)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function updatedSearchVendor()
    {
        $vendorIds = [];

        // If there are selected vendors, populate $vendorIds array
        if (!empty($this->selectedVendors)) {
            foreach ($this->selectedVendors as $vendor) {
                $vendorIds[] = $vendor->id;
            }
        }

        // Query vendors, excluding those already selected
        $this->vendors = Vendor::search($this->searchVendor)
            ->whereNotIn('id', $vendorIds)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function selectVendor(Vendor $vendor)
    {
        $this->selectedVendors[] = $vendor;

        $this->updatedSearchVendor();
    }

    public function removeVendor(Vendor $vendor)
    {
        $removedVendors[] = $vendor;
        $this->selectedVendors = array_diff($this->selectedVendors, $removedVendors);

        $this->updatedSearchVendor();
    }

    public function updatedSelectedBanner($banner)
    {
        $this->sizes = Banner::where('name', $banner)->value('sizes');
        $this->selectedSize = NULL;
    }


    public function generateName()
    {
        $this->validate();

        $vendorNames = [];

        foreach ($this->selectedVendors as $vendor) {
            $vendorNames[] = $vendor->name; // Assuming 'name' is the attribute you want
        }

        $this->selectedVendorNames = implode('&', array_map('strtolower', $vendorNames));
        $campaign = str_replace(' ', '', ucwords($this->campaign));
        $campaignId = str_replace(' ', '', ucwords($this->campaign_id));
        $this->output = "{$campaign}_{$campaignId}_{$this->selectedBanner}_{$this->selectedSize}";
    }

    public function rules()
    {
        return [
            'selectedVendors' => 'required|array|max:4',
            'selectedBanner' => 'required',
            'selectedSize' => 'required',
            'campaign' => 'required',
            'campaign_id' => 'required',
            'calendarWeek' => ['required', 'regex:/^\d{2}CW\d{2}$/'],
        ];
    }

    public function messages()
    {
        return [
            'selectedVendors.required' => 'Please select at least one vendor.',
            'calendarWeek.regex' => 'The :attribute must be in the format YYCWXX where YY = Year and XX = Week. Both numbers.',
        ];
    }

    public function validationAttributes()
    {
        return [
            'selectedVendors' => 'vendors',
            'selectedBanner' => 'banner',
            'selectedSize' => 'size',
            'campaign' => 'campaign',
            'campaign_id' => 'campaign ID',
            'calendarWeek' => 'calendar week',
        ];
    }
} ?>

<div>
    <form wire:submit="generateName">
        <div
            class="p-6 flex flex-col text-neutral-900 sm:rounded-lg dark:text-neutral-100 bg-white dark:bg-neutral-900 dark:bg-opacity-90 mb-6">

            <div class="block mb-6">
                <div class="flex mb-3">
                    @foreach($selectedVendors as $selectedVendor)
                    <span id="badge-dismiss-default" class="inline-flex items-center px-2 py-1 me-2 text-sm font-medium text-blue-800 bg-blue-100 rounded dark:bg-blue-900 dark:text-blue-300">
                        <p>{{ $selectedVendor->name }}</p>
                        <button wire:click="removeVendor({{ $selectedVendor }})" type="button" class="inline-flex items-center p-1 ms-2 text-sm text-blue-400 bg-transparent rounded-sm hover:bg-blue-200 hover:text-blue-900 dark:hover:bg-blue-800 dark:hover:text-blue-300" data-dismiss-target="#badge-dismiss-default" aria-label="Remove">
                            <svg class="w-2 h-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Remove vendor</span>
                        </button>
                    </span>
                    @endforeach
                </div>
                <div
                    x-data="{ open: false }"
                    class="relative x-vendors">
                    <div class="block" x-on:click="open = true">
                        <x-label>Select vendors (maximum 4):</x-label>
                        <x-input
                            type="text"
                            @keyup="open = true"
                            wire:model.live="searchVendor"
                            wire:ignore
                            class="mt-1 w-full"
                            placeholder="Start typing...">
                        </x-input>
                        <x-input-error for="selectedVendors" class="mt-2" />
                    </div>

                    <ul
                        x-show="open"
                        x-on:click.away="open = false"
                        class="overflow-y-auto h-96 bg-white text-gray-700 dark:bg-neutral-800 dark:text-gray-50 rounded shadow-lg absolute py-2 mt-1"
                        style="min-width:15rem">

                        @forelse($vendors as $vendor)
                        <li>
                            <p wire:click="selectVendor({{ $vendor }})" class="block hover:bg-gray-200 dark:hover:bg-neutral-900 whitespace-no-wrap py-2 px-4">
                                {{ $vendor->name }}
                            </p>
                        </li>
                        @empty
                        <p class="block whitespace-no-wrap py-2 px-4">No vendors found.</p>
                        @endforelse

                    </ul>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <!-- Campaign -->
                <div class="block mb-3">
                    <x-label>Campaign Name:</x-label>
                    <x-input type="text" wire:model="campaign" class="mt-1 w-full"
                        placeholder="e.g. Promo"></x-input>
                    <x-input-error for="campaign" class="mt-2" />
                </div>
                <!-- Campaign ID -->
                <div class="block mb-3">
                    <x-label>Campaign ID:</x-label>
                    <x-input type="text" wire:model="campaign_id" class="mt-1 w-full"
                        placeholder="e.g. IS200401"></x-input>
                    <x-input-error for="campaign_id" class="mt-2" />
                </div>
                <!-- Banner Name -->
                <div class="block mb-3">
                    <x-label>Banner Name:</x-label>
                    <x-select wire:model.live="selectedBanner" wire:ignore class="mt-1 w-full">
                        <option value="">Select Banner</option>
                        @foreach($banners as $banner)
                        <option value="{{ $banner->name }}">{{ $banner->name }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="selectedBanner" class="mt-2" />
                </div>
                <!-- Size-->
                <div class="block mb-3">
                    <x-label>Size:</x-label>
                    <x-select type="text" wire:model="selectedSize" class="mt-1 w-full"
                        placeholder="e.g., Summer Sale">
                        <option value="">Select Size</option>
                        @foreach($sizes as $size)
                        <option value="{{ $size }}">{{ $size }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="selectedSize" class="mt-2" />
                </div>
                <!-- Calendar Week -->
                <div class="block mb-3">
                    <x-label>Calendar Week:</x-label>
                    <x-input type="text" wire:model="calendarWeek" class="mt-1 w-full"
                        placeholder="e.g. 24CW45"></x-input>
                    <x-input-error for="calendarWeek" class="mt-2" />
                </div>
            </div>

            <!-- Generate Button -->
            <x-button wire:click="generateName" class="self-center mt-6">
                Generate Name
            </x-button>
        </div>
    </form>

    <!-- Display Generated Output -->
    @if($output)
    <div class="">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-neutral-900 dark:bg-opacity-50">
            <table class="w-full text-sm text-left rtl:text-right text-neutral-500 dark:text-neutral-400">
                <thead class="text-xs text-neutral-700 uppercase bg-neutral-50 dark:bg-neutral-800 dark:text-neutral-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Sales Org
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Country Name
                        </th>
                        <th scope="col" class="px-6 py-3 w-1">
                            Language Code
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Result
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Copy Link
                        </th>
                    </tr>
                </thead>

                <tbody class="">
                    @forelse($countries as $country)
                    <tr class="odd:bg-white odd:dark:bg-neutral-900 even:bg-neutral-50 even:dark:bg-neutral-900 border-b dark:border-neutral-800">
                        <td class="px-6 py-4">
                            {{ $country->code }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $country->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $country->language_code }}
                        </td>
                        <td class="px-6 py-4">
                            <p id="generatedOutput{{$country->id}}">{{ $country->code }}_{{$this->selectedVendorNames}}_{{ $country->language_code }}{{ $output }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <x-copy-button id="copyButton{{$country->id}}"
                                class="py-1 px-4 bg-blue-500 text-white rounded-xl"
                                onclick="copyToClipboard({{$country->id}})">Copy
                            </x-copy-button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4"
                            class="px-6 py-4 dark:text-white text-sm leading-5 text-neutral-900 whitespace-no-wrap">
                            No countries found.
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
    @endif

</div>

<script>
    function copyToClipboard(id) {
        console.log(id); // Logs the actual id
        const outputText = document.getElementById(`generatedOutput${id}`).innerText;
        navigator.clipboard.writeText(outputText).then(() => {
            const copyButton = document.getElementById(`copyButton${id}`);
            copyButton.innerHTML = "Copied!";
            setTimeout(() => {
                copyButton.innerHTML = "Copy";
            }, 2000); // 1 second
        }).catch(err => {
            console.error("Failed to copy text: ", err);
        });
    }
</script>