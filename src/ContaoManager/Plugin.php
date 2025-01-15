<?php
namespace Lukasbableck\ContaoHBRechtstexteBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Lukasbableck\ContaoHBRechtstexteBundle\ContaoHBRechtstexteBundle;

class Plugin implements BundlePluginInterface {
	public function getBundles(ParserInterface $parser): array {
		return [BundleConfig::create(ContaoHBRechtstexteBundle::class)->setLoadAfter([ContaoCoreBundle::class])];
	}
}
