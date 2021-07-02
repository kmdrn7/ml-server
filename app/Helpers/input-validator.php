<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InputValidator
{
    public static function validateRequest(Request $request, $rules)
    {
        $object = $request->all();
        $validated_rules = array_filter($rules);
        Validator::make($object, $validated_rules)->validate();

        return (object) $request->only(array_keys($rules));
    }
}
