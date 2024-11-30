<?php

namespace App\Livewire;

use App\Models\Doctor;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Get;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
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
            ->label('Add new doctor')
            ->model(Doctor::class)
            ->form(
                $this->doctorForm()
            )
            ->mutateFormDataUsing(function (array $data): array {
//
//                dd($data);
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
                    ->circular()->defaultImageUrl(function (?Model $record) {
                        return 'https://ui-avatars.com/api/?background=random&name=' . urlencode($record->user->name ?? 'User');
                    }),
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
                ActionGroup::make([
                    EditAction::make('schedule')
                        ->label('Schedules')
                        ->icon('heroicon-s-clock')
                        ->color('success')
                        ->slideOver()
                        ->modalHeading(fn($record) => $record->user->name . ' Schedules')
                        ->mutateRecordDataUsing(function ($record) {
                            return $record->schedules->toArray();
                        })
                        ->form(
                            $this->scheduleForm()
                        ),
                    EditAction::make()
                        ->color('primary')
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
                            unset($data['name'], $data['username'], $data['email'], $data['password'], $data['profile_photo_path']); // Remove non-doctor fields

                            return $data;
                        })
                        ->form($this->doctorForm()),
                    DeleteAction::make(),
                ]),
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

    public function doctorForm(): array
    {
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
                    ])->columnSpan(['xl' => 2]),

                Group::make()
                    ->schema([
                        TextInput::make('name')
                            ->dehydrateStateUsing(fn($state) => ucwords($state))
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),
                        TextInput::make('username')
                            ->rule(fn($component) => Rule::unique('users', 'username')
                                ->ignore($component->getRecord()->user_id ?? null, 'id'))
                            ->required()
                            ->maxLength(25)
                            ->autocomplete(false)
                            ->columnSpan(1),
                        TextInput::make('email')
                            ->rule(fn($component) => Rule::unique('users', 'email')
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
                            ->dehydrateStateUsing(static fn(null|string $state): null|string => filled($state) ? Hash::make($state) : null,
                            )
                            ->dehydrated(static fn(null|string $state): bool => filled($state),
                            )
                            ->columnSpan(1),
                        TextInput::make('passwordConfirmation')
                            ->same('password')
                            ->password()
                            ->dehydrated(false)
                            ->columnSpan(1),
                    ])
                    ->columns(2)
                    ->columnSpan(['xl' => 3])
            ])->columns(['xl' => 5]),
        ];
    }

    public function scheduleForm(): array
    {
        return [
            Repeater::make('schedules')
                ->relationship()
                ->hiddenLabel()
                ->addActionLabel('Add schedule')
                ->schema([
                    Select::make('day')
                        ->options([
                            'Monday' => 'Monday',
                            'Tuesday' => 'Tuesday',
                            'Wednesday' => 'Wednesday',
                            'Thursday' => 'Thursday',
                            'Friday' => 'Friday',
                            'Saturday' => 'Saturday',
                            'Sunday' => 'Sunday',
                        ])
                        ->reactive()
                        ->disableOptionWhen(function ($value, $state, Get $get) {
                            return collect($get('../*.day'))
                                ->reject(fn($selected) => $selected === $state)
                                ->filter()
                                ->contains($value);
                        })
                        ->required()
                        ->label('Day'),

                    // Set start time
                    TimePicker::make('start_time')
                        ->required()
                        ->seconds(false)
                        ->label('Start Time'),

                    // Set end time
                    TimePicker::make('end_time')
                        ->required()
                        ->seconds(false)
                        ->label('End Time'),

                    Select::make('week')
                        ->multiple()
                        ->options([
                            '1' => '1st Week',
                            '2' => '2nd Week',
                            '3' => '3rd Week',
                            '4' => '4th Week',
                            '5' => '5th Week',
                        ])
                        ->label('Applicable Weeks')
                        ->placeholder('Select weeks')
                        ->helperText('Choose which weeks of the month this schedule applies to')
                        ->required()
                        ->columnSpan(2),

                    // Toggle for "By Appointment"
                    Toggle::make('by_appointment')
                        ->label('By Appointment')
                        ->default(false),
                ])
                ->cloneable()
                ->columns(3),
        ];
    }
}
