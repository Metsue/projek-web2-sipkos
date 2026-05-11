<?php
/**
 * BasicPdf - Simple PDF generator without external libraries
 *
 * Kelas ini hanya dibuat untuk kebutuhan export PDF ringan pada aplikasi SIPKOS.
 * Mendukung output teks satu halaman dengan font Helvetica.
 *
 * @author SIPKOS Team
 * @version 1.0
 */

class BasicPdf
{
    private $title;
    private $lines = [];

    public function __construct($title = 'Document')
    {
        $this->title = $title;
    }

    public function addLine(string $line)
    {
        $this->lines[] = $line;
    }

    public function output(string $filename = 'document.pdf')
    {
        $stream = $this->buildContentStream();
        $pdf = $this->buildPdfDocument($stream);

        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
        header('Content-Length: ' . strlen($pdf));

        echo $pdf;
        exit;
    }

    private function buildContentStream(): string
    {
        $content = "BT\n";
        $content .= "/F1 14 Tf\n";
        $content .= "50 800 Td\n";
        $content .= '(' . $this->escapeText($this->title) . ') Tj\n';
        $content .= "/F1 10 Tf\n";
        $content .= "0 -18 Td\n";

        foreach ($this->lines as $index => $line) {
            $content .= '(' . $this->escapeText($line) . ') Tj\n';
            if ($index !== array_key_last($this->lines)) {
                $content .= "0 -14 Td\n";
            }
        }

        $content .= "ET\n";
        return $content;
    }

    private function buildPdfDocument(string $stream): string
    {
        $objects = [];

        $objects[] = "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n";
        $objects[] = "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n";
        $objects[] = "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 5 0 R >> >> /Contents 4 0 R >>\nendobj\n";
        $objects[] = "4 0 obj\n<< /Length " . strlen($stream) . " >>\nstream\n" . $stream . "endstream\nendobj\n";
        $objects[] = "5 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n";

        $pdf = "%PDF-1.3\n";
        $offsets = [0 => '0000000000 65535 f '];
        $pos = strlen($pdf);

        foreach ($objects as $object) {
            $offsets[] = sprintf('%010d 00000 n ', $pos);
            $pdf .= $object;
            $pos += strlen($object);
        }

        $xrefOffset = $pos;
        $pdf .= "xref\n0 " . count($offsets) . "\n";
        foreach ($offsets as $line) {
            $pdf .= $line . "\n";
        }
        $pdf .= "trailer\n<< /Size " . count($offsets) . " /Root 1 0 R >>\n";
        $pdf .= "startxref\n" . $xrefOffset . "\n%%EOF";

        return $pdf;
    }

    private function escapeText(string $text): string
    {
        return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $text);
    }
}
