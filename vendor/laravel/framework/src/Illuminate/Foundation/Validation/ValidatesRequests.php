<?php
 namespace Illuminate\Foundation\Validation; use Illuminate\Support\Str; use Illuminate\Http\Request; use Illuminate\Contracts\Validation\Factory; use Illuminate\Validation\ValidationException; trait ValidatesRequests { public function validateWith($validator, Request $request = null) { $request = $request ?: request(); if (is_array($validator)) { $validator = $this->getValidationFactory()->make($request->all(), $validator); } $validator->validate(); return $this->extractInputFromRules($request, $validator->getRules()); } public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = []) { $this->getValidationFactory() ->make($request->all(), $rules, $messages, $customAttributes) ->validate(); return $this->extractInputFromRules($request, $rules); } protected function extractInputFromRules(Request $request, array $rules) { return $request->only(collect($rules)->keys()->map(function ($rule) { return Str::contains($rule, '.') ? explode('.', $rule)[0] : $rule; })->unique()->toArray()); } public function validateWithBag($errorBag, Request $request, array $rules, array $messages = [], array $customAttributes = []) { try { return $this->validate($request, $rules, $messages, $customAttributes); } catch (ValidationException $e) { $e->errorBag = $errorBag; throw $e; } } protected function getValidationFactory() { return app(Factory::class); } } 