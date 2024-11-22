<?php

namespace App\Livewire;

use App\Models\Appointment;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AppointmentList extends Component implements HasForms, HasTable, HasActions
{
    use InteractsWithTable;
    use InteractsWithForms;
    use InteractsWithActions;

    public Appointment $appointment;
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function createAction(): Action
    {
        return \Filament\Actions\CreateAction::make()
            ->model(Appointment::class)
            ->form($this->appointmentForm())
            ->mutateFormDataUsing(function (array $data): array {
                $data['added_by_id'] = auth()->id();
                return $data;
            });
    }
//    public function form(Form $form): Form
//    {
//        return $form
//            ->schema($this->appointmentForm())
//            ->statePath('data');
//    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Appointment::query())
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('email')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('phone')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('gender')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('schedule_date')
                    ->dateTime('F d, Y')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('schedule_time')
                    ->dateTime('g:i A')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('doctor.user.name')
                    ->label('Doctor')
                    ->searchable()
                    ->toggleable()
            ])
            ->filters([
                // ...
            ])
            ->actions([
                \Filament\Tables\Actions\EditAction::make()
    //                    ->record($this->appointment)
                    ->form($this->appointmentForm()),
                DeleteAction::make()
            ])
            ->bulkActions([
                // ...
            ])
            ->headerActions([
                //
            ]);
    }
    public function create(): void
    {
        dd($this->form->getState());
        Appointment::create($this->form->getState());
    }
    public function render(): View
    {
        return view('livewire.appointments.appointment-list');
    }

    public function appointmentForm(): array
    {
        return [
            Group::make([
                Group::make()
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('email')
                            ->email()
                            ->required(),
                        TextInput::make('phone')
                            ->required(),
                        Select::make('gender')
                            ->options([
                                'male' => 'Male',
                                'female' => 'Female',
                            ])
                            ->native(false)
                            ->required(),
                        DatePicker::make('birthdate')
                    ]),

                Group::make()
                    ->schema([
                        Textarea::make('address')
                            ->required()
                            ->maxLength(25),
                        DatePicker::make('schedule_date')
                            ->required(),
                        TimePicker::make('schedule_time'),
                        Select::make('doctor_id')
                            ->relationship('doctor', 'id')
                            ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->user->name}")
                            ->preload()
                            ->searchable(),
                    ])
            ])->columns([ 'xl' => 2]),
        ];
    }

}
