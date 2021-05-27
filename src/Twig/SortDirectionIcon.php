<?php


namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SortDirectionIcon extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('sortDirectionIcon', [$this, 'sortDirectionIcon']),
        ];
    }

    public function sortDirectionIcon(string $label, array $params): string
    {
        if (array_key_exists('sort', $params) && $label === $params['sort']) {
            if ('asc' === $params['direction']) {
                return 'sort-up';
            } else {
                return 'sort-down';
            }
        } else {
            return 'sort';
        }
    }
}
