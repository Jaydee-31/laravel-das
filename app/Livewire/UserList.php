<?php

namespace App\Livewire;

use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public User $user;
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
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

                Section::make()
                    ->schema([
//                        TextInput::make('id_number')
//                            ->label('ID Number')
//                            ->autofocus()
//                            ->required()
//                            ->maxLength(25),
                        TextInput::make('name')
                            ->dehydrateStateUsing(fn ($state) => ucwords($state))
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),
                        TextInput::make('email')
                            ->unique(ignoreRecord: true)
                            ->email()
                            ->disableAutocomplete()
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),
                        TextInput::make('password')
                            ->password()
                            ->maxLength(255)
                            ->dehydrateStateUsing(static fn (null|string $state): null|string =>
                            filled($state) ? Hash::make($state) : null,
                            )
                            ->dehydrated(static fn (null|string $state): bool =>
                            filled($state),
                            )
                            ->columnSpan(2),
                        TextInput::make('passwordConfirmation')
                            ->same('password')
                            ->password()
                            ->dehydrated(false)
                            ->columnSpan(2),
                    ])
                    ->columns(2)
                    ->columnSpan([ 'xl' => 3]),
            ])->columns([ 'xl' => 5])
            ->statePath('data');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(User::query())
            ->columns([
                TextColumn::make('name'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ]);
    }
    public function create(): void
    {
//        dd($this->form->getState());
        User::create($this->form->getState());
    }
    public function render(): View
    {
        return view('livewire.user-list');
    }
}
