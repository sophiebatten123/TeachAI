<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use App\Models\Lesson;

class DocumentController extends Controller
{
    public function download($lessonId)
{
    // Retrieve the lesson from the database
    $lesson = Lesson::findOrFail($lessonId);

    // Create a new PhpWord object
    $phpWord = new PhpWord();

    // Add a section
    $section = $phpWord->addSection();

    $boldFontStyle = ['bold' => true];
    $normalFontStyle = ['bold' => false];

    // Add the sections to the section
    $section->addText('Title:', $boldFontStyle);
    $section->addText($lesson->title, $normalFontStyle);
    $section->addText('Objective:', $boldFontStyle);
    $section->addText($lesson->objective, $normalFontStyle);
    $section->addText('Recap Activity:', $boldFontStyle);
    $section->addText($lesson->recap_activity, $normalFontStyle);
    $section->addText('Teaching:', $boldFontStyle);
    $section->addText($lesson->teaching, $normalFontStyle);
    $section->addText('Practice:', $boldFontStyle);
    $section->addText($lesson->practice, $normalFontStyle);
    $section->addText('Exit Ticket:', $boldFontStyle);
    $section->addText($lesson->exit_ticket, $normalFontStyle);
    $section->addText('Worksheet:', $boldFontStyle);
    $section->addText($lesson->worksheet, $normalFontStyle);


    // Set the output file path
    $filePath = public_path('documents/document.docx');

    // Save the Word document
    $phpWord->save($filePath);

    // Download the Word document
    return response()->download($filePath, 'document.docx');
}
}

