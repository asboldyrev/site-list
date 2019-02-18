<?php

namespace Core;


class Site
{
	/**
	 * @var string $icon
	 */
	protected $icon = '';

	/**
	 * @var string $name
	 */
	protected $name;

	/**
	 * @var bool $isChunker
	 */
	protected $isChunker = false;

	protected $faviconPaths = [
		'/public/favicon.ico',
		'/public/img/layout/favicon.png',
		'/public/img/layout/logo.png',
		'/public/img/favicon.png',
		'/public/favicon.png',
		'/public/assets/favicon.png',
		'/favicon.ico',
	];


	private function __construct() { }


	public static function create(string $name):self {
		$path = env('SCAN_DIR') . '/' . $name;
		$self = new static();

		foreach ($self->faviconPaths as $faviconPath) {
			if (
				file_exists($path . $faviconPath) &&
				filesize($path . $faviconPath)
			) {
				$mime_type = mime_content_type($path . $faviconPath);

				$data = file_get_contents($path . $faviconPath);
				$self->icon = 'data:' . $mime_type . ';base64,' . base64_encode($data);
				break;
			}
		}

		$self->name = $name;
		$self->isChunker = $self->isChunker($name);

		return $self;
	}


	public static function load(array $params):self {
		$self = new static();

		if (key_exists('icon', $params)) {
			$self->icon = $params[ 'icon' ];
		}

		if (key_exists('name', $params)) {
			$self->name = $params[ 'name' ];
		}

		if (key_exists('isChunker', $params)) {
			$self->isChunker = $params[ 'isChunker' ];
		}

		return $self;
	}


	public function __toString():string {
		return serialize([
			'icon'      => $this->icon,
			'name'      => $this->name,
			'isChunker' => $this->isChunker,
		]);
	}


	public function hasIcon() {
		return is_string($this->icon) && mb_strlen($this->icon);
	}


	public function getIcon() {
		return $this->icon;
	}


	public function getName() {
		return $this->name;
	}


	public function getUrl(string $domain = NULL):string {
		return 'http://' . $this->name . '.' . ($domain ?: host());
	}


	public function getAdminUrl(string $domain = NULL):string {
		return $this->getUrl($domain) . '/admin';
	}


	public function hasAdmin() {
		return $this->isChunker;
	}


	protected function isChunker(string $name) {
		$path = env('SCAN_DIR') . '/';

		return is_dir($path . $name . '/vendor/chunker/base/') || is_dir($path . $name . '/chunker/');
	}
}