<?php
class AdminMenu extends AppModel {
	public $order = "AdminMenu.order ASC";

	public function afterFind($results, $primary = false) {
		foreach ($results as $i => &$result) {
			$result = $result['AdminMenu'];
			$result['url'] = $settings['site_url'].'/admin/'.$result['url'];
		}

		return $results;
	}
}