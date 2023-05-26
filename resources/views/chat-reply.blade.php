@extends('layouts.app')
@section('content')
<div class="m-4 p-4">
    <p> Your question was: {{ $message}} <p>
    <h2 class="font-bold underline mb-2"> {{ $yearSelections }} {{ $subjectSelections }} Worksheet</h2>
    <ol>
        @foreach ($questions as $question)
            <li>{{ $question }}</li>
        @endforeach
    </ol>
    <div>
        <a href="{{ route('presentation.download', ['aiResponse' => $aiResponse]) }}" class="border bg-blue-200 p-2">Download as PowerPoint</a>
    </div>
</div>
@endsection
