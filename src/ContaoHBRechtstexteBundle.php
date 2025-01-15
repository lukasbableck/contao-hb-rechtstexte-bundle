<?php
namespace Lukasbableck\ContaoHBRechtstexteBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ContaoHBRechtstexteBundle extends Bundle {
	public function getPath(): string {
		return \dirname(__DIR__);
	}
}
