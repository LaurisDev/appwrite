<?php

namespace Tests\Unit\Validator;

use Appwrite\Validator\Email;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class EmailTest extends TestCase
{
    private Email $validator;

    protected function setUp(): void
    {
        $this->validator = new Email();
    }

    public static function invalidEmailProvider(): array
    {
        return [
            'boolean' => [false],
            'null' => [null],
            'empty string' => [''],
            'missing at symbol' => ['email.com'],
            'missing local part' => ['@email.com'],
            'missing domain' => ['user@'],
            'missing top level domain' => ['user@email'],
            'double at symbol' => ['user@@email.com'],
            'space in email' => ['user @email.com'],
        ];
    }

    #[DataProvider('invalidEmailProvider')]
    public function testRejectsInvalidEmails(mixed $email): void
    {
        // Arrange

        // Act
        $result = $this->validator->isValid($email);

        // Assert
        $this->assertFalse($result);
    }

    public static function validEmailProvider(): array
    {
        return [
            'simple email' => ['user@email.com'],
            'subdomain' => ['user@mail.email.com'],
            'plus alias' => ['user+test@email.com'],
            'numeric local part' => ['123@email.com'],
            'mixed characters' => ['john.doe_123@email.co'],
        ];
    }

    #[DataProvider('validEmailProvider')]
    public function testAcceptsValidEmails(string $email): void
    {
        // Arrange

        // Act
        $result = $this->validator->isValid($email);

        // Assert
        $this->assertTrue($result);
    }
}