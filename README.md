### Joomla-Shortcode
##### Joomla shortcode plugin
  
Plugin to implement shortcodes into Joomla where unlike in Wordpress there is no Shortcode API.  
  
The plugin parses shortcodes in all Joomla content looking for matrching RegEx.  
It explodes the string saving parts of it into variables.  

### Check the develompent branch for more functions
[and nicer code](https://github.com/mthjn/Joomla-Shortcode/tree/development)  
![Dev Branch](http://i.giphy.com/xTiTnha7sQBSXcl4SA.gif)

##### Default Usage

      {bild url=/some/location/of/a/page}{img=/some/location/of/an/image.jpg}{tt=Title}

Paste into Articles. Will be rendered in the frontend -  the output is an image with Title and button overlay on hover mimicking [SP Simple Portfolio images](http://demo.joomshaper.com/extensions/sp-simple-portfolio) (when you only want the images not the content system around it, it's for you).  
  
Create your own shortcode (onContentPrepare) and change the CSS flushed into header (onBeforeCompileHead)  
