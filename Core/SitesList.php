<?php

namespace Core;


class SitesList
{
	/** @var Site[] $sites */
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

		$this->sortSites();

		$this->putDataToFile();
	}


	public function load() {
		$data = $this->getDataFromFile();

		foreach ($data as $item) {
			$this->sites[] = Site::load(unserialize($item));
		}

		$this->sortSites();
	}


	public function getSites():array {
		return $this->sites;
	}

	public function getGroupedSites():array {
		$result = [];
		$letter = '';

		foreach ($this->sites as $site) {
			$_letter = mb_substr($site->getName(), 0, 1);
			if ($_letter != $letter) {
				$letter = $_letter;
			}

			$result[ mb_strtoupper($letter) ][] = $site;
		}

		return $result;
	}


	protected function sortSites():void {
		usort($this->sites, function(Site $first, Site $second) {
			return $first->getName() > $second->getName();
		});
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