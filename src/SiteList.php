<?php

namespace Sites;

use Iterator;
use Sites\Site;
use JsonSerializable;

class SiteList implements JsonSerializable, Iterator {

	private const PATH = '../storage/sites.json';

	private $index = 0;

	private $sites = [];

	public function __construct() {
		if(!$this->hasFile()) {
			file_put_contents(self::PATH, '');
		}

		$this->loadData();
		$this->checkUpdate();
	}


	public function loadData() {
		$data = file_get_contents(self::PATH);

		foreach (json_decode($data) ?? [] as $site_data) {
			$this->sites[] = new Site($site_data);
		}
	}


	public function saveData() {
		file_put_contents(self::PATH, json_encode($this));
	}


	public function checkUpdate() {
		$exceptions = explode(';', env('EXCEPTIONS'));
		$list = scandir(env('SCAN_DIR'));
		$list = array_diff($list, $exceptions);
		$has_timestamp_updated = false;

		if(count($list) != count($this->sites)) {
			$this->updateData($list);
		}

		foreach($this->sites as $index => $site) {
			$path = env('SCAN_DIR') . '/' . $site->name;

			if(!file_exists($path)) {
				$has_timestamp_updated = true;
				unset($this->sites[$index]);
				continue;
			}

			$last_update = filemtime(env('SCAN_DIR') . '/' . $site->name);
			if($last_update != $site->lastUpdate) {
				$site->updateTimestamp($last_update);
				$has_timestamp_updated = true;
			}
		}

		if($has_timestamp_updated) {
			$this->saveData();
		}
	}


	public function updateData(array $list) {
		foreach ($list as $name) {
			if(!$this->hasSite($name)) {
				$this->sites[] = Site::create($name);
			}
		}

		$this->saveData();
	}


	public function hasSite(string $name) {
		/** @var Site $site */
		foreach($this->sites as $site) {
			if($site->name == $name) {
				return true;
			}
		}

		return false;
	}


	public function sort(string $field, string $order = 'asc') {
		usort($this->sites, function(Site $first, Site $second) use ($field, $order) {
			if($order == 'asc') {
				return $first->{$field} > $second->{$field};
			}

			if($order == 'desc') {
				return $first->{$field} < $second->{$field};
			}
		});
	}


	public function jsonSerialize() {
		return $this->sites;
	}


	public function current():Site {
		return $this->sites[$this->index];
	}


	public function next() {
		$this->index++;
	}


	public function key() {
		return $this->index;
	}


	public function valid() {
		return $this->index < count($this->sites) && $this->index >= 0;
	}


	public function rewind() {
		$this->index = 0;
	}


	private function hasFile() {
		return file_exists(self::PATH);
	}
}