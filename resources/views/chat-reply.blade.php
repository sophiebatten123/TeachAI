@extends('layouts.app')
@section('content')
<div class="m-4 p-4">
    @foreach ($lessons as $lesson)
        <div>
            <div class="h-auto">
                <h2>Lesson Resource</h2>
            </div>
            <div class="flex">
                <div>
                    <a href="{{ route('presentation.download', ['aiResponse' => $lesson->lesson_content]) }}" class="border bg-blue-200 p-2">Download as PowerPoint</a>
                </div>
                <div>
                    <a href="{{ route('document.download', ['aiResponse' => $lesson->lesson_content]) }}" class="border bg-blue-200 p-2">Download as Worksheet</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
