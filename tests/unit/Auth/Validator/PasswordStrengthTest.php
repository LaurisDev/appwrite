<?php
// La clase PasswordStrength valida que una contraseña cumpla una política de seguridad.
declare(strict_types=1);

namespace Tests\Unit\Auth\Validator;

use Appwrite\Auth\Validator\PasswordStrength;
use PHPUnit\Framework\TestCase;

final class PasswordStrengthTest extends TestCase
{
    // Verifica la política por defecto. -> La contraseña tiene 7 caracteres.
    public function testDefaultPolicyRejectsPasswordShorterThanEightCharacters(): void
    {
        // Arrange
        $validator = new PasswordStrength();

        // Act
        $result = $validator->isValid('1234567');

        // Assert
        $this->assertFalse($result); -> // se espera falso porque tiene 7, no alcanza la minima
    }

    // password tiene 8 caracteres. -> Comprueba que la longitud mínima por defecto es aceptada.
    public function testDefaultPolicyAcceptsPasswordWithEightCharacters(): void
    {
        // Arrange
        $validator = new PasswordStrength();

        // Act
        $result = $validator->isValid('password');

        // Assert
        $this->assertTrue($result);
    }

    // Mirar que se cumplan las demas politicas pero rechaza al no cumplir con el minimo
    public function testConfiguredPolicyRejectsPasswordShorterThanMinimumLength(): void
    {
        // Arrange
        $validator = new PasswordStrength([
            'min' => 12,
            'uppercase' => true,
            'lowercase' => true,
            'number' => true,
            'symbols' => true,
        ]);

        // Act
        $result = $validator->isValid('Password1!');

        // Assert
        $this->assertFalse($result);
    }

    // verificar si cumple con una letra en mayuscula. 
    public function testConfiguredPolicyRequiresUppercaseLetter(): void
    {
        // Arrange
        $validator = new PasswordStrength([
            'min' => 12,
            'uppercase' => true,
            'lowercase' => true,
            'number' => true,
            'symbols' => true,
        ]);

        // Act
        $result = $validator->isValid('password123!');

        // Assert
        $this->assertFalse($result);
    }

    // veriricar si cumple con letras en minuscula
    public function testConfiguredPolicyRequiresLowercaseLetter(): void
    {
        // Arrange
        $validator = new PasswordStrength([
            'min' => 12,
            'uppercase' => true,
            'lowercase' => true,
            'number' => true,
            'symbols' => true,
        ]);

        // Act
        $result = $validator->isValid('PASSWORD123!');

        // Assert
        $this->assertFalse($result);
    }

    // verificar si cumple con numeros
    public function testConfiguredPolicyRequiresNumber(): void
    {
        // Arrange
        $validator = new PasswordStrength([
            'min' => 12,
            'uppercase' => true,
            'lowercase' => true,
            'number' => true,
            'symbols' => true,
        ]);

        // Act
        $result = $validator->isValid('PasswordOnly!');

        // Assert
        $this->assertFalse($result);
    }

    // si tiene simbolo
    public function testConfiguredPolicyRequiresSymbol(): void
    {
        // Arrange
        $validator = new PasswordStrength([
            'min' => 12,
            'uppercase' => true,
            'lowercase' => true,
            'number' => true,
            'symbols' => true,
        ]);

        // Act
        $result = $validator->isValid('Password1234');

        // Assert
        $this->assertFalse($result);
    }

    public function testConfiguredPolicyAcceptsValidPassword(): void
    {
        // Arrange
        $validator = new PasswordStrength([
            'min' => 12,
            'uppercase' => true,
            'lowercase' => true,
            'number' => true,
            'symbols' => true,
        ]);

        // Act
        $result = $validator->isValid('Password123!');

        // Assert
        $this->assertTrue($result);
    }

    public function testConfiguredPolicyAcceptsUnicodeSymbols(): void
    {
        // Arrange
        $validator = new PasswordStrength([
            'min' => 12,
            'uppercase' => true,
            'lowercase' => true,
            'number' => true,
            'symbols' => true,
        ]);

        // Act
        $result = $validator->isValid('Password123€');

        // Assert
        $this->assertTrue($result);
    }

    public function testMinimumLengthCanBeConfiguredToEightCharacters(): void
    {
        // Arrange
        $validator = new PasswordStrength([
            'min' => 8,
        ]);

        // Act
        $invalidResult = $validator->isValid('1234567');
        $validResult = $validator->isValid('12345678');

        // Assert
        $this->assertFalse($invalidResult);
        $this->assertTrue($validResult);
    }

    public function testAllowEmptyAcceptsEmptyPassword(): void
    {
        // Arrange
        $validator = new PasswordStrength([
            'min' => 12,
            'uppercase' => true,
            'lowercase' => true,
            'number' => true,
            'symbols' => true,
        ], true);

        // Act
        $result = $validator->isValid('');

        // Assert
        $this->assertTrue($result);
    }
}