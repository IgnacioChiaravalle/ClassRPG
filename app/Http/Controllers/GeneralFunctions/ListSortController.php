<?php

namespace App\Http\Controllers\GeneralFunctions;

use App\Http\Controllers\Controller;

class ListSortController extends Controller {
	public function quicksort($list, $criteria) {
		$loe = $gt = array();
		if ($this->findSize($list) < 2)
			return $list;
		$pivot_key = key($list);
		$pivot = array_shift($list);
		foreach ($list as $element) {
			$comparationResult = $this->compare($element, $pivot, $criteria);
			if($comparationResult <= 0)
				$loe[] = $element;
			else
				$gt[] = $element;	
		}
		return array_merge($this->quicksort($loe, $criteria), array($pivot_key=>$pivot), $this->quicksort($gt, $criteria));
	}

	private function compare($element, $pivot, $criteria) {
		if ($criteria == 'user')
			return strcasecmp($element->real_name, $pivot->real_name);
		if ($criteria == 'sale') {
			if ($element->cost < $pivot->cost)
				return -1;
			elseif ($element->cost > $pivot->cost)
				return 1;
			else
				return 0;
		}
		return 0;
	}

	private function findSize($list) {
		$size = 0;
		foreach ($list as $l)
			$size++;
		return $size;
	}
}
