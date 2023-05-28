<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Settings;

class DocumentController extends Controller
{
    public function download(Request $request)
    {
        // AI response
        $aiResponse = $request->query('aiResponse');

        // Create a new PhpWord object
        $phpWord = new PhpWord();

        // Add a section
        $section = $phpWord->addSection();

        // Set text alignment to center
        $section->addText($aiResponse, ['alignment' => 'center']);

        // Set the output file path
        $filePath = public_path('documents/document.docx');

        // Save the Word document
        $phpWord->save($filePath);

        // Download the Word document
        return response()->download($filePath, 'document.docx');
    }
}

