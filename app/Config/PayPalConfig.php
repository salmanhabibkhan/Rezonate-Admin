<?php

namespace Config;

class PayPalConfig
{
    public $clientId     = 'ATGagypcNA6LfaeattL1GSDlEF3iwf_wx_UTOaaRhi9pmGDZlPe7pX66D2WyDjCwN4gd4eP42Cs5cnUV';
    public $clientSecret = 'EK8dv89Y_RK_qRsph1ehiKK3vsW-2v8LBTksVX8WEj7RiDsIWB2ZFoWt89Q3tvRbGBlc-xIV2RH8ecMa';
    public $sandbox      = true;  // Set to false for live payments

    public function getPayPalConfig()
    {
        return [
            'mode'    => $this->sandbox ? 'sandbox' : 'live',
            'clientId' => $this->clientId,
            'clientSecret' => $this->clientSecret,
        ];
    }
}