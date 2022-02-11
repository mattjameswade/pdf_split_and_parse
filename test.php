<?php
use setasign\Fpdi\Fpdi;
use Smalot\PdfParser\Parser;

require_once('./vendor/autoload.php');

$i = 1;

while ($i = $i) {
    $pdf = new Fpdi();
    $pdf->AddPage();
    $pdf->setSourceFile("./example_input/test.pdf");
    $page = $pdf->importPage($i);
    $pdf->useTemplate($page);
    $pdf->Output("./example_output/output.pdf", "F");
    $parser = new Parser();
    $file = './example_output/output.pdf';
    $textContent = ($parser->parseFile($file))->getText();
    preg_match('/(PDF FILES [A-Za-z\s]+)\n/', $textContent, $matches);
    //var_dump($textContent);
    if ($matches) {
        echo "Outputting file for: " . $matches[1] . "\n";
        $output_name = "./example_output/output" . trim($matches[1]) . ".pdf";
        rename("./example_output/output.pdf", str_replace(' ', '_', $output_name));
    } else {
        echo "no more matches\n";
        unlink('./example_output/output.pdf');
        break;
    }
    $i++;
}
