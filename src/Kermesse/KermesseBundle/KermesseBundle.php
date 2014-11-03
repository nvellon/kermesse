<?php

namespace Kermesse\KermesseBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class KermesseBundle extends Bundle
{
    /**
     * Boots the Bundle.
     */
    public function boot()
    {
        require_once(dirname(__FILE__).'/../../html2pdf/html2pdf.class.php');
    }
}
