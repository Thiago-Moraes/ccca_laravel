<?php

namespace Tests\Unit;

use App\Http\Cpf;
use Exception;
use PHPUnit\Framework\TestCase;

class CpfTest extends TestCase
{
   public function testCpfIsValid()
   {
      $cpf = new Cpf("23382522098");
      $this->assertTrue($cpf->validate());
   }

   public function testCpfIsValidWithSpecialChars()
   {
      $cpf = new Cpf("233.825.220-98");
      $this->assertTrue($cpf->validate());
   }

   public function testCpfIsInvalid()
   {
      $this->expectException(Exception::class);
      $this->expectExceptionMessage('Invalid CPF');
      $cpf = new Cpf("23382522090");
   }

   public function testCpfIsInvalidWithAllDigitsEquals()
   {
      $this->expectException(Exception::class);
      $this->expectExceptionMessage('Invalid CPF');
      $cpf = new Cpf("11111111111");
   }

   public function testCpfIsInvalidWithOutDigits()
   {
      $this->expectException(Exception::class);
      $this->expectExceptionMessage('Invalid CPF');
      $cpf = new Cpf("");
   }
}