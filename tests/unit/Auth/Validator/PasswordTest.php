<?php
 // Lo que está verificando es que la clase Password exija una longitud mínima de 8 caracteres y que el valor sea una cadena válida.
declare(strict_types=1);

namespace Tests\Unit\Auth\Validator;

use Appwrite\Auth\Validator\Password;
use PHPUnit\Framework\TestCase;

final class PasswordTest extends TestCase
{
    protected ?Password $object = null;

    protected function setUp(): void
    {
        $this->object = new Password();
    }

    public function testRejectsBooleanValue(): void
    {
        // Arrange
        $password = false;

        // Act
        $result = $this->object->isValid($password);

        // Assert
        $this->assertFalse($result);
    }

    public function testRejectsNullValue(): void
    {
        // Arrange
        $password = null;

        // Act
        $result = $this->object->isValid($password);

        // Assert
        $this->assertFalse($result);
    }

    public function testRejectsEmptyString(): void
    {
        // Arrange
        $password = '';

        // Act
        $result = $this->object->isValid($password);

        // Assert
        $this->assertFalse($result);
    }

    public function testRejectsPasswordWithOneCharacter(): void
    {
        // Arrange
        $password = '1';

        // Act
        $result = $this->object->isValid($password);

        // Assert
        $this->assertFalse($result);
    }

    public function testRejectsPasswordWithSevenCharacters(): void
    {
        // Arrange
        $password = '1234567';

        // Act
        $result = $this->object->isValid($password);

        // Assert
        $this->assertFalse($result);
    }

    public function testAcceptsPasswordWithMinimumLength(): void
    {
        // Arrange
        $password = '12345678';

        // Act
        $result = $this->object->isValid($password);

        // Assert
        $this->assertTrue($result);
    }

    public function testAcceptsLongPassword(): void
    {
        // Arrange
        $password = 'WUnOZcn0piQMN8Mh31xw4KQPF0gcNGVA';

        // Act
        $result = $this->object->isValid($password);

        // Assert
        $this->assertTrue($result);
    }
}