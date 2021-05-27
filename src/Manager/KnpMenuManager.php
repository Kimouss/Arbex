<?php


namespace App\Manager;


use App\Entity\Menu;
use App\Repository\MenuRepository;
use KevinPapst\AdminLTEBundle\Event\KnpMenuEvent;
use Knp\Menu\ItemInterface;
use Symfony\Bundle\MakerBundle\Str;
use Symfony\Component\Security\Core\Security;

class KnpMenuManager
{
    /**
     * @var MenuRepository $menuRepository
     */
    private MenuRepository $menuRepository;

    /**
     * @var Security
     */
    private Security $security;

    public function __construct(MenuRepository $menuRepository, Security $security)
    {
        $this->menuRepository = $menuRepository;
        $this->security = $security;
    }

    public function knpMenuBuilder(KnpMenuEvent $event)
    {
        $menus = $this->menuRepository->findAll();
        $menuEvent = $event->getMenu();
        $user = $this->security->getUser();

        foreach ($menus as $menu) {
            if (!$menu->getIsActive() && !in_array('ROLE_ADMIN_SOGEC', $user->getRoles())) {
                continue;
            }

            $menuEvent = $this->buildMenu($event, $menu, $menuEvent);
        }

        return $menuEvent;
    }

    protected function buildMenu(KnpMenuEvent $event, Menu $menu, ItemInterface $menuEvent)
    {
        $menuParent = $menu->getMenu();
        if (!$menuParent instanceof Menu) {
            $menuEvent
                ->addChild(
                    Str::asCamelCase($menu->getLabel()).$menu->getId(),
                    $this->buildParentMenu($menu, $event),
                )->setLabelAttribute('icon', $menu->getIcon() ?? 'fas fa-list');

        } else {
            $menuEvent
                ->getChild(Str::asCamelCase($menuParent->getLabel()).$menuParent->getId())
                ->addChild(
                    Str::asCamelCase($menu->getLabel()).$menu->getId(),
                    $this->buildChildMenu($menu, $event),
                )->setLabelAttribute('icon', $menu->getIcon());
        }

        return $menuEvent;
    }

    protected function buildParentMenu(Menu $menu, KnpMenuEvent $event)
    {
        return [
            'label' => $menu->getLabel(),
            'childOptions' => $event->getChildOptions(),
        ];
    }

    protected function buildChildMenu(Menu $menu, KnpMenuEvent $event): array
    {
        $array = [
            'label' => $menu->getLabel(),
            'childOptions' => $event->getChildOptions()
        ];

        if ($menu->getIsUri()) {
            $array['uri'] = $menu->getRoute();
            $array['linkAttributes'] = ['target' => '_blank'];
        } else {
            $array['route'] = $menu->getRoute();
        }

        return $array;
    }
}
