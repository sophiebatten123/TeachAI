<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $certificatePath = base_path('certificates/cacert.pem');
    
        $yearSelections = implode(', ', $request->input('year'));
        $subjectSelections = implode(', ', $request->input('subject'));
        $numberOfLessons = implode(', ', $request->input('lessons'));

        $message = "Create $numberOfLessons lesson plans on $subjectSelections for $yearSelections students all of which follow on
            from the previous days learning and contain recap activities. You must also provide at least 10
             questions for worksheets, an exit ticket and any additional printable resources text. I will need
              these so that I can print these before hand.";
    
        $response = Http::withOptions([
                'verify' => $certificatePath,
            ])->withHeaders([
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type' => 'application/json',
            ])->timeout(60) // Set the timeout value to 60 seconds
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a Laravel user.'],
                    ['role' => 'user', 'content' => $message],
                ],
            ]);

        $reply = $response->json('choices.0.message.content');

        // Separate the response into individual lessons
        $lessons = explode('Lesson Plan', $reply);
        unset($lessons[0]); // Remove the first empty element
    
        // Save the individual lessons to the database
        foreach ($lessons as $lesson) {
            // Clean up the lesson content (remove HTML tags, trim whitespace, etc.)
            $lessonContent = strip_tags($lesson);
            $lessonContent = trim($lessonContent);
    
            // Save the lesson to the database
            Lesson::create([
                'user_id' => Auth::user()->id,
                'lesson_content' => $lessonContent,
            ]);
        }
    
        return view('chat-reply', [
            'yearSelections' => $yearSelections,
            'subjectSelections' => $subjectSelections,
            'message' => $message,
            'aiResponse' => $reply
        ]);
    }
}

