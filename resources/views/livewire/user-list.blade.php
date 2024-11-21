<div>
{{--    <form wire:submit="create">--}}
{{--        {{ $this->form }}--}}

{{--        <button type="submit">--}}
{{--            Submit--}}
{{--        </button>--}}
{{--    </form>--}}

    <div class="mb-3">
        {{ $this->createAction }}
    </div>

    <x-filament-actions::modals />

    {{ $this->table }}
</div>
