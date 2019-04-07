<?php

namespace Izica;

use Phalcon\Validation as PhalconValidation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Numericality;

class Validation {
    private static $sTypeRequired = 'required';
    private static $sTypeNumeric = 'numeric';
    private static $sTypeEmail = 'email';
    private $arOptions = [];
    public static $arValidators = [
        'required' => PresenceOf::class,
        'numeric' => Numericality::class,
        'email' => Email::class,
    ];

    function __construct($arOptions) {
        $this->arOptions = $arOptions;
    }

    private static function getValidator($sName, $arOptions) {
        if (self::$arValidators[$sName]) {
            return new self::$arValidators[$sName]($arOptions);
        }
        return false;
    }

    public function validate($arData) {
        $obValidation = new PhalconValidation();
        foreach ($this->arOptions as $sField => $arFieldOptions) {
            foreach ($arFieldOptions as $arFieldOption) {
                $obValidator = self::getValidator($arFieldOption['type'], $arFieldOption['options']);
                if ($obValidator !== false) {
                    $obValidation->add($sField, $obValidator);
                }
            }
        }
        $obMessages = $obValidation->validate($arData);
        $arMessages = [];

        foreach ($obMessages as $obMessage) {
            $arMessages[] = [
                'field' => $obMessage->getField(),
                'type' => $obMessage->getType(),
                'message' => $obMessage->getMessage(),
            ];
        }
    }

    public static function required(
        $arOptions = [
            'message' => ':field is required'
        ]
    ) {
        return [
            'type' => self::$sTypeRequired,
            'options' => $arOptions
        ];
    }

    public static function numeric(
        $arOptions = [
            'message' => ':field is not numeric'
        ]
    ) {
        return [
            'type' => self::$sTypeNumeric,
            'options' => $arOptions
        ];
    }

    public static function email(
        $arOptions = [
            'message' => ':field is not valid'
        ]
    ) {
        return [
            'type' => self::$sTypeEmail,
            'options' => $arOptions
        ];
    }
}
