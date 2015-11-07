<?php

namespace Kermesse\KermesseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
/**
 * Sales controller.
 *
 */
class LettersController extends Controller
{
    /**
     * Lists all Sales entities.
     *
     */
    public function indexAction(Request $request)
    {
        $ini = (int)$request->get('ini');
        $fin = (int)$request->get('fin');

        $tktTpl = $this->getTicketTpl();

        $allTkts = '';

        for ($i = $ini; $i <= $fin; $i++) {
            $prodTkts = str_repeat($tktTpl, 1);
            $prodTkts = str_replace('{{number}}', $i, $prodTkts);

            $allTkts .= $prodTkts;
        }
        $file = $this->convertToPdf($allTkts);
        $this->sendToPrinter($file);
        exit;
    }

    private function getTicketTpl()
    {
        return '<page format="80x35" orientation="L">
<table  style="width: 100%; height: 100%;">
    <tr>
        <td style="width: 100%; text-align: center; padding: 10px 0 10px 0; font-weight: bold; font-size: 60px;">{{number}}</td>
    </tr>
</table></page>';
    }

    private function convertToPdf($content)
    {
        try
        {
            $fileName = '/tmp/'.uniqid ('ticket_', true).'.pdf';
            $html2pdf = new \HTML2PDF('P', array(80, 35), 'es', true, 'UTF-8', array(0, 5, 0, 0));
            $html2pdf->setDefaultFont('Helvetica');
            $html2pdf->writeHTML($content);
            $html2pdf->Output($fileName, 'F');
            //$html2pdf->Output('exemple00.pdf');

            return $fileName;
        }
        catch(\HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    private function sendToPrinter($file)
    {
        exec('lp -d EPSON-TM-T20 -o media=Custom.72x35mm -o fit-to-page -o source=PageFeedCut '.$file);
    }
}
