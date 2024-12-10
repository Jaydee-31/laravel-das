<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Doctor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
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
                TextEntry::make('user.name'),
                TextEntry::make('license_number')
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Appointment::query()->where('doctor_id', '=', $this->doctor->id))
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
                SelectFilter::make('doctor')
                    ->relationship('doctor.user', 'name')
                    ->searchable()
                    ->preload()
                    ->native(false)
            ])
//            ->actions([
//                ActionGroup::make([
//                    \Filament\Tables\Actions\Action::make('sendEmail')
//                        ->label('Send Email')
//                        ->url(function (Appointment $record) {
//                            $to = $record->email;
//                            $cc = Auth::user()->email;
//                            $bcc = $record->doctor->user->email;
//                            $subject = 'RESULTS: ';
//                            $body = '';
//
//                            return "mailto:$to?cc=$cc&bcc=$bcc&subject=$subject&body=$body";
//                        })
//                        ->color('success')
//                        ->icon('heroicon-m-envelope'),
//                    EditAction::make()
//                        ->mutateRecordDataUsing(function ($record) {
//                            $data = $record->toArray();
//                            return $data;
//                        })
//                        ->color('primary')
//                        ->form($this->appointmentForm()),
//                    DeleteAction::make(),
//                    ViewAction::make()
//                        ->modalHeading('Appointment Details')
//                        ->form($this->appointmentForm())
//                        ->infolist($this->appointmentView())
//                        ->slideOver()
//                        ->modalContent(function (Appointment $record) {
//                            return view('livewire.appointments.view-appointment', ['appointment' => $record]);
//                        }),
//                ]),
//            ])
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
