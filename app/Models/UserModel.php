<?php

namespace App\Models;

use App\Enums\UserType;
use App\Repository\UserRepositoryResolver;

class UserModel
{
    public function __construct(
        public readonly ?int  $id,
        public readonly ?string $name,
        public readonly ?UserType $type,
        public readonly ?int $document,
        public readonly ?string $amount,
        public readonly ?string $email,
        public readonly ?string $password,
        public readonly ?\DateTime $created_at,
        public readonly ?\DateTime $updated_at,
    ){}

    public static function fromArray(array $userData): UserModel
    {
        return new UserModel(
            $userData['id'],
            $userData['name'],
            UserType::from($userData['type']),
            $userData['document'],
            $userData['amount'],
            $userData['email'],
            $userData['password'],
            $userData['created_at'] ?? null,
            $userData['password'] ?? null,
        );
    }

    public static function isHasMoney(int $userId, string $amount): bool
    {
        return  UserRepositoryResolver::resolve()->hasAmount($userId, $amount);
    }

    public static function getMoney(int $userId): bool
    {
        return UserRepositoryResolver::resolve()->getAmount($userId);
    }

    public static function isCommonUser(int $userId): bool
    {
        return UserRepositoryResolver::resolve()->isCommonUserType($userId);
    }

    public static function updateAmount(int $userId, string $amount, bool $is_payer): bool
    {
        $user_amount = self::getMoney($userId);
        if ($is_payer) {
            return UserRepositoryResolver::resolve()->updateAmount((float)$user_amount - (float)$amount, $userId);
        }
        return UserRepositoryResolver::resolve()->updateAmount((float)$amount + (float)$user_amount, $userId);
    }

}