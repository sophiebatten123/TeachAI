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
             questions for worksheets and an exit ticket. Provide the lesson plan with the following objective, recap activity, teaching, practice, exit ticket, worksheet.";
    
        $response = Http::withOptions([
                'verify' => $certificatePath,
            ])->withHeaders([
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type' => 'application/json',
            ])->timeout(100) // Set the timeout value to 60 seconds
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
    
        $savedLessons = [];
        foreach ($lessons as $lesson) {
            // Clean up the lesson content (remove HTML tags, trim whitespace, etc.)
            $lessonContent = strip_tags($lesson);
            $lessonContent = trim($lessonContent);  

            $title = $this->extractSection($lessonContent, '/^\d+:\s*(.+)/');
            $objective = $this->extractSection($lessonContent, '/Objective:(.*?)Recap Activity:/s');
            $recapActivity = $this->extractSection($lessonContent, '/Recap Activity:(.*?)Teaching:/s');
            $teaching = $this->extractSection($lessonContent, '/Teaching:(.*?)Practice:/s');
            $practice = $this->extractSection($lessonContent, '/Practice:(.*?)Exit Ticket:/s');
            $exitTicket = $this->extractSection($lessonContent, '/Exit Ticket:(.*?)Worksheet:/s');
            $worksheet = $this->extractSection($lessonContent, '/Worksheet:(.*)/s');            
            
            Log::info('Title: ' . $title);
            Log::info('Objective: ' . $objective);
            Log::info('Recap Activity: ' . $recapActivity);
            Log::info('Teaching: ' . $teaching);
            Log::info('Practice: ' . $practice);
            Log::info('Exit Ticket: ' . $exitTicket);
            Log::info('Worksheet: ' . $worksheet);
    
            // Save the lesson to the database
            $savedLesson = Lesson::create([
                'user_id' => Auth::user()->id,
                'lesson_content' => $lessonContent,
                'title' => $title,
                'objective' => $objective,
                'recap_activity' => $recapActivity,
                'teaching' => $teaching,
                'practice' => $practice,
                'exit_ticket' => $exitTicket,
                'worksheet' => $worksheet,
            ]);
    
            // Add the saved lesson to the array
            $savedLessons[] = $savedLesson;
        }
    
        // Redirect to the viewLessons method with the saved lessons
        return $this->viewLessons($savedLessons);
    }
    public function extractSection($lessonContent, $pattern)
    {
        preg_match($pattern, $lessonContent, $matches);
        return isset($matches[1]) ? trim($matches[1]) : null;
    }       
    public function viewLessons()
    {
        $lessons = Lesson::all();

        return view('chat-reply', [
            'lessons' => $lessons,
        ]);
    }
}

