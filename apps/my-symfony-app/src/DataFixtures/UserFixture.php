<?php

namespace App\DataFixtures;

use App\Entity\ApiToken;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends BaseFixture
{
    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_users', function($i) use ($manager) {
            $user = new User();
            $user->setEmail(sprintf('spacebar%d@example.com', $i));
            $user->setFirstName($this->faker->firstName);
            $user->setPassword($this->userPasswordEncoder->encodePassword($user, '123456'));
            $user->setTwitterUsername($this->faker->userName);
            $user->agreeToTerms();

            $apiToken1 = new ApiToken($user);
            $apiToken2 = new ApiToken($user);

            $manager->persist($apiToken1);
            $manager->persist($apiToken2);

            return $user;
        });

        $this->createMany(3, 'admin_users', function($i) {
            $user = new User();
            $user->setEmail(sprintf('admin%d@user.com', $i));
            $user->setFirstName($this->faker->firstName);
            $user->setPassword($this->userPasswordEncoder->encodePassword($user, '123456'));
            $user->setRoles([
                'ROLE_ADMIN'
            ]);
            $user->agreeToTerms();

            return $user;
        });

        $manager->flush();
    }
}
