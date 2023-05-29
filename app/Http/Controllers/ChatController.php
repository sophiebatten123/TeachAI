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
    
        // Define subheadings for each section of the lesson plan
        $subheadings = [
            'title' => 'Title:',
            'objective' => 'Objective:',
            'recap' => 'Recap Activity:',
            'teaching' => 'Teaching:',
            'practice' => 'Practice:',
            'exit_ticket' => 'Exit Ticket:',
            'worksheet' => 'Worksheet:',
        ];
    
        // Construct the message content with subheadings
        $message = "Create $numberOfLessons lesson plans on $subjectSelections for $yearSelections students. The lesson plan must have the following sections:\n\n . You need to supply 3 recap questions, 10 worksheet questions and a detailed plan for teaching";
        foreach ($subheadings as $section => $subheading) {
            $message .= "\n$subheading";
        }
    
        $response = Http::withOptions([
            'verify' => $certificatePath,
        ])->withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            'Content-Type' => 'application/json',
        ])->timeout(100) // Set the timeout value to 100 seconds
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
    
            $lessonSections = [];
            foreach ($subheadings as $section => $subheading) {
                $regex = "/$subheading(.*?)(" . implode('|', array_values($subheadings)) . ")/is";
                preg_match($regex, $lessonContent, $matches);
                $lessonSections[$section] = isset($matches[1]) ? trim($matches[1]) : '';

                if ($section === 'worksheet') {
                    $worksheetRegex = "/$subheading(.*?)(Exit Ticket:|Worksheet:|$)/is";
                    preg_match($worksheetRegex, $lessonContent, $worksheetMatches);
                    $lessonSections[$section] = isset($worksheetMatches[1]) ? trim($worksheetMatches[1]) : '';
                }
            }
    
            // Save the lesson to the database
            $savedLesson = Lesson::create([
                'user_id' => Auth::user()->id,
                'lesson_content' => $lessonContent,
                'title' => $lessonSections['title'],
                'objective' => $lessonSections['objective'],
                'recap_activity' => $lessonSections['recap'],
                'teaching' => $lessonSections['teaching'],
                'practice' => $lessonSections['practice'],
                'exit_ticket' => $lessonSections['exit_ticket'],
                'worksheet' => $lessonSections['worksheet'],
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

