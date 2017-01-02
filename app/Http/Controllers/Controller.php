<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function validate(
        \Illuminate\Http\Request $request,
        array $rules,
        array $messages = array(),
        array $customAttributes = array()
    ) {
        $validator = $this->getValidationFactory()
            ->make($request->input(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }
    }
}
