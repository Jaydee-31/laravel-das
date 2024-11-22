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
use Filament\Tables\Columns\ImageColumn;
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
//
                $user = User::create([
                    'name' => $data['name'],
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'password' => $data['password'],
                    'profile_photo_path' => $data['profile_photo_path'],
                ]);
                // Add the user ID to the doctor record
                $data['user_id'] = $user->id;

                // Remove fields not in the doctors table
                unset($data['name'], $data['username'], $data['email'], $data['password'], $data['profile_photo_path']);

                return $data;
            });
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Doctor::query())
            ->defaultSort('created_at', 'desc')
            ->columns([
                ImageColumn::make('user.profile_photo_path')
                    ->label('Avatar')
                    ->circular(),
                TextColumn::make('user.name')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('user.email')
                    ->searchable()
                    ->iconColor('primary')
                    ->icon('heroicon-m-envelope'),
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
//                        dd($record);
                        return array_merge(
                            $record->user ? $record->user->only(['name', 'username', 'email', 'password', 'profile_photo_path']) : [],
                            $record->only(['id', 'user_id', 'license_number', 'specialty'])
                        );
                    })
                    ->mutateFormDataUsing(function (array $data, $record) {
                        // Update the related user fields
                        $record->user->update([
                            'name' => $data['name'],
                            'username' => $data['username'],
                            'email' => $data['email'],
                            'password' => $data['password'],
                            'profile_photo_path' => $data['profile_photo_path'],
                        ]);

                        // Update the doctor-specific fields
                        $data['user_id'] = $record->user_id; // Ensure user_id is retained
                        unset($data['name'], $data['username'],  $data['email'], $data['password'], $data['profile_photo_path']); // Remove non-doctor fields

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
                        TextInput::make('username')
                            ->rule(fn ($component) => Rule::unique('users', 'username')
                                ->ignore($component->getRecord()->user_id ?? null, 'id'))
                            ->required()
                            ->maxLength(25)
                            ->autocomplete(false)
                            ->columnSpan(1),
                        TextInput::make('email')
                            ->rule(fn ($component) => Rule::unique('users', 'email')
                                ->ignore($component->getRecord()->user_id ?? null, 'id'))
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
