# Matomo TrackingCodeCustomizer Plugin
Tracking Code Customizer plugin for the Matomo Web Analytics software package

## Description
Allows Matomo admininstrators to customize the tracking code that is autogenerated for users. This is useful for directing requests to the correct servers in a multi-server setup, include additional parameters in default tracking, or to perform conditional checks before initiating a tracking call. 

## Instructions
The easiest way to install is to find the plugin in the [Matomo Marketplace](https://plugins.matomo.org/).

## Usage

Set additional default OPTIONS for tracking. The follwing is entered into the "options" field.

```javascript
if (typeof(hash) !== 'undefined'){_paq.push(['setCustomVariable','1','U',hash,'visit']); _paq.push(['setUserId',hash]);};
```
Resultant tracking code
```javascript
<!-- Matomo -->
<script type="text/javascript">
  var _paq = _paq || [];
  if (typeof(hash) !== 'undefined'){_paq.push(['setCustomVariable','1','U',hash,'visit']); _paq.push(['setUserId',hash]);};
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  var u="//webanalytics-tracker.XXXX.XXX/";
_paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', 1]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="//webanalytics-tracker.XXXX.XXX/piwik.php?idsite=1" style="border:0;" alt="" /></p></noscript>
<!-- End Matomo Code -->
```

## License
GPL v3 / fair use

## Support
Please [report any issues](https://github.com/jbrule/piwikplugin-TrackingCodeCustomizer/issues). Pull requests welcome.
