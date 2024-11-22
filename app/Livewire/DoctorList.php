<?php

namespace App\Livewire;

use App\Models\Doctor;
use App\Models\User;
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
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

class DoctorList extends Component implements HasForms, HasTable, HasActions
{
    use InteractsWithTable;
    use InteractsWithForms;
    use InteractsWithActions;

    public Doctor $doctor;
    public ?array $data = [];

    public function mount(Doctor $doctor): void
    {
        $this->form->fill($doctor->toArray());
    }

    public function createAction(): Action
    {
        return \Filament\Actions\CreateAction::make()
            ->model(Doctor::class)
            ->form($this->doctorForm())
            ->mutateFormDataUsing(function (array $data): array {
                $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => $data['password'],
                ]);
                // Add the user ID to the doctor record
                $data['user_id'] = $user->id;

                // Remove fields not in the doctors table
                unset($data['name'], $data['email'], $data['password']);

                return $data;
            });
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Doctor::query())
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('user.name')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('user.email')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('license_number')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('specialty')
                    ->searchable()
                    ->toggleable(),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                EditAction::make()
                    ->mutateRecordDataUsing(function ($record) {
                        return array_merge(
                            $record->user ? $record->user->only(['name', 'email', 'password']) : [],
                            $record->only(['id', 'license_number', 'specialty'])
                        );
                    })
                    ->mutateFormDataUsing(function (array $data, $record) {
                        // Update the related user fields
                        $record->user->update([
                            'name' => $data['name'],
                            'email' => $data['email'],
                            'password' => $data['password'],
                        ]);

                        // Update the doctor-specific fields
                        $data['user_id'] = $record->user_id; // Ensure user_id is retained
                        unset($data['name'], $data['email'], $data['password']); // Remove non-doctor fields

                        return $data;
                    })
                    ->form($this->doctorForm()),
                DeleteAction::make()
            ])
            ->bulkActions([
                // ...
            ])
            ->headerActions([
                //
            ]);
    }

    public function render(): View
    {
        return view('livewire.doctors.doctor-list');
    }

    public function save(): void
    {
        dd('asdad');
    }

    public function doctorForm(): array {
        return [
            Group::make([
                Group::make()
                    ->schema([
                        FileUpload::make('profile_photo_path')
                            ->directory('profile-photos')
                            ->label('Profile photo')
                            ->image()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->maxSize(2048)
                            ->panelAspectRatio('1:1')
                    ])->columnSpan([ 'xl' => 2]),

                Group::make()
                    ->schema([
                        TextInput::make('name')
                            ->dehydrateStateUsing(fn ($state) => ucwords($state))
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),
                        TextInput::make('email')
                            ->rule(function ($component) {
                                return Rule::unique('users', 'email')
                                    ->ignore($component->getRecord()->user_id, 'id'); // Ignore the current user's ID
                            })
                            ->email()
                            ->autocomplete(false)
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),
                        TextInput::make('license_number')
                            ->label('License Number')
                            ->required(),
                        TextInput::make('specialty')
                            ->label('Specialty')
                            ->required()
                            ->columnSpan(2),
                        TextInput::make('password')
                            ->password()
                            ->maxLength(255)
                            ->dehydrateStateUsing(static fn (null|string $state): null|string =>
                            filled($state) ? Hash::make($state) : null,
                            )
                            ->dehydrated(static fn (null|string $state): bool =>
                            filled($state),
                            )
                            ->columnSpan(1),
                        TextInput::make('passwordConfirmation')
                            ->same('password')
                            ->password()
                            ->dehydrated(false)
                            ->columnSpan(1),
                    ])
                    ->columns(2)
                    ->columnSpan([ 'xl' => 3])
            ])->columns([ 'xl' => 5]),
        ];
    }

}
