<?php
namespace Lukasbableck\ContaoHBRechtstexteBundle\Controller\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\Monolog\ContaoContext;
use Contao\Template;
use Lukasbableck\ContaoHBRechtstexteBundle\Classes\Haendlerbund;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

#[AsContentElement(RechtstextController::TYPE, category: 'miscellaneous', template: 'ce_hb_rechtstext')]
class RechtstextController extends AbstractContentElementController {
	public const string TYPE = 'hb_rechtstext';

	public function __construct(private CacheInterface $cache, private LoggerInterface $contaoGeneralLogger, private Haendlerbund $haendlerbund) {
	}

	protected function getResponse(Template $template, ContentModel $model, Request $request): Response {
		$language = $model->hb_rechtstext_language;
		$docID = $model->hb_rechtstext_type;
		$accessToken = $model->hb_rechtstext_access_token;

		if (!$language || !$docID || !$accessToken) {
			$this->contaoGeneralLogger->error('Händlerbund Rechtstexte: Access token, language or type not set in content element '.$model->id, ['contao' => new ContaoContext(__METHOD__, ContaoContext::ERROR)]);

			return $template->getResponse();
		}

		$rechtstext = $this->cache->get('hb_rechtstext_'.$docID.'_'.$language.'_'.$accessToken, function (ItemInterface $item) use ($docID, $language, $accessToken) {
			$hbResult = $this->haendlerbund->request($docID, $language, $accessToken);
			if (!$hbResult) {
				$item->expiresAfter(0);

				return '';
			}
			$item->expiresAfter(3600);

			return $hbResult;
		});

		$template->rechtstext = $rechtstext;

		return $template->getResponse();
	}
}
