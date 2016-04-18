<?php

namespace Piwik\Plugins\TrackingCodeCustomizer;

use Piwik\Piwik;
use Piwik\Settings\SystemSetting;
use Piwik\Settings\UserSetting;

class Settings extends \Piwik\Plugin\Settings
{
    public $idSite;
    public $piwikUrl;
    public $options;
    public $optionsBeforeTrackerUrl;
    public $httpsPiwikUrl;
    public $protocol;
    public $piwikJs;
    public $piwikPhp;
    public $paqVariable;
    public $removePiwikBranding;
    
    protected function init()
    {
        $this->setIntroduction($this->t('PluginDescription'));
        
        $default_textbox_size = array("size"=> 65);
        
        
        $this->idSite = new SystemSetting('idSite', $this->t('idSiteSettingTitle'));
        $this->idSite->type  = static::TYPE_STRING;
        $this->idSite->uiControlType = static::CONTROL_TEXT;
        $this->idSite->uiControlAttributes = array("size" => "6", "maxlenth" => "8");
        $this->idSite->description   = $this->t('idSiteSettingDescription');
        $this->idSite->readableByCurrentUser = true;
        $this->idSite->defaultValue  = "";
        $this->idSite->inlineHelp = 'Probably not useful in most scenarios. The idSite option is included for completeness.';
        
        $this->idSite->validate = function ($value, $setting) {
            if ($value != "" && preg_match("/^[0-9]+$/",$value) !== 1) {
                throw new \Exception('Value is invalid. Must be positive integer');
            }
        };
        
        $this->addSetting($this->idSite);
        
        $this->protocol = new SystemSetting('protocol', $this->t('protocolSettingTitle'));
        $this->protocol->type  = static::TYPE_STRING;
        $this->protocol->uiControlType = static::CONTROL_TEXT;
        $this->protocol->uiControlAttributes = array("size" => "10", "maxlenth" => "8");
        $this->protocol->description   = $this->t('protocolSettingDescription');
        $this->protocol->readableByCurrentUser = true;
        $this->protocol->defaultValue  = "";
        $this->protocol->inlineHelp = 'http(s)://';
        
        $this->protocol->validate = function ($value, $setting) {
            if ($value != "" && !($value == "http://" || $value == "https://")) {
                throw new \Exception('Value is invalid');
            }
        };
        
        $this->addSetting($this->protocol);
        
        $this->piwikUrl = new SystemSetting('piwikUrl', $this->t('piwikUrlSettingTitle'));
        $this->piwikUrl->type  = static::TYPE_STRING;
        $this->piwikUrl->uiControlType = static::CONTROL_TEXT;
        $this->piwikUrl->uiControlAttributes = $default_textbox_size;
        $this->piwikUrl->description   = $this->t('piwikUrlSettingDescription');
        $this->piwikUrl->readableByCurrentUser = true;
        $this->piwikUrl->defaultValue  = "";
        $this->piwikUrl->inlineHelp = 'tracker.example.com/piwik use hostname+basepath only (omit protocol and trailing slash)';
        
        $this->addSetting($this->piwikUrl);
        
        $this->httpsPiwikUrl = new SystemSetting('httpsPiwikUrl', $this->t('httpsPiwikUrlSettingTitle'));
        $this->httpsPiwikUrl->type  = static::TYPE_STRING;
        $this->httpsPiwikUrl->uiControlType = static::CONTROL_TEXT;
        $this->httpsPiwikUrl->uiControlAttributes = $default_textbox_size;
        $this->httpsPiwikUrl->description   = $this->t('httpsPiwikUrlSettingDescription');
        $this->httpsPiwikUrl->readableByCurrentUser = true;
        $this->httpsPiwikUrl->defaultValue  = "";
        $this->httpsPiwikUrl->inlineHelp = 'secure-tracker.example.com/piwik use hostname+basepath only (omit protocol and trailing slash)';
        
        $this->addSetting($this->httpsPiwikUrl);


        $this->piwikJs = new SystemSetting('piwikJs', $this->t('piwikJsSettingTitle'));
        $this->piwikJs->type  = static::TYPE_STRING;
        $this->piwikJs->uiControlType = static::CONTROL_TEXT;
        $this->piwikJs->uiControlAttributes = $default_textbox_size;
        $this->piwikJs->description   = $this->t('piwikJsSettingDescription');
        $this->piwikJs->readableByCurrentUser = true;
        $this->piwikJs->defaultValue  = "";
        $this->piwikJs->inlineHelp = 'alternative name for piwik.js in Javascript tracking code';

        $this->addSetting($this->piwikJs);


        $this->piwikPhp = new SystemSetting('piwikPhp', $this->t('piwikPhpSettingTitle'));
        $this->piwikPhp->type  = static::TYPE_STRING;
        $this->piwikPhp->uiControlType = static::CONTROL_TEXT;
        $this->piwikPhp->uiControlAttributes = $default_textbox_size;
        $this->piwikPhp->description   = $this->t('piwikPhpSettingDescription');
        $this->piwikPhp->readableByCurrentUser = true;
        $this->piwikPhp->defaultValue  = "";
        $this->piwikPhp->inlineHelp = 'alternative name for piwik.php in Javascript tracking code';

        $this->addSetting($this->piwikPhp);


        $this->paqVariable = new SystemSetting('paqVariable', $this->t('paqVariableSettingTitle'));
        $this->paqVariable->type  = static::TYPE_STRING;
        $this->paqVariable->uiControlType = static::CONTROL_TEXT;
        $this->paqVariable->uiControlAttributes = $default_textbox_size;
        $this->paqVariable->description   = $this->t('paqVariableSettingDescription');
        $this->paqVariable->readableByCurrentUser = true;
        $this->paqVariable->defaultValue  = "";
        $this->paqVariable->inlineHelp = 'alternative name for _paq';

        $this->addSetting($this->paqVariable);


        $this->removePiwikBranding = new SystemSetting('removePiwikBranding', $this->t('removePiwikBrandingSettingTitle'));
        $this->removePiwikBranding->type  = static::TYPE_BOOL;
        $this->removePiwikBranding->uiControlType = static::CONTROL_CHECKBOX;
        $this->removePiwikBranding->description   = $this->t('removePiwikBrandingSettingDescription');
        $this->removePiwikBranding->readableByCurrentUser = true;
        $this->removePiwikBranding->defaultValue  = "";
        $this->removePiwikBranding->inlineHelp = 'Remove Piwik branding in comments';

        $this->addSetting($this->removePiwikBranding);

        
        $this->options = new SystemSetting('options', $this->t('optionsSettingTitle'));
        $this->options->type  = static::TYPE_STRING;
        $this->options->uiControlType = static::CONTROL_TEXTAREA;
        $this->options->description   = $this->t('optionsSettingDescription');
        $this->options->readableByCurrentUser = true;
        $this->options->defaultValue  = "";
        $this->options->inlineHelp = '{$original_paramname} and {$paramname} tokens are available for referencing values.';
        
        $this->addSetting($this->options);
        
        $this->optionsBeforeTrackerUrl = new SystemSetting('optionsBeforeTrackerUrl', $this->t('optionsBeforeTrackerUrlSettingTitle'));
        $this->optionsBeforeTrackerUrl->type  = static::TYPE_STRING;
        $this->optionsBeforeTrackerUrl->uiControlType = static::CONTROL_TEXTAREA;
        $this->optionsBeforeTrackerUrl->description   = $this->t('optionsBeforeTrackerUrlSettingDescription');
        $this->optionsBeforeTrackerUrl->readableByCurrentUser = true;
        $this->optionsBeforeTrackerUrl->defaultValue  = "";
        $this->optionsBeforeTrackerUrl->inlineHelp = '{$original_paramname} and {$paramname} tokens are available for referencing values.';
        
        $this->addSetting($this->optionsBeforeTrackerUrl);
    }
    
    private function t($key)
    {
        return Piwik::translate('TrackingCodeCustomizer_' . $key);
    }
}