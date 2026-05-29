{{-- Reusable schedule form fields --}}
<div class="form-group">
  <label class="form-label">Subject</label>
  <input type="text" name="subject" class="form-input" value="{{ old('subject', $schedule->subject ?? '') }}" placeholder="e.g. Data Structures" required />
</div>

<div class="form-group">
  <label class="form-label">Professor</label>
  <input type="text" name="professor" class="form-input" value="{{ old('professor', $schedule->professor ?? '') }}" placeholder="e.g. Dr. Dela Cruz" required />
</div>

<div class="form-row">
  <div class="form-group">
    <label class="form-label">Section</label>
    <input type="text" name="section" class="form-input" value="{{ old('section', $schedule->section ?? '') }}" placeholder="BSCS-3A" required />
  </div>
  <div class="form-group">
    <label class="form-label">Year</label>
    <select name="year_level" class="form-select" required>
      @foreach(['1st Year','2nd Year','3rd Year','4th Year'] as $yl)
        <option value="{{ $yl }}" {{ old('year_level', $schedule->year_level ?? '') === $yl ? 'selected' : '' }}>{{ $yl }}</option>
      @endforeach
    </select>
  </div>
</div>

<div class="form-row">
  <div class="form-group">
    <label class="form-label">Day</label>
    <select name="day" class="form-select" required>
      @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $d)
        <option value="{{ $d }}" {{ old('day', $schedule->day ?? '') === $d ? 'selected' : '' }}>{{ $d }}</option>
      @endforeach
    </select>
  </div>
  <div class="form-group">
    <label class="form-label">Room</label>
    <input type="text" name="room" class="form-input" value="{{ old('room', $schedule->room ?? '') }}" placeholder="e.g. Room 301" required />
  </div>
</div>

<div class="form-row">
  <div class="form-group">
    <label class="form-label">Start</label>
    <input type="time" name="time_start" class="form-input" value="{{ old('time_start', $schedule->time_start ?? '') }}" required />
  </div>
  <div class="form-group">
    <label class="form-label">End</label>
    <input type="time" name="time_end" class="form-input" value="{{ old('time_end', $schedule->time_end ?? '') }}" required />
  </div>
</div>

<div class="form-group">
  <label class="form-label">Room</label>
  <input type="text" name="room" class="form-input {{ $errors->has('room') ? 'error' : '' }}"
    value="{{ old('room', $schedule->room ?? '') }}"
    placeholder="e.g. Star Building" required />
  @error('room')<p class="error-msg">{{ $message }}</p>@enderror
</div>
