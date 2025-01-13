@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Doctor Dashboard</h1>

    <!-- Full Calendar with new ID -->
    <div id="doctor-calendar"></div>  <!-- Changed the ID to 'doctor-calendar' -->

    <!-- Modal for creating/updating the schedule -->
    <div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scheduleModalLabel">Buat/Update Jadwal Dokter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.jadwal.storeOrUpdate') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_dokter" value="{{ $dokter->id }}">
    <input type="hidden" name="schedule_id" value="{{ $schedule->id ?? '' }}">
                        <input type="hidden" id="schedule-id" name="schedule_id"> <!-- For update -->
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="text" class="form-control" id="modal-tanggal" name="tanggal" required readonly>
                        </div>

                        <div class="form-group mt-3">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="Praktik">Praktik</option>
                                <option value="Tidak Praktik">Tidak Praktik</option>
                            </select>
                        </div>

                        <div class="form-group mt-3">
                            <label for="maksimal_konsultasi">Maksimal Konsultasi</label>
                            <input type="number" class="form-control" id="maksimal_konsultasi" name="maksimal_konsultasi" min="1" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary mt-4">Simpan Jadwal</button>
                        <button type="button" class="btn btn-secondary mt-4" data-bs-dismiss="modal">Kembali</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include FullCalendar and dependencies -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.2.0/dist/fullcalendar.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.2.0/dist/fullcalendar.min.js"></script>

<<script>
    $(document).ready(function () {
        const schedules = @json($schedules);
        const existingDates = schedules.map(schedule => schedule.tanggal);

        // Get today's date in YYYY-MM-DD format
        const today = moment().format('YYYY-MM-DD');

        // Initialize FullCalendar only once
        $('#doctor-calendar').fullCalendar({
            header: {
                left: 'prev,next',
                center: 'title',
                right: ''
            },
            events: schedules.map(schedule => ({
                title: schedule.status,
                start: schedule.tanggal,
                backgroundColor: schedule.status === 'Praktik' ? '#28a745' : '#dc3545',
                textColor: 'white'
            })),
            dayClick: function (date, jsEvent, view) {
                const clickedDate = date.format();
                
                // Block the modal from appearing if the clicked date is in the past
                if (clickedDate < today) {
                    alert('Tidak dapat memilih tanggal yang sudah lewat!');
                    return; // Prevent the modal from opening
                }

                const existingSchedule = schedules.find(schedule => schedule.tanggal === clickedDate);

                if (existingSchedule) {
                    // Populate the modal for updating an existing schedule
                    $('#schedule-id').val(existingSchedule.id);
                    $('#modal-tanggal').val(existingSchedule.tanggal);
                    $('#status').val(existingSchedule.status);
                    $('#maksimal_konsultasi').val(existingSchedule.maksimal_konsultasi);
                    $('#scheduleModalLabel').text('Update Jadwal Dokter');
                } else {
                    // Populate the modal for creating a new schedule
                    $('#schedule-id').val('');
                    $('#modal-tanggal').val(clickedDate);
                    $('#status').val('Praktik');
                    $('#maksimal_konsultasi').val('');
                    $('#scheduleModalLabel').text('Buat Jadwal Dokter');
                }

                // Trigger the change event to update the state of 'maksimal_konsultasi'
                $('#status').trigger('change');

                $('#scheduleModal').modal('show');
            },
            validRange: {
                start: today // Disable past dates (can't select dates before today)
            }
        });

        // Disable 'maksimal_konsultasi' when 'status' is 'Tidak Praktik'
        $('#status').change(function() {
            if ($(this).val() === 'Tidak Praktik') {
                $('#maksimal_konsultasi').val('').prop('disabled', true).css('background-color', '#e9ecef'); // Make sure it appears visible but disabled
            } else {
                $('#maksimal_konsultasi').prop('disabled', false).css('background-color', 'white'); // Restore normal appearance
            }
        });

        // Trigger the change event on page load to set the correct state of 'maksimal_konsultasi'
        $('#status').trigger('change');
    });
</script>





<style>
    /* Additional custom styles can be added here */
</style>
@endsection

