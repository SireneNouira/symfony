<?php

// src/Security/Voter/RecipeVoter.php

namespace App\Security\Voter;

use App\Entity\Recipe;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class RecipeVoter extends Voter
{
    const EDIT = 'edit';
    const DELETE = 'delete';

    public function __construct(private Security $security) {}

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::DELETE]) && $subject instanceof Recipe;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user) {
            return false; // L'utilisateur doit être connecté
        }

        /** @var Recipe $recipe */
        $recipe = $subject;

        return $recipe->getUser() === $user; // Seul le propriétaire peut modifier/supprimer
    }
}
