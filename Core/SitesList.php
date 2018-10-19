<?php

namespace Core;


class SitesList
{
	protected $sites = [];


	public function __construct() {
		$list = $this->getListDirectories();

		if (Changes::update($list)) {
			$this->create($list);
		} else {
			$this->load();
		}
	}


	public function create(array $list) {
		foreach ($list as $item) {
			$this->sites[] = Site::create($item);
		}

		$this->putDataToFile();
	}


	public function load() {
		$data = $this->getDataFromFile();

		foreach ($data as $item) {
			$this->sites[] = Site::load(unserialize($item));
		}
	}


	public function getSites():array {
		return $this->sites;
	}


	protected function getListDirectories() {
		$exceptions = env('EXCEPTIONS');
		$list = scandir(env('SCAN_DIR'));

		return array_diff($list, $exceptions);
	}


	protected function getDataFromFile():array {
		$file = file_get_contents(base_path('sites.txt'));

		return unserialize($file);
	}


	protected function putDataToFile() {
		$sites = [];

		foreach ($this->sites as $site) {
			$sites[] = strval($site);
		}

		$sites = serialize($sites);

		file_put_contents(base_path('sites.txt'), $sites);
	}

}