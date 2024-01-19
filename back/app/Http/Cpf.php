<?php

namespace App\Http;

use Exception;

class Cpf
{
    private const POSITION_FIRST_DIGIT = 11;
    private const POSITION_SECOND_DIGIT = 12;
    private const MIN_LENGTH = 11;
    private string $cpf = '';
  
    public function __construct(string $cpf) {
      $this->cpf = $this->removeUnecessaryChars($cpf);
      if (!$this->isValid() || !$this->validate()) {
        throw new Exception("Invalid CPF");
      }
    }
  
    private function isValid():bool
    {
      return 
        $this->cpf &&
        strlen($this->cpf) == self::MIN_LENGTH &&
        count(array_unique(str_split($this->cpf, 1))) > 1;
    }
  
    private function removeUnecessaryChars(string $cpf) {
      $a = preg_replace('/[^\d+]/', '', $cpf);
      return $a;
    }
  
    private function getFactor(int $digit):int
    {

      $valueByPosition = 0;
      $factor = 0;
      for ($position = 1; $position < strlen($this->cpf)-1; $position++) {
        $valueByPosition = (int) substr($this->cpf, $position-1, 1);
        $factor += ($digit - $position) * $valueByPosition;
      }
  
      return $factor;
    }
  
    private function getDigit(int $factor) {
      $rest = 0;
      $rest = $factor % 11;
      return $rest < 2 ? 0 : 11 - $rest;
    }
  
    public function validate() {
      $firstFactor = 0;
      $firstDigit = 0;
      $secondfactor = 0;
      $secondDigit = 0;
  
      $firstFactor = $this->getFactor(self::POSITION_FIRST_DIGIT);
      $firstDigit = $this->getDigit($firstFactor);
  
      $secondfactor = $this->getFactor(self::POSITION_SECOND_DIGIT);
      $secondfactor += 2 * $firstDigit;
      $secondDigit = $this->getDigit($secondfactor);

      return (
        substr($this->cpf, strlen($this->cpf) - 2, strlen($this->cpf)) ==
        "{$firstDigit}{$secondDigit}"
      );
    }
}
