<?php

namespace App\Models;

use App\Enums\UserType;
use App\Repository\User\UserRepositoryResolver;
use DateTime;

class UserModel
{
    public function __construct(
        public readonly ?int       $id,
        public readonly ?string    $name,
        public readonly ?UserType  $type,
        public readonly ?int       $document,
        public readonly ?int       $amount,
        public readonly ?string    $email,
        public readonly ?string    $password,
        public readonly ?\DateTime $createdAt,
        public readonly ?\DateTime $updatedAt,
    ){}

    public static function fromArray(array $userData): UserModel
    {
        return new UserModel(
            $userData['id'] ?? null,
            $userData['name'],
            UserType::from((int)$userData['type']),
            $userData['document'],
            $userData['amount'],
            $userData['email'],
            $userData['password'],
             isset($userData['created_at']) ? new DateTime($userData['created_at']) : null,
            isset($userData['updated_at']) ? new DateTime($userData['created_at']) : null,
        );
    }

    public static function getUser(int $userId): ?UserModel
    {
        $user = UserRepositoryResolver::resolve()->getUser($userId);
        return isset($user) ? UserModel::fromArray($user) : null;
    }

    public static function asArray(UserModel $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'type' => $user->type->value,
            'document' => $user->document,
            'amount' => $user->amount,
            'email' => $user->email,
            'password' => $user->password,
            'created_at' => $user->createdAt->format(\DateTimeInterface::ATOM),
            'updated_at' => $user->updatedAt->format(\DateTimeInterface::ATOM),
        ];
    }
}