<?php
namespace BienEtre;

use Omeka\Module\AbstractModule;
use Laminas\View\Model\ViewModel;
use Laminas\Mvc\Controller\AbstractController;

class Module extends AbstractModule
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
