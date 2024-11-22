<?php

namespace App\Livewire;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserList extends Component implements HasForms, HasTable, HasActions
{
    use InteractsWithTable;
    use InteractsWithForms;
    use InteractsWithActions;

    public User $user;
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function createAction(): Action
    {
        return \Filament\Actions\CreateAction::make()
            ->model(User::class)
            ->form($this->userForm())
            ->createAnother(false);
    }
//    public function form(Form $form): Form
//    {
//        return $form
//            ->schema($this->userForm())
//            ->statePath('data');
//    }

    public function table(Table $table): Table
    {
        return $table
            ->query(User::query())
            ->defaultSort('created_at', 'desc')
            ->columns([
                ImageColumn::make('profile_photo_path')
                    ->label('Avatar')
                    ->circular()
                    ->defaultImageUrl(function (?Model $record) {
                        return 'https://ui-avatars.com/api/?background=random&name=' . urlencode($record->name ?? 'User');
                    }),
                TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('username')
                    ->searchable()
                    ->toggleable()
                    ->width('20%'),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(false)
                    ->iconColor('primary')
                    ->icon('heroicon-m-envelope'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                \Filament\Tables\Actions\EditAction::make()
//                    ->record($this->user)
                    ->form($this->userForm()),
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
//        dd($this->form->getState());
        User::create($this->form->getState());
    }
    public function render(): View
    {
        return view('livewire.users.user-list');
    }

    public function userForm(): array {
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
                        TextInput::make('username')
                            ->unique(ignoreRecord: true)
                            ->required()
                            ->maxLength(25)
                            ->autocomplete(false)
                            ->columnSpan(1),
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
                    ->columnSpan([ 'xl' => 3])
            ])->columns([ 'xl' => 5]),
        ];
    }

}
