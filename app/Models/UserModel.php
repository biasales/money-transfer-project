<?php

namespace App\Models;

use App\Enums\UserType;

class UserModel
{
    public function __construct(
        public readonly ?string $name,
        public readonly ?UserType $type,
        public readonly ?int $document,
        public readonly ?string $amount,
        public readonly ?string $email,
        public readonly ?string $password,
    ){}

    public static function fromArray(array $userData): UserModel
    {
        return new UserModel(
            $userData['name'],
            UserType::from($userData['type']),
            $userData['document'],
            $userData['amount'],
            $userData['email'],
            $userData['password'],
        );
    }

}