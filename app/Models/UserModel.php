<?php

namespace App\Models;

use App\Enums\UserType;
use App\Repository\UserRepositoryResolver;
use DateTime;

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
            isset($userData['id']) ? $userData['id'] : null,
            $userData['name'],
            UserType::from($userData['type']),
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

    public static function isHasMoney(int $userId, string $amount): bool
    {
        return UserRepositoryResolver::resolve()->hasAmount($userId, $amount);
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
            'created_at' => $user->created_at->format(\DateTimeInterface::ATOM),
            'updated_at' => $user->updated_at->format(\DateTimeInterface::ATOM),
        ];

    }

    public static function deleteUser(string $userId) : bool {
        $user = self::getUser($userId);

        if (isset($user->id)) {
            return UserRepositoryResolver::resolve()->deleteUser($user);
        }
        return false;
    }

}