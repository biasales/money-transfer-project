<?php

namespace App\Seeders\User;

use App\Enums\UserType;
use App\Models\UserModel;
use App\Repository\User\UserRepositoryResolver;
use App\Seeders\Seeder;

class UserSeeder implements Seeder
{
    public static function seed(): void
    {
//        $common_user = new UserModel(
//            random_int(10,999),
//            "Bianca Sales Usuario",
//            UserType::MERCHANT,
//            random_int(5,15),
//            "biasalsessa@test.com",
//            123456,
//           null,
//            null
//        );
//
//        $merchant_user = new UserModel(
//            random_int(10,999),
//            "Bianca Sales Lojista",
//            UserType::MERCHANT,
//            random_int(5,999),
//            "biasasles_lojasa@test.com",
//            123456,
//           null,
//           null,
//        );
//
//        $user_repository = UserRepositoryResolver::resolve();
//
//        $user_repository::createUser($common_user);
//        $user_repository::createUser($merchant_user);
    }
}
