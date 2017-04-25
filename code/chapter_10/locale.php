<?php
class Locale {
  public $timezone;
  public $language;
  public $currency;
  
  public function __construct(
    $timezone, $language, $currency) {
    $this->timezone = $timezone;
    $this->language = $language;
    $this->currency = $currency;
  }
}

$locale = new Locale('EST', 'EN-US', 'USD');
$_SESSION['locale'] = $locale;

$locale = $_SESSION['locale'];
$language = $locale->language;
echo $_SESSION['locale']->language;
?>