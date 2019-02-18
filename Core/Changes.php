<?php

namespace Core;


class Changes
{
	public static function isChange(array $list):bool {
		if (!file_exists(base_path('count_sites.txt'))) {
			return true;
		}

		$current_count = count($list);
		$last_count = file_get_contents(base_path('count_sites.txt'));

		return $current_count != $last_count;
	}


	public static function update(array $list):bool {
		$current_count = count($list);

		if (self::isChange($list)) {
			file_put_contents(base_path('count_sites.txt'), $current_count);

			return true;
		}

		return false;
	}
}