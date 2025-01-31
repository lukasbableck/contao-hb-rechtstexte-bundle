<?php

namespace Lukasbableck\ContaoHBRechtstexteBundle\Controller\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\Monolog\ContaoContext;
use Contao\Template;
use Lukasbableck\ContaoHBRechtstexteBundle\Classes\Haendlerbund;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(RechtstextController::TYPE, category: 'miscellaneous', template: 'ce_hb_rechtstext')]
class RechtstextController extends AbstractContentElementController {
	public const string TYPE = 'hb_rechtstext';

	public function __construct(private LoggerInterface $contaoGeneralLogger, private Haendlerbund $haendlerbund) {
	}

	protected function getResponse(Template $template, ContentModel $model, Request $request): Response {
		$cache = new FilesystemAdapter();
		$language = $model->hb_rechtstext_language;
		$docID = $model->hb_rechtstext_type;
		$accessToken = $model->hb_rechtstext_access_token;

		if (!$language || !$docID || !$accessToken) {
			$this->contaoGeneralLogger->error('Händlerbund Rechtstexte: Access token, language or type not set in content element '.$model->id, ['contao' => new ContaoContext(__METHOD__, ContaoContext::ERROR)]);

			return $template->getResponse();
		}

		$cacheKey = 'hb_rechtstext_'.$docID.'_'.$language.'_'.$accessToken;
		$cacheItem = $cache->getItem($cacheKey);
		if (!$cacheItem->isHit() || $cacheItem->get()['created'] < time() - 3) {
			$hbResult = $this->haendlerbund->request($docID, $language, $accessToken);
			if ($hbResult !== null) {
				$cacheItem->set(['created' => time(), 'content' => $hbResult]);
				$cache->save($cacheItem);
			}
		}

		$template->rechtstext = $cacheItem->get()['content'];

		return $template->getResponse();
	}
}
