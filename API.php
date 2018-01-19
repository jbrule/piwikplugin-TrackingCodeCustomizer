<?php

namespace Piwik\Plugins\TrackingCodeCustomizer;

class API extends \Piwik\Plugin\API
{

    private static $plugin_name = 'TrackingCodeCustomizer';
    
    public function getSettings()
    {
        $outParams = array();
        
        $params = array("idSite","piwikUrl","options","optionsBeforeTrackerUrl","httpsPiwikUrl","protocol");
        
        $settings = new SystemSettings();
        
        foreach($params as $param){
            
            $value = $settings->{$param}->getValue();
            if(!empty($value))
                $outParams[$param] = $value;
        }
        
        return $outParams;
    }
    
}