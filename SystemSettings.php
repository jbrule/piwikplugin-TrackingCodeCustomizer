<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\TrackingCodeCustomizer;

use Piwik\Piwik;
use Piwik\Settings\Setting;
use Piwik\Settings\FieldConfig;

/**
 * Defines Settings for TrackingCodeCustomizer.
 *
 * Usage like this:
 * $settings = new SystemSettings();
 * $settings->metric->getValue();
 * $settings->description->getValue();
 */
class SystemSettings extends \Piwik\Settings\Plugin\SystemSettings
{
   
    public $idSite;
    public $protocol;
    public $piwikUrl;
    public $httpsPiwikUrl;
    public $options;
    public $optionsBeforeTrackerUrl;
    
    const TEXTBOX_SETTINGS = array("size"=> 65);

    protected function init()
    {
        $this->idSite = $this->createIdSiteSetting();
        $this->protocol = $this->createProtocolSetting();
        $this->piwikUrl = $this->createInstallUrlSetting();
        $this->httpsPiwikUrl = $this->createSecureInstallUrlSetting();
        $this->options = $this->createOptionsSetting();
        $this->optionsBeforeTrackerUrl = $this->createOptionsBeforeTrackerUrl();
    }
    
    private function createIdSiteSetting(){
        return $this->makeSetting('idSite', $default = "", FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = $this->t('idSiteSettingTitle');
            $field->introduction = $this->t('PluginDescription');
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->uiControlAttributes = array("size" => "6", "maxlength" => "8");
            $field->description = $this->t('idSiteSettingDescription');
            $field->inlineHelp = sprintf('<br/>Probably not useful in most scenarios. The idSite option is included for completeness.<br/><br/>Default: %s',$this->t('idSiteSettingDefault'));
            $field->validate = function ($value, $setting) {
                if ($value != "" && preg_match("/^[0-9]+$/",$value) !== 1) {
                throw new \Exception('Value is invalid. Must be positive integer');
                }
            };
            
        });
    }
    
    private function createProtocolSetting(){
        return $this->makeSetting('protocol', $default = "", FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = $this->t('protocolSettingTitle');
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->uiControlAttributes = array("size" => "10", "maxlength" => "8");
            $field->description = $this->t('protocolSettingDescription');
            $field->inlineHelp = sprintf('<br/>http:// or https://<br/><br/>Default: %s',$this->t('protocolSettingDefault'));
            $field->validate = function ($value, $setting) {
                if ($value != "" && !($value == "http://" || $value == "https://")) {
                    throw new \Exception('Value is invalid');
                }
            };
        });
    }
    
    private function createInstallUrlSetting(){
        return $this->makeSetting('piwikUrl', $default = "", FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = $this->t('piwikUrlSettingTitle');
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            //$field->uiControlAttributes = array("size"=> 65);
            $field->description = $this->t('piwikUrlSettingDescription');
            $field->inlineHelp = sprintf('<br/>tracker.example.com/piwik use hostname+basepath only (omit protocol and trailing slash)<br/><br/>Default: %s',$this->t('piwikUrlSettingDefault'));
        });
    }
    
    private function createSecureInstallUrlSetting(){
        return $this->makeSetting('httpsPiwikUrl', $default = "", FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = $this->t('httpsPiwikUrlSettingTitle');
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            //$field->uiControlAttributes = array("size"=> 65);
            $field->description = $this->t('httpsPiwikUrlSettingDescription');
            $field->inlineHelp = sprintf('<br/>secure-tracker.example.com/piwik use hostname+basepath only (omit protocol and trailing slash)<br/><br/>Default: %s',$this->t('httpsPiwikUrlSettingDefault'));
            
        });
    }
    
    private function createOptionsSetting(){
        return $this->makeSetting('options', $default = "", FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = $this->t('optionsSettingTitle');
            $field->uiControl = FieldConfig::UI_CONTROL_TEXTAREA;
            //$field->uiControlAttributes = array("size"=> 65);
            $field->description = $this->t('optionsSettingDescription');
            $field->inlineHelp = sprintf('<br/>{$original_paramname} and {$paramname} tokens are available for referencing values.<br/><br/>Default: %s',$this->t('optionsSettingDefault'));
        });
    }
    
        private function createOptionsBeforeTrackerUrl(){
        return $this->makeSetting('optionsBeforeTrackerUrl', $default = "", FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = $this->t('optionsBeforeTrackerUrlSettingTitle');
            $field->uiControl = FieldConfig::UI_CONTROL_TEXTAREA;
            //$field->uiControlAttributes = array("size"=> 65);
            $field->description = $this->t('optionsBeforeTrackerUrlSettingDescription');
            $field->inlineHelp = sprintf('<br/>{$original_paramname} and {$paramname} tokens are available for referencing values.<br/><br/>Default: %s',$this->t('optionsBeforeTrackerUrlSettingDefault'));
        });
    }
    
    private function t($translate_token){
        return Piwik::translate("TrackingCodeCustomizer_".$translate_token);
    }
}
