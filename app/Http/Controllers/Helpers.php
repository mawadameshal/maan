<?php

function quick_sort($my_array) {

	$loe = $gt = [];

	if (count($my_array) < 2) {
		return $my_array;
	}
	$pivot_key = key($my_array);
	$pivot = array_shift($my_array);
	foreach ($my_array as $val) {
		if ($val <= $pivot) {
			$loe[] = $val;
		} elseif ($val > $pivot) {
			$gt[] = $val;
		}
	}

	return array_merge(quick_sort($loe), array($pivot_key => $pivot), quick_sort($gt));
}

function check_permission($name) {
    return (boolean)\App\Account::query()->where('id', auth()->id())->whereHas('circle', function ($q) use($name) {
        $q->whereHas('links', function ($q) use ($name) {
            $q->where('links.title', $name);
        });
    })->first();
}

function check_permission_with_user_id($name, $user_id) {
    return (boolean)\App\Account::query()->where('id', $user_id)->whereHas('circle', function ($q) use($name) {
        $q->whereHas('links', function ($q) use ($name) {
            $q->where('links.title', $name);
        });
    })->first();
}

function check_permission_by_id($id) {
    return (boolean)\App\Account::query()->where('id', auth()->id())->whereHas('circle', function ($q) use($id) {
        $q->whereHas('links', function ($q) use ($id) {
            $q->where('links.id', $id);
        });
    })->first();
}
