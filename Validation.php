<?php

namespace Izica;

use Phalcon\Validation as PhalconValidation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Between;
use Phalcon\Validation\Validator\File;
use Phalcon\Validation\Validator\UniquenessValidator;
use Phalcon\Validation\Validator\Callback;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\Url;
use Phalcon\Validation\Validator\Date;
use Phalcon\Validation\Validator\Regex;

class Validation {
    private $arOptions = [];
    public static $arValidators = [
        'required' => PresenceOf::class,
        'numeric' => Numericality::class,
        'email' => Email::class,
        'unique' => UniquenessValidator::class,
        'callback' => Callback::class,
        'length' => StringLength::class,
        'between' => Between::class,
        'file' => File::class,
        'url' => Url::class,
        'date' => Date::class,
        'regex' => Regex::class,
    ];

	public static $arTypes = [
		'PresenceOf'          => 'required',
		'Numericality'        => 'numeric',
		'Email'               => 'email',
		'UniquenessValidator' => 'unique',
		'Callback'            => 'callback',
		'StringLength'        => 'length',
		'Between'             => 'between',
		'File'                => 'file',
		'Url'                 => 'url',
		'Date'                => 'date',
		'Regex'               => 'regex',
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
                'type' => self::$arTypes[$obMessage->getType()],
                'message' => $obMessage->getMessage(),
            ];
        }
        return $arMessages;
    }

    public static function required(
        $arOptions = [
            'message' => ':field is required'
        ]
    ) {
        return [
            'type' => 'required',
            'options' => $arOptions
        ];
    }

    public static function numeric(
        $arOptions = [
            'message' => ':field is not numeric'
        ]
    ) {
        return [
            'type' => 'numeric',
            'options' => $arOptions
        ];
    }

    public static function url(
        $arOptions = [
            'message' => ':field must be a url'
        ]
    ) {
        return [
            'type' => 'url',
            'options' => $arOptions
        ];
    }

    public static function email(
        $arOptions = [
            'message' => ':field is not valid'
        ]
    ) {
        return [
            'type' => 'email',
            'options' => $arOptions
        ];
    }

    public static function unique($arOptions) {
        return [
            'type' => 'unique',
            'options' => $arOptions
        ];
    }

    public static function callback($arOptions) {
        return [
            'type' => 'callback',
            'options' => $arOptions
        ];
    }

    public static function length($arOptions) {
        return [
            'type' => 'length',
            'options' => $arOptions
        ];
    }

    public static function file($arOptions) {
        return [
            'type' => 'file',
            'options' => $arOptions
        ];
    }

    public static function between($arOptions) {
        return [
            'type' => 'between',
            'options' => $arOptions
        ];
    }

    public static function date($arOptions) {
        return [
            'type' => 'date',
            'options' => $arOptions
        ];
    }

    public static function regex($arOptions) {
        return [
            'type' => 'regex',
            'options' => $arOptions
        ];
    }
}
