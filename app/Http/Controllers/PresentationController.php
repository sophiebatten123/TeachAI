<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Style\Alignment;
use PhpOffice\PhpPresentation\Style\Color;

class PresentationController extends Controller
{
    public function download(Request $request)
    {
        // AI response
        $aiResponse = $request->query('aiResponse');

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
        $textRun = $shape->createTextRun($aiResponse);
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
}
