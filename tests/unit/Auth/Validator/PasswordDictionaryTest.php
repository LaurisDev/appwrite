<?php
// valida contraseñas correctamente según las reglas establecidas.

declare(strict_types=1);

namespace Tests\Unit\Auth\Validator;

use Appwrite\Auth\Validator\PasswordDictionary;
use PHPUnit\Framework\TestCase;

final class PasswordDictionaryTest extends TestCase
{
    protected ?PasswordDictionary $object = null;

    protected function setUp(): void
    {
        $this->object = new PasswordDictionary(
            ['password' => true, '123456' => true], // que no sea password ni 123456
            true
        );
    }

    // Comprueba que una contraseña demasiado corta sea rechazada
    public function testRejectsPasswordShorterThanMinimumLength(): void
    {
        // Arrange
        $password = '1';

        // Act
        $result = $this->object->isValid($password);

        // Assert
        $this->assertFalse($result);
    }

    // Verifica que una contraseña incluida en el diccionario sea rechazada.
    public function testRejectsPasswordFoundInDictionary(): void
    {
        // Arrange
        $password = 'password';

        // Act
        $result = $this->object->isValid($password);

        // Assert
        $this->assertFalse($result);
    }

    // Verifica que una contraseña incluida en el diccionario sea rechazada.
    public function testRejectsNumericPasswordFoundInDictionary(): void
    {
        // Arrange
        $password = '123456';

        // Act
        $result = $this->object->isValid($password);

        // Assert
        $this->assertFalse($result);
    }

    // comprueba una contraseña sea aceptada
    public function testAcceptsValidPassword(): void
    {
        // Arrange
        $password = 'myPasswordIsRight';

        // Act
        $result = $this->object->isValid($password);

        // Assert
        $this->assertTrue($result);
    }

    // Verifica que el límite máximo permitido sea inclusivo -> contraseña exactamente de 256.
    public function testAcceptsPasswordWithMaximumAllowedLength(): void
    {
        // Arrange
        $password = str_repeat('p', 256);

        // Act
        $result = $this->object->isValid($password);

        // Assert
        $this->assertTrue($result);
    }

    // Verifica que el rechazo si se pasa 256 con 257.
    public function testRejectsPasswordLongerThanMaximumAllowedLength(): void
    {
        // Arrange
        $password = str_repeat('p', 257);

        // Act
        $result = $this->object->isValid($password);

        // Assert
        $this->assertFalse($result);
    }
}