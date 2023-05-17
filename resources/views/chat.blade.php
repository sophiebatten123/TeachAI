@extends('layouts.app')
@section('content')
<form action="/chat" method="POST">
    @csrf
    <div class="mb-4 bg-blue-600">
        <label class="form-label" for="year">Year:</label>
        <select name="year[]" multiple class="form-select">
            <option value="Year 7">Year 7</option>
            <option value="Year 8">Year 8</option>
            <option value="Year 9">Year 9</option>
            <option value="Year 10">Year 10</option>
            <option value="Year 11">Year 11</option>
        </select>
    </div>
    <div class="mb-4">
        <label class="form-label" for="subject">Subject:</label>
        <select name="subject[]" multiple class="form-select">
            <option value="Math">Math</option>
            <option value="Science">Science</option>
            <!-- Add more options for different subjects -->
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Send</button>
</form>
@endsection


