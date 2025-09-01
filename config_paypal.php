<?php
define('ProPayPal', 1);
if(ProPayPal){
    define("PayPalClientId", "ASwjkyKliKo10t3CwQs22TDOdXDQla_F4sJdYdtZLcMSUlxAI0Fv7wWqFPFkxK6xSFpwsT-gHaEkVoiK");
    define("PayPalSecret", "EDIF4YIm_f7s1hWATH-cPy4J8NxcoQiO7T2q3gUvgb8xb8Uasseqt2exUcGOaRJ-mx7yWakR5HEZGhFL");
    define("PayPalBaseUrl", "https://api.paypal.com/v1/");
    define("PayPalENV", "production");
} else {
    define("PayPalClientId", "Ac9qGlcFtvTFDYSI-lkeRZMV3-TBFg5-UlaZCmea64vuhWQ7w1plhsQzDezT73kBfIISItisq1b42VHj");
    define("PayPalSecret", "ENs6kiaUO4R4gwIw6ptN_YB9h5ejXim5l9GiMqrKsqda_0_NN5185tyQSPgDQf-33RLMnHfUkHCy8L0o");
    define("PayPalBaseUrl", "https://api.sandbox.paypal.com/v1/");
    define("PayPalENV", "sandbox");
}
?>