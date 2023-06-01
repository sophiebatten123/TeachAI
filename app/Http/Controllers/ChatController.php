<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Lesson;
use App\Models\Powerpoint;
use App\Models\Worksheet;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Style\Alignment;
use PhpOffice\PhpPresentation\Style\Color;
use PhpOffice\PhpWord\PhpWord;


class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
    
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
            'exit_ticket' => 'Exit Ticket:'
        ];
    
        // Construct the message content with subheadings
        $message = "Create $numberOfLessons lesson plans on $subjectSelections for $yearSelections students. The lesson plan must have the following sections:\n\n . Please make the lesson plan detailed and comprehensive.";
        foreach ($subheadings as $section => $subheading) {
            $message .= "\n$subheading";
        }
        
        $lessonPlanResponse = $this->openAIRequest($message);
        $lessonPlanReply = $lessonPlanResponse->json('choices.0.message.content');
    
        // Separate the response into individual lessons
        $lessons = explode('Lesson Plan', $lessonPlanReply);
        unset($lessons[0]); // Remove the first empty element
    
        $savedLessons = [];
        foreach ($lessons as $lesson) {

            $lessonContent = strip_tags($lesson);
            $lessonContent = trim($lessonContent);
    
            $lessonSections = [];
            foreach ($subheadings as $section => $subheading) {
                $regex = "/$subheading(.*?)(" . implode('|', array_values($subheadings)) . ")/is";
                preg_match($regex, $lessonContent, $matches);
                $lessonSections[$section] = isset($matches[1]) ? trim($matches[1]) : '';

                if ($section === 'exit_ticket') {
                    $exitTicketRegex = "/$subheading(.*?)(Practice:|Exit Ticket:|$)/is";
                    preg_match($exitTicketRegex, $lessonContent, $exitTicketMatches);
                    $lessonSections[$section] = isset($exitTicketMatches[1]) ? trim($exitTicketMatches[1]) : '';
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
            ]);
    
            // Add the saved lesson to the array
            $savedLessons[] = $savedLesson;
        }
    
        // Redirect to the viewLessons method with the saved lessons
        return $this->viewLessons($savedLessons);
    }
    public function createPowerPoint(Request $request)
    {
        $lessonId = $request->input('lesson_id');
        $lessonContent = $request->input('lesson_content');
        
        // Produce PowerPoint slides
        $powerpoint_message = "Based on this lesson plan: $lessonContent can you tell me what I should include on each of my PowerPoint slides.";
        $powerpointResponse = $this->openAIRequest($powerpoint_message);
        $powerpointReply = $powerpointResponse->json('choices.0.message.content');

        // Saves the powerpoint to the database
        Powerpoint::create([
            'lesson_id' => $lessonId,
            'powerpoint_content' => $powerpointReply,
        ]);

        // Create a new PhpPresentation object
        $presentation = new PhpPresentation();

        // Create a slide and add content
        $slide = $presentation->createSlide();
        $shape = $slide->createRichTextShape();
        $shape->setHeight(500);
        $shape->setWidth(700);
        
        // Apply formatting to the shape
        $shape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $shape->getActiveParagraph()->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        // $shape->getActiveParagraph()->getAlignment()->setWrapText(true);
        // $shape->getActiveParagraph()->getAlignment()->setLineHeight(1.5);
        $shape->getFill()->setFillType(\PhpOffice\PhpPresentation\Style\Fill::FILL_SOLID)->setStartColor(new Color('FFEEEEEE'));
        
        // Apply formatting to the text
        $textRun = $shape->createTextRun($powerpointReply);
        $textRun->getFont()->setBold(true);
        $textRun->getFont()->setSize(24);
        $textRun->getFont()->setColor(new Color('FF000000'));

        // Set the output file path
        $filePath = public_path('presentations/presentation.pptx');

        // Save the presentation
        $writer = IOFactory::createWriter($presentation, 'PowerPoint2007');
        $writer->save($filePath);

        // Download the presentation
        return response()->download($filePath, 'presentation.pptx');
    }
    public function createWorksheet(Request $request)
    {
        $lessonId = $request->input('lesson_id');
        $lessonContent = $request->input('lesson_content');
        
        // Produce PowerPoint slides
        $worksheet_message = "Based on this lesson plan: $lessonContent please create questions to include on a worksheet. These questions should test what has been taught in the lesson and be differentiated.";
        $worksheetResponse = $this->openAIRequest($worksheet_message);
        $worksheetReply = $worksheetResponse->json('choices.0.message.content');

        // Saves the powerpoint to the database
        Worksheet::create([
            'lesson_id' => $lessonId,
            'worksheet_content' => $worksheetReply,
        ]);

        // Create a new PhpWord object
        $phpWord = new PhpWord();

        // Add a section
        $section = $phpWord->addSection();

        $boldFontStyle = ['bold' => true];
        $normalFontStyle = ['bold' => false];

        // Add the sections to the section
        $section->addText('Questions:', $boldFontStyle);
        $section->addText($worksheetReply, $normalFontStyle);

        // Set the output file path
        $filePath = public_path('documents/document.docx');

        // Save the Word document
        $phpWord->save($filePath);

        // Download the Word document
        return response()->download($filePath, 'document.docx');
    }
    public function openAIRequest($message)
    {
        $certificatePath = base_path('certificates/cacert.pem');

        $response = Http::withOptions([
            'verify' => $certificatePath,
        ])->withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            'Content-Type' => 'application/json',
        ])->timeout(120) // Set the timeout value to 350 seconds
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a Laravel user.'],
                    ['role' => 'user', 'content' => $message],
                ],
            ]);

        return $response;
    }   
    public function viewLessons()
    {
        $lessons = Lesson::all();

        return view('chat-reply', [
            'lessons' => $lessons,
        ]);
    }
}

