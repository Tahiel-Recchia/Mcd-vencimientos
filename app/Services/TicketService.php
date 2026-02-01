<?php
namespace App\Services;

use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class TicketService
{
    protected $printerName;

    public function __construct($printerName = "ticketera")
    {
        $this->printerName = $printerName;
    }
    public function printTicket(array $data)
    {
        try {
            $connector = new WindowsPrintConnector($this->printerName);
            $printer = new Printer($connector);


            // A. NOMBRE
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setTextSize(2, 2);
            $printer->text(mb_strtoupper($data['productName']) . "\n");

            // B. UBICACIÓN
            $printer->setTextSize(1, 1);
            $printer->setEmphasis(true); // Negrita
            $locationText = $data['productLocation'];
            $locationWrapped = wordwrap($locationText, 30, "\n", false);
            foreach (explode("\n", $locationWrapped) as $line) {
                $printer->text("(" . trim($line) . ")\n");
            }

            $printer->setEmphasis(false);

            $printer->text("--------------------------------\n");

            // C. TIEMPOS
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->setTextSize(1, 1);

            // Retirado
            $printer->text("Retirado:   " . $data['elaborationTime']->format('d/m/Y H:i') . "\n");

            // Descongela
            if ($data['raw_defrosting_minutes'] > 0) {
                $printer->text("Descongela: " . $data['defrostingTime']->format('d/m/Y H:i') . "\n");
            }

            // D. VENCIMIENTO

            $printer->setEmphasis(true);
            $printer->text("Vencimiento:" . $data['expirationTime']->format('d/m/Y H:i') . "\n");
            $printer->setEmphasis(false);

            // F. Cierre
            $printer->feed(3);
            $printer->cut();
            $printer->close();

            return true;
        } catch (\Exception $e) {
            return "Error de impresión: " . $e->getMessage();
        }
    }
}
