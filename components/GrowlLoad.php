<?php
namespace app\components;
use kartik\growl\Growl;
use kartik\growl\GrowlAsset;
use kartik\base\AnimateAsset;
/**
 * GrowlLoad
 *
 * @author Hafid Mukhlasin <hafidmukhlasin@gmail.com>
 * @since 1.0
 */
class GrowlLoad extends Growl
{
    public static function reload($view)
    {
        GrowlAsset::register($view);
        AnimateAsset::register($view);
    }
}
