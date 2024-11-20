<?php

namespace App\Livewire;

use App\Models\Vendor;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;

class VendorList extends Component
{
    use WithPagination;

    public $search = '';
    public $name, $description, $vendor_id;
    public $updateVendor = false;
    public $openingModal = false;
    protected $listeners = [
        'deleteVendor' => 'destroy'
    ];
    // Validation Rules
    protected $rules = [
        'name' => 'required',
        'description' => 'required'
    ];

    public function openModal()
    {
        $this->openingModal = true;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.vendors.vendor-list', [
            'vendors' => Vendor::search($this->search)->orderby('id', 'desc')
                ->paginate(10),
        ]);
    }
    public function resetFields()
    {
        $this->name = '';
        $this->description = '';
    }
    public function store()
    {
        // Validate Form Request
        $this->validate();
        try {
            // Create Vendor
            Vendor::create([
                'name' => $this->name,
                'description' => $this->description
            ]);

            // Set Flash Message
            session()->flash('success', 'Vendor Created Successfully!!');
            // Reset Form Fields After Creating Vendor
            $this->resetFields();

            $this->openingModal = false;
        } catch (\Exception $e) {
            // Set Flash Message
            session()->flash('error', 'Something goes wrong while creating vendor!!');
            // Reset Form Fields After Creating Vendor
            $this->resetFields();
        }
    }
    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);
        $this->name = $vendor->name;
        $this->description = $vendor->description;
        $this->vendor_id = $vendor->id;
        $this->updateVendor = true;
        $this->openingModal = true;
    }
    public function cancel()
    {
        $this->updateVendor = false;
        $this->resetFields();
    }
    public function update()
    {
        // Validate request
        $this->validate();
        try {
            // Update vendor
            Vendor::find($this->vendor_id)->fill([
                'name' => $this->name,
                'description' => $this->description
            ])->save();
            session()->flash('success', 'Vendor Updated Successfully!');

            $this->cancel();
        } catch (\Exception $e) {
            session()->flash('error', 'Something goes wrong while updating vendor!');
            $this->cancel();
        }
        $this->openingModal = false;
    }
    public function destroy($id)
    {
        try {
            Vendor::find($id)->delete();
            session()->flash('success', "Vendor Deleted Successfully!!");
        } catch (\Exception $e) {
            session()->flash('error', "Something goes wrong while deleting vendor!!");
        }
    }
}
