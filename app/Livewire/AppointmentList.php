<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Schedule;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AppointmentList extends Component implements HasForms, HasTable, HasActions, HasInfolists
{

    use InteractsWithInfolists;
    use InteractsWithTable;
    use InteractsWithForms;
    use InteractsWithActions;

    protected string $view = 'livewire.appointments.view-appointment';
    public Appointment $appointment;
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function createAction(): Action
    {
        return \Filament\Actions\CreateAction::make()
            ->label('Create Appointment')
            ->model(Appointment::class)
            ->form($this->appointmentForm())
            ->mutateFormDataUsing(function (array $data): array {
                $data['end_time'] = Carbon::parse($data['start_time'])->addHour();
                $data['added_by_id'] = auth()->id();

                return $data;
            })
            ->createAnother(false);
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
            ->recordAction(EditAction::class)
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('email')
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('status')
                    ->badge(true)
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'secondary',
                        'confirmed' => 'primary',
                        'cancelled' => 'danger',
                        'completed' => 'success',
                    }),
                TextColumn::make('phone')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('gender')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('date')
                    ->dateTime('F d, Y')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('start_time')
                    ->dateTime('g:i A')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('doctor.user.name')
                    ->label('Doctor')
                    ->searchable()
                    ->toggleable()
            ])
            ->filters([
            ])
            ->actions([
                ActionGroup::make([
                    \Filament\Tables\Actions\Action::make('sendEmail')
                        ->label('Send Email')
                        ->url(function (Appointment $record) {
                            $to = $record->email;
                            $cc = Auth::user()->email;
                            $bcc = $record->doctor->user->email;
                            $subject = 'RESULTS: ';
                            $body = '';

                            return "mailto:$to?cc=$cc&bcc=$bcc&subject=$subject&body=$body";
                        })
                        ->color('success')
                        ->icon('heroicon-m-envelope'),
                    EditAction::make()
                        ->mutateRecordDataUsing(function ($record) {
                            $data = $record->toArray();
                            return $data;
                        })
                        ->color('primary')
                        ->form($this->appointmentForm()),
                    DeleteAction::make(),
//                    ViewAction::make()
//                        ->modalHeading('Appointment Details')
//                        ->form($this->appointmentForm())
//                        ->infolist($this->appointmentView())
//                        ->slideOver()
//                        ->modalContent(function (Appointment $record) {
//                            return view('livewire.appointment-modal', ['appointment' => $record]);
//                        }),
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
        return view('livewire.appointments.appointment-list');
    }

    public function appointmentView(): array
    {
        return [
            TextEntry::make('name')
        ];
    }

    public static function appointmentForm(): array
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
                        Select::make('doctor_id')
                            ->relationship(
                                name: 'doctor',
                                titleAttribute: 'id',
                                modifyQueryUsing: fn(Builder $query) => $query
                                    ->select('doctors.id', 'doctors.*')
                                    ->join('users', 'doctors.user_id', '=', 'users.id') // Join with the users table
                                    ->orderBy('users.name')
                            )
                            ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->user->name}")
                            ->preload()
                            ->reactive()
                            ->searchable(),
                        Select::make('schedule_id')
                            ->label('Available Schedules')
                            ->options(function (callable $get) {
                                $doctorId = $get('doctor_id');
                                if (!$doctorId) return [];

                                $schedules = Schedule::where('doctor_id', $doctorId)->get();
                                return $schedules->mapWithKeys(function ($schedule) {
                                    return [
                                        $schedule->id => "{$schedule->day} ("
                                            . date('h:i A', strtotime($schedule->start_time))
                                            . " - "
                                            . date('h:i A', strtotime($schedule->end_time))
                                            . ")"
                                    ];
                                });
                            })
                            ->reactive()
                            ->required(),
                        DatePicker::make('date')
                            ->label('Appointment Date')
                            ->required()
                            ->minDate(Carbon::today())
                            ->seconds(false)
                            ->timezone('Asia/Manila')
                            ->locale('ph')
                            ->reactive()
                            ->afterStateUpdated(function ($state, $set, callable $get) {
                                $scheduleId = $get('schedule_id');
                                if (!$scheduleId) return;

                                // Fetch the selected schedule
                                $schedule = Schedule::find($scheduleId);
                                if (!$schedule) return;

                                // Check if the selected date matches the schedule's day
                                $dayOfWeek = Carbon::parse($state)->format('l');

                                if ($dayOfWeek !== $schedule->day) {
                                    Notification::make()
                                        ->title('Invalid Date')
                                        ->body('Selected date does not match the schedule day.')
                                        ->warning()
                                        ->send();
                                }
                            }),

                        Select::make('start_time')
                            ->reactive()
                            ->label('Available Slots')
                            ->options(function (callable $get) {
                                $scheduleId = $get('schedule_id');
                                $appointmentDate = $get('date');

                                if (!$scheduleId || !$appointmentDate) {
                                    return [];
                                }

                                // Fetch the selected schedule
                                $schedule = Schedule::find($scheduleId);
                                if (!$schedule) {
//                                    dd('Schedule not found');
                                    return [];
                                }

                                // Break the time range into hourly slots
                                $startTime = Carbon::parse($schedule->start_time);
                                $endTime = Carbon::parse($schedule->end_time);

                                $slots = [];
                                while ($startTime->lt($endTime)) {
                                    $slotEnd = $startTime->copy()->addHour();
                                    if ($slotEnd->gt($endTime)) {
                                        $slotEnd = $endTime;
                                    }

                                    $slots[$startTime->toTimeString()] = $startTime->format('g:i A') . ' - ' . $slotEnd->format('g:i A');
                                    $startTime->addHour();
                                }
//                                dd($slots);
                                return $slots;
                            })
                            ->required(),
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'confirmed' => 'Confirmed',
                                'cancelled' => 'Cancelled',
                                'completed' => 'Completed',
                            ])
                            ->default('pending')
                            ->hidden(!Auth::check())
                            ->native(false)
                    ]),
                Textarea::make('address')
                    ->required()
                    ->maxLength(25)
                    ->columnSpan(2),
            ])->columns(['xl' => 2]),
        ];
    }


//    public static function view(Appointment $record)
//    {
////        $this->dispatch('open-modal', id: 'view-appointment');
//        return ViewAppointment::class;
//    }

}
