<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $certificatePath = base_path('certificates/cacert.pem');
    
        $yearSelections = implode(', ', $request->input('year'));
        $subjectSelections = implode(', ', $request->input('subject'));
    
        $message = "Get me 5 year questions for $subjectSelections in $yearSelections.";
    
        $response = Http::withOptions([
            'verify' => $certificatePath,
        ])->withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a Laravel user.'],
                ['role' => 'user', 'content' => $message],
            ],
        ]);
    
        $reply = $response->json('choices.0.message.content');
    
        return view('chat-reply', ['reply' => $reply]);
    }
}

