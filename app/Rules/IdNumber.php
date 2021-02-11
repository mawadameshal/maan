<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IdNumber implements Rule {
	/**
	 * Create a new rule instance.
	 *
	 * @return void
	 */
	public function __construct() {
		//
	}

	/**
	 * Determine if the validation rule passes.
	 *
	 * @param  string  $attribute
	 * @param  mixed  $value
	 * @return bool
	 */
	public function passes($attribute, $value) {
		$id = $value;

		if (strlen($id) != 9 || !preg_match('/^[0-9]*$/', $id)) {
			return false;
		} else {
			// our ID calculation here
			// 123456789
			$Ldigit = $id % 10;

			$j1 = 1; // division
			$j2 = 10; // mod
			$t1;
			$t2;
			$arr = Array();
			$arr2 = Array();

			for ($i = 0; $i < 8; $i++) {
				$j1 = $j1 * 10;
				$j2 = $j2 * 10;

				$t1 = $id % $j2;
				$t2 = ($t1 / $j1) | 0;
				$arr[$i] = $t2;

			}

			$j = 7;

			for ($i = 0; $i < 8; $i++) {
				$arr2[$j] = $arr[$i];
				$j--;
			}

			$odd = 1;
			for ($i = 0; $i < 8; $i++) {
				if ($odd == 1) {
					$arr2[$i] = $arr2[$i] * 1;
					$odd = 2;
				} else {
					$arr2[$i] = $arr2[$i] * 2;
					$odd = 1;
				}

				if ($arr2[$i] > 9) // if elemenet  > 9
				{
					$temp = str_split(strval($arr2[$i]));

					$temp = (int) $temp[0] + (int) $temp[1];

					$arr2[$i] = $temp;
				}

			}

			$sub = 0;

			for ($i = 0; $i < 8; $i++) {
				$sub += $arr2[$i];

			}

			$Valid;

			$Valid = str_split(strval($sub));

			$Valid = $Valid[1];
			$Valid = 10 - $Valid;

			if ($Ldigit == $Valid) {
				return true;
			} else {
				return false;
			}

		}
	}

	/**
	 * Get the validation error message.
	 *
	 * @return string
	 */
	public function message() {
		return 'رقم الهوية خطأ، يرجى إدخال رقم هوية صحيح.';
	}
}
