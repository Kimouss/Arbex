<?php

namespace App\DataFixtures\Provider;


use App\Entity\User\User;

class UserProvider
{
    /**
     * @param User $user
     *
     * @return string
     */
    public function emailFrom(User $user)
    {
        return sprintf('%s@mail.fr', $this->getSlug($user->getUserName()));
    }

    public function nameFrom($string)
    {
        return ucwords(str_replace('_', ' ', $string));
    }

    private function getSlug(string $string): string
    {
        $slug = strtolower($string);

        // Remove accents
        $slug = preg_replace('/[^a-z0-9 -]/', '', $slug);

        // Remove duplicate caret/space
        $slug = trim(preg_replace('/[ -]+/', ' ', $slug));

        // Replace space by caret
        $slug = preg_replace('/ /', '-', $slug);

        return $slug;
    }

    public function arbexEmail($string)
    {
        $user = explode('_', $string);
        $firstname = '';
        for ($i = 0; $i < count($user) - 1; $i++) {
            $firstname .= $user[$i][0];
        }

        return $firstname.$user[array_key_last($user)].'@arbex.com';
    }
}
