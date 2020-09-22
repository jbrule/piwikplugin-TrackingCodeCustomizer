<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\TrackingCodeCustomizer;

/**
         * HOOK DOCUMENTATION
         * Present in >=v2.9.0 /piwik/core/Tracker/TrackerCodeGenerator.php
         * https://github.com/piwik/piwik/blob/master/core/Tracker/TrackerCodeGenerator.php
         * Triggered when generating JavaScript tracking code server side. Plugins can use
         * this event to customise the JavaScript tracking code that is displayed to the
         * user.
         *
         * @param array &$codeImpl An array containing snippets of code that the event handler
         *                         can modify. Will contain the following elements:
         *
         *                         - **idSite**: The ID of the site being tracked.
         *                         - **piwikUrl**: The tracker URL to use.
         *                         - **options**: A string of JavaScript code that customises
         *                                        the JavaScript tracker.
         *                         - **optionsBeforeTrackerUrl**: A string of Javascript code that customises
         *                                        the JavaScript tracker inside of anonymous function before
         *                                        adding setTrackerUrl into paq.
         *                         - **protocol**: Piwik url protocol.
         *
         *                         The **httpsPiwikUrl** element can be set if the HTTPS
         *                         domain is different from the normal domain.
         * @param array $parameters The parameters supplied to `TrackerCodeGenerator::generate()`.
         
*/

class TrackingCodeCustomizer extends \Piwik\Plugin
{
    private static $hooks = array(
            'Tracker.getJavascriptCode' => 'applyTrackingCodeCustomizations'
        );
    
    public function registerEvents()
    {
        return self::$hooks;
    }
        
    /*
    * @param array &$sysparams 
    *        @key int idSite
    *        @key string piwikUrl
    *        @key string options
    *        @key string optionsBeforeTrackerUrl
    *        @key string protocol
    * @param array $parameters
    *        @key bool mergeSubdomains
    *        @key bool groupPageTitlesByDomain
    *        @key bool mergeAliasUrls
    *        @key bool visitorCustomVariables
    *        @key bool pageCustomVariables
    *        @key bool customCampaignNameQueryParam
    *        @key bool customCampaignKeywordParam
    *        @key bool doNotTrack
    **/
    public function applyTrackingCodeCustomizations(&$sysparams,$parameters){
        
        $originalSysparams = $sysparams;
        
        $storedSettings = $this->getSettings();
        
        if(array_key_exists("options", $storedSettings))
                $storedSettings["options"] .= $sysparams["options"];

        if(array_key_exists("optionsBeforeTrackerUrl", $storedSettings))
                $storedSettings["optionsBeforeTrackerUrl"] .=$sysparams["optionsBeforeTrackerUrl"];
        
        $sysparams = array_merge($sysparams,$storedSettings);
        
        foreach($sysparams as $key => $value){
            
            $sysparams[$key] =  $this->replaceTokens($value,$originalSysparams,$sysparams);
        }
    
    }
    
    private function getSettings()
    {
        $outParams = array();
        
        $params = array("idSite","piwikUrl","options","optionsBeforeTrackerUrl","httpsPiwikUrl","protocol");
        
        $settings = new SystemSettings();
        
        //print_r($settings);
        //end();
        
        foreach($params as $param){
            
            $value = $settings->{$param}->getValue();
            if(!empty($value))
                $outParams[$param] = $value;
        }
                
        return $outParams;
    }
    
    private function replaceTokens($subject,$originalSysparams,$sysparams){
        $output = str_replace(array_map(function($item){return '{$original_'.$item.'}';},array_keys($originalSysparams)),array_values($originalSysparams),$subject);
        $output = str_replace(array_map(function($item){return '{$'.$item.'}';},array_keys($sysparams)),array_values($sysparams),$output);
        return $output;
    }
}
