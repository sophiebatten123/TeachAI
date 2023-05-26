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
        $questionSelections = implode(', ', $request->input('questions'));
        $questionTypes = $request->input('questionType');
        $questionTypeCount = count($questionTypes);

        if (!empty($questionTypes)) {
            $questionTypesString = implode(', ', $questionTypes);
        } else {
            $questionTypesString = "";
        }
    
        if ($questionTypeCount > 1) {
            $messages = [];
            foreach ($questionTypes as $index => $questionType) {
                $message = "Can you write me $questionSelections $questionType aimed at $yearSelections pupils on $subjectSelections";
                $messages[] = $message;
            }
            $message = implode(' and ', $messages);
        } else {
            $message = "Can you write me $questionSelections $questionTypes[0] aimed at $yearSelections pupils on $subjectSelections";
        }
    
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

        $pattern = '/\d+\.\s(.+)/';
        preg_match_all($pattern, $reply, $matches);
        $questions = $matches[1] ?? [];

        $reply = $response->json('choices.0.message.content');
    
        return view('chat-reply', [
            'questions' => $questions,
            'yearSelections' => $yearSelections,
            'subjectSelections' => $subjectSelections,
            'questionSelections' => $questionSelections,
            'message' => $message,
            'aiResponse' => $reply
        ]);
    }
}

