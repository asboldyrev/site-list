<?php

namespace Sites;

use stdClass;
use JsonSerializable;

class Site implements JsonSerializable {

	protected $iconPath = '';

	protected $name;

	protected $isChunker = false;

	protected $lastUpdate;

	protected static $iconPaths = [
		'/public/favicon.ico',
		'/public/img/layout/favicon.png',
		'/public/img/layout/logo.png',
		'/public/img/favicon.png',
		'/public/favicon.png',
		'/public/assets/favicon.png',
		'/favicon.ico',
		'/public/img/layout/favicon.svg',
		'/public/favicon.svg',
	];


	/**
	 * Undocumented function
	 *
	 * @param stdClass|array $data
	 */
	function __construct($data) {
		if(is_array($data)) {
			$this->iconPath = $data['iconPath'] ?? null;
			$this->name = $data['name'];
			$this->isChunker = $data['isChunker'];
			$this->lastUpdate = $data['lastUpdate'] ?? null;
		} else {
			$this->iconPath = $data->iconPath ?? null;
			$this->name = $data->name;
			$this->isChunker = $data->isChunker;
			$this->lastUpdate = $data->lastUpdate ?? null;
		}
	}


	public function __get($name) {
		if(property_exists($this, $name)) {
			return $this->{$name};
		}

		return null;
	}


	public function getUrl(string $path = '') {
		return 'http://' . $this->name  . '.' . env('ROOT_DOMAIN') . $path;
	}


	public function getIconPath() {
		return $this->getUrl() . str_replace(['/public', 'public'], '', $this->iconPath);
	}


	public function jsonSerialize():array {
		return [
			'iconPath'   => $this->iconPath,
			'name'       => $this->name,
			'isChunker'  => $this->isChunker,
			'lastUpdate' => $this->lastUpdate
		];
	}


	public static function create(string $name):self {
		$path = env('SCAN_DIR') . '/' . $name;
		$data = [
			'name' => $name,
		];

		foreach (self::$iconPaths as $iconPath) {
			if (
				file_exists($path . $iconPath) &&
				filesize($path . $iconPath)
			) {
				$data['iconPath'] = $iconPath;
				break;
			}
		}
		$data['isChunker'] = is_dir($path . '/vendor/chunker/base/') || is_dir($path . '/chunker/');

		return new static($data);
	}


	public function updateTimestamp($timestamp) {
		$this->lastUpdate = $timestamp;
	}
}