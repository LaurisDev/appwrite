<?php

declare(strict_types=1);

namespace Tests\Unit\Auth\Validator;

use Appwrite\Auth\Validator\Phone;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class PhoneTest extends TestCase
{
    private Phone $validator;

    protected function setUp(): void
    {
        $this->validator = new Phone();
    }

    #[DataProvider('invalidPhoneProvider')]
    public function testRejectsInvalidPhoneNumbers(mixed $phone): void
    {
        // Arrange
        $validator = $this->validator;

        // Act
        $result = $validator->isValid($phone);

        // Assert
        $this->assertFalse($result);
    }

    #[DataProvider('validPhoneProvider')]
    public function testAcceptsValidPhoneNumbers(string $phone): void
    {
        // Arrange
        $validator = $this->validator;

        // Act
        $result = $validator->isValid($phone);

        // Assert
        $this->assertTrue($result);
    }

    public static function invalidPhoneProvider(): array
    {
        return [
            [false],
            [null],
            [''],
            ['+1'],
            ['+14'],
            ['+141'],
            ['+1415'],
            ['+14155'],
            ['+141555'],
            ['8989829304'],
            ['786-307-3615'],
            ['+16308A520397'],
            ['+0415553452342'],
            ['+14 155 5524564'],
            ['+1415555245634543'],
            ['+8020000000'],
            [+14155552456],
        ];
    }

    public static function validPhoneProvider(): array
    {
        return [
            ['+1415555'],
            ['+14155552'],
            ['+141555526'],
            ['+16308520394'],
            ['+163085205339'],
            ['+5511552563253'],
            ['+55115525632534'],
            ['+919367788755111'],
        ];
    }
}