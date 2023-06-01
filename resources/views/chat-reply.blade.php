@extends('layouts.app')
@section('content')

<div class="m-4 p-4">
    @php
        $lessonNumber = 1;
    @endphp
    @foreach ($lessons as $lesson)
        <div class="my-4">
            <h2>Lesson {{ $lessonNumber }}: {{ $lesson->title }}</h2>
        </div>
        <div class="flex">
        <form action="{{ route('create-powerpoint') }}" method="POST" id="form-create-powerpoint">
            @csrf
            <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">
            <input type="hidden" name="lesson_content" value="{{ $lesson->lesson_content }}">
            <button type="submit" class="border bg-blue-200 p-2">Create PowerPoint Slides</button>
        </form>
            <div class="ml-2">
                <a href="{{ route('document.download', ['lessonId' => $lesson->id]) }}" class="border bg-blue-200 p-2">Download as Lesson Plan</a>
            </div>
        </div>
    @php
        $lessonNumber++;
    @endphp
    @endforeach
</div>

<script>
  document.getElementById('form-create-powerpoint').addEventListener('submit', function(event) {
    event.preventDefault();
    this.submit();
  });
</script>
@endsection
