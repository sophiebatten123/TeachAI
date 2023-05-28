@extends('layouts.app')
@section('content')
<div class="m-4 p-4">
    <p> Your question was: {{ $message}} <p>
    <h2 class="font-bold underline mb-2"> {{ $yearSelections }} {{ $subjectSelections }} Worksheet</h2>
    <div class="bg-red-200 h-auto mb-4">
        <ol>
            @foreach ($questions as $question)
                <li>{{ $question }}</li>
            @endforeach
        </ol>
    </div>
    <div class="flex">
        <div>
            <a href="{{ route('presentation.download', ['aiResponse' => $aiResponse]) }}" class="border bg-blue-200 p-2">Download as PowerPoint</a>
        </div>
        <div>
            <a href="{{ route('document.download', ['aiResponse' => $aiResponse]) }}" class="border bg-blue-200 p-2">Download as Worksheet</a>
        </div>
    </div>
</div>
@endsection
