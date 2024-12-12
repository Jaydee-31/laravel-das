<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Doctor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ViewDoctorAppointment extends Component implements HasForms, HasInfolists, HasTable
{
    use InteractsWithInfolists;
    use InteractsWithForms;
    use InteractsWithTable;

    public Doctor $doctor;

    public function doctorAppointmentInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->doctor)
            ->schema([
                \Filament\Infolists\Components\Section::make()
                    ->schema([
                        \Filament\Infolists\Components\Grid::make([
                            'sm' => 2,
                            'md' => 2,
                            'lg' => 4,
                        ])
                            ->schema([
                                ImageEntry::make('user.profile_photo_path')
                                    ->hiddenLabel()
                                    ->defaultImageUrl(function (?Model $record) {
                                        return 'https://ui-avatars.com/api/?background=random&name=' . urlencode($record->user->name ?? 'User');
                                    }),
                                \Filament\Infolists\Components\Group::make([
                                    \Filament\Infolists\Components\TextEntry::make('user.name')
                                        ->label('Name'),
                                    \Filament\Infolists\Components\TextEntry::make('user.email')
                                        ->label('Email'),
                                    \Filament\Infolists\Components\TextEntry::make('contact_number'),
                                ]),
                                \Filament\Infolists\Components\Group::make([
                                    \Filament\Infolists\Components\TextEntry::make('license_number'),
                                    \Filament\Infolists\Components\TextEntry::make('specialty')
                                        ->label('Specialization'),
                                ]),
                                \Filament\Infolists\Components\Group::make([
                                    ViewEntry::make('schedules')
                                        ->view('infolists.components.schedules'),
//                                    RepeatableEntry::make('schedules')
//                                        ->schema([
//                                            TextEntry::make('day'),
//                                            TextEntry::make('week'),
//                                            TextEntry::make('start_time'),
//                                            TextEntry::make('start_time'),
//                                            TextEntry::make('end_time'),
//                                        ])->contained(false)
                                ]),

                            ]),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Appointment::query()->where('doctor_id', '=', $this->doctor->id))
            ->defaultSort('created_at', 'desc')
            ->recordUrl(null)
            ->recordAction(ViewAction::class)
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
                        ->form(AppointmentList::appointmentForm()),
                    DeleteAction::make(),
                    ViewAction::make()
                        ->modalHeading('Appointment Details')
                        ->form(AppointmentList::appointmentForm())
//                        ->infolist($this->appointmentView())
                        ->slideOver()
                        ->modalContent(function (Appointment $record) {
                            return view('livewire.appointments.view-appointment', ['appointment' => $record]);
                        }),
                ]),
            ])
            ->bulkActions([
                // ...
            ])
            ->headerActions([
                //
            ]);
    }

    public function render()
    {
        return view('livewire.view-doctor-appointment');
    }
}
