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
            <div>
                <a href="{{ route('presentation.download', ['aiResponse' => $lesson->lesson_content]) }}" class="border bg-blue-200 p-2">Download as PowerPoint</a>
            </div>
            <div class="ml-2">
                <a href="{{ route('document.download', ['lessonId' => $lesson->id]) }}" class="border bg-blue-200 p-2">Download as Worksheet</a>
            </div>
        </div>
    @php
        $lessonNumber++;
    @endphp
    @endforeach
</div>
@endsection
