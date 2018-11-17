<?php
/**
 * Created by PhpStorm.
 * User: andreyfilenko
 * Date: 2018-11-06
 * Time: 22:27
 */

namespace App\Security;


use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class ExampleVoter implements VoterInterface
{
    public function vote(TokenInterface $token, $subject, array $attributes)
    {
        // TODO: Implement vote() method.
    }

}