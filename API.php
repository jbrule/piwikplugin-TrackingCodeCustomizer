<?php

namespace Piwik\Plugins\TrackingCodeCustomizer;

class API extends \Piwik\Plugin\API
{

    private static $plugin_name = 'TrackingCodeCustomizer';
    
    public function getSettings()
    {
        $outParams = array();
        
        $params = array("idSite","piwikUrl","options","optionsBeforeTrackerUrl","httpsPiwikUrl","protocol","piwikJs", "piwikPhp","paqVariable","removePiwikBranding");
        
        $settings = new Settings(self::$plugin_name);
        
        foreach($params as $param){
            
            $value = $settings->{$param}->getValue();
            if(!empty($value))
                $outParams[$param] = $value;
        }
        
        return $outParams;
    }
    
}