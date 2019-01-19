<?php
 namespace Illuminate\Validation\Concerns; use Illuminate\Support\Arr; trait ReplacesAttributes { protected function replaceBetween($message, $attribute, $rule, $parameters) { return str_replace([':min', ':max'], $parameters, $message); } protected function replaceDateFormat($message, $attribute, $rule, $parameters) { return str_replace(':format', $parameters[0], $message); } protected function replaceDifferent($message, $attribute, $rule, $parameters) { return $this->replaceSame($message, $attribute, $rule, $parameters); } protected function replaceDigits($message, $attribute, $rule, $parameters) { return str_replace(':digits', $parameters[0], $message); } protected function replaceDigitsBetween($message, $attribute, $rule, $parameters) { return $this->replaceBetween($message, $attribute, $rule, $parameters); } protected function replaceMin($message, $attribute, $rule, $parameters) { return str_replace(':min', $parameters[0], $message); } protected function replaceMax($message, $attribute, $rule, $parameters) { return str_replace(':max', $parameters[0], $message); } protected function replaceIn($message, $attribute, $rule, $parameters) { foreach ($parameters as &$parameter) { $parameter = $this->getDisplayableValue($attribute, $parameter); } return str_replace(':values', implode(', ', $parameters), $message); } protected function replaceNotIn($message, $attribute, $rule, $parameters) { return $this->replaceIn($message, $attribute, $rule, $parameters); } protected function replaceInArray($message, $attribute, $rule, $parameters) { return str_replace(':other', $this->getDisplayableAttribute($parameters[0]), $message); } protected function replaceMimetypes($message, $attribute, $rule, $parameters) { return str_replace(':values', implode(', ', $parameters), $message); } protected function replaceMimes($message, $attribute, $rule, $parameters) { return str_replace(':values', implode(', ', $parameters), $message); } protected function replaceRequiredWith($message, $attribute, $rule, $parameters) { return str_replace(':values', implode(' / ', $this->getAttributeList($parameters)), $message); } protected function replaceRequiredWithAll($message, $attribute, $rule, $parameters) { return $this->replaceRequiredWith($message, $attribute, $rule, $parameters); } protected function replaceRequiredWithout($message, $attribute, $rule, $parameters) { return $this->replaceRequiredWith($message, $attribute, $rule, $parameters); } protected function replaceRequiredWithoutAll($message, $attribute, $rule, $parameters) { return $this->replaceRequiredWith($message, $attribute, $rule, $parameters); } protected function replaceSize($message, $attribute, $rule, $parameters) { return str_replace(':size', $parameters[0], $message); } protected function replaceRequiredIf($message, $attribute, $rule, $parameters) { $parameters[1] = $this->getDisplayableValue($parameters[0], Arr::get($this->data, $parameters[0])); $parameters[0] = $this->getDisplayableAttribute($parameters[0]); return str_replace([':other', ':value'], $parameters, $message); } protected function replaceRequiredUnless($message, $attribute, $rule, $parameters) { $other = $this->getDisplayableAttribute(array_shift($parameters)); return str_replace([':other', ':values'], [$other, implode(', ', $parameters)], $message); } protected function replaceSame($message, $attribute, $rule, $parameters) { return str_replace(':other', $this->getDisplayableAttribute($parameters[0]), $message); } protected function replaceBefore($message, $attribute, $rule, $parameters) { if (! (strtotime($parameters[0]))) { return str_replace(':date', $this->getDisplayableAttribute($parameters[0]), $message); } return str_replace(':date', $parameters[0], $message); } protected function replaceBeforeOrEqual($message, $attribute, $rule, $parameters) { return $this->replaceBefore($message, $attribute, $rule, $parameters); } protected function replaceAfter($message, $attribute, $rule, $parameters) { return $this->replaceBefore($message, $attribute, $rule, $parameters); } protected function replaceAfterOrEqual($message, $attribute, $rule, $parameters) { return $this->replaceBefore($message, $attribute, $rule, $parameters); } protected function replaceDimensions($message, $attribute, $rule, $parameters) { $parameters = $this->parseNamedParameters($parameters); if (is_array($parameters)) { foreach ($parameters as $key => $value) { $message = str_replace(':'.$key, $value, $message); } } return $message; } } 