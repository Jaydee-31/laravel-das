<div>
{{--    <form wire:submit="create">--}}
{{--        {{ $this->form }}--}}

{{--        <button type="submit">--}}
{{--            Submit--}}
{{--        </button>--}}
{{--    </form>--}}

    {{ $this->createAction }}

    <x-filament-actions::modals />

    {{ $this->table }}
</div>
